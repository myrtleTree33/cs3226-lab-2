(function() {
  'use strict';


  angular
    .module('cs3226Lab2')
    .controller('GameController', GameController);

  /** @ngInject */
  function GameController($scope, gameService, _, $, $state) {
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
      if (currSel.left === currSel.right) {
        score++;
        var selector = '.match-' + currSel.left;
        $(selector).each(function() {
          $(this).addClass('lab2-match-correct');
        });
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
