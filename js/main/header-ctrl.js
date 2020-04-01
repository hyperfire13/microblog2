microblogApp.controller('headerCtrl',
  [
    '$rootScope',
    '$scope',
    '$timeout',
    '$http',
    '$log',
    '$httpParamSerializerJQLike',
    '$filter',
    'handler',
  function(
    $rootScope, 
    $scope,
    $timeout,
    $http,
    $log,
    $httpParamSerializerJQLike,
    $filter,
    handler
  ) {
    $scope.logoutVar = {
      token : localStorage.getItem('token')
    }
    $scope.logout = function () {
      $http({
          method:'POST',
          url:'apis/users/logout',
          data : JSON.stringify($scope.logoutVar),
          headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
      }).then(function mySuccess(response) {
          console.log(response);
          //$timeout(function() { location.href = './'; }, 600);
      });
    }
  }]);