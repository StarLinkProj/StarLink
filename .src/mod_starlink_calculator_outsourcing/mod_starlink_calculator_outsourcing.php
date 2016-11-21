<?php defined( '_JEXEC' ) or die( 'Restricted access' );

if(isset($_POST['mod_calculator_count']))
{
	
}
else
{
    require( JModuleHelper::getLayoutPath( 'mod_starlink_calculator_outsourcing' ) );    
}

$doc = JFactory::getDocument();
// base path for all assets (css, js, images, fonts)
$assetsPath = JURI::base( true ).$params->get('assetsBasePath', '/media/mod_starlink_calculator_outsourcing');
$doc->addScript(JURI::root(true). $assetsPath . '/js/starlink_calculator_outsourcing.js');
