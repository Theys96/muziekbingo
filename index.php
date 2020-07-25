<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_PARSE);

require 'php/config.php';
require 'php/text.php';
require 'php/functions.php';
require 'php/router.class.php';
require 'php/exceptions.class.php';
$Router = new Router();
$Error  = new ExceptionHandler($DeployType == "beta");
if ($Router->useDbConnection()) {
  $Db = new Mysqli($MySQL_host, $MySQL_username, $MySQL_password, $MySQL_database);
  if ($Db->connect_errno) {
    $Error->fatal("Database connection failed");
  }
}

$FULLPAGE = true;
if(file_exists($Router->pageCodeFile()))
  include $Router->pageCodeFile();
?>
<!DOCTYPE html>
<html>
  <head>
  	<!-- Meta -->
    <title><?php txt('title'); if (isset($TITLE)) { echo " | " . $TITLE; } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="icon" href="/img/logo.ico" type="image/x-icon"/>
  
    <!-- jQuery -->
    <script src='/js/jquery.js'></script>
    <script src='/js/jquery.redirect.js'></script>
    
    <!-- Misc -->
    <script src='/js/popper.min.js'></script>
    <script src='/js/bootstrap.min.js'></script>
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b78ba82296.js" crossorigin="anonymous"></script>
  
    <!-- fullpage.js -->
    <link rel="stylesheet" type="text/css" href="/css/fullpage.min.css" />
    <script type="text/javascript" src="/js/fullpage.min.js"></script>
    <script type="text/javascript" src="/js/fullpage.extensions.min.js"></script>
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/kaartstyle.css" />
    <script>
      $(document).ready(function() {
        $('#fullpage').fullpage({
          autoScrolling: true,
          normalScrollElements: '.scrollable',
          licenseKey: '7BD63EE1-78304227-BC88F0C9-71A87E45' /* Don't steal my licence! */
        });
        
        $.fn.fullpage.setAllowScrolling(true);
        $('.waitForPageLoad').show();
      });
    </script>
  </head>
  <body class='waitForPageLoad'>
    <?php
    if(file_exists($Router->pageBodyFile()))
        include $Router->pageBodyFile();
    ?>
    <div id='fullpage'>
      <?php 
      include $Router->pageFile();
      if ($Error->doDisplayErrors && $Error->hasErrors()) {
        echo "<div class='section'><div class='jumbotron'>\n";
        $Error->print();
        echo "</div></div>\n";
      }
      ?>
    </div>
  </body>
</html>

<?php
if ($DeployType == "prod" && $Error->hasErrors()) {
  if (!isset($Db)) {
    $Db = new Mysqli($MySQL_host, $MySQL_username, $MySQL_password, $MySQL_database);
    if ($Db->connect_errno) {
      $Error->fatal("Database connection failed");
    }
  }

  $Error->reportToDb($Db);
}
?>
