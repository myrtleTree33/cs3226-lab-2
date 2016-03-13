#!/bin/bash

url="http://localhost:8000/joel/matching.php?graph_id=0&cmd=submit&solution=[[1,4],[2,0]]";
echo $url;

get_res () {
  echo "";
  echo $1;
  content=$(wget $1 -q -O -);
  echo $content;
  echo "";
}

echo "--- BEGIN TESTS ---";

get_res "http://localhost:8000/joel/matching.php?graph_id=0&cmd=submit&solution=[[1,4],[2,0]]";

get_res "http://localhost:8000/joel/matching.php?graph_id=0&cmd=submit&solution=[[1,4],[2,8]]";

get_res "http://localhost:8000/joel/matching.php?graph_id=0&cmd=submit&solution=[[1,4]]";

get_res "http://localhost:8000/joel/matching.php?graph_id=0&cmd=submit&solution=[[1,4],[1,0]]";

get_res "http://localhost:8000/joel/matching.php?graph_id=0&cmd=submit&solution=[[1,2],[2,2]]";

get_res "http://localhost:8000/joel/matching.php?graph_id=0&cmd=submit&solution=[[1,2],[99,2]]";

get_res "http://localhost:8000/joel/matching.php?graph_id=0&cmd=submit&solution=[[1,2],[-9,2]]";

get_res "http://localhost:8000/joel/matching.php?graph_id=0&cmd=submit&solution=[[1,2],[2,3]]";

get_res "http://localhost:8000/joel/matching.php?graph_id=0&cmd=submit&solution=[[0,2,29],[0,3,50],[1,1,66],[1,4,95],[2,0,90],[2,1,86]]";


echo "--- END TESTS ---";
