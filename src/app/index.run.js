(function() {
  'use strict';

  angular
    .module('cs3226Lab2')
    .run(runBlock);

  /** @ngInject */
  function runBlock($log) {

    $log.debug('runBlock end');

  }

})();
