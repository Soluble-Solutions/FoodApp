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
    /*$returnArr = array();
    foreach($q as $row){
      $returnArr['entry_id'] = $row['entry_id'];
      $returnArr['title'] = $row['title'];
      $returnArr['votes'] = $row['votes'];
      $returnArr['time_stamp'] = $row['time_stamp'];
      $returnArr['image'] = $row['image'];
      $returnArr['dh_id'] = $row['dh_id'];
      $returnArr['station_id'] = $row['station_id'];
      echo json_encode($returnArr);*/

    }

  #}
    /*
    if($check){
      //$response->setStatus(200);
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      header('Content-type: application/json');
      echo json_encode($q);
      $db = null;
    } else{
      throw new PDOException('No records found.');
    }
  }*/
  catch(PDOException $e){
    $this->notFoundHandler; //404
    //$app->$response->setStatus(404);
    //echo "Error: ".$e.getMessage();
  }
});

$app->put('/index',function($request,$response,$args)
{#CHANGE TO RECEIVE TWO PARAMETERS
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
  $station_id = $data['station_id'];//??
  $attribute_id =$data['attribute_id'];//NEED TO GET A JSON OBJ
  $image = $data['image'];
  $title = $data['title'];
  $comment = $data['comment'];

  $sql = "INSERT INTO Entry (image,title,time_stamp,dh_id,station_id) VALUES ('$image','$title',now(),'$dh_id','$station_id');
  INSERT INTO DiningHall_Station (dh_id,station_id) VALUES ('$dh_id','$station_id'); ";

  $db->query($sql);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  #GET Entry_id from first line (based on image)
  $sql = "SELECT entry_id
          FROM Entry
          WHERE image = '$image';";

  $entry_id = $db->query($sql);

  /*if(!empty($comment))
  {
    $sql ="INSERT INTO Comment (comment,time_stamp) VALUES ('$comment',now());";
    $q = $db->query($sql);
  }

  #$attributes = json_decode($attribute_id, TRUE);


  #foreach($attribute_id as $attribute)
  for($i=0; $i<count($attribute_id['attribute']); $i++)
  {
    $sql = "INSERT INTO Attributes (attribute_id) VALUES ('$attribute_id['attribute'][$i]');
    INSERT INTO Entry_Attributes(entry_id,attribute_id) VALUES ('$entry_id','$attributes_id['attribute'][$i]');";
    $db->query($sql);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }*/

});

$app->get('/comment/{entry_id}', function ($request, $response, $args) {
  try{
    #$data = $request->getParsedBody();
    #$entry_id = $data['entry_id'];
    $entry_id = $_GET;
    $sql = "SELECT e.image,e.votes #ADD COMMENTS AND USE SORT BY
            FROM Entry e
            WHERE e.entry_id = '$entry_id'
            ;";
    $db = $this->dbConn;
    $q = $db->query($sql);
    //$check = $q->setFetchMode(PDO::FETCH_ASSOC);
    $row = $q->fetchAll();
    $returnArr = array();
    $data = $row[0];
    $returnArr['image'] = $data['image'];
    $returnArr['votes'] = $data['votes'];
    echo json_encode($returnArr);
    $sql = "SELECT a.name
            FROM Entry e
            INNER JOIN Entry_Attributes ea
            ON e.entry_id = '$entry_id'
            AND e.entry_id=ea.entry_id
            INNER JOIN Attribute a
            ON ea.attribute_id = a.attribute_id
            ;";
    $db = $this->dbConn;
    $q = $db->query($sql);

    foreach($q as $row){
      $returnArr['name'] = $row['name'];
      echo json_encode($returnArr);
    }

    $sql = "SELECT c.comment
            FROM Comment c
            INNER JOIN Entry e
            ON e.entry_id = c.entry_id
            AND e.entry_id = '$entry_id'
            ;";
    $q = $db->query($sql);

    foreach($q as $row){
      $returnArr['comment'] = $row['comment'];
      echo json_encode($returnArr);
    }

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
