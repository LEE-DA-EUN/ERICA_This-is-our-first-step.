<?php

function signIn(){

  if(!isset($_POST['requestBody'])){
    $json = json_encode(array('resCode' => 400, 'resMsg' => 'Wrong request'));
    return $json;
  }

  $rBody = json_decode($_POST['requestBody'], true);

  include "./MySQLConfig/MySQLConfig.php";

  $stmt = $conn->prepare("SELECT COUNT(*) FROM LANDA_User_TB WHERE englishName=?");
  @$stmt->bind_param("s", $rBody['englishName']);
  $stmt->execute();
  $res = $stmt->get_result();

  $row = mysqli_fetch_assoc($res);
  if($row['COUNT(*)'] > 0){
    return json_encode(array('resCode'=>400, 'resMsg'=>'User Already Exist'));
  }

  $stmt = $conn->prepare("INSERT INTO LANDA_User_TB(nickname,englishName,password,email,authPlatform,otherPlatformToken,signInDate) VALUES(?,?,?,?,?,?,?)");

  @$stmt->bind_param("sssssss", $rBody['nickname'],
                                $rBody['englishName'],
                                $rBody['password'],
                                $rBody['email'],
                                $rBody['authPlatform'],
                                $rBody['otherPlatformToken'],
                                date('Y-m-d H:i:s'));

  $stmt->execute();




  $stmt = $conn->prepare("SELECT COUNT(*),no FROM LANDA_User_TB WHERE englishName=?");
  @$stmt->bind_param("s",$rBody['englishName']);
  $stmt->execute();
  $res = $stmt->get_result();

  $row = mysqli_fetch_assoc($res);

  if($row['COUNT(*)'] > 0){
    return json_encode(array('resCode'=>200,'resMsg'=>'Success','userNum'=>$row['no']));
  }else {
    return json_encode(array('resCode'=>400,'resMsg'=>'Sign In Error'));
  }
}

function doLogin(){
  if(!isset($_POST['requestBody'])){
    $json = json_encode(array('resCode' => 400, 'resMsg' => 'Wrong request'));
    return $json;
  }

  $rBody = json_decode($_POST['requestBody'], true);

  include "./MySQLConfig/MySQLConfig.php";

  $stmt = $conn->prepare("SELECT COUNT(*), no FROM LANDA_User_TB WHERE englishName=? and password=?");
  @$stmt->bind_param("ss", $rBody['englishName'], $rBody['password']);
  $stmt->execute();
  $res = $stmt->get_result();

  $row = mysqli_fetch_assoc($res);

  if($row['COUNT(*)'] > 0){
    return json_encode(array('resCode'=>200, 'resMsg'=>'User Found', 'no'=>$row['no']));
  }

  else {
    return json_encode(array('resCode'=>400, 'resMsg'=>'Wrong User Information'));
  }
}

 ?>
