<?php //topcloud300 ***  Joomla Module *** Copyright Bob Galway - www.blackdale.com *** License GPL3 - http://www.gnu.org/licenses/

// no direct access
defined('_JEXEC') or die;
$helper = new modtopcloud300Helper();
$doc = JFactory::getDocument();
include('params.php');
include('assets/data/links.php');
include('css.php');
include('sql.php');

if ($shuffle == 1) {
    $query1 = explode(',', $querytext);
    shuffle($query1);
    $querytext = implode(',', $query1);
}
$censor = $helper->censor($querytext, $exclude, $phrase);
if (empty($censor)) {
    $censor = "Search";
}
//set extra charactors availabilty if outside localization
$xchars1 = "#!ÀÁÂÄÈÉÊËÎÏÍÒÓÔÖÙÚÛÜßŸàáâäèéêëîïíòóôöùúûüÿñÑ0..9аАБбВвГгДдЕеЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя";
$xchars1 = $xchars1 . $xchars;
// Get individual words and build a frequency table but only if word length is greater than 3 and less than 20

$freqData = array();
foreach (str_word_count($censor, 1, $xchars1) as $word) {
    // For each word found in the frequency table, increment its value by one
    if ((strlen($word) >= $wordmin) && (strlen($word) <= $wordmax)) {
        array_key_exists($word, $freqData) ? $freqData[$word]++ : $freqData[$word] = 0;
    }
}

include('view1.php');

echo '
 <!-- Start TopCloud300 -->
 <div id="holder'.$modno.'">
    <div id="buffer'.$modno.'">
        <div id="inner'.$modno.'">
            '.$contenttc.'
        </div>
    </div>
</div>
<!-- End TopCloud300 -->
';
