"use strict";

var microblogApp = angular.module('microblogApp', [
  "ngRoute",
  "ngAnimate",
  'ngSanitize',
  "routeStyles",
  "bw.paging"
]);

microblogApp.service('SessionService', function($rootScope) {
  var userIsAuthenticated = false;
  this.setUserAuthenticated = function(value) { userIsAuthenticated = value; };
  this.getUserAuthenticated = function() {
    if (localStorage.getItem('token') === null || localStorage.getItem('token') === '') {
        userIsAuthenticated = false;
    } else {
        userIsAuthenticated = true;
    }
    return userIsAuthenticated;
  };
});

microblogApp.config(['$routeProvider',function($routeProvider) {
  window.routes = {
    '/home' : {
      templateUrl:"main/home.php",
      controller:"homeCtrl",
      // css:"css/main/home.css",
      js:"js/main/home.js",
      requireLogin	:	true
    },'/profile' : {
      templateUrl:"main/profile.php",
      controller:"profileCtrl",
      css:"css/main/profile.css",
      js:"js/main/profile.js",
      requireLogin	:	true
    },
    '/compose-blog' : {
      templateUrl:"main/compose-blog.php",
      controller:"composeCtrl",
      // css:"css/main/compose-blog.css",
      js:"js/main/compose-blog.js",
      requireLogin	:	true
    }
  };
  for (var path in window.routes) {
    $routeProvider.when(path, window.routes[path]);
  }
  $routeProvider.otherwise({ templateUrl: 'main/page-not-found.php' });
}])
.run(function($rootScope,SessionService) {

  $rootScope.$on("$locationChangeStart", function(event, next, current) {
    for (var i in window.routes) {
      if (next.indexOf(i) != -1) {
        if (window.routes[i].requireLogin && !SessionService.getUserAuthenticated()) {
          /* alert("You need to be authenticated to see this page!");*/
          event.preventDefault(); location.href = './';
        }
      }
  }
  });
});