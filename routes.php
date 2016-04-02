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

  /*foreach($attribute_id as $attribute)
  {
    $attributenum =(int)$attribute['attribute'];
    $sql = "INSERT INTO Attribute (attribute_id) VALUES ('$attributenum');
    INSERT INTO Entry_Attributes(entry_id,attribute_id) VALUES ('$entry_id','$attributenum');";
    $db->query($sql);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }*/

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
