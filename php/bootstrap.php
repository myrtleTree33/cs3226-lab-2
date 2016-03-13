<?php
header("Access-Control-Allow-Origin: *");

require_once('./connect.php');

function errLog($str = "An error occured.") {
  die("ERROR: " . $str);
}

function addUser($user_id, $password, $role) {
  global $db;
  $hashed_password = crypt($password, $salt);
  $q = "INSERT INTO User (user_id, hashed_password, role) VALUES ('$user_id', '$hashed_password', $role)";
  if (!$db->query($q)) {
    echo ($db->error);
  }
  echo 'done';
}

addUser('boss', 'TAplstest', 0);
addUser('student1', 'iamstudent1', 1);
addUser('student2', 'number2', 1);


?>
