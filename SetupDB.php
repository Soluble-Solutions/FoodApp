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

  $sql = "CREATE TABLE IF NOT EXISTS Attribute
  (
    attribute_id INT  NOT NULL,
    name VARCHAR(45)  NOT NULL,
    CONSTRAINT Attribute_pk PRIMARY KEY (attribute_id)
  );

  CREATE TABLE IF NOT EXISTS User
  (
    user_id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(45) NOT NULL,
    salt VARCHAR(250) NOT NULL,
    hash VARCHAR(45) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(15),
    active TINYINT(1) NOT NULL,
    CONSTRAINT user_id PRIMARY KEY (user_id)
  );

  CREATE TABLE IF NOT EXISTS Entry
  (
    entry_id INT  NOT NULL  AUTO_INCREMENT,
    title VARCHAR(45)  NOT NULL,
    votes INT  NOT NULL,
    time_stamp DateTime  NOT NULL,
    image VARCHAR(100)  NOT NULL,
    dh_id INT NOT NULL,
    station_id INT  NOT NULL,
    user_id INT NOT NULL,
    active TINYINT(1) NOT NULL,
    CONSTRAINT entry_id PRIMARY KEY (entry_id)
  );

  CREATE TABLE IF NOT EXISTS Comment
  (
    comment_id INT  NOT NULL  AUTO_INCREMENT,
    comment VARCHAR(200)  NOT NULL,
    time_stamp DateTime  NOT NULL,
    entry_id INT  NOT NULL,
    user_id INT NOT NULL,
    CONSTRAINT Comment_pk PRIMARY KEY (comment_id),
    CONSTRAINT Comment_Entry_fk FOREIGN KEY (entry_id) REFERENCES Entry (entry_id)
  );

  CREATE TABLE IF NOT EXISTS Entry_Attributes
  (
    entry_id INT  NOT NULL,
    attribute_id INT  NOT NULL,
    CONSTRAINT Entry_Attributes_pk PRIMARY KEY (entry_id,attribute_id),
    CONSTRAINT Entry_Attributes_Attribute_fk FOREIGN KEY (attribute_id) REFERENCES Attribute (attribute_id),
    CONSTRAINT Entry_Attributes_Entry_fk FOREIGN KEY (entry_id) REFERENCES Entry (entry_id)
  );

  CREATE TABLE IF NOT EXISTS Dining_Hall
  (
    dh_id INT  NOT NULL,
    name VARCHAR(45)  NOT NULL,
    CONSTRAINT Dining_Hall_pk PRIMARY KEY (dh_id)
  );

  CREATE TABLE IF NOT EXISTS Station
  (
    station_id INT  NOT NULL,
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
  );";

  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "INSERT IGNORE into Attribute (attribute_id, name) values (1, 'Hot');
  INSERT IGNORE into Attribute (attribute_id, name) values (2, 'Cold');
  INSERT IGNORE into Attribute (attribute_id, name) values (3, 'Vegetarian');
  INSERT IGNORE into Attribute (attribute_id, name) values (4, 'Vegan');
  INSERT IGNORE into Station (station_id, name) values (1, 'Bakery');
  INSERT IGNORE into Station (station_id, name) values (2, 'Griz');
  INSERT IGNORE into Station (station_id, name) values (3, 'Bakery');
  INSERT IGNORE into Station (station_id, name) values (4, 'Grill');
  INSERT IGNORE into Station (station_id, name) values (5, 'Pizza');
  INSERT IGNORE into Station (station_id, name) values (6, 'Deli');
  INSERT IGNORE into Station (station_id, name) values (7, 'Home Zone');
  INSERT IGNORE into Station (station_id, name) values (8, 'Mongolian Grill');
  INSERT IGNORE into Station (station_id, name) values (9, 'Produce');
  INSERT IGNORE into Station (station_id, name) values (10, 'Soup');
  INSERT IGNORE into Station (station_id, name) values (11, 'Tex Mex');
  INSERT IGNORE into Station (station_id, name) values (12, 'Health On The Hilltop');
  INSERT IGNORE into Station (station_id, name) values (13, 'International');
  INSERT IGNORE into Station (station_id, name) values (14 'Salad Bar');";

  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "INSERT IGNORE into Dining_Hall (dh_id, name) values (2, 'Arnold');
  INSERT IGNORE into Dining_Hall (dh_id, name) values (1, 'Umph');
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (1, 1);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (1, 2);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (1, 3);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (1, 4);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (1, 5);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (1, 7);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (1, 8);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (1, 10);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (1, 11);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (1, 12);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (2, 1);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (2, 2);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (2, 3);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (2, 4);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (2, 5);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (2, 6);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (2, 7);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (2, 8);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (2, 9);
  INSERT IGNORE into DiningHall_Station (dh_id, station_id) values (2, 12);";

  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, active) values ('aliquet', 76, '2010-07-14 19:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1458694423/chicken-salad.jpg', 1, 4, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id,  station_id, active) values ('purus', 38, '2008-05-14 20:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1458694423/Croissant.jpg', 2, 12, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, active) values ('in', 91, '2012-05-14 08:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1458694423/lasagna.jpg', 1, 1, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, active) values ('etiam', 61, '2009-12-14 17:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1458694423/fries.jpg', 2, 5, 1);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (1, 1);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (2, 1);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (3, 2);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (4, 2);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (2, 3);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (3, 3);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (1, 4);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (4, 4);
  INSERT into Comment (comment, time_stamp, entry_id) values ('pellentesque', '2008-02-14 22:37', 1);
  INSERT into Comment (comment, time_stamp, entry_id) values ('felis', '2008-02-14 7:12', 2);
  INSERT into Comment (comment, time_stamp, entry_id) values ('habitasse platea dictumst', '2008-02-14 14:29', 3);
  INSERT into Comment (comment, time_stamp, entry_id) values ('dignissim', '2008-02-14 20:41', 4);";
  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  ?>
