<?php
require_once('./connect.php');
session_start();

// Redirect if no session found
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) ) {
  echo '<script type="text/javascript">window.location ="login.php"</script>';
}

function update_stats_and_retrieve($db, $graph_id, $num_match, $score, $userId) {
  $q = "UPDATE Stats SET num_match=$num_match, match_score=$score, user_id='$userId' WHERE graph_id = $graph_id";
  $db->query($q);
}

function resetScores() {
  global $db;
  foreach (range(0,8) as $i) {
    update_stats_and_retrieve($db, $i, 0, 0, '');
  }
}


if ($_SESSION['role'] == 0) {
  resetScores();
}


// Wehn done with reset, redirect if already logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) ) {
  echo '<script type="text/javascript">window.location ="admin.php"</script>';
}

 ?>
