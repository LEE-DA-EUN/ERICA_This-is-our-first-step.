<?php

error_reporting(E_ALL);

ini_set("display_errors", 1);

function uploadDeviceData(){

  require_once("./module/dbConfig.php");

 

  $stmt = $conn->prepare("INSERT INTO THF_Data(device, header, data) VALUES(?,?,?)");

  @$stmt->bind_param("sss", $_GET['device'], $_GET['header'], $_GET['data']);

  $stmt->execute();

 

  $stmt = $conn->prepare("SELECT COUNT(*) FROM THF_Data WHERE device=? and header=? and data=?");

  @$stmt->bind_param("sss",$_GET['device'], $_GET['header'], $_GET['data']);

  $stmt->execute();

  $res = $stmt->get_result();

 

  $row = mysqli_fetch_assoc($res);

 

  $jsonObj = array();

 

  if($row['COUNT(*)'] == 0){

    $jsonObj += ['ResCode'=>400, 'ResMsg'=>'UPLOAD FAIL'];

  }

  else if($row['COUNT(*)'] > 0){

    $jsonObj += ['ResCode'=>200, 'ResMsg'=>'UPLOAD SUCCESS'];

  }

 

  return json_encode($jsonObj);

}

 

function getDeviceData(){

   include "./module/dbConfig.php";

 

   $stmt = $conn->prepare("SELECT * FROM THF_Data WHERE device=? ORDER BY no desc LIMIT 1");

 

   @$stmt->bind_param("s",$_GET['device']);

   $stmt->execute();

   $res = $stmt->get_result();

 

   $row = mysqli_fetch_assoc($res);

 

   $jsonObj = array();

 

   $stmt = $conn->prepare("SELECT COUNT(*) FROM THF_Data WHERE device=? ORDER BY no desc LIMIT 1");

   @$stmt->bind_param("i",$_GET['device']);

   $stmt->execute();

   $res2 = $stmt->get_result();

 

   $row2 = mysqli_fetch_assoc($res2);

 

   if($row2['COUNT(*)'] == 0){

     $jsonObj += ['ResCode'=>400, 'ResMsg'=>'GET FAIL'];

   }

   else if($row2['COUNT(*)'] > 0){

     $jsonObj += ['ResCode'=>200, 'ResMsg'=>'GET SUCCESS', 'Device'=>$row['device'], 'Header'=>$row['header'], 'Data'=>$row['data']];

   }

 

   return json_encode($jsonObj);

}

 ?>
