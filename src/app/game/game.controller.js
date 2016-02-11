(function() {
  'use strict';


  angular
    .module('cs3226Lab2')
    .controller('GameController', GameController);

  /** @ngInject */
  function GameController($scope, gameService, _, $, $state) {
    var iconPoints = [];
    var canvasObj = {}; // will be initialized with paperJS
    var numMatches = gameService.numMatches;
    var numWrong = 0;
    console.log(gameService)
    var currSel = {
        left: null,
        right: null
      },
      score = 0;
    $scope.isDone = false;

    function getScoreMsg(score, totalScore) {
      var result = score / totalScore;
      if (result === 1) {
        return 'Outstanding!!';
      } else if (result >= .7) {
        return 'Great job!!';
      } else if (result >= .5) {
        return 'Very good!!';
      } else {
        return 'Try again next time!!';
      }
    }

    function checkCurrSel(currSel) {
      if (!currSel.left || !currSel.right) {
        return;
      }

      // correct
      if (currSel.left === currSel.right) {
        score++;
        var selector = '.match-' + currSel.left;
        $(selector).each(function() {
          $(this).addClass('lab2-match-correct');
        });

        // TODO refactor
        var getIndexes = function(selector) {
          var results = [];
          results.push($($(selector).get(0)).index('.lab2-match'));
          results.push($($(selector).get(1)).index('.lab2-match'));
          return results;
        };

        var getTrueIndex = function(idx) {
          if (idx % 2 == 0) {
            return idx / 2;
          } else {
            return (idx - 1) / 2;
          }
        };

        var indexes = getIndexes(selector);
        var left = getTrueIndex(indexes[0]);
        var right = getTrueIndex(indexes[1]);
        if (Math.abs(left - right) <= 1) {
        canvasObj.drawStraightLine(
          iconPoints[indexes[0]],
          iconPoints[indexes[1]],
          true);
        } else {
        canvasObj.drawCurvyLine(
          iconPoints[indexes[0]],
          iconPoints[indexes[1]],
          true);
        }

        // wrong
      } else {
        numWrong++;
        $scope.numWrong = numWrong;
        if (numWrong === 3) {
          $scope.isDone = true;
        }
      }

      currSel.left = null;
      currSel.right = null;

      $scope.score = score;
      $scope.scoreMsg = getScoreMsg(score, numMatches);

      if (gameService.numMatches == score) {
        $scope.isDone = true;
      }

      // if (score === gameService.numMatches) {
      // alert('done!')
      // }

    }


    function getGridPoints() {
      // height of 1 icon
      var offset = 10;
      var iconHeight = $($('.lab2-match').get(0)).height() + 20;
      var canvas = {
        height: $('#myCanvas').height(),
        width: $('#myCanvas').width()
      };
      var length = $('.lab2-match').length / 2;
      for (var i = 0; i < length; i++) {
        iconPoints.push(
          new paper.Point(offset, i * iconHeight + iconHeight / 2)
        );
        iconPoints.push(
          new paper.Point(canvas.width - offset, i * iconHeight + iconHeight / 2)
        );
      }
    }

    var setupPaper = function() {


      var init = function() {
        paper.install(window);
        var canvas = document.getElementById('myCanvas');
        paper.setup(canvas);

      };

      var drawStraightLine = function(start, end, blinks) {
        var path = new paper.Path({
          strokeColor: '#000000',
          strokeWidth: 10,
          strokeCap: 'round'
        });
        // path.removeSegments();
        path.fullySelected = true;
        path.strokeColor = '#e08285';
        path.add(start);
        path.lineTo(end);
        path.fullySelected = true;
        // console.log(segment.handleIn);
        if (blinks) {
          path.onFrame = function(event) {
            path.strokeColor.hue += 5;
          }
        }
        paper.view.draw();
      };

      var drawCurvyLine = function(start, end, blinks) {
        var path = new paper.Path({
          strokeColor: '#000000',
          strokeWidth: 10,
          strokeCap: 'round'
        });
        path.fullySelected = true;
        path.strokeColor = '#e08285';

        var rect = new paper.Rectangle(start, end);
        var r1 = rect.topCenter;
        var r2 = rect.bottomCenter;

        path.add(start);

        for (var i = 0; i < 3; i++) {
          var diff = end.subtract(start).divide(5);
          diff.y = Math.sin(i * 30) * diff.y;
          path.lineTo(start.add(diff.multiply(i)));
        }
        path.lineTo(end);
        path.smooth();
        var segment = path.segments;

        path.fullySelected = true;

        if (blinks) {
          path.onFrame = function(event) {
            path.strokeColor.hue += 5;
          }
        }
      };


      init();

      return {
        drawStraightLine: drawStraightLine,
        drawCurvyLine: drawCurvyLine
      };
    };


    setTimeout(function() {
      getGridPoints();
      canvasObj = setupPaper();
    }, 1000);





    $scope.retry = function() {
      $state.go('details')
    }

    // var numMatches = 3;
    var numMatches = gameService.numMatches;
    var subset = _.sampleSize(gameService.db, numMatches);

    $scope.matches = gameService.genGame(subset, gameService.gameType);
    $scope.setSel = function(direction, id) {
      if (direction === 'left') {
        currSel.left = id;
      } else if (direction === 'right') {
        currSel.right = id;
      }
      checkCurrSel(currSel);
    }
  }
})();
