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
  INSERT IGNORE into Station (station_id, name) values (1, 'Bakery');
  INSERT IGNORE into Station (station_id, name) values (2, 'Grill');
  INSERT IGNORE into Station (station_id, name) values (3, 'Pizza');
  INSERT IGNORE into Station (station_id, name) values (4, 'Deli');
  INSERT IGNORE into Station (station_id, name) values (5, 'Home Zone');
  INSERT IGNORE into Station (station_id, name) values (6, 'Mongolian Grill');
  INSERT IGNORE into Station (station_id, name) values (7, 'Produce');
  INSERT IGNORE into Station (station_id, name) values (8, 'Soup');
  INSERT IGNORE into Station (station_id, name) values (9, 'Tex Mex');
  INSERT IGNORE into Station (station_id, name) values (10, 'Health On The Hilltop');
  INSERT IGNORE into Station (station_id, name) values (11, 'International');
  INSERT IGNORE into Station (station_id, name) values (12 'Salad Bar');";


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
  INSERT into User (salt, hash, email, phone, active) values ('RaGbWd2AMwzvDHewF4RRdUBTbFcaAz', 'jFTLm4JZssMAvaKRuwKRmeE2VtwGrc', 'pmyers5@youtu.be', '46-(671)666-8364', 1);
  INSERT into User (salt, hash, email, phone, active) values ('HKYvTrj7vyQ2jaXL5rPy6tGtFsHbDW', 'JfQj8cPqhRbJkEbQvznns6zpWzPPyn', 'rharris6@google.it', '7-(671)264-8055', 1);
  INSERT into User (salt, hash, email, phone, active) values ('wpCZfvgx6U2cT6qMrNyvB8zzkaMDjY', 'PCYjQpC5vnRdvEtupLY6mEPWrDQyA8', 'ehill7@go.com', '261-(597)577-1739', 1);
  INSERT into User (salt, hash, email, phone, active) values ('yyA4HgVWv4zmrSGNxNvApdFjHAQ68k', '8xgPQsnstrB2Rq7HKD2enJgUjMnSDa', 'rramirez8@angelfire.com', '86-(945)234-6683', 1);
  INSERT into User (salt, hash, email, phone, active) values ('VkqaPxB3g5eButWLVbSfS8r6BvWBtS', 'PB86qYeNkrfPc6QnsztdYSgkt23zAT', 'rspencer9@furl.net', '86-(674)531-1550', 1);
  INSERT into User (salt, hash, email, phone, active) values ('E2xBGEVkbyz8rRSEDfn4tgawaGLQeF', 'KAdAREyHe29A5zV6QNrYHeVCTazdXc', 'rhernandeza@angelfire.com', '7-(582)725-0872', 1);
  INSERT into User (salt, hash, email, phone, active) values ('KRzFLE5SxTtvhe27YZDT53y6SDEHXp', 'JFLbutU6M5dxUwuhTy6DQ6jW7pFXL7', 'clawsonb@amazonaws.com', '86-(156)956-5032', 1);
  INSERT into User (salt, hash, email, phone, active) values ('NRYf9yRXeSHV7s2bQJxZtYwkcUkETW', 'ScW2z8JSEaxfSU6LfEMWQb3TZrh6GK', 'fpayned@google.com.au', '81-(223)950-2861', 1);
  INSERT into User (salt, hash, email, phone, active) values ('vJW3XVqydxSQgsRkuSEsqcTdDm8EG2', 'M6UrW5nC5FvXYRHQQaLEGydjsnKeqW', 'bwelche@gov.uk', '353-(200)204-6584', 1);
  INSERT into User (salt, hash, email, phone, active) values ('ZxysSguV2bnMFgq4K5FFfkMruSjQAp', 'CxjmEB6gtH5kHQkdQKG475ZVBfPRfE', 'jharrisonf@sohu.com', '375-(806)185-8177', 1);
  INSERT into User (salt, hash, email, phone, active) values ('jdsnTB2Kf3XhcdDYejCUPrh6qSpwja', 'E6MT3yAZuGSbwrsNDtmEdvdETgcLws', 'jshawg@51.la', '48-(236)153-9104', 1);
  INSERT into User (salt, hash, email, phone, active) values ('tKaLvQEFwHwZ6wJwVVNg8kgCjvRpAb', 'CrqwF2d6XAF9dJK7zQGURDSjrUmWbD', 'gmatthewsh@e-recht24.de', '62-(411)738-5781', 1);
  INSERT into User (salt, hash, email, phone, active) values ('vrQeDhfAbbnyh2td5BTUbLMqY2HyjK', 'TCkBnGHKcVSUEFcwv2b2pgV6yT3Y7V', 'jdixoni@nature.com', '351-(768)753-1860', 1);
  INSERT into User (salt, hash, email, phone, active) values ('wz6BZawKdLJaWEJkMnP5S3wRf397h4', 'eV3L4RChAWv5bzQaZtaHdhT8NyFJDZ', 'kmurrayj@discovery.com', '82-(298)644-4925', 1);
  INSERT into User (salt, hash, email, phone, active) values ('uKk4nghAbP83Dc7fhDpDFfPS7yMkn5', 'fMxM5XxpKfsBnAWCWXm5yChurXnJ6V', 'jbellk@harvard.edu', '507-(338)620-4629', 1);
  INSERT into User (salt, hash, email, phone, active) values ('vQf89VLt4UnXMhqtbPpPKYEr2wBUvr', 'HFBg9V3szpMVeY4WuHXtsysd8xReub', 'mhunterl@buzzfeed.com', '351-(446)222-3481', 1);
  INSERT into User (salt, hash, email, phone, active) values ('c9vpwWuGLPYHHSkNPSZg3JvS2mGCRx', 'UyAjpuGGQwHyJtPrVHyn2Acx8mTykD', 'kwheelerm@harvard.edu', '233-(603)990-3663', 1);
  INSERT into User (salt, hash, email, phone, active) values ('nFHsvxcacxxCQHckWBJBnf39JM3Zp8', 'szYV5JU6zH2aX9n8JLAMuwEJa259SW', 'kgriffinn@addtoany.com', '966-(395)533-1797', 1);
  INSERT into User (salt, hash, email, phone, active) values ('uYzhtYdtNEuDhPSESq2r5MNyQw8XHc', 'Dd4m2NbhSkJM6fGjKFMPfn4dAgm6PB', 'delliso@uiuc.edu', '86-(948)515-1107', 1);
  INSERT into User (salt, hash, email, phone, active) values ('pJMWcbcQ54HwBCLcv4YP8WHmChhL62', 'dvk6yTtVEVBcmTT7gUvcT8UfMNSBDd', 'bsullivanp@unicef.org', '242-(479)149-1445', 1);
  INSERT into User (salt, hash, email, phone, active) values ('WjLJvZG2Dr3eqVXFnT5nsyGhDCKvat', 'HVFEk2BEymmZbDVk6ZBz6zMbWeR5Wn', 'mwagnerq@intel.com', '7-(851)830-9614', 1);
  INSERT into User (salt, hash, email, phone, active) values ('xc9dX7emDdjVTenGTzNXwCwxeyUrja', 'tGTvPgn2JKZ7AqEJH24fZCHN6zkdqD', 'cjamesr@ow.ly', '46-(285)915-9241', 1);
  INSERT into User (salt, hash, email, phone, active) values ('kGeEpK7V8pdV92vBWtTHXzdpJBHhSK', 'FfBKMezMzwGgpmBRuPtbRmMjZUdrKE', 'hrobinsons@archive.org', '31-(943)411-4017', 1);
  INSERT into User (salt, hash, email, phone, active) values ('LsDWepjgmzvvc3amN377panJVZNrXE', 'm4UnXrfXAarXFMKL3umWBRAkPy6Y92', 'awelcht@a8.net', '62-(763)404-7121', 1);
  INSERT into User (salt, hash, email, phone, active) values ('DpPRStrB55qf2FRMCLTudF2b7JcrAE', 'hMQv3kkz2n8Uvn2K7L3HkbGdF2nM3C', 'mwoodsu@xrea.com', '86-(382)914-9462', 1);
  INSERT into User (salt, hash, email, phone, active) values ('K5UaXYMQB5BjgE6qgq2marRWVrFAje', '32MjaRUQ4kcAuT2EbC6qyJ4eDZkUWR', 'jbishopv@mysql.com', '86-(179)594-9438', 1);
  INSERT into User (salt, hash, email, phone, active) values ('xDtFLsabWnDF6Yz49qGWE2Nw4pXKTq', '4dPePd9FqZBRh7D2reXj8fRT8szpxA', 'achavezw@mail.ru', '62-(337)140-8502', 0);
  INSERT into User (salt, hash, email, phone, active) values ('yeRsvFL3FzfM8Fj69BTYYNkFPermGW', 'YmFPfmuScXXRUyUyWduHTLTzJc2hPK', 'rwellsx@sogou.com', '420-(100)690-2579', 1);
  INSERT into User (salt, hash, email, phone, active) values ('wZNGVjLT66zzHwWZazQZbNpxRj88Sz', '45ZgJFp9NLuVAbsGjPA3jssnvTv39L', 'pnguyeny@alibaba.com', '86-(307)694-8381', 1);
  INSERT into User (salt, hash, email, phone, active) values ('UYhJUXhxSaRdHMr2KhBnfWgUTaGNkQ', 'ePf42Wv6qkAUfDyueTTBgnCGJVP3Uw', 'bmcdonaldz@timesonline.co.uk', '52-(558)824-0479', 1);
  INSERT into User (salt, hash, email, phone, active) values ('TcC894ULYzjmR4T6JE77AA3EBW78uE', 'xGWecYD5tkvwsZDb6Gb9tsGYcbdCDx', 'bstephens10@sitemeter.com', '55-(707)461-5759', 1);
  INSERT into User (salt, hash, email, phone, active) values ('47hNnqvgvvAZWN42njYusCgVmChuEx', 'QvgQLMRBhznjbZsu4NGrft5Nrx2RcH', 'jcunningham11@walmart.com', '7-(943)761-1239', 1);
  INSERT into User (salt, hash, email, phone, active) values ('ppkymYpNDG6SqP5EYTAt3njnACYtZ2', 'vV92rKPxxvJCsXnRpfaDyEbYEFTaQM', 'pmatthews12@yellowpages.com', '380-(274)475-1948', 1);
  INSERT into User (salt, hash, email, phone, active) values ('fF28Fp97dJhQTvv7p2Uqc6nWZ4xsM9', 'nqKHESRqmeBMUbSch8BKWchk9J6ku6', 'mfernandez13@usa.gov', '961-(290)986-2818', 1);
  INSERT into User (salt, hash, email, phone, active) values ('RSbe6pMr6fwuUwT7AK7jfvyBJCfynN', 'ppkymYpNDG6SqP5EYTAt3njnACYtZ2', 'lowens14@hugedomains.com', '46-(915)232-0040', 1);
  INSERT into User (salt, hash, email, phone, active) values ('reXVdzcVLxmz2HmDURfe8KGQ6C4GsE', 'HJEZCM6Gsk3GffvPEX4DuBaHycugud', 'wburton15@hostgator.com', '86-(110)925-3609', 1);
  INSERT into User (salt, hash, email, phone, active) values ('9JLQP8eagNcNuE6XvwyJmPrMmMve9s', 'hMwrmDMqx7ht4VB6tQagmuqtuqnxBU', 'cramos16@domainmarket.com', '351-(438)140-6497', 1);
  INSERT into User (salt, hash, email, phone, active) values ('ufR6qEYnwyzcfUaXZj6MdyPmBzNZKY', 'xZ9ZAZkM5F7wHfyU5yt4J79V79pMRt', 'fbailey17@earthlink.net', '63-(980)357-8530', 1);
  INSERT into User (salt, hash, email, phone, active) values ('BA7xNegSKnKCmJ5UtNcJyDHn558NTR', 'GvBEeQJ8JxftjfNnD4QPDRVQXJXLua', 'rruiz18@newsvine.com', '86-(626)589-0400', 1);
  INSERT into User (salt, hash, email, phone, active) values ('EHJETzXC7jKtH8spRuaxuvFJq3tVD7', 'V5q63XKp65mq2kzjYcVePvcabXzcz2', 'dcampbell19@printfriendly.com', '86-(628)285-4451', 1);
  INSERT into User (salt, hash, email, phone, active) values ('kVmH49qfRM4xNpKq3JVkQTL6rzxrj3', 'KnNUAdLvD2wass8K6SQQ5cvwQhpFaS', 'ewright1a@dion.ne.jp', '992-(788)334-3494', 1);
  INSERT into User (salt, hash, email, phone, active) values ('daCtgy2WqXzpdcZWJ6zYjZH96gFafv', 'pmPCk5KLA29WtyBJSu7L9EfNR9Mf4J', 'pgardner1b@pinterest.com', '62-(233)533-1406', 1);
  INSERT into User (salt, hash, email, phone, active) values ('QJeV92AdvjEDGgqGKsdPGcdJ3VfxTD', 'yDeSSDvt3cyxdPu9YJyhFJEkKEwu7D', 'awheeler1c@xing.com', '7-(114)998-6437', 1);
  INSERT into User (salt, hash, email, phone, active) values ('F2ytWkQ5Fyx72qQu9VaaWPLgWqLeYR', 'Knz4AJZPTLqKvatWXQ4Sz6NmhPUe5T', 'jbradley1d@yale.edu', '86-(199)238-3551', 1);";

  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('chicken-salad', 76, '2010-07-14 19:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1458694423/chicken-salad.jpg', 1, 4, 24, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('Croissant', 38, '2008-05-14 20:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1458694423/Croissant.jpg', 2, 12, 20, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('lasagna', 91, '2012-05-14 08:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1458694423/lasagna.jpg', 1, 1, 2, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('fries', 61, '2009-12-14 17:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1458694423/fries.jpg', 2, 5, 17, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('asparagus', 36, '2008-05-14 20:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1460567505/asparagus.jpg', 2, 12, 20, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('bacon', 92, '2012-05-14 08:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1460567641/Bacon.jpg', 1, 4, 26, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('baked beans', 24, '2009-12-14 17:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1460567861/baked_beans.jpg', 2, 7, 12, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('brownie', 35, '2010-07-14 19:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1460568006/Brownies.jpg', 1, 1, 5, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('Pizza', 76, '2010-07-14 19:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1459262991/Pizza.jpg', 1, 4, 24, 1);
  INSERT into Entry (title, votes, time_stamp, image, dh_id, station_id, user_id, active) values ('broccoli', 38, '2008-05-14 20:00', 'http://res.cloudinary.com/doazmoxb7/image/upload/v1460568111/broccoli.jpg', 2, 12, 20, 1);

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
  INSERT into Entry_Attributes (entry_id, attribute_id) values (2, 3);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (4, 3);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (5, 4);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (7, 3);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (8, 3);
  INSERT into Entry_Attributes (entry_id, attribute_id) values (10, 4);
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
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not so good', '2008-10-14 20:41', 2, 34);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('this is great', '2008-11-14 22:37', 3, 22);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not so good', '2008-04-14 7:12', 14, 4);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not any more', '2008-02-14 14:29', 4, 10);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('this is great', '2008-02-14 20:41', 5, 50);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('tasty', '2008-02-14 22:37', 6, 3);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not fresh', '2008-02-14 7:12', 7, 44);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('great', '2008-02-14 14:29', 8, 23);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('great one', '2008-10-14 20:41', 9, 38);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('tasty', '2008-11-14 22:37', 10, 2);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not fresh', '2008-04-14 7:12', 1, 4);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('great one', '2008-02-14 14:29', 2, 10);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('tasty', '2008-02-14 20:41', 3, 5);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('great', '2008-02-14 22:37', 4, 26);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not fresh', '2008-02-14 7:12', 5, 44);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('tasty', '2008-02-14 14:29', 6, 22);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('great, '2008-10-14 20:41', 7, 40);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not fresh', '2008-11-14 22:37', 8, 22);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('not any more', '2008-04-14 7:12', 9, 24);
  INSERT into Comment (comment, time_stamp, entry_id, user_id) values ('tasty', '2008-02-14 14:29', 10, 16);

  $conn->query($sql);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  ?>
