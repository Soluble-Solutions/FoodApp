<?php
// Routes
$servername = "localhost";
$username = "admin";
$password = "tester123";
$dbname = "foodapp";
//$app = new \Slim\App(); //
//$app->get('/[{name}]', function ($request, $response, $args)
$app->get('/index', function ($request, $response, $args) {
    // Sample log message
  try{
    $sql = 'SELECT *
            FROM Entry'; #ORDER BY votes DESC
    $db = $this->dbConn;
    $q = $db->query($sql);
    $check = $q->setFetchMode(PDO::FETCH_ASSOC);
    $returnArr = array();
    foreach($q as $row){
      //$returnArr['success'] ='True';
      //$data = $row[$i];
      $returnArr['entry_id'] = $row['entry_id'];
      $returnArr['title'] = $row['title'];
      $returnArr['votes'] = $row['votes'];
      $returnArr['time_stamp'] = $row['time_stamp'];
      $returnArr['image'] = $row['image'];
      $returnArr['dh_id'] = $row['dh_id'];
      $returnArr['station_id'] = $row['station_id'];
      //$returnArr[$row['entry_id']] = $row['entry_id'];
      //$returnArr[$row['title']] = $row['title'];
      //$returnArr['votes'] = $data['votes'];
      //$returnArr['time_stamp'] = $data['time_stamp'];
      //$returnArr['image'] = $data['image'];
      //$returnArr['dh_id'] = $data['dh_id'];
      //$returnArr['station_id'] = $data['station_id'];
      echo json_encode($returnArr);
    }
    /*if(sizeof($row)>=1){
      //$returnArr['success'] ='True';
      $data = $row[1];
      $returnArr['entry_id'] = $data['entry_id'];
      $returnArr['title'] = $data['title'];
      $returnArr['votes'] = $data['votes'];
      $returnArr['time_stamp'] = $data['time_stamp'];
      $returnArr['image'] = $data['image'];
      $returnArr['dh_id'] = $data['dh_id'];
      $returnArr['station_id'] = $data['station_id'];
    }
    else{
      $returnArr['success'] ='False';
    }*/
    //$response->getBody()->write(json_encode($returnArr));
    //return $response;
    //return $response->getBody()->write(json_encode($q));
  }
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
  //$entry_id = $request->getAttribute('entry_id');
  //$votes = $request->getAttribute('votes');
  //$votes = $request->getAttribute('votes');
  //$votes = $request->getAttribute('votes');
  $sql = "UPDATE Entry SET votes = '$votes' WHERE entry_id = '$entry_id'";
  //$sql = "UPDATE Entry SET votes = '$votes' WHERE entry_id = '$entry_id'";
  $db->query($sql);
  /* try{
    $sql = '';
  }
  */
});
$app->post('/entry',function($request,$response,$args)
{
  $db = $this->dbConn;
  //$entry_id = $request->getAttribute('entry_id'); //??
  $dh_id = $request->getAttribute('dh_id');//??
  $station_id = $request->getAttribute('station_id');//??
  $attribute_id = $request->getAttribute('attribute_id');//NEED TO GET A JSON OBJ
  $image = $request->getAttribute('image');
  $title = $request->getAttribute('title');
  $comment = $request->getAttribute('comment');
  $time_stamp = $request->getAttribute('time_stamp'); //REMOVE
  $votes = $request->getAttribute('votes'); //REMOVE
  //$dh_name = $request->getAttribute('Dining_Hall.name');//???
  //$s_name = $request->getAttribute('Station.name');//???
  //$a_name = $request->getAttribute('Attribute.name');//???
  $sql = "INSERT INTO Entry (image,title,time_stamp,votes,dh_id,station_id) VALUES ('$image','$title','$time_stamp','$votes','$dh_id','$station_id');
  INSERT INTO Comment (comment,time_stamp) VALUES ('$comment','$time_stamp'); #ENTER COMMENT IF NOT NULL
  INSERT INTO DiningHall_Station (dh_id,station_id) VALUES ('$dh_id','$station_id');
  INSERT INTO Entry_Attributes (attribute_id) VALUES ('$attribute_id'); #GET Entry_id from first line (based on image and time_stamp )and then insert it here
  ";
  $q = $db->query($sql);
});
$app->get('/comment/{entry_id}', function ($request, $response, $args) {
  try{
    $entry_id = $request->getAttribute('entry_id');
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
    //$check = $q->setFetchMode(PDO::FETCH_ASSOC);
    //$row = $q->fetchAll();
  //  $returnArr = array();


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
    //$check = $q->setFetchMode(PDO::FETCH_ASSOC);
   // $row = $q->fetchAll();
    //$returnArr = array();


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
  $comment = $request->getAttribute('comment');
  $entry_id = $request->getAttribute('entry_id');
  //echo json_encode($comment);
  //echo json_encode($entry_id);
  $sql = "INSERT INTO Comment (comment,time_stamp,entry_id) VALUES ('$comment',now(),'$entry_id');"; #now()
  $db->query($sql);
});
$app->post('/tags',function($request,$response,$args)
{
  #return a JSON object of all the IDs
});
/*$app->get('/goodbye', function($request, $response, $args){
  return $response->write("Time to go. Goodbye!");
});
$app->get('/comments', function($request, $response, $args){
    // Sample log message
    //$this->logger->info("Slim-Skeleton '/' route");
    $db = $this->dbConn;
    $strToReturn ='';
    //$sql = 'SELECT * FROM foodpost';
    //$result = $db->query('SELECT * FROM foodpost');
    //while ($row = $result->fetch_assoc()){
    //while ($row = mysql_fetch_array($result)){
    //foreach($db->query('select * from foodpost') as $row) {
    foreach($db->query('SELECT * FROM foodpost') as $row) {
      $strToReturn .= '<br />' . $row ['comment']. '<br /> '. $row['choice']. '<br/>'. $row['time'];
    }
    return $response->write($strToReturn);
    // Render index view
    //return $this->renderer->render($response, 'index.phtml', $args);
});
*/
//http://192.168.56.103/practice.php
