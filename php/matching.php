<?php
header("Access-Control-Allow-Origin: *");

require_once('./connect.php');
session_start();

## Get session state variables
$user_id = NULL;
$role = NULL;

if (isset($_SESSION['user_id']) && isset($_SESSION['role']) ) {
  $user_id = $_SESSION['user_id'];
  $role = $_SESSION['role'];
}

$nn = (int)$_GET['n'];
$mm = (int)$_GET['m'];
$cmd = (string)$_GET['cmd'];
$graph_id = (string)$_GET['graph_id'];
$solution = (string)$_GET['solution'];

// $db = [];
// array_push($db,
// json_decode('{"N":3,"M":5,"E":[[0,2,29],[0,3,50],[1,1,66],[1,4,95],[2,0,90],[2,1,86]]}'));
// array_push($db,
// json_decode('{"N":3,"M":5,"E":[[0,2,19],[0,3,5],[1,3,100],[1,4,64],[2,2,41],[2,3,8]]}'));
// array_push($db,
// json_decode('{"N":3,"M":5,"E":[[0,2,22],[0,3,90],[1,0,71],[1,3,74],[2,3,16],[2,4,78]]}'));
// array_push($db,
// json_decode('{"N":3,"M":5,"E":[[0,1,10],[0,4,26],[1,0,98],[1,1,30],[2,3,45],[2,4,51]]}'));
//
//
// $db_stats = [];
// array_push($db_stats, json_decode('
// {"graph_id":0,"num_match":"3","match_score":"235"}
// '));
//
// array_push($db_stats, json_decode('
// {"graph_id":1,"num_match":"3","match_score":"110"}
// '));
//
// array_push($db_stats, json_decode('
// {"graph_id":2,"num_match":"3","match_score":"239"}
// '));
//
// array_push($db_stats, json_decode('
// {"graph_id":3,"num_match":"3","match_score":"169"}
// '));


function errLog($str = "An error occured.") {
  die("ERROR: " . $str);
}

function fetch_edges($db, $table_name, $graph_id) {
  $edges = [];
  $q = 'SELECT leftNode, rightNode, weight FROM ' . $table_name . ' WHERE graph_id = ' . $graph_id;
  $result = $db->query($q);
  while($row = $result->fetch_assoc()) {
    $edges[] = [(int)$row['leftNode'], (int)$row['rightNode'], (int)$row['weight']];
  }
  // $db->free_result($result);
  return $edges;
}

function generate($db, $graph_id) {
  // Do error checking here
  if ($graph_id == NULL) {
    errLog("Got error");
    die();
  }
  $q = 'SELECT n,m FROM Graphs WHERE id = ' . $graph_id;
  $result = $db->query($q);
  if ($result->num_rows > 0) {
    $obj = $result->fetch_assoc();
    $obj['graph_id'] = (int)$graph_id;
    $obj['n'] = (int)$obj['n'];
    $obj['m'] = (int)$obj['m'];
    $obj['E'] = fetch_edges($db, 'Edges', $graph_id);
    return $obj;
  } else {
    errLog('Error retrieving object');
  }
}

function validate_soln($n, $m, $edges, $soln) {
  if (count($soln) > (int)$n) {
    errLog("Too many matches specified.");
  }
  if (!check_left_nodes_valid($n, $soln)) {
    errLog("Not all nodes are present");
  }
  if (!check_right_nodes_valid($m, $soln)) {
    errLog("Problem with right nodes");
  }
  if (!check_edges_exist($edges, $soln)) {
    errLog("Edge submitted does not exist");
  }
  // success
  return true;
}

function get_score($a, $b, $edges) {
  for ($i = 0; $i < count($edges); $i++) {
    $curr = $edges[$i];
    if ($a == $curr[0] && $b == $curr[1]) {
      return $curr[2];
    }
  }
  return 0;
}

function check_left_nodes_valid($n, $soln) {
  $acc = [];

  for ($i = 0; $i < count($soln); $i++) {
    $x = $soln[$i][0];
    if ($x >= $n || $x < 0) {
      errLog("Invalid left node: $x");
      return false;
    }
    $acc[$x]++;
  }
  foreach($acc as $key => $value) {
    if ($value > 1) {
      errLog("Duplicate left node: $key");
      return false;
    }
  }
  return true;
}


function check_right_nodes_valid($m, $soln) {
  $acc = [];

  for ($i = 0; $i < count($soln); $i++) {
    $x = $soln[$i][1];
    if ($x >= $m || $x < 0) {
      errLog("Invalid right node: $x");
      return false;
    }
    $acc[$x]++;
  }
  foreach($acc as $key => $value) {
    if ($value > 1) {
      errLog("Duplicate right node: $key");
      return false;
    }
  }
  return true;
}

function check_edges_exist($edges, $soln) {
  for ($i = 0; $i < count($soln); $i++) {
    $curr = $soln[$i];
    $currValidEdge = false;
    for ($x = 0; $x < count($edges); $x++) {
      $actual = $edges[$x];
      $currValidEdge = ($curr[0] == $actual[0]) && ($curr[1] == $actual[1]);
      if ($currValidEdge) {
        $currValidEdge = true;
        break;
      }
    }
    if (!$currValidEdge) {
      errLog("An edge ($curr[0], $curr[1]) submitted does not exist");
      return false;
    }
  }
  return true;
}

function calc_stats($db, $graph_id, $solution) {
  // Do error checking here
  if ($graph_id == NULL) {
    errLog("Invalid graph id");
    return;
  }

  if ($solution == NULL) {
    errLog("No solution provided");
    return;
  }

  $soln = json_decode($solution);
  if ($soln == NULL) {
    errLog("Invalid JSON");
    return;
  }
  // / Do error checking here
  $graph = generate($db, $graph_id);
  $edges = $graph['E'];
  $n = $graph['n'];
  $m = $graph['m'];

  if (!validate_soln($n, $m, $edges, $soln)) {
    errLog("Solution is invalid.");
  }

  $score = 0;
  for ($i = 0; $i < count($soln); $i++) {
    $a = $soln[$i][0];
    $b = $soln[$i][1];
    $score += get_score($a, $b, $edges);
  }

  // return results
  $num_match = count($soln);
  $result = update_stats_and_retrieve($db, $graph_id, $num_match, $score);
  echo(json_encode($result));
}


function update_stats_and_retrieve($db, $graph_id, $num_match, $score) {
  global $user_id;
  $q = 'SELECT num_match, match_score FROM ' . 'Stats' . ' WHERE graph_id = ' . $graph_id;
  $result = $db->query($q);
  $stat = $result->fetch_assoc();
  $new_best = $score > (int)$stat['match_score'];
  $newNumMatch = ($stat['num_match'] > $num_match ? $stat['num_match'] : $num_match);
  $newScore = $stat['match_score'];
  if ($new_best && $_SESSION['role'] == 1) {
    $q = "UPDATE Stats SET num_match=$num_match, match_score=$score, user_id='$user_id' WHERE graph_id = $graph_id";
    if($db->query($q)) {
      $newNumMatch = $num_match;
      $newScore = $score;
    }
  }

  $response = [];
  $response['num_best'] = (int)$new_best;
  $response['num_match'] = (int)$newNumMatch;
  $response['match_score'] = (int)$newScore;

  return $response;
}


if ($cmd == 'generate') {
  $result = json_encode(generate($db, $graph_id));
  echo($result);
} else if ($cmd == 'submit') {
  // errLog('Invalid solution');
  calc_stats($db, $graph_id, $solution);
} else {
  errLog("Invalid command");

}




function array_rand_guarantee($arr, $min, $max) {
    $result = [];
    while(count($result) == 0 || $result[0] === NULL) {
        $result = array_rand($arr, rand($min,$max));
    }
    return $result;
}

function gen_soln($n, $m) {
    $matches = [];
    $mRange = range(0,$m - 1);
    for ($i = 0; $i < $n; $i++) {
        $rightKeys = array_rand_guarantee($mRange, 1, 1 + round($m * 0.2));
        for ($h = 0; $h < count($rightKeys); $h++) {
            $score = rand(0,100);
            $matches[] = array($i, $mRange[$rightKeys[$h]], $score);
        }
    }

    $result = [];
    $result['N'] = (int)$n;
    $result['M'] = (int)$m;
    $result['E'] = $matches;


    return json_encode($result);
}

// echo(gen_soln($nn,$mm));
?>
