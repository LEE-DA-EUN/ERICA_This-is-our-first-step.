<?php

error_reporting(E_ALL);

ini_set("display_errors", 1);

 

switch($_GET['query']){

  case 'udd' :

    require_once("./module/device.php");

    echo uploadDeviceData();

    break;

  case 'gdd' :

    require_once("./module/device.php");

    echo getDeviceData();

    break;

}

 

 

 ?>

