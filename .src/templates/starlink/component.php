<?php defined( '_JEXEC' ) or die; 

// variables
$doc = JFactory::getDocument(); 
$tpath = $this->baseurl.'/templates/'.$this->template;

// generator tag
$this->setGenerator(null);

// base path for all assets (css, js, images, fonts)
$assetsPathFile = JPATH_ROOT.$this->params->get('assetsBasePath', '/media/mod_starlink');
$assetsPath = $this->baseurl .$this->params->get('assetsBasePath', '/media/mod_starlink');
// load sheets and scripts
$doc->addStyleSheet($assetsPath . '/css/print.css?v=1');
/*$doc->addStyleSheet($tpath.'/css/print.css?v=1');*/

?><!doctype html>

<html lang="<?php echo $this->language; ?>">

<head>
  <jdoc:include type="head" />
</head>

<body id="print">
  <div id="overall">
    <jdoc:include type="message" />
    <jdoc:include type="component" />
  </div>
  <?php if ($_GET['print'] == '1') echo '<script type="text/javascript">window.print();</script>'; ?>
</body>

</html>
