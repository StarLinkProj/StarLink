<?php
/**
 * Created by PhpStorm.
 * User: mao
 * Date: 08.09.2016
 * Time: 17:52
 */

$directory = "../scss";

require "scss.inc.php";
scss_server::serveFrom($directory);
/*$scss = new scssc();
$scss->setImportPaths("scss/");
echo $scss->compile('@import "am_style.scss"');*/