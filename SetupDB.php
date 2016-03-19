<?php
$servername = "localhost";
$username = "admin";
$password = "tester123";
$dbname = "foodapp";
?>
<?php


// set the PDO error mode to exception
  $sql = 'CREATE DATABASE IF NOT EXISTS foodapp;';
  $conn = new PDO("mysql:host=$servername", $username, $password);

  $conn->query($sql);

  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  /*try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  } catch (\Exception $e){
    echo $e->getMessage(),PHP_EOL;
  }
  if($conn->select_db('foodapp') === false){
    $sql = "CREATE DATABASE foodapp;";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $q = $conn->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  }*/
  /*$sql = 'mysql_select_db($mysql, 'foodapp')';
  if(!$sql)
    echo "database exists";
    //do everything
  else {
    $sql2 = "CREATE DATABASE foodapp;

  }*/
  ?>
