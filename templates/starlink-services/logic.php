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

// template css
$doc->addStyleSheet($tpath . '/css/bootstrap.min.css');
$doc->addStyleSheet($tpath . '/css/template.css');

// template js
$doc->addScript($tpath . '/js/jui/bootstrap.min.js');
$doc->addScript($tpath . '/js/scripts.js');