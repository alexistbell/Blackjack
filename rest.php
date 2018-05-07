<?php

const SERVERNAME = "localhost";
const USERNAME = "root";
const PASSWORD = "root";
const DB = "myDatabase";

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));

//this gets the POST data even if it is in JSON form.
$rawData = json_decode(file_get_contents('php://input'),true);
 
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB);
mysqli_set_charset($link,'utf8'); 

$table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
$key = array_shift($request)+0;
 
// this is to check for illegal characters and prevent script injections
$columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input));
$values = array_map(function ($value) use ($conn) {
  if ($value===null) return null;
  return mysqli_real_escape_string($conn,(string)$value);
},array_values($rawData));
 
// builds a string for POST and PUT commands to be added to SQL
$set = '';
for ($i=0;$i<count($columns);$i++) {
  $set.=($i>0?',':'').'`'.$columns[$i].'`=';
  $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
}

switch ($method) {
  case 'GET':
    $sql = "select * from `$table`".($key?" WHERE id=$key":''); break;
  case 'PUT':
    $sql = "update `$table` set $set where id=$key"; break;
  case 'POST':
    $sql = "insert into `$table` set $set"; break;
  case 'DELETE':
    $sql = "delete `$table` where id=$key"; break;
}
 
$result = mysqli_query($conn,$sql);
  
if ($method == 'GET') {
  if (!$key) echo '[';
  for ($i=0;$i<mysqli_num_rows($result);$i++) {
    echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
  }
  if (!$key) echo ']';
} elseif ($method == 'POST') {
  echo mysqli_insert_id($conn);
} else {
  echo mysqli_affected_rows($conn);
}
 
mysqli_close($conn);