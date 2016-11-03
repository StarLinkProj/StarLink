<?php //topcloud300 ***  Joomla Module *** Copyright Bob Galway - www.blackdale.com *** License GPL3 - http://www.gnu.org/licenses/

// no direct access
defined('_JEXEC') or die;

// filter exclusions
class modtopcloud300Helper
{
    function censor($text, $filter, $phrase1)
    {
        // clean up input
        for ($i = 1; $i <= 10; $i++) {
            $filter = trim($filter, ",");
            $filter = trim($filter);
        }
        for ($j = 1; $j <= 10; $j++) {
            $filter = str_replace(",,", ",", $filter);
            $filter = str_replace(", ", ",", $filter);
        }
        for ($a = 1; $a <= 10; $a++) {
            $text = trim($text, ",");
            $text = trim($text);
        }
        for ($b = 1; $b <= 10; $b++) {
            $text = str_replace(",,", ",", $text);
            $text = str_replace(", ", ",", $text);
            $text = str_replace("  ", " ", $text);
        }
        if ($phrase1 == 2) {
            $text = str_replace(" ", ",", $text);
        }
        $f = explode(',', $filter);
        $t = explode(',', $text);
        $k = 0;
        while (isset($f[$k])) {
            $m = 0;
            while (isset($t[$m])) {
                if ($f[$k] == $t[$m]) {
                    $t[$m] = "a";
                }
                $m++;
            }
            $k++;
        }
        $text = implode("|", $t);
        if ($phrase1 == 1) {
            $text = str_replace(" ", "###", $text);
        }
        return $text;
    }
    function getCloud($url1, $start, $length, $scale1, $font1, $fontweight1, $menu,
        $no, $data = array(), $minFontSize = 12, $maxFontSize = 30)
    {
        $links="";
        $minimumCount = min(array_values($data));
        $maximumCount = max(array_values($data));
        $spread = $maximumCount - $minimumCount;
        $spread == 0 && $spread = 1;
        foreach ($data as $tag => $count) {
            $size = $minFontSize + ($count - $minimumCount) * ($maxFontSize - $minFontSize) / $spread;
            $tag = str_replace("###", " ", $tag);
            $links .= '<a style="font-family:' . $font1 . ';font-weight:' . $fontweight1 . ';font-size: ' . (floor($size) * ($scale1)) . 'px" class="cloud' . $no .'" href="' . $url1 . 'index.php?searchword=' . $tag .'&ordering=&searchphrase=exact&Itemid=' . $menu . '&option=com_search" >' . $tag .'</a>'. PHP_EOL."\t\t\txxx";
        }
        $cloudTags= array();
        $cloudTags=explode("xxx", $links);
        $cloudTags=array_slice($cloudTags,$start,$length);
        $links=implode("", $cloudTags);
        return $links;
    }

}
