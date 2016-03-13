<?php
require_once './config.php'; // your PHP script(s) can access this file

$db = new mysqli(db_host, db_uid, db_pwd, db_name); // it is built-in
if ($db->connect_errno) // are we connected properly?
  die("Failed to connect to MySQL, exiting this script");

?>
