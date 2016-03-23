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
    dh_id INT NOT NULL,
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

  $sql = "insert into Entry (title, votes, time_stamp, image, dh_id, comment_id, station_id) values ('aliquet', 76, '2010-07-14 19:00', 'http:/dummyimage.com/183x191.gif/ff4444/ffffff', 1, 1, 4);
  insert into Entry (title, votes, time_stamp, image, dh_id, comment_id, station_id) values ('purus', 38, '2008-05-14 20:00', 'http:/dummyimage.com/184x163.png/cc0000/ffffff', 2, 2, 12);
insert into Entry (title, votes, time_stamp, image, dh_id, comment_id, station_id) values ('in', 91, '2012-05-14 08:00', 'http:/dummyimage.com/158x103.jpg/5fa2dd/ffffff', 1, 3, 1);
insert into Entry (title, votes, time_stamp, image, dh_id, comment_id, station_id) values ('etiam', 61, '2009-12-14 17:00', 'http:/dummyimage.com/159x243.png/cc0000/ffffff', 2, 4, 5);
insert into Entry_Attributes (entry_id, attribute_id) values (1, 1);
insert into Entry_Attributes (entry_id, attribute_id) values (2, 1);
insert into Entry_Attributes (entry_id, attribute_id) values (3, 1);
insert into Entry_Attributes (entry_id, attribute_id) values (4, 1);
insert into Entry_Attributes (entry_id, attribute_id) values (1, 2);
insert into Entry_Attributes (entry_id, attribute_id) values (2, 2);
insert into Entry_Attributes (entry_id, attribute_id) values (3, 2);
insert into Entry_Attributes (entry_id, attribute_id) values (4, 2);
insert into Entry_Attributes (entry_id, attribute_id) values (1, 3);
insert into Entry_Attributes (entry_id, attribute_id) values (2, 3);
insert into Entry_Attributes (entry_id, attribute_id) values (3, 3);
insert into Entry_Attributes (entry_id, attribute_id) values (4, 3);
insert into Entry_Attributes (entry_id, attribute_id) values (1, 4);
insert into Entry_Attributes (entry_id, attribute_id) values (2, 4);
insert into Entry_Attributes (entry_id, attribute_id) values (3, 4);
insert into Entry_Attributes (entry_id, attribute_id) values (4, 4);
insert into Attribute (name) values ('pede');
insert into Attribute (name) values ('tortor');
insert into Attribute (name) values ('urna');
insert into Attribute (name) values ('donec');
insert into Comment (comment, time_stamp, entry_id) values ('pellentesque', '2008-02-14 22:37', 1);
insert into Comment (comment, time_stamp, entry_id) values ('felis', '2008-02-14 7:12', 2);
insert into Comment (comment, time_stamp, entry_id) values ('habitasse platea dictumst', '2008-02-14 14:29', 3);
insert into Comment (comment, time_stamp, entry_id) values ('dignissim', '2008-02-14 20:41', 4);
insert into Dining_Hall (name) values ('a');
insert into Dining_Hall (name) values ('b');
insert into DiningHall_Station (dh_id, station_id) values (1, 1);
insert into DiningHall_Station (dh_id, station_id) values (1, 2);
insert into DiningHall_Station (dh_id, station_id) values (1, 3);
insert into DiningHall_Station (dh_id, station_id) values (1, 4);
insert into DiningHall_Station (dh_id, station_id) values (1, 5);
insert into DiningHall_Station (dh_id, station_id) values (1, 6);
insert into DiningHall_Station (dh_id, station_id) values (1, 7);
insert into DiningHall_Station (dh_id, station_id) values (1, 8);
insert into DiningHall_Station (dh_id, station_id) values (1, 9);
insert into DiningHall_Station (dh_id, station_id) values (1, 10);
insert into DiningHall_Station (dh_id, station_id) values (1, 11);
insert into DiningHall_Station (dh_id, station_id) values (1, 12);
insert into DiningHall_Station (dh_id, station_id) values (2, 1);
insert into DiningHall_Station (dh_id, station_id) values (2, 2);
insert into DiningHall_Station (dh_id, station_id) values (2, 3);
insert into DiningHall_Station (dh_id, station_id) values (2, 4);
insert into DiningHall_Station (dh_id, station_id) values (2, 5);
insert into DiningHall_Station (dh_id, station_id) values (2, 6);
insert into DiningHall_Station (dh_id, station_id) values (2, 7);
insert into DiningHall_Station (dh_id, station_id) values (2, 8);
insert into DiningHall_Station (dh_id, station_id) values (2, 9);
insert into DiningHall_Station (dh_id, station_id) values (2, 10);
insert into DiningHall_Station (dh_id, station_id) values (2, 11);
insert into DiningHall_Station (dh_id, station_id) values (2, 12);
insert into Station (name) values ('phasellus');
insert into Station (name) values ('eget');
insert into Station (name) values ('proin');
insert into Station (name) values ('sed');
insert into Station (name) values ('nisl');
insert into Station (name) values ('in');
insert into Station (name) values ('faucibus');
insert into Station (name) values ('et');
insert into Station (name) values ('eget');
insert into Station (name) values ('diam');
insert into Station (name) values ('nulla');
insert into Station (name) values ('mauris');
";
  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  ?>
