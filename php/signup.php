<?php
require_once('./connect.php');
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) ) {
  echo '<script type="text/javascript">window.location ="admin.php"</script>';
}
?>


<html>

<head>
  <title>Sign up</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h2>Sign up for a new account</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <form id="signup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="">
          <div class="form-group">
            <label for="user_id">Create a User ID</label>
            <input type="text" name="user_id" value="" placeholder="Username" class="form-control">
          </div>
          <div class="form-group">
            <label for="user_password">Create a password</label>
            <input type="password" name="user_password" value="" placeholder="password" class="form-control">
          </div>
          <input type="submit" name="signup" class="btn btn-default">
        </form>

      </div>
    </div>
  </div>
</body>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

</html>

  <div class="container">
    <div class="row">
      <div class="col-lg-12">
<?php

function addUser($user_id, $password, $role) {
  global $db;
  $hashed_password = crypt($password, $salt);
  $q = "INSERT INTO User (user_id, hashed_password, role) VALUES ('$user_id', '$hashed_password', $role)";
  if (!$db->query($q)) {
    echo '<div class="alert alert-danger">';
    echo '<strong>Unable to create user.  </strong>' . $db->error;
    echo '</div>';
  } else {
    echo '<script type="text/javascript">window.location ="login.php"</script>';
  }
}

if(isset($_POST['signup'])) {
  $user_id = (string)$_POST['user_id'];
  $password = (string)$_POST['user_password'];
  addUser($user_id, $password, 1);
  // $q = "SELECT * FROM User WHERE (user_id = '$user_id') ";
  // $result = $db->query($q);
  // if ($result->num_rows > 0) {
  //   $obj = $result->fetch_assoc();
  //   $attempt = crypt($password, $obj['hashed_password']);
  //   $serverHashed = $obj['hashed_password'];
  //   if ($attempt == $serverHashed) {
  //     // Success
  //     $_SESSION["user_id"] = $obj['user_id'];
  //     $_SESSION["role"] = $obj['role'];
  //     echo '<script type="text/javascript">window.location ="admin.php"</script>';
  //   } else {
  //     echo "<script type='text/javascript'>alert('Invalid password');</script>";
  //   }
  // } else {
  //   echo "<script type='text/javascript'>alert('Invalid credentials');</script>";
  // }
}
// $hashed_password = crypt((string)$_POST['password'])
?>

      </div>
    </div>
  </div>
