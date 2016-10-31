<?php
/**
 * @package     Joomla.Site
 * @subpackage  Template.system
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 */

defined('_JEXEC') or die;

/*
 * mao: Module chrome for mod_starlink_services_block
 *
 */

function modChrome_services( $module, &$params, &$attribs )
{
  $moduleTag      = $params->get('module_tag', 'div');
  $headerTag      = htmlspecialchars($params->get('header_tag', 'h3'), ENT_COMPAT, 'UTF-8');
  $headerClass    = 's-ServicesBlock__header col-xs-12';
  $containerWide = $params->get('containerType');

  echo '<' . $moduleTag . ' class="container-fluid s-ServicesBlock' . htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8') . '">';
    if ( ! (bool) $containerWide ) { echo '<div class="container">'; } ?>
      <?php if ((bool) $module->showtitle) { echo '<' . $headerTag . ' class="' . $headerClass . '">' . $module->title . '</' . $headerTag . '>'; }
      echo $module->content; ?>
    <?php if ( ! (bool) $containerWide ) { echo '</div>'; }
  echo '</' . $moduleTag . '>';
}