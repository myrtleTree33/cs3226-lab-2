/* global malarkey:false, moment:false */
(function() {
  'use strict';

  angular
    .module('cs3226Lab2')
    .constant('malarkey', malarkey)
    .constant('_', window._)
    .constant('$', window.$)
    .constant('moment', moment);

})();
