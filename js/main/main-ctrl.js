microblogApp.run(['$rootScope', '$location', '$routeParams', '$http', '$timeout', '$interval', '$httpParamSerializerJQLike', '$log', 
function($rootScope, $location, $routeParams, $http, $timeout, $interval, $httpParamSerializerJQLike, $log, handler) {
  $rootScope.user = null;
  $rootScope.firstName = null;
  var securityKeys = {
    token : null
  };
  $rootScope.auth = function(realtime) {
    if (localStorage.getItem('token') === null ||localStorage.getItem('token') === '') {
        location.href = './';
    }
    securityKeys.token = localStorage.getItem('token');
    $.ajax({
      url: 'apis/users/authenticate',
      method: 'POST',
      data: JSON.stringify(securityKeys), 
      success: function(data) {
        var response = data;
        
        if (response.status === "failed") {
            location.href = './';
            $rootScope.$apply();
        }
      },
      error: function() {
        console.log("Something went wrong","It's not on you,It's on us");
      }
    });
    if (realtime) { 
        $timeout(function () { 
          $rootScope.auth(true); 
        }, 2000); 
    }
  };
  
  $rootScope.getProfile = function () {
    
    $http({
        method:'POST',
        url:'apis/users/getProfile',
        data : {
          token : localStorage.getItem('token')
        },
        headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
    }).then(function mySuccess(response) {
        if (response.data.status === 'success') {
            $rootScope.user = response.data.record.User;
        }
        //$timeout(function() { location.href = './'; }, 600);
    });
  }
 $rootScope.auth(true);
 $rootScope.getProfile();
}]);