(function() {
  'use strict';

  angular
    .module('cs3226Lab2')
    .service('gameService', function(_) {

      /**
       * Generates a proper game for a subset of objects
       * @param  {[type]} subset [description]
       * @param  {[type]} type   [description]
       * @return {[type]}        [description]
       */
      function genSide(subset, type) {
        var result = [];
        if (type === "pic") {
          result = _.map(subset, function(curr) {
            return {
              id: curr.id,
              src: curr.src
            }
          });
        } else if (type === "color") {
          result = _.map(subset, function(curr) {
            return {
              id: curr.id,
              src: curr.color
            }
          });
        }
        return _.shuffle(result);
      }

      function genGame(subset, type) {
        var temp = [], result = [];
        if (type === "same") {
          temp = {
            left: genSide(subset, 'pic'),
            right: genSide(subset, 'pic')
          };
        } else if (type === "color") {
          temp = {
            left: genSide(subset, 'pic'),
            right: genSide(subset, 'color')
          };
        }

        for (var i = 0; i < temp.left.length; i++) {
          result.push({
            left: temp.left[i],
            right: temp.right[i]
          });
        }
        return result;
      }

      var db = [{
        src: 'assets/images/round-icons/free-60-icons-05.png',
        id: 1,
        color: 'white'
      }, {
        src: 'assets/images/round-icons/free-60-icons-07.png',
        id: 2,
        color: 'pink'
      }, {
        src: 'assets/images/round-icons/free-60-icons-09.png',
        id: 3,
        color: 'blue'
      }, {
        src: 'assets/images/round-icons/free-60-icons-11.png',
        id: 4,
        color: 'grey'
      }, {
        src: 'assets/images/round-icons/free-60-icons-12.png',
        id: 5,
        color: 'brown'
      }];

      return {
        game: "qq",
        db: db,
        genSide: genSide,
        genGame: genGame,
        numMatches: 0
      }
    })

})();
