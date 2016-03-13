<?php // config.php basically contains these 4 constants


// Change the below accordingly -----------------------------
// define ("APP_ENV", "debug");
define ("APP_ENV", "deploy");
// / Change the below accordingly ---------------------------

if (APP_ENV === "debug") {
  define("db_host", "localhost"); // a constant doesn't need a $
  define("db_uid", "root"); // change this to yours
  define("db_pwd", "MYPASSWORD123"); // change this to yours
  define("db_name", "a0108165"); // default for this class
  define("salt", "!D@#J67sdfc326df8221jkhsdf"); // for password encryption

} else if (APP_ENV === "deploy") {
  define("db_host", "localhost"); // a constant doesn't need a $
  define("db_uid", "a0108165"); // change this to yours
  define("db_pwd", "greenleaf#33"); // change this to yours
  define("db_name", "a0108165"); // default for this class
  define("salt", "!D@#J67sdfc326df8221jkhsdf"); // for password encryption
}

$salt = salt
?>
