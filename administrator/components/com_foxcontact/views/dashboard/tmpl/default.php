<?php defined("_JEXEC") or die(file_get_contents("index.html")); ?>

<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>

<div id="j-main-container" class="span10">
	<p>
		<img class="floatleft" src="../media/<?php echo("com_foxcontact/images/foxcontact.png"); ?>" width="128" height="128">
	</p>
	<h2><?php echo JText::_("COM_FOXCONTACT") ?></h2>
	<p><?php echo JText::_("COM_FOXCONTACT_CREATION_DESCRIPTION") ?></p>
		<form method="post" action="index.php?option=com_menus&amp;view=item&amp;layout=edit&amp;task=item.setType">
		<input type="hidden" name="jform[type]" value="eyJpZCI6MCwidGl0bGUiOiJDT01fRk9YQ09OVEFDVF9WSUVXX0RFRkFVTFRfVElUTEUiLCJyZXF1ZXN0Ijp7Im9wdGlvbiI6ImNvbV9mb3hjb250YWN0IiwidmlldyI6ImZveGNvbnRhY3QifX0="/>
			<button class="btn btn-primary" type="submit" ><?php echo JText::_("COM_FOXCONTACT_CREATE_MENU") ?></button>
			<a class="btn btn-primary" href="index.php?option=com_modules&task=module.add&eid=<?php echo $this->extension_id ?>">
				<?php echo JText::_("COM_FOXCONTACT_CREATE_MODULE") ?>
			</a>
		</form>
	<p>
		<a href="<?php echo (string)$this->xml->{"documentation"} ?>"><?php echo JText::_("COM_FOXCONTACT_DOCUMENTATION") ?></a> |
		<a href="<?php echo (string)$this->xml->{"download"} ?>"><?php echo JText::_("COM_FOXCONTACT_DOWNLOAD") ?></a> |
		<a href="<?php echo (string)$this->xml->{"forum"} ?>"><?php echo JText::_("COM_FOXCONTACT_FORUM") ?></a> |
		<?php //echo JText::_("JFIELD_LANGUAGE_LABEL"); echo $language->get("name") ?>
		<a href="<?php echo (string)$this->xml->{"transifex"} ?>"><?php echo JText::_("COM_FOXCONTACT_TRANSLATE") ?></a> |
		<a href="<?php echo (string)$this->xml->{"rating"} ?>"><?php echo JText::_("COM_FOXCONTACT_RATING") ?></a>
	</p>

	<p><?php echo str_replace("licenses/gpl-2.0.html", "copyleft/gpl.html", sprintf(JText::_("JGLOBAL_ISFREESOFTWARE"), JText::_("COM_FOXCONTACT") . " " . (string)$this->xml->{"version"})) ?></p>
</div>