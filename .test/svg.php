<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */
?>
<!DOCTYPE html>
<html>
<head>
  <style>
    .icon {
      height:50px;
      width: 50px;
    }
    svg.icon {
      fill: blue;
    }
  </style>
</head>
<body>
<?php require_once '../media/mod_starlink/images/icons.svg'; ?>
<h1>SVG icons</h1>
<p>Some text and icon: <svg class="icon"><use xlink:href="#iconCheck" /></svg></p>
<svg class="icon"><use xlink:href="#iconCancel" /></svg>
<svg class="icon"><use xlink:href="#iconExpandMore" /></svg>
</body>