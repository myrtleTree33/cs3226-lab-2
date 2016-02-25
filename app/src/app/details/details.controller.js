(function() {
  'use strict';


  angular
    .module('cs3226Lab2')
    .controller('DetailsController', DetailsController);

  /** @ngInject */
  function DetailsController($scope, $state, gameService) {

    // $scope.audio = new Audio('assets/sounds/01 A Night Of Dizzy Spells.mp3');
    // $scope.audio.play();

    // var audio = new Audio('assets/sounds/01 A Night Of Dizzy Spells.mp3', {});
    // audio.play();

    var sound = {};
    //
    angular.element(document).ready(function() {});


    // set defaults
    $scope.user = {
      gameType: 'same',
      numMatches: 4
    };

    $scope.submit = function() {
      setTimeout(function() {
        sound.stop();
      }, 2000);
      gameService.numMatches = $scope.user.numMatches;
      gameService.gameType = $scope.user.gameType;
      $state.go('game')
    }
  }
})();
