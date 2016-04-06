<?php
// Routes
$servername = "localhost";
$username = "admin";
$password = "tester123";
$dbname = "foodapp";

$app->get('/index', function ($request, $response, $args) {
    // Sample log message
  try{
    $sql = 'SELECT *
            FROM Entry'; #ORDER BY votes DESC
    $db = $this->dbConn;
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
  $sql = "UPDATE Entry SET votes = '$votes' WHERE entry_id = '$entry_id'";
  $db->query($sql);

});

$app->post('/entry',function($request,$response,$args)
{
  $db = $this->dbConn;
  $data = $request->getParsedBody();
  $dh_id = $data['dh_id'];
  $station_id = $data['station_id'];
  $attribute_id =$data['attribute_id'];
  $image = $data['image'];
  $title = $data['title'];
  $comment = $data['comment'];
  $time_stamp = date("Y-m-d H:i:s");
  $active = 1;

  $sql = "INSERT INTO Entry (image,title,time_stamp,dh_id,station_id,active) VALUES ('$image','$title','$time_stamp','$dh_id','$station_id','$active');";

  $db->query($sql);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  #GET Entry_id from first line (based on image)
  $sql = "SELECT entry_id
          FROM Entry
          WHERE image = '$image' AND time_stamp = '$time_stamp';";
  $query = $db->query($sql);
  $arr = $query->fetch(PDO::FETCH_ASSOC);
  $entry_id = (int)$arr['entry_id'];
  if(!empty($comment))
  {
    $sql ="INSERT INTO Comment (comment,time_stamp,entry_id) VALUES ('$comment','$time_stamp',$entry_id);";
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

});

$app->get('/comment/{entry_id}', function ($request, $response, $args) {
  try{
    $entry_id = $request->getAttribute('entry_id');
    $sql = "SELECT c.comment
            FROM Comment c
            INNER JOIN Entry e
            ON e.entry_id = c.entry_id
            AND e.entry_id = '$entry_id'
            ;";
    $db = $this->dbConn;
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

$app->post('/comment',function($request,$response,$args){
  $db = $this->dbConn;
  $data = $request->getParsedBody();
  $entry_id = $data['entry_id'];
  $comment = $data['comment'];

  $sql = "INSERT INTO Comment (comment,time_stamp,entry_id) VALUES ('$comment',now(),'$entry_id');"; #now()
  $db->query($sql);
});

$app->post('/tags',function($request,$response,$args)
{
  #return a JSON object of all the IDs
});

$app->post('/login',function($request,$response,$args)
{
    $db = $this->dbConn;
    $data = $request->getParsedBody();
    $email = $data['email']; //change to user?
    $password = $data['password'];
    $sql = "SELECT hash, salt, user_id
            FROM User
            WHERE email = '$email';";
    $q = $db->query($sql);
    $array = $q->fetch(PDO::FETCH_ASSOC);
    $hash = $array['hash'];
    //echo $hash, "\n";
    $salt = $array['salt'];
    //echo $salt, "\n";
    $user_id = $array['user_id'];

    $active = 1;
    //$pass = "tester123";
    //$test_hash = crypt($pass,"ELNjNsSgwbDXpKRFXa7NBjGuFyRVyP");

    //echo $test_hash;
    //echo "hash: ".$hash;
    $test = crypt($password,$salt);
    //echo $test;
    //echo "crypt($password,$hash): ".$test;
    if(hash_equals($hash,crypt($password,$salt))) // Valid
    {
      //$this->logger->info("success=true");
      //SESSION STUFF
      $success = "true";
      //echo $success;
      $str = array("success" => $success);
      return $response->write(json_encode($str));
      //return $response->withJson($str,200);
      //return $response->write(json_encode($success)); //?
    }
    else
    {
      $this->logger->info("success=false");
      $success = "false";
      //echo $success;
      $str = array("success" => $success);
      //return $response->write(json_encode($str));
      //return $response->withJson($str,401);
    }


});
//Referenced from https://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/
$app->post('/registration',function($request,$response,$args)
{
  $db = $this->dbConn;
  $data = $request->getParsedBody();
  $username = $data['username'];
  $password = $data['password'];
  $email = $data['email'];
  $phone = $data['phone'];
  echo $phone;
  $active = 1; //? Needed?
  $cost = 10;
  $salt = strtr(base64_encode(mcrypt_create_iv(16,MCRYPT_DEV_URANDOM)),'+','.'); //generating a salt
  $salt = sprintf("$2a$%02d$", $cost) . $salt; //Prefix for PHP verification purposes. 2a refers to Blowfish algorithm used
  $hash = crypt($password,$salt);
  //echo $hash;
  /*$sql = "INSERT into User (username,salt,hash,email,phone,active) VALUES ('$username','$salt','$hash','$email','$phone','$active');";
  $db->query($sql);
  //echo $salt;*/
	$query = $db->prepare('INSERT INTO User (username,salt,hash,email,phone,active) VALUES (:username, "$salt", "$hash", :email, :phone, "$active")');
  $query->execute(array(
    'username' => $request->getParam('username'),
    'email' => $request->getParam('email'),
    'phone' => $request->getParam('phone')
  ));
  /*$query->bindParam(':username', $username);
  $query->bindParam(':salt', $salt);
  $query->bindParam(':hash', $hash);
  $query->bindParam(':phone', $phone);
  $query->bindParam(':email', $email);
  $query->bindParam(':active', $active);
	$query->execute();*/
  return $response->withStatus(200);

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
?>
