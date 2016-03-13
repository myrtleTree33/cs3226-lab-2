<h1>Admin Page</h1>

<?php
require_once('./connect.php');
session_start();

// Redirect if no session found
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) ) {
  echo '<script type="text/javascript">window.location ="login.php"</script>';
}

echo "<h2>Welcome, " . $_SESSION['user_id'] . "!</h2>";

function printUsers() {
  global $db;
  $q = "SELECT * FROM User";
  $result = $db->query($q);
  if ($result->num_rows > 0) {
    echo "<Table>";
      echo "<tr>";
      echo "<th>";
      echo "User_id";
      echo "</th>";
      echo "<th>";
      echo "Role";
      echo "</th>";
      echo "</tr>";
    while($obj = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $obj['user_id'] . "</td>";
      echo "<td>" . $obj['role'] . "</td>";
      echo "</tr>";
    }
    echo "</Table>";
  }
}

function printScores() {
  global $db;
  $q = "SELECT * FROM Stats";
  $result = $db->query($q);
  if ($result->num_rows > 0) {
    echo "<Table>";
      echo "<tr>";
      echo "<th>" . "Graph ID" . "</th>";
      echo "<th>" . "Num Match" . "</th>";
      echo "<th>" . "Match Score" . "</th>";
      echo "<th>" . "User ID" . "</th>";
      echo "</tr>";
    while($obj = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $obj['graph_id'] . "</td>";
      echo "<td>" . $obj['num_match'] . "</td>";
      echo "<td>" . $obj['match_score'] . "</td>";
      echo "<td>" . $obj['user_id'] . "</td>";
      echo "</tr>";
    }
    echo "</Table>";
  }
}

function update_stats_and_retrieve($db, $graph_id, $num_match, $score, $userId) {
  $q = "UPDATE Stats SET num_match=$num_match, match_score=$score, user_id='$userId' WHERE graph_id = $graph_id";
  if($db->query($q)) {
  } else {
  }
}

if ($_SESSION['role'] == 0) {
  echo "<br>";
  echo '<h2>' . "Here are the users enrolled" . '</h2>';
  echo "<br>";
  printUsers();
  echo '<form action="resetScores.php" method="get"><input type="submit" name="" value="Reset Scores"></form>';
}

  echo '<form action="logout.php" method="get"><input type="submit" name="" value="logout"></form>';

echo "<br>";
echo '<h2>' . "Here are the highest scores" . '</h2>';
echo "<br>";

printScores();



 ?>
