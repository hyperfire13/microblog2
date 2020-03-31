"use strict";

var microblogApp = angular.module('microblogApp', [
  "ngRoute",
  "ngAnimate",
  'ngSanitize',
  "routeStyles",
  "bw.paging"
]);

microblogApp.config(['$routeProvider',function($routeProvider) {
  window.routes = {
    '/home' : {
      templateUrl:"main/home.php",
      controller:"homeCtrl",
      // css:"css/main/home.css",
      js:"js/main/home.js"
    },
    '/compose-blog' : {
      templateUrl:"main/compose-blog.php",
      controller:"composeCtrl",
      // css:"css/main/compose-blog.css",
      js:"js/main/compose-blog.js"
    }
	};
	for (var path in window.routes) {
    $routeProvider.when(path, window.routes[path]);
	}
	$routeProvider.otherwise({ templateUrl: 'main/page-not-found.php' });
}]);