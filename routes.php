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
    $row = $q->fetchAll(); //
    $returnArr = array();
    if(sizeof($row)>=1){
      //$returnArr['success'] ='True';
      $data = $row[0];
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
    }
    return json_encode($returnArr);
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
$app->put('/index/{votes}',function($request,$response,$args)
{
  /* try{
    $sql = '';
  }
  */
});
$app->post('/entry',function($request,$response,$args)
{

});
$app->get('/comment', function ($request, $response, $args) {
  try{
    $sql = 'SELECT e.image,e.votes,a.name
            FROM Entry e
            INNER JOIN Entry_Attributes ea
            ON e.entry_id = ea.entry_id
            INNER JOIN Attribute a
            ON ea.attribute_id = a.attribute_id
            UNION
            SELECT c.comment
            FROM Entry e
            INNER JOIN Comment c
            ON e.comment_id = c.comment_id
            ;';
    $db = $this->dbConn;

    $q = $db->query($sql);
    $check = $q->setFetchMode(PDO::FETCH_ASSOC);

    if($check){
      //$response->setStatus(200);
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      header('Content-type: application/json');
      echo json_encode($check);
      $db = null;
    } else{
      throw new PDOException('No records found.');
    }

  }
  catch(PDOException $e){
    $this->notFoundHandler; //404
    //$app->$response->setStatus(404);
    //echo "Error: ".$e.getMessage();
  }
});
$app->post('/comment',function($request,$response,$args){

});
$app->post('/tags',function($request,$response,$args)
{

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
