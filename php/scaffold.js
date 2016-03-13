var graph =
{"id": 8, "N":5,"M":8,"E":[[0,3,69],[0,5,16],[0,6,85],[1,1,24],[1,4,34],[1,5,92],[2,3,32],[2,6,58],[3,1,36],[3,4,93],[3,5,32],[4,0,87],[4,3,6],[4,7,85]]}
;


// INSERT INTO Graphs VALUES(0,3,5);

console.log("INSERT INTO Graphs VALUES" + "("
+ graph.id + ","
+ graph.N + ","
+ graph.M
 + ");");

 for (var i = 0; i < graph.E.length; i++) {
   var edge = graph.E[i];
   console.log("INSERT INTO Edges VALUES("
   + "DEFAULT" + ","
   + graph.id + ","
   + edge[0] + ","
   + edge[1] + ","
   + edge[2]
   + ");" );
 }

 console.log("INSERT INTO Stats VALUES("
   + graph.id + ","
   + "0" + ","
   + "0"
   + ");" );
