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

  $sql = 'CREATE TABLE IF NOT EXISTS Attribute
  (
    attribute_id INT  NOT NULL  AUTO_INCREMENT,
    name VARCHAR(45)  NOT NULL,
    CONSTRAINT Attribute_pk PRIMARY KEY (attribute_id)
  );

  CREATE TABLE IF NOT EXISTS Entry
  (
    entry_id INT  NOT NULL  AUTO_INCREMENT,
    title VARCHAR(45)  NOT NULL,
    votes INT  NOT NULL,
    time_stamp DateTime  NOT NULL,
    image VARCHAR(100)  NOT NULL,
    station_id INT  NOT NULL,
    CONSTRAINT entry_id PRIMARY KEY (entry_id)
  );

  CREATE TABLE IF NOT EXISTS Comment
  (
    comment_id INT  NOT NULL  AUTO_INCREMENT,
    comment VARCHAR(200)  NOT NULL,
    time_stamp DateTime  NOT NULL,
    entry_id INT  NOT NULL,
    CONSTRAINT Comment_pk PRIMARY KEY (comment_id),
    CONSTRAINT Comment_Entry_fk FOREIGN KEY (entry_id) REFERENCES Entry (entry_id)
  );

  CREATE TABLE IF NOT EXISTS Dining_Hall
  (
    dh_id INT  NOT NULL  AUTO_INCREMENT,
    name VARCHAR(45)  NOT NULL,
    entry_id INT  NOT NULL,
    CONSTRAINT Dining_Hall_pk PRIMARY KEY (dh_id),
    CONSTRAINT Location_Entry_fk FOREIGN KEY (entry_id) REFERENCES Entry (entry_id)
  );

  CREATE TABLE IF NOT EXISTS Entry_Attributes
  (
    entry_id INT  NOT NULL  AUTO_INCREMENT,
    attribute_id INT  NOT NULL,
    CONSTRAINT Entry_Attributes_pk PRIMARY KEY (entry_id,attribute_id),
    CONSTRAINT Entry_Attributes_Attribute_fk FOREIGN KEY (attribute_id) REFERENCES Attribute (attribute_id),
    CONSTRAINT Entry_Attributes_Entry_fk FOREIGN KEY (entry_id) REFERENCES Entry (entry_id)
  );

  CREATE TABLE IF NOT EXISTS Station
  (
    station_id INT  NOT NULL  AUTO_INCREMENT,
    name VARCHAR(45)  NOT NULL,
    CONSTRAINT Station_pk PRIMARY KEY (station_id)
  );

  CREATE TABLE IF NOT EXISTS DiningHall_Station
  (
    dh_id INT  NOT NULL,
    station_id INT  NOT NULL,
    CONSTRAINT DiningHall_Station_pk PRIMARY KEY (dh_id,station_id),
    CONSTRAINT DiningHall_Station_Dining_Hall_fk FOREIGN KEY (dh_id) REFERENCES Dining_Hall (dh_id),
    CONSTRAINT DiningHall_Station_Station_fk FOREIGN KEY (station_id) REFERENCES Station (station_id)
  );';

  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  ?>
