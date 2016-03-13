<html>

<head>
  <title>Login</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h2>Sign in</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <form id="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="">
          <div class="form-group">
            <label for="user_id">User ID</label>
            <input type="text" name="user_id" value="" placeholder="Username" class="form-control">
          </div>
          <div class="form-group">
            <label for="user_password">Password</label>
            <input type="password" name="user_password" value="" placeholder="password" class="form-control">
          </div>
          <input type="submit" name="login" class="btn btn-default">
        </form>

      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <form action="signup.php" method="get">
          <input type="submit" name="" value="Signup" class="btn btn-default">
        </form>
      </div>
    </div>

  </div>
</body>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

</html>


<?php
require_once('./connect.php');
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) ) {
  echo '<script type="text/javascript">window.location ="admin.php"</script>';
}

if(isset($_POST['login'])) {
  $user_id = (string)$_POST['user_id'];
  $password = (string)$_POST['user_password'];
  $q = "SELECT * FROM User WHERE (user_id = '$user_id') ";
  $result = $db->query($q);
  if ($result->num_rows > 0) {
    $obj = $result->fetch_assoc();
    $attempt = crypt($password, $obj['hashed_password']);
    $serverHashed = $obj['hashed_password'];
    if ($attempt == $serverHashed) {
      // Success
      $_SESSION["user_id"] = $obj['user_id'];
      $_SESSION["role"] = $obj['role'];
      echo '<script type="text/javascript">window.location ="admin.php"</script>';
    } else {
      echo "<script type='text/javascript'>alert('Invalid password');</script>";
    }
  } else {
    echo "<script type='text/javascript'>alert('Invalid credentials');</script>";
  }
}
// $hashed_password = crypt((string)$_POST['password'])
?>
