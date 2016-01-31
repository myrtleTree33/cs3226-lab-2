(function() {
  'use strict';

  angular
    .module('cs3226Lab2')
    .config(routerConfig);

  /** @ngInject */
  function routerConfig($stateProvider, $urlRouterProvider) {
    $stateProvider
      // .state('home', {
      //   url: '/',
      //   templateUrl: 'app/main/main.html',
      //   controller: 'MainController',
      //   controllerAs: 'main'
      // })

      .state('details', {
        url: '/details',
        templateUrl: 'app/details/details.html',
        controller: 'DetailsController',
        controllerAs: 'details'
      })

      .state('game', {
        url: '/game',
        templateUrl: 'app/game/game.html',
        controller: 'GameController',
        controllerAs: 'game'
      });

    $urlRouterProvider.otherwise('/details');
  }

})();
