(function() {
  'use strict';

  angular
    .module('cs3226Lab2')
    .service('gameService', function(_) {

      function checkPermutationsNotSame(obj) {
        var valid = true;
        for (var i = 0; i < obj.length; i++) {
          var ele = obj[i],
            leftId = ele.left.id,
            rightId = ele.right.id;
          if (leftId === rightId) {
            valid = false;
          }
        }
        return valid;
      }

      /**
       * Generates a proper game for a subset of objects
       * @param  {[type]} subset [description]
       * @param  {[type]} type   [description]
       * @return {[type]}        [description]
       */
      function genSide(subset, type) {
        var base = 'assets/images/'
        var result = [];
        if (type === "pic") {
          result = _.map(subset, function(curr) {
            return {
              id: curr.id,
              src: base + curr.src
            }
          });
        } else if (type === "color") {
          result = _.map(subset, function(curr) {
            return {
              id: curr.id,
              src: base + curr.color
            }
          });
        } else if (type === "words") {
          result = _.map(subset, function(curr) {
            return {
              id: curr.id,
              src: base + curr.name
            }
          });
        }
        return _.shuffle(result);
      }

      function genGame(subset, type) {
        var checkPassed = false;
        while (!checkPassed) {
          var temp = [],
            result = [];
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
          } else if (type === "words") {
            temp = {
              left: genSide(subset, 'pic'),
              right: genSide(subset, 'words')
            };
          }

          for (var i = 0; i < temp.left.length; i++) {
            result.push({
              left: temp.left[i],
              right: temp.right[i]
            });
          }
          console.log(result);
          checkPassed = checkPermutationsNotSame(result);
        }
        return result;
      }

      var db = [{
        src: 'icons/free-60-icons-01.png',
        id: 1,
        color: 'colors/color1.png',
        name: 'words/bomb.png'
      }, {
        src: 'icons/free-60-icons-03.png',
        id: 2,
        color: 'colors/color2.png',
        name: 'words/canvas.png'
      }, {
        src: 'icons/free-60-icons-04.png',
        id: 3,
        color: 'colors/color3.png',
        name: 'words/guy.png'
      }, {
        src: 'icons/free-60-icons-08.png',
        id: 4,
        color: 'colors/color4.png',
        name: 'words/coins.png'
      }, {
        src: 'icons/free-60-icons-10.png',
        id: 5,
        color: 'colors/color5.png',
        name: 'words/console.png'
      }, {
        src: 'icons/free-60-icons-11.png',
        id: 6,
        color: 'colors/color6.png',
        name: 'words/doughnut.png'
      }, {
        src: 'icons/free-60-icons-13.png',
        id: 7,
        color: 'colors/color7.png',
        name: 'words/plant.png'
      }, {
        src: 'icons/free-60-icons-14.png',
        id: 8,
        color: 'colors/color8.png',
        name: 'words/plug.png'
      }, {
        src: 'icons/free-60-icons-19.png',
        id: 9,
        color: 'colors/color9.png',
        name: 'words/ball.png'
      }, {
        src: 'icons/free-60-icons-40.png',
        id: 10,
        color: 'colors/color10.png',
        name: 'words/snowman.png'
      }, {
        src: 'icons/free-60-icons-49.png',
        id: 11,
        color: 'colors/color11.png',
        name: 'words/thumbdrive.png'
      }, {
        src: 'icons/free-60-icons-60.png',
        id: 12,
        color: 'colors/color12.png',
        name: 'words/heart.png'
      }, ];

      return {
        game: "qq",
        db: db,
        genSide: genSide,
        genGame: genGame,
        numMatches: 0,
        gameType: 'same'
      }
    })

})();
