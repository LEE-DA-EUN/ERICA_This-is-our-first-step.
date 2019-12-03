<?php

define("HOST", "localhost");
define("USER", "alld");
define("PASS", "alp03100716");
define("DBNAME", "alld");

$conn = mysqli_connect(HOST, USER, PASS, DBNAME);

if(!$conn){
  echo "Database connection error";
}

 ?>
