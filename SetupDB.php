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

  $sql = 'CREATE TABLE IF NOT Exists Characteristics
  (
    characteristics_id int  NOT NULL  AUTO_INCREMENT,
    hot TINYINT(1),
    cold TINYINT(1),
    vegetarian TINYINT(1),
    vegan TINYINT(1),
    entry_id INT  NOT NULL,
    CONSTRAINT Characteristics_pk PRIMARY KEY (characteristics_id)
  );

  CREATE TABLE IF NOT EXISTS Comment
  (
    comment_id INT  NOT NULL  AUTO_INCREMENT,
    comment VARCHAR(200)  NOT NULL,
    time_stamp DateTime  NOT NULL,
    entry_id INT  NOT NULL,
    CONSTRAINT Comment_pk PRIMARY KEY (comment_id)
  );

  CREATE TABLE IF NOT EXISTS Entry
  (
    entry_id int  NOT NULL  AUTO_INCREMENT,
    title varchar(45)  NOT NULL,
    votes int,
    time_stamp timestamp  NOT NULL,
    image varchar(100)  NOT NULL,
    location_id int  NOT NULL,
    characteristics_id int,
    comment_id int,
    CONSTRAINT entry_id PRIMARY KEY (entry_id)
  );';

  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = 'CREATE TABLE IF NOT EXISTS Location
  (
    location_id int  NOT NULL  AUTO_INCREMENT,
    umph tinyint(1),
    arnold tinyint(1),
    bakery tinyint(1),
    grill tinyint(1),
    pizza tinyint(1),
    deli tinyint(1),
    home_zone tinyint(1),
    mongolian_grill tinyint(1),
    produce tinyint(1),
    soup tinyint(1),
    tex_mex tinyint(1),
    healthy_on_the_hilltop tinyint(1),
    international tinyint(1),
    salad_bar tinyint(1),
    entry_id int  NOT NULL,
    CONSTRAINT Location_pk PRIMARY KEY (location_id)
  );';

  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  ?>
