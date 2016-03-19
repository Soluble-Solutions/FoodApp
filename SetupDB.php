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
  $sql = 'USE foodapp;';
  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = 'CREATE TABLE Entry
  (
    entry_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(45),
    votes INT,
    hot TINYBLOB,
    cold TINYBLOB,
    vegan TINYBLOB,
    vegitarian TINYBLOB,
    umph TINYBLOB,
    arnold TINYBLOB,
    bakery TINYBLOB,
    grill TINYBLOB,
    pizza TINYBLOB,
    deli TINYBLOB,
    home_zone TINYBLOB,
    mongolian_grill TINYBLOB,
    produce TINYBLOB,
    soup TINYBLOB,
    tex_mex TINYBLOB,
    healthy_on_the_hilltop TINYBLOB,
    international TINYBLOB,
    salad_bar TINYBLOB,
    time_stamp VARCHAR(45),
    image BLOB,
    PRIMARY KEY (entry_id)
);'; 
  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'CREATE TABLE Comments
  (
    comment_id INT NOT NULL AUTO_INCREMENT,
    comment VARCHAR(100),
    entry_id INT,
    PRIMARY KEY (comment_id),
    FOREIGN KEY (entry_id)
      REFERENCES Entry (entry_id)
);'; 
  $conn->query($sql);
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
