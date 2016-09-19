<?php defined( '_JEXEC' ) or die;

// variables
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$menu = $app->getMenu();
$active = $app->getMenu()->getActive();
$params = $app->getParams();
$pageclass = $params->get('pageclass_sfx');
$tpath = $this->baseurl.'/templates/'.$this->template;

// generator tag
$this->setGenerator(null);

// template js
$doc->addScript($tpath.'/js/libs/jquery-ui.js');
$doc->addScript($tpath.'/js/libs/bootstrap.min.js');
$doc->addScript($tpath.'/js/scripts.js');
$doc->addScript($tpath.'/js/calculator_it_outsourcing.js');

// template css
//
// am: replacing this to plain css in order to help debug in Firefox development tools
$doc->addStyleSheet($tpath.'/css/bootstrap.min.css');
$doc->addStyleSheet($tpath.'/css/fonts.css');                   // new instructions
$doc->addStyleSheet($tpath.'/css/template.css');                    // new instructions
$doc->addStyleSheet($tpath.'/css/calculator.css');
# $doc->addStyleSheet($tpath.'/../../media/system/css/system.css');   // new instructions
# $doc->addStyleSheet($tpath.'/../system/css/system.css');            // new instructions
# $doc->addStyleSheet($tpath.'/../system/css/general.css');           // new instructions

// am: add scss
//$doc->addStyleSheet($tpath.'/css/am_style.php/am_style.scss');
