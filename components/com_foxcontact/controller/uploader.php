<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.constants');
jimport('foxcontact.form.model');
jimport('foxcontact.html.mimetype');
jimport('foxcontact.joomla.log');

class FoxContactControllerUploader extends JControllerLegacy
{
	
	public function receive()
	{
		$input = JFactory::getApplication()->input;
		$form = FoxFormModel::getFormByUid($input->get('uid'));
		$item = $form->getDesign()->getFoxDesignItemByType('attachments');
		if (is_null($item))
		{
			$result = array('error' => 'Upload is disabled');
		}
		else
		{
			$manager = $this->getUploaderRequestManager();
			$result = !is_null($manager) ? $manager->exec(JPATH_COMPONENT . '/uploads/', $item) : array('error' => JText::_('COM_FOXCONTACT_ERR_NO_FILE'));
			$form->save();
		}
		
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		JFactory::getApplication()->close();
	}
	
	
	private function getUploaderRequestManager()
	{
		if (isset($_GET['qqfile']))
		{
			return new XhrUploadRequestManager();
		}
		
		if (isset($_FILES['qqfile']))
		{
			return new FormUploadRequestManager();
		}
		
		if (JFactory::getApplication()->input->get('action', 0) == 'deletefile')
		{
			return new XhrDeleteRequestManager();
		}
		
		return null;
	}

}


abstract class RequestManager
{
	
	public function __construct()
	{
		JLog::addLogger(array('text_file' => 'foxcontact.php', 'text_entry_format' => "{DATE}\t{TIME}\t{PRIORITY}\t{CATEGORY}\t{MESSAGE}"), JLog::ALL, array('upload'));
	}
	
	
	public abstract function exec($upload_directory, $item);
}


abstract class UploadRequestManager extends RequestManager
{
	
	public function exec($upload_directory, $item)
	{
		if (!is_writable($upload_directory))
		{
			return array('error' => JText::_('COM_FOXCONTACT_ERR_DIR_NOT_WRITABLE'));
		}
		
		$size = $this->getFileSize();
		if ($size == 0)
		{
			return array('error' => JText::_('COM_FOXCONTACT_ERR_FILE_EMPTY'));
		}
		
		if ($size > constant($item->get('file.size', 'MB100')))
		{
			return array('error' => JText::_('COM_FOXCONTACT_ERR_FILE_TOO_LARGE'));
		}
		
		$realname = $this->getFileName();
		$filename = JFilterInput::getInstance()->clean($realname, 'cmd');
		$filename = basename($filename);
		$filename = trim($filename, '.');
		$forbidden_extensions = '/ph(p[345st]?|t|tml|ar)/i';
		if (preg_match($forbidden_extensions, $filename))
		{
			FoxLog::add("Blocked a file upload attempt [forbidden extension]: {$filename}", JLog::INFO, 'upload');
			return array('error' => JText::_('COM_FOXCONTACT_ERR_MIME') . ' [forbidden extension]');
		}
		
		if (!$this->checkMimeType($_SERVER['CONTENT_TYPE'], $item))
		{
			$type = preg_replace('/;.*/', '', $_SERVER['CONTENT_TYPE']);
			return array('error' => JText::_('COM_FOXCONTACT_ERR_MIME') . " [{$type}]");
		}
		
		$filename = uniqid() . '-' . $filename;
		$full_filename = $upload_directory . $filename;
		$item_data = $item->getValue();
		if (count($item_data) >= $item->get('file.max', 10))
		{
			return array('error' => JText::_('COM_FOXCONTACT_ERR_MAX_UPLOAD_FILES_EXCEEDED'));
		}
		
		if (!$this->saveFile($full_filename))
		{
			return array('error' => JText::_('COM_FOXCONTACT_ERR_SAVE_FILE'));
		}
		
		if (!$this->checkFileContent($full_filename))
		{
			FoxLog::add("Blocked a file upload attempt [forbidden content]: {$filename}", JLog::INFO, 'upload');
			unlink($full_filename);
			return array('error' => JText::_('COM_FOXCONTACT_ERR_MIME') . ' [forbidden content]');
		}
		
		$item_data[] = array('filename' => $filename, 'realname' => $realname, 'size' => $size);
		$item->setValue($item_data);
		end($item_data);
		$last = key($item_data);
		FoxLog::add("File {$filename} uploaded succesful.", JLog::INFO, 'upload');
		return array('success' => true, 'index' => $last);
	}
	
	
	private function checkMimeType($mime_type, $item)
	{
		if (!(bool) $item->get('filter.enable', 1))
		{
			return true;
		}
		
		$allowed = array('/^application\\/octet-stream$/');
		if ((bool) $item->get('filter.audio', 0))
		{
			$allowed[] = '/^audio\\//';
		}
		
		if ((bool) $item->get('filter.video', 0))
		{
			$allowed[] = '/^video\\//';
		}
		
		if ((bool) $item->get('filter.image', 0))
		{
			$allowed[] = '/^image\\//';
		}
		
		if ((bool) $item->get('filter.zip', 0))
		{
			$allowed[] = '/^application\\/.*zip/';
			$allowed[] = '/^application\\/x-compress/';
			$allowed[] = '/^application\\/x-compressed/';
			$allowed[] = '/^application\\/x-gzip/';
			$allowed[] = '/^application\\/x-rar/';
		}
		
		if ((bool) $item->get('filter.document', 0))
		{
			$allowed[] = '/^(application|text)\\/rtf/';
			$allowed[] = '/^application\\/pdf/';
			$allowed[] = '/^application\\/msword/';
			$allowed[] = '/^application\\/vnd.ms-/';
			$allowed[] = '/^application\\/vnd\\.openxmlformats-officedocument\\./';
			$allowed[] = '/^application\\/x-mspublisher/';
			$allowed[] = '/^application\\/x-mswrite/';
			$allowed[] = '/^application\\/vnd\\.oasis\\.opendocument\\.text/';
		}
		
		foreach ($allowed as $allowed_type)
		{
			if ((bool) preg_match($allowed_type, $mime_type))
			{
				return true;
			}
		
		}
		
		return false;
	}
	
	
	public static function checkFileContent($full_filename)
	{
		$chunk_size = MB1;
		$back_step = -6;
		$handle = fopen($full_filename, 'rb');
		do
		{
			$content = fread($handle, $chunk_size);
			fseek($handle, $back_step, SEEK_CUR);
			if (strpos($content, '<?php') !== false || strpos($content, '<script') !== false)
			{
				fclose($handle);
				return false;
			}
		
		} while (strlen($content) == $chunk_size);
		
		fclose($handle);
		return true;
	}
	
	
	protected abstract function saveFile($path);
	
	protected abstract function getFileName();
	
	protected abstract function getFileSize();
}


class XhrUploadRequestManager extends UploadRequestManager
{
	
	protected function saveFile($path)
	{
		$input = fopen('php://input', 'r');
		$target = fopen($path, 'w');
		$real_size = $input !== false && $target !== false ? stream_copy_to_stream($input, $target) : false;
		if ($input !== false)
		{
			fclose($input);
		}
		
		if ($target !== false)
		{
			fclose($target);
		}
		
		return $real_size !== false && $real_size === $this->getFileSize();
	}
	
	
	protected function getFileName()
	{
		return JFactory::getApplication()->input->get->get('qqfile');
	}
	
	
	protected function getFileSize()
	{
		return isset($_SERVER['CONTENT_LENGTH']) ? (int) $_SERVER['CONTENT_LENGTH'] : 0;
	}

}


class FormUploadRequestManager extends UploadRequestManager
{
	
	protected function saveFile($path)
	{
		return move_uploaded_file($_FILES['qqfile']['tmp_name'], $path);
	}
	
	
	protected function getFileName()
	{
		return $_FILES['qqfile']['name'];
	}
	
	
	protected function getFileSize()
	{
		return $_FILES['qqfile']['size'];
	}

}


class XhrDeleteRequestManager extends RequestManager
{
	
	public function exec($upload_directory, $item)
	{
		$file_index = JFactory::getApplication()->input->get('fileindex', 0);
		$item_data = $item->getValue();
		if (!isset($item_data[$file_index]))
		{
			return array('error' => 'Index not found');
		}
		
		$deleted = @unlink("{$upload_directory}{$item_data[$file_index]['filename']}");
		if (!$deleted)
		{
		}
		
		unset($item_data[$file_index]);
		$item->setValue($item_data);
		return array('success' => true);
	}

}