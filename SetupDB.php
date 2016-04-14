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
    attribute_id INT  NOT NULL PRIMARY KEY,
    attribute_name VARCHAR(45)  NOT NULL
  );

  CREATE TABLE IF NOT EXISTS User
  (
    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    salt VARCHAR(250) NOT NULL,
    hash VARCHAR(300) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(15),
    active TINYINT(1) NOT NULL
  );

  CREATE TABLE IF NOT EXISTS Entry
  (
    entry_id INT  NOT NULL  AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(45)  NOT NULL,
    votes INT  NOT NULL,
    time_stamp DateTime  NOT NULL,
    image VARCHAR(100)  NOT NULL,
    dh_id INT NOT NULL,
    station_id INT  NOT NULL,
    user_id INT NOT NULL,
    active TINYINT(1) NOT NULL
  );

  CREATE TABLE IF NOT EXISTS Comment
  (
    comment_id INT  NOT NULL  AUTO_INCREMENT PRIMARY KEY,
    comment VARCHAR(200)  NOT NULL,
    time_stamp DateTime  NOT NULL,
    entry_id INT  NOT NULL,
    user_id INT NOT NULL,
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
    dh_id INT  NOT NULL PRIMARY KEY,
    dh_name VARCHAR(45)  NOT NULL
  );

  CREATE TABLE IF NOT EXISTS Station
  (
    station_id INT  NOT NULL PRIMARY KEY,
    station_name VARCHAR(45)  NOT NULL
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

  $sql = "INSERT IGNORE into Attribute (attribute_id, attribute_name) values (1, 'Hot');
  INSERT IGNORE into Attribute (attribute_id, attribute_name) values (2, 'Cold');
  INSERT IGNORE into Attribute (attribute_id, attribute_name) values (3, 'Vegetarian');
  INSERT IGNORE into Attribute (attribute_id, attribute_name) values (4, 'Vegan');
  INSERT IGNORE into Station (station_id, station_name) values (1, 'Bakery');
  INSERT IGNORE into Station (station_id, station_name) values (2, 'Grill');
  INSERT IGNORE into Station (station_id, station_name) values (3, 'Pizza');
  INSERT IGNORE into Station (station_id, station_name) values (4, 'Deli');
  INSERT IGNORE into Station (station_id, station_name) values (5, 'Home Zone');
  INSERT IGNORE into Station (station_id, station_name) values (6, 'Mongolian Grill');
  INSERT IGNORE into Station (station_id, station_name) values (7, 'Produce');
  INSERT IGNORE into Station (station_id, station_name) values (8, 'Soup');
  INSERT IGNORE into Station (station_id, station_name) values (9, 'Tex Mex');
  INSERT IGNORE into Station (station_id, station_name) values (10, 'Health On The Hilltop');
  INSERT IGNORE into Station (station_id, station_name) values (11, 'International');
  INSERT IGNORE into Station (station_id, station_name) values (12 'Salad Bar');";


  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "INSERT IGNORE into Dining_Hall (dh_id, dh_name) values (2, 'Arnold');
  INSERT IGNORE into Dining_Hall (dh_id, dh_name) values (1, 'Umph');
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

  $sql = "INSERT into User (salt, hash, email, phone, active) values ('ELNjNsSgwbDXpKRFXa7NBjGuFyRVyP', 'ELjVIJe6P9w7g', 'arichardson0@cmu.edu', '591-(481)352-2469', 1);
  INSERT into User (salt, hash, email, phone, active) values ('n7pGScbbaGT327HBbzZYkHaGL3GHv3', '2cZvydbk5D4Vkgf3jacTvvvdemZAtx', 'lramirez1@hatena.ne.jp', '62-(892)331-3167', 1);
  INSERT into User (salt, hash, email, phone, active) values ('a95m4NpC3nyeM54RhTAR4n3Mn8pBAv', 'CWnxucn68vAVMBgEwCdP5WbSqCh6cf', 'ajames2@mozilla.org', '30-(851)903-0129', 1);
  INSERT into User (salt, hash, email, phone, active) values ('QSzgbk7kwR84GX8DfSgbEPYvffAGBD', 'QXkZecUm6E2m7WJcQLs83py4QweHqT', 'pshaw3@hostgator.com', '52-(295)439-0433', 1);
  INSERT into User (salt, hash, email, phone, active) values ('2dcCCMsCdTUZMyswWLryGxDC4zSdrL', 'DNTbCRVFbgfz88GaBE954rjGfFzdpR', 'kmills4@google.it', '51-(123)723-6056', 1);
  INSERT into User (salt, hash, email, phone, active) values ('RaGbWd2AMwzvDHewF4RRdUBTbFcaAz', 'jFTLm4JZssMAvaKRuwKRmeE2VtwGrc', 'pmyers5@youtu.be', '46-(671)666-8364', 1);";

  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $sql = "INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('chicken-salad', 76, '2010-07-14 19:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1458694423/chicken-salad.jpg', 1, 12, 1, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('Croissant', 38, '2008-05-14 20:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1458694423/Croissant.jpg', 2, 1, 2, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('lasagna', 91, '2012-05-14 08:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1458694423/lasagna.jpg', 1, 2, 3, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('fries', 61, '2009-12-14 17:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1458694423/fries.jpg', 2, 2, 4, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('asparagus', 36, '2008-05-14 20:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1460567505/asparagus.jpg', 1, 10, 5, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('bacon', 92, '2012-05-14 08:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1460567641/Bacon.jpg', 2, 4, 6, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('baked beans', 24, '2009-12-14 17:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1460567861/baked_beans.jpg', 1, 7, 1, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('brownie', 35, '2010-07-14 19:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1460568006/Brownies.jpg', 2, 1, 2, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('Pizza', 76, '2010-07-14 19:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1459262991/Pizza.jpg', 1, 4, 3, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('broccoli', 38, '2008-05-14 20:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1460568111/broccoli.jpg', 2, 2, 4, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('buritto', 24, '2009-12-14 17:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1460584391/buritto.jpg', 1, 7, 5, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('Chipotle Chicken Tortilla Soup', 35, '2010-07-14 19:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1460594192/Chipotle%20Chicken%20Tortilla%20Soup.jpg', 2, 5, 2, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('butter-chicken', 76, '2010-07-14 19:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1460594328/Butter-Chicken.jpg', 1, 11, 3, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('baked sweet potato', 38, '2008-05-14 20:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1460594473/sweet_potato.jpg', 2, 2, 4, 1);

  INSERT into Entry_Attributes (entry_id, attribute_id) values (1, 2);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (2, 2);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (3, 1);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (4, 1);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (5, 1);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (6, 1);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (7, 1);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (8, 2);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (9, 1);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (10, 1);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (11, 1);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (12, 1);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (13, 1);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (14, 1);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (2, 3);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (4, 3);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (5, 4);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (7, 3);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (8, 3);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (10, 4);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (14, 3);
  ";

  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('tasty', '2008-02-14 22:37', 1, 23);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('this is great', '2008-02-14 7:12', 2, 40);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not fresh', '2008-02-14 14:29', 3, 21);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('great one', '2008-10-14 20:41', 4, 38);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not so good', '2008-11-14 22:37', 5, 2);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not any more', '2008-04-14 7:12', 6, 4);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('great', '2008-02-14 14:29', 7, 10);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('this is great', '2008-02-14 20:41', 8, 5);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not fresh', '2008-02-14 22:37', 9, 23);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not so good', '2008-02-14 7:12', 10, 35);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('tasty', '2008-02-14 14:29', 1, 14);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('yum', '2008-10-14 20:41', 2, 34);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('this is great', '2008-11-14 22:37', 3, 22);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not so good', '2008-04-14 7:12', 14, 4);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not any more', '2008-02-14 14:29', 4, 10);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('this is great', '2008-02-14 20:41', 13, 50);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('tasty', '2008-02-14 22:37', 6, 3);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not fresh', '2008-02-14 7:12', 7, 44);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('great', '2008-02-14 14:29', 13, 23);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('great one', '2008-10-14 20:41', 9, 38);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('tasty', '2008-11-14 22:37', 10, 2);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not fresh', '2008-04-14 7:12', 1, 4);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('great one', '2008-02-14 14:29', 12, 10);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('tasty', '2008-02-14 20:41', 3, 5);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('great', '2008-02-14 22:37', 14, 26);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not fresh', '2008-02-14 7:12', 11, 44);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('tasty', '2008-02-14 14:29', 6, 22);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('great', '2008-10-14 20:41', 7, 40);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('yum', '2008-11-14 22:37', 8, 22);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('disgusting', '2008-04-14 7:12', 9, 24);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('tasty', '2008-02-14 14:29', 10, 16);";

  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  ?>
