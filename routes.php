<?php

// Routes
$servername = "localhost";
$username = "admin";

date_default_timezone_set('America/Chicago');

$app->get('/index', function ($request, $response, $args) {

    // Sample log message
  try{
    $db = $this->dbConn;
    $currentTime = date("H:i:s");
    $weekday = date('w');
    $day = date("Y-m-d");

    $sql = 'SELECT entry_id,time_stamp
            FROM Entry
            WHERE active = 1
            ORDER BY votes DESC'; #ORDER BY votes DESC
    $q = $db->query($sql);
    $check = $q->fetchAll(PDO::FETCH_ASSOC);
    $sql = 'SELECT *
            FROM Entry
            WHERE active = 1'; #ORDER BY votes DESC
    $q = $db->query($sql);
    $check = $q->fetchAll(PDO::FETCH_ASSOC);
    return $response->write(json_encode($check));
  }
  catch(PDOException $e){
    $this->notFoundHandler; //404
    //$app->$response->setStatus(404);
    //echo "Error: ".$e.getMessage();
  }
});


$app->put('/index',function($request,$response,$args)
{
  $db = $this->dbConn;
  $data = $request->getParsedBody();
  $entry_id = $data['entry_id'];
  $votes = $data['votes'];
  $user_id = $data['user_id'];
  //$sql = "UPDATE Entry SET votes = '$votes' WHERE entry_id = '$entry_id'";
  //$retr_votes= $db->query($sql);
  $sql = "SELECT votes FROM Entry WHERE entry_id = '$entry_id'";
  $result = $db->query($sql);
  $arr = $result->fetch(PDO::FETCH_ASSOC);
  $retr_votes = $arr['votes'];

  if($retr_votes == $votes){
    $success = "false";
    /*$sql = "SELECT votes FROM entry_id WHERE entry_id = '$entry_id'";
    $result = $db->query($sql);*/
    $messageDB = "Number of votes hasn't changed";
    $str = array("success" => $success, "votes" => $retr_votes, "messageDB" =>$messageDB);
    //echo $success;
    return $response->write(json_encode($str));
  }
  else if($retr_votes < $votes) //if(!empty($retr_votes))//
  {
    $sql = "SELECT upvote FROM User_Votes WHERE entry_id = '$entry_id' AND user_id = '$user_id'";
    $result = $db->query($sql);
    $arr = $result->fetch(PDO::FETCH_ASSOC);
    $upvoted = (int)$arr['upvote'];

    if(empty($arr))
    {
      $success = "true";
      $sql = "UPDATE Entry SET votes = '$votes' WHERE entry_id = '$entry_id'";
      $db->query($sql);
      $sql = "INSERT into User_Votes(entry_id,user_id,upvote,downvote) VALUES ('$entry_id','$user_id',1,0)";
      $db->query($sql);
      $str = array("success" => $success, "votes" => $votes);
      return $response->write(json_encode($str));

    }

    else if($upvoted == 0)
    {
      $success = "true";
      $sql = "UPDATE Entry SET votes = '$votes' WHERE entry_id = '$entry_id'";
      $db->query($sql);
      $sql = "UPDATE User_Votes SET upvote = 1 WHERE entry_id = '$entry_id' AND user_id = '$user_id';
              UPDATE User_Votes SET downvote = 0 WHERE entry_id = '$entry_id' AND user_id = '$user_id';";
      $db->query($sql);
      $str = array("success" => $success, "votes" => $votes);
      return $response->write(json_encode($str));
    }

    else {
      $success = "true";
      $sql = "UPDATE Entry SET votes = ('$retr_votes' - 1) WHERE entry_id = '$entry_id'";
      $db->query($sql);
      $sql = "UPDATE User_Votes SET upvote = 0 WHERE entry_id = '$entry_id' AND user_id = '$user_id';
              UPDATE User_Votes SET downvote = 0 WHERE entry_id = '$entry_id' AND user_id = '$user_id';";
      $db->query($sql);
      $str = array("success" => $success, "votes" => $retr_votes-1);
      return $response->write(json_encode($str));
    }
  }

  else
  {
    $sql = "SELECT downvote FROM User_Votes WHERE entry_id = '$entry_id' AND user_id = '$user_id'";
    $result = $db->query($sql);
    $arr = $result->fetch(PDO::FETCH_ASSOC);
    $downvoted = (int)$arr['downvote'];

    if(empty($arr))
    {
      $success = "true";
      $sql = "UPDATE Entry SET votes = '$votes' WHERE entry_id = '$entry_id'";
      $db->query($sql);
      $sql = "INSERT into User_Votes(entry_id,user_id,upvote,downvote) VALUES ('$entry_id','$user_id',0,1)";
      $db->query($sql);
      $str = array("success" => $success, "votes" => $votes);
      return $response->write(json_encode($str));
    }

    else if($downvoted == 0)
    {
      $success = "true";
      $sql = "UPDATE Entry SET votes = '$votes' WHERE entry_id = '$entry_id'";
      $db->query($sql);
      $sql = "UPDATE User_Votes SET downvote = 1 WHERE entry_id = '$entry_id' AND user_id = '$user_id';
              UPDATE User_Votes SET upvote = 0 WHERE entry_id = '$entry_id' AND user_id = '$user_id';";
      $db->query($sql);
      $str = array("success" => $success, "votes" => $votes);
      return $response->write(json_encode($str));
    }
    else {
      $success = "true";
      $sql = "UPDATE Entry SET votes = ('$retr_votes' + 1) WHERE entry_id = '$entry_id'";
      $db->query($sql);
      $sql = "UPDATE User_Votes SET upvote = 0 WHERE entry_id = '$entry_id' AND user_id = '$user_id';
              UPDATE User_Votes SET downvote = 0 WHERE entry_id = '$entry_id' AND user_id = '$user_id';";
      $db->query($sql);
      $str = array("success" => $success, "votes" => $retr_votes+1);
      return $response->write(json_encode($str));
    }
  }

});

$app->post('/entry',function($request,$response,$args)
{
  $db = $this->dbConn;
  $data = $request->getParsedBody();
  $dh_id = $data['dh_id'];
  $user_id = $data['user_id'];
  $station_id = $data['station_id'];
  $attribute_id =$data['attribute_id'];
//  $image = $data['image'];
  $image = "http://res.cloudinary.com/doazmoxb7/image/upload/v1460929747/noodles_c4gq9p.jpg";
  $title = $data['title'];
  $comment = $data['comment'];
  $time_stamp = date("Y-m-d H:i:s");
  $time = date("H:i:s");
  $weekday = date('w');
  $active = 1;
  $meal = 0;


  if($weekday == 0 || $weekday == 6)
  {
    if( strtotime("00:00:00") < strtotime($time) && strtotime($time) <= strtotime("12:00:00"))
    {
      $meal = 1;
    }

    else if( strtotime("12:00:00") < strtotime($time) && strtotime($time) <= strtotime("14:30:00"))
    {
      $meal = 2;
    }

    else if( strtotime("14:30:00") < strtotime($time) && strtotime($time) <= strtotime("22:00:00"))
    {
      $meal = 3;
    }
  }
  else
  {
    if( (strtotime("00:00:00") < strtotime($time) )&& (strtotime($time) <= strtotime("10:30:00")))
    {
      $meal = 1;
    }

    else if( (strtotime("10:30:00") < strtotime($time)) && (strtotime($time) <= strtotime("14:30:00")))
    {
      $meal = 2;
    }

    else if(( strtotime("14:30:00") < strtotime($time)) && (strtotime($time) <= strtotime("22:00:00")))
    {
      $meal = 3;
    }
  }


  $sql = 'SELECT dh_id
          FROM Dining_Hall'; #ORDER BY votes DESC
  $q = $db->query($sql);
  $currentDH = $q->fetchAll(PDO::FETCH_ASSOC);

  $sql = 'SELECT user_id
          FROM User'; #ORDER BY votes DESC
  $q = $db->query($sql);
  $currentUsers = $q->fetchAll(PDO::FETCH_ASSOC);

  $sql = 'SELECT station_id
          FROM Station'; #ORDER BY votes DESC
  $q = $db->query($sql);
  $currentStations = $q->fetchAll(PDO::FETCH_ASSOC);

  $sql = "SELECT title
          FROM Entry
          WHERE dh_id = '$dh_id' AND station_id = '$station_id' AND active = 1";
  $q = $db->query($sql);
  $currentEntries = $q->fetchAll(PDO::FETCH_ASSOC);

  $alreadExhists = 0;
  foreach($currentEntries as $cE)
  {
    $lenDiff = (strlen($cE['title']) + strlen($title))/5;
    if (levenshtein($cE['title'], $title) < $lenDiff)
      $alreadExhists = 1;
  }

  #echo $alreadExhists;

  if(empty($dh_id) || empty($user_id) || empty($station_id) || empty($attribute_id) || empty($image) || empty($title))
  {
    $success = "false";
    $messageDB = "Empty Data Sent";
    $str = array("success" => $success, "messageDB" =>$messageDB );
    //echo $success;
    return $response->write(json_encode($str));
  }

  else if(!in_array(array("dh_id"=>(string)$dh_id),$currentDH))
  {
    $success = "false";
    $messageDB = "That Dining Hall ID $dh_id does not exists";
    $str = array("success" => $success, "messageDB" =>$messageDB );
    //echo $success;
    return $response->write(json_encode($str));
  }

  else if(!in_array(array("user_id"=>(string)$user_id),$currentUsers))
  {
    $success = "false";
    $messageDB = "That User ID $user_id does not exists";
    $str = array("success" => $success, "messageDB" =>$messageDB );
    //echo $success;
    return $response->write(json_encode($str));
  }

  else if(!in_array(array("station_id"=>(string)$station_id),$currentStations))
  {

    foreach($attribute_id as $attribute)
    {
      echo gettype($attribute);
      print_r(array_values($attribute_id));
    }

    $success = "false";
    $messageDB = "That Station ID $station_id does not exists";
    $str = array("success" => $success, "messageDB" =>$messageDB );
    //echo $success;
    return $response->write(json_encode($str));
  }

  else if($alreadExhists == 1)
  {
    $success = "false";
    $messageDB = "This Food Item is Currently in the Feed";
    $str = array("success" => $success, "messageDB" =>$messageDB );
    return $response->write(json_encode($str));
  }

  else
  {
    $sql = "INSERT INTO Entry (image,title,time_stamp,dh_id,station_id,active,user_id,meal) VALUES ('$image','$title','$time_stamp','$dh_id','$station_id','$active','$user_id','$meal');";

    $db->query($sql);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    #GET Entry_id from first line (based on image)
    $sql = "SELECT entry_id FROM Entry WHERE image = '$image' AND time_stamp = '$time_stamp';";
    $query = $db->query($sql);
    $arr = $query->fetch(PDO::FETCH_ASSOC);
    $entry_id = (int)$arr['entry_id'];
    if(!empty($comment))
    {
      $sql ="INSERT INTO Comment (comment,time_stamp,entry_id,user_id) VALUES ('$comment','$time_stamp','$entry_id','$user_id');";
      $db->query($sql);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    foreach($attribute_id as $attribute)
    {

      $attributenum =(int)$attribute['attribute'];
      $sql = "INSERT INTO Entry_Attributes(entry_id,attribute_id) VALUES ('$entry_id','$attributenum');";
      $db->query($sql);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    $success = "true";
    $str = array("success" => $success);
    //echo $success;
    return $response->write(json_encode($str));
}
});

$app->get('/comment/{entry_id}', function ($request, $response, $args) {
  try{
    $entry_id = $request->getAttribute('entry_id');
    $sql = "SELECT * FROM Entry WHERE entry_id = $entry_id";
   // echo gettype($entry_id);
    $db = $this->dbConn;
    $q = $db->query($sql);
    $entrydata = $q->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT c.comment
            FROM Comment c
            INNER JOIN Entry e
            ON e.entry_id = c.entry_id
            AND e.entry_id = '$entry_id';";

    $q = $db->query($sql);
    $commentdata = $q->fetchAll(PDO::FETCH_ASSOC);

    $check = ['entry'=>$entrydata, 'comment'=>$commentdata];
    return $response->write(json_encode($check));
  }
  catch(PDOException $e){
    $this->notFoundHandler; //404
    //$app->$response->setStatus(404);
    //echo "Error: ".$e.getMessage();
  }
});

$app->post('/comment',function($request,$response,$args){
  $db = $this->dbConn;
  $data = $request->getParsedBody();
  $entry_id = $data['entry_id'];
  $user_id = $data['user_id'];
  $comment = $data['comment'];

  $sql = "INSERT INTO Comment (comment,time_stamp,entry_id,user_id) VALUES ('$comment',now(),'$entry_id','$user_id');"; #now()
  $db->query($sql);
});

$app->put('/login',function($request,$response,$args)
{
    $db = $this->dbConn;
    $data = $request->getParsedBody();
    $email = $data['email']; //change to user?
    $password = $data['password'];
    $sql = "SELECT hash, salt, user_id, active
            FROM User
            WHERE email = '$email';";
    $q = $db->query($sql);
    $array = $q->fetch(PDO::FETCH_ASSOC);
    $hash = $array['hash'];
    //echo $hash, "\n";
    $salt = $array['salt'];

    $currentactivity= (int)$array['active'];
    //echo $salt, "\n";
    $user_id = (int)$array['user_id'];

    $active = 1;
    //$pass = "tester123";
    //$test_hash = crypt($pass,"ELNjNsSgwbDXpKRFXa7NBjGuFyRVyP");

    //echo $test_hash;
    //echo "hash: ".$hash;
    $test = crypt($password,$salt);
    //echo $test;
    //echo "crypt($password,$hash): ".$test;
    //echo json_encode($currentactivity);

    if($currentactivity == 1) //already logged in
    {
      $success = "false";
      $messageDB = "already logged in";
      //echo $success;
      $str = array("success" => $success, "messageDB" =>$messageDB);
      return $response->write(json_encode($str));
    }
    else if(hash_equals($hash,crypt($password,$salt))) // Valid
    {
      //$this->logger->info("success=true");
      //SESSION STUFF
      $sql = "UPDATE User SET active = $active WHERE user_id = '$user_id'";
      $db->query($sql);
      $success = "true";
      //echo $success;
      $str = array("success" => $success, "user_id" =>$user_id);
      //echo $success;
      return $response->write(json_encode($str));
      //return $response->withJson($str,200);
      //return $response->write(json_encode($success)); //?
    }
    else //incorrect password
    {
     //$this->logger->info("success=false");
      $success = "false";
      $messageDB = "incorrect password";
      //echo $success;
      $str = array("success" => $success, "messageDB" =>$messageDB);
      return $response->write(json_encode($str));
      //return $response->withJson($str,401);
    }


});
//Referenced from https://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/
$app->post('/registration',function($request,$response,$args)
{
  $db = $this->dbConn;
  $data = $request->getParsedBody();
  $password = $data['password'];
  $email = $data['email'];
  $phone = $data['phone'];
  $active = 1; //? Needed?
  $cost = 10;
  $salt = strtr(base64_encode(mcrypt_create_iv(16,MCRYPT_DEV_URANDOM)),'+','.'); //generating a salt
  $salt = sprintf("$2a$%02d$", $cost) . $salt; //Prefix for PHP verification purposes. 2a refers to Blowfish algorithm used
  $hash = crypt($password,$salt);

  $sql = "SELECT email FROM User WHERE email = '$email'";
  $q = $db->query($sql);
  $arr = $q->fetch(PDO::FETCH_ASSOC);
  //echo json_encode($arr);

  if($arr == false)//successful
  {
    $sql = "INSERT into User (salt,hash,email,phone,active) VALUES ('$salt','$hash','$email','$phone','$active');";
    $db->query($sql);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT user_id
            FROM User
            WHERE salt = '$salt' AND email = '$email'";
    $q = $db->query($sql);
    $array = $q->fetch(PDO::FETCH_ASSOC);
    $user_id = (int)$array['user_id'];
    $success = "true";
    $str = array("success" => $success, "user_id" =>$user_id);
    //echo $success;
    return $response->write(json_encode($str));
  }
  else {//email account already in database
    $success = "false";
    $messageDB = "That email already exists.";
    $str = array("success" => $success, "messageDB" =>$messageDB);
    //echo $success;
    return $response->write(json_encode($str));
  }
    //echo $salt;
});
// from http://php.net/manual/en/function.hash-equals.php
function hash_equals($str1,$str2)
{
  //echo "in";
  /*$var = "IN";
  if(!function_exists('hash_equals')) {
    echo $var;
    function hash_equals($str1, $str2) {*/
      if(strlen($str1) != strlen($str2)) {
        return false;
      } else {
        $res = $str1 ^ $str2;
        $ret = 0;
        for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
        return !$ret;
      }
    //}
  //}
}

$app->put('/logout',function($request,$response,$args)
{
  $db = $this->dbConn;
  $data = $request->getParsedBody();
  $user_id = $data['user_id'];
  $inactive = 0;
  //echo json_encode($user_id);

  $sql = "SELECT active FROM User WHERE user_id = '$user_id'";
  $q = $db->query($sql);
  $arr = $q->fetch(PDO::FETCH_ASSOC);
  $currentactivity= (int)$arr['active'];
  //echo json_encode($currentactivity);

  if($currentactivity == 1)//successful logout
  {
    $sql = "UPDATE User SET active = $inactive  WHERE user_id = '$user_id'";
    $db->query($sql);
    $success = "true";
    $str = array("success" => $success);
    //echo $success;
    return $response->write(json_encode($str));
  }
  else {//user already logged out
    $success = "false";
    $messageDB = "You have already logged out.";
    $str = array("success" => $success, "messageDB" =>$messageDB );
    //echo $success;
    return $response->write(json_encode($str));
  }



});
$app->post('/filters',function($request,$response,$args)
{

  $db = $this->dbConn;
  $data = $request->getParsedBody();
  $dh_id = $data['dh_id'];
  $station_id = $data['station_id'];
  $attribute_id =$data['attribute_id'];
  $user_id = $data['user_id'];
  $sql = "SELECT admin
          FROM User
          WHERE user_id = '$user_id'";
  $q = $db->query($sql);
  $isAdmin = $q->fetch(PDO::FETCH_ASSOC);
  if((int)$isAdmin['admin'] == 0) //if User
  {
  /*  foreach($check as $entry)
    {
      $entry_id = $entry['entry_id'];
      $ts = $entry['time_stamp'];
      $dt = new DateTime($ts);
      $date = $dt->format("Y-m-d");


      if($date != $day)
      {
        $sql = "UPDATE Entry SET active = 0 WHERE entry_id = '$entry_id'";
        $db->query($sql);
      }
    }


    if($weekday == 0 || $weekday == 6)
    {
      if(strtotime($currentTime) >= strtotime("12:00:00") && strtotime($currentTime) <= strtotime("14:30:00"))
      {
        $sql = 'UPDATE Entry SET active = 0 WHERE meal = 1';
        $db->query($sql);
      }

      else if(strtotime($currentTime) >= strtotime("14:30:00") && strtotime($currentTime) <= strtotime("22:00:00"))
      {
        $sql = 'UPDATE Entry SET active = 0 WHERE meal = 2 OR meal = 1';
        $db->query($sql);
      }

      else if(strtotime($currentTime) >= strtotime("22:00:00"))
      {
        $sql = 'UPDATE Entry SET active = 0 WHERE meal = 3 OR meal = 2 OR meal 1';
        $db->query($sql);
      }

    }

    else
    {
      if(strtotime($currentTime) >= strtotime("10:30:00") && strtotime($currentTime) <= strtotime("14:30:00"))
      {
        $sql = 'UPDATE Entry SET active = 0 WHERE meal = 1';
        $db->query($sql);
      }

      else if(strtotime($currentTime) >= strtotime("14:30:00") && strtotime($currentTime) <= strtotime("22:00:00"))
      {
        $sql = 'UPDATE Entry SET active = 0 WHERE meal = 2 OR meal = 1';
        $db->query($sql);
      }

      else if(strtotime($currentTime) >= strtotime("22:00:00"))
      {
        $sql = 'UPDATE Entry SET active = 0 WHERE meal = 1 OR meal = 2 OR meal = 3';
        $db->query($sql);
      }*/

  /*    echo gettype($dh_id);
      echo is_array($dh_id) ? 'Array' : 'not an Array';
      echo "\n";
      */

      //echo "dh";
    //  $query = $db->query(('$dh_id','$station_id','$attribute_id'));
    $arr=array();
      foreach($dh_id as $dh)
     {
        foreach($station_id as $station)
        {
          foreach($attribute_id as $attribute)
          {
          //  echo $attribute;
            //print_r(array_values($attribute_id));
          //  echo gettype($dh);

            $dhnum =(int)$dh['dh'];
            $stationnum =(int)$station['station'];
            $attributenum =(int)$attribute['attribute'];
            $sql = "SELECT *
                    FROM Entry  e
                    INNER JOIN Entry_Attributes ea
                    ON e.entry_id = ea.entry_id
                    WHERE e.dh_id='$dhnum'
                    AND e.station_id='$stationnum'
                    AND ea.attribute_id='$attributenum'
                    AND e.active=1
                    ORDER BY e.votes DESC";
            $q = $db->query($sql);

            $val =$q->fetchAll(PDO::FETCH_ASSOC);
            //echo gettype($q);
            //echo "!!!!!";
          //  echo gettype($val);
          //  $arr[]=$val;
            foreach($val as $row)
            {
              $arr[]=$row;
            //  print_r(array_values($arr));
            }
          //  print_r(array_values($arr));
          }
        }
      }
    //  usort($arr, "entry_id");
      $AssocArr = array();
      $returnArr = array();
      usort($arr, function($a, $b) {
      return $b['votes'] - $a['votes'];
      });
    //  echo gettype($arr);
    //  print_r(array_values($arr));
      $counter=0;
      foreach($arr as $row){
        $counter+=1;
        $test=true;

        for($i=0;$i<$counter-1;$i++){
          if($row['entry_id']==$arr[$i]['entry_id'])
          {
            $test=false;
          }
        }
        if($test==true){
          $returnArr['entry_id'] = $row['entry_id'];
          $returnArr['title'] = $row['title'];
          $returnArr['votes'] = $row['votes'];
          $returnArr['time_stamp'] = $row['time_stamp'];
          $returnArr['image'] = $row['image'];
          $returnArr['dh_id'] = $row['dh_id'];
          $returnArr['station_id'] = $row['station_id'];
          $returnArr['user_id'] = $row['user_id'];
          $returnArr['active'] = $row['active'];
          $returnArr['entry_id'] = $row['entry_id'];
          $returnArr['attribute_id'] = $row['attribute_id'];
          //echo json_encode($returnArr);
          $AssocArr[] = $returnArr;
        }
      }
  /*
      $success = "true";
      $str = array("success" => $success, "data" => $arr);
      //echo $success;
      return $response->write(json_encode($str));
      */
      return $response->write(json_encode($AssocArr));
  }
  else { // if Admin
    $arr=array();
      foreach($dh_id as $dh)
     {
        foreach($station_id as $station)
        {
          foreach($attribute_id as $attribute)
          {
          //  echo $attribute;
            //print_r(array_values($attribute_id));
          //  echo gettype($dh);

            $dhnum =(int)$dh['dh'];
            $stationnum =(int)$station['station'];
            $attributenum =(int)$attribute['attribute'];
            $sql = "SELECT *
                    FROM Entry  e
                    INNER JOIN Entry_Attributes ea
                    ON e.entry_id = ea.entry_id
                    WHERE e.dh_id='$dhnum'
                    AND e.station_id='$stationnum'
                    AND ea.attribute_id='$attributenum'
                    AND e.active=1
                    ORDER BY e.votes DESC";
            $q = $db->query($sql);

            $val =$q->fetchAll(PDO::FETCH_ASSOC);
            //echo gettype($q);
            //echo "!!!!!";
          //  echo gettype($val);
          //  $arr[]=$val;
            foreach($val as $row)
            {
              $arr[]=$row;
            //  print_r(array_values($arr));
            }
          //  print_r(array_values($arr));
          }
        }
      }
    //  usort($arr, "entry_id");
      $AssocArr = array();
      $returnArr = array();
      usort($arr, function($a, $b) {
      return $b['votes'] - $a['votes'];
      });
    //  echo gettype($arr);
    //  print_r(array_values($arr));
      $counter=0;
      foreach($arr as $row){
        $counter+=1;
        $test=true;

        for($i=0;$i<$counter-1;$i++){
          if($row['entry_id']==$arr[$i]['entry_id'])
          {
            $test=false;
          }
        }
        if($test==true){
          $returnArr['entry_id'] = $row['entry_id'];
          $returnArr['title'] = $row['title'];
          $returnArr['votes'] = $row['votes'];
          $returnArr['time_stamp'] = $row['time_stamp'];
          $returnArr['image'] = $row['image'];
          $returnArr['dh_id'] = $row['dh_id'];
          $returnArr['station_id'] = $row['station_id'];
          $returnArr['user_id'] = $row['user_id'];
          $returnArr['active'] = $row['active'];
          $returnArr['entry_id'] = $row['entry_id'];
          $returnArr['attribute_id'] = $row['attribute_id'];
          //echo json_encode($returnArr);
          $AssocArr[] = $returnArr;
        }
      }
  /*
      $success = "true";
      $str = array("success" => $success, "data" => $arr);
      //echo $success;
      return $response->write(json_encode($str));
      */
      return $response->write(json_encode($AssocArr));
  }

});

$app->post('/newFeed',function($request,$response,$args)
{
  $db = $this->dbConn;
  $data = $request->getParsedBody();
  $dh_id = $data['dh_id'];
  $station_id = $data['station_id'];
  $attribute_id =$data['attribute_id'];
  $user_id = $data['user_id'];
  $sql = "SELECT admin
          FROM User
          WHERE user_id = '$user_id'";
  $q = $db->query($sql);
  $isAdmin = $q->fetch(PDO::FETCH_ASSOC);
  if((int)$isAdmin['admin'] == 0) //if not admin
  {
  /*foreach($check as $entry)
  {
    $entry_id = $entry['entry_id'];
    $ts = $entry['time_stamp'];
    $dt = new DateTime($ts);
    $date = $dt->format("Y-m-d");

    if($date != $day)
    {
      $sql = "UPDATE Entry SET active = 0 WHERE entry_id = '$entry_id'";
      $db->query($sql);
    }
  }

  if($weekday == 0 || $weekday == 6)
  {
    if(strtotime($currentTime) >= strtotime("12:00:00") && strtotime($currentTime) <= strtotime("14:30:00"))
    {
      $sql = 'UPDATE Entry SET active = 0 WHERE meal = 1';
      $db->query($sql);
    }

    else if(strtotime($currentTime) >= strtotime("14:30:00") && strtotime($currentTime) <= strtotime("22:00:00"))
    {
      $sql = 'UPDATE Entry SET active = 0 WHERE meal = 2 OR meal = 1';
      $db->query($sql);
    }

    else if(strtotime($currentTime) >= strtotime("22:00:00"))
    {
      $sql = 'UPDATE Entry SET active = 0 WHERE meal = 3 OR meal = 2 OR meal 1';
      $db->query($sql);
    }

  }

  else
  {
    if(strtotime($currentTime) >= strtotime("10:30:00") && strtotime($currentTime) <= strtotime("14:30:00"))
    {
      $sql = 'UPDATE Entry SET active = 0 WHERE meal = 1';
      $db->query($sql);
    }

    else if(strtotime($currentTime) >= strtotime("14:30:00") && strtotime($currentTime) <= strtotime("22:00:00"))
    {
      $sql = 'UPDATE Entry SET active = 0 WHERE meal = 2 OR meal = 1';
      $db->query($sql);
    }

    else if(strtotime($currentTime) >= strtotime("22:00:00"))
    {
      $sql = 'UPDATE Entry SET active = 0 WHERE meal = 1 OR meal = 2 OR meal = 3';
      $db->query($sql);
    }
  */

  /*    echo gettype($dh_id);
      echo is_array($dh_id) ? 'Array' : 'not an Array';
      echo "\n";
      */

      //echo "dh";
    //  $query = $db->query(('$dh_id','$station_id','$attribute_id'));
    $arr=array();
      foreach($dh_id as $dh)
     {
        foreach($station_id as $station)
        {
          foreach($attribute_id as $attribute)
          {
          //  echo $attribute;
            //print_r(array_values($attribute_id));
          //  echo gettype($dh);

            $dhnum =(int)$dh['dh'];
            $stationnum =(int)$station['station'];
            $attributenum =(int)$attribute['attribute'];
            $sql = "SELECT *
                    FROM Entry  e
                    INNER JOIN Entry_Attributes ea
                    ON e.entry_id = ea.entry_id
                    WHERE e.dh_id='$dhnum'
                    AND e.station_id='$stationnum'
                    AND ea.attribute_id='$attributenum'
                    AND e.active=1
                    ORDER BY e.time_stamp DESC";
            $q = $db->query($sql);

            $val =$q->fetchAll(PDO::FETCH_ASSOC);
            //echo gettype($q);
            //echo "!!!!!";
          //  echo gettype($val);
          //  $arr[]=$val;
            foreach($val as $row)
            {
              $arr[]=$row;
            //  print_r(array_values($arr));
            }
          //  print_r(array_values($arr));
          }
        }
      }
    //  usort($arr, "entry_id");
      $AssocArr = array();
      $returnArr = array();
      usort($arr, function($a, $b) {
      return $b['time_stamp'] - $a['time_stamp'];
      });
    //  echo gettype($arr);
    //  print_r(array_values($arr));
      $counter=0;
      foreach($arr as $row){
        $counter+=1;
        $test=true;

        for($i=0;$i<$counter-1;$i++){
          if($row['entry_id']==$arr[$i]['entry_id'])
          {
            $test=false;
          }
        }
        if($test==true){
          $returnArr['entry_id'] = $row['entry_id'];
          $returnArr['title'] = $row['title'];
          $returnArr['votes'] = $row['votes'];
          $returnArr['time_stamp'] = $row['time_stamp'];
          $returnArr['image'] = $row['image'];
          $returnArr['dh_id'] = $row['dh_id'];
          $returnArr['station_id'] = $row['station_id'];
          $returnArr['user_id'] = $row['user_id'];
          $returnArr['active'] = $row['active'];
          $returnArr['entry_id'] = $row['entry_id'];
          $returnArr['attribute_id'] = $row['attribute_id'];
          //echo json_encode($returnArr);
          $AssocArr[] = $returnArr;
        }
     }
  /*
      $success = "true";
      $str = array("success" => $success, "data" => $arr);
      //echo $success;
      return $response->write(json_encode($str));
      */
      return $response->write(json_encode($AssocArr));

  }
  else //if admin, don't do time/day fading
  {
    $arr=array();
      foreach($dh_id as $dh)
     {
        foreach($station_id as $station)
        {
          foreach($attribute_id as $attribute)
          {
          //  echo $attribute;
            //print_r(array_values($attribute_id));
          //  echo gettype($dh);

            $dhnum =(int)$dh['dh'];
            $stationnum =(int)$station['station'];
            $attributenum =(int)$attribute['attribute'];
            $sql = "SELECT *
                    FROM Entry  e
                    INNER JOIN Entry_Attributes ea
                    ON e.entry_id = ea.entry_id
                    WHERE e.dh_id='$dhnum'
                    AND e.station_id='$stationnum'
                    AND ea.attribute_id='$attributenum'
                    AND e.active=1
                    ORDER BY e.time_stamp DESC";
            $q = $db->query($sql);

            $val =$q->fetchAll(PDO::FETCH_ASSOC);
            //echo gettype($q);
            //echo "!!!!!";
          //  echo gettype($val);
          //  $arr[]=$val;
            foreach($val as $row)
            {
              $arr[]=$row;
            //  print_r(array_values($arr));
            }
          //  print_r(array_values($arr));
          }
        }
      }
    //  usort($arr, "entry_id");
      $AssocArr = array();
      $returnArr = array();
      usort($arr, function($a, $b) {
      return $b['time_stamp'] - $a['time_stamp'];
      });
    //  echo gettype($arr);
    //  print_r(array_values($arr));
      $counter=0;
      foreach($arr as $row){
        $counter+=1;
        $test=true;

        for($i=0;$i<$counter-1;$i++){
          if($row['entry_id']==$arr[$i]['entry_id'])
          {
            $test=false;
          }
        }
        if($test==true){
          $returnArr['entry_id'] = $row['entry_id'];
          $returnArr['title'] = $row['title'];
          $returnArr['votes'] = $row['votes'];
          $returnArr['time_stamp'] = $row['time_stamp'];
          $returnArr['image'] = $row['image'];
          $returnArr['dh_id'] = $row['dh_id'];
          $returnArr['station_id'] = $row['station_id'];
          $returnArr['user_id'] = $row['user_id'];
          $returnArr['active'] = $row['active'];
          $returnArr['entry_id'] = $row['entry_id'];
          $returnArr['attribute_id'] = $row['attribute_id'];
          //echo json_encode($returnArr);
          $AssocArr[] = $returnArr;
        }
      }
      return $response->write(json_encode($AssocArr));
  }
}
);
