(function() {
  'use strict';


  angular
    .module('cs3226Lab2')
    .controller('DetailsController', DetailsController);

  /** @ngInject */
  function DetailsController($scope, $state, gameService) {
    $scope.submit = function() {
      gameService.numMatches = $scope.user.numMatches;
      $state.go('game')
    }
  }
})();
