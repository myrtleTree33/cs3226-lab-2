(function() {
  'use strict';


  angular
    .module('cs3226Lab2')
    .controller('DetailsController', DetailsController);

  /** @ngInject */
  function DetailsController($scope, $state, gameService) {
    // set defaults
    $scope.user = {
      gameType: 'same',
      numMatches: 2
    };

    $scope.submit = function() {
      gameService.numMatches = $scope.user.numMatches;
      gameService.gameType = $scope.user.gameType;
      $state.go('game')
    }
  }
})();
