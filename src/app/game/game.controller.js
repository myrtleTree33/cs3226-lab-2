(function() {
  'use strict';


  angular
    .module('cs3226Lab2')
    .controller('GameController', GameController);

  /** @ngInject */
  function GameController($scope, gameService, _, $) {
    // var numMatches = gameService.numMatches;
    var currSel = {
      left: 0,
      right: 0
    }

    function checkCurrSel(currSel) {
      if (currSel.left === currSel.right) {
        var selector = '.match-' + currSel.left;
        $(selector).each(function() {
          $(this).addClass('lab2-match-correct');
        });
      }
    }

    var numMatches = 3;
    var subset = _.sampleSize(gameService.db, numMatches);

    $scope.matches = gameService.genGame(subset, 'same');
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
