microblogApp.controller('profileCtrl',
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
    
    $scope.pictureChange = false;
    $scope.editUser = {
      email : '',
      username : '',
      password : '',
      firstName : '',
      middleName : '',
      password : '',
      birthDate : '',
    };

    $scope.getExtension = function(filename) {
      var parts = filename.split('.');
      return parts[parts.length - 1];
    };
    $scope.isImage = function(filename) {
      var ext = $scope.getExtension(filename);
      switch (ext.toLowerCase()) {
        case 'jpg':
        case 'jpeg':
        case 'png':
        return true;
      }
      return false;
    };
    $scope.cancelProfilePic = function () {
      jQuery('#picPreview').attr('src', null);
      $scope.pictureChange = false;
    }
    $scope.saveProfilePic = function () {
      var formSample = new FormData();
      formSample.append("file[]", $("#fileId")[0].files[0]);
      formSample.append("token", localStorage.getItem('token'));
      handler.showLoading(true,"Updating your profile picture...");
      $.ajax({
        method: 'POST',
        data: formSample ,
        processData: false,
        contentType: false,
        url: 'apis/users/profilePic',
        success: function(data) {
          var response = data;
          $timeout(function () {
            handler.showLoading(false,"");
          }, 2000);
          if (response.status === 'success') {
              handler.growler("Image Successfully Updated");
              jQuery('#picPreview').attr('src', null);
              $scope.pictureChange = false;
              location.reload();
          } else if (response.status === 'empty') {
              handler.growler("Please choose an image");
          } else if (response.status !== 'success') {
              handler.unknown();
          }
        }
      });
    }
    $scope.showEditProfile = function () {
      console.log(JSON.stringify($rootScope.user));
      $scope.editUser.email = $rootScope.user.email;
      $scope.editUser.username = $rootScope.user.username;
      $scope.editUser.firstName = $rootScope.user.first_name;
      $scope.editUser.middleName = $rootScope.user.middle_name;
      $scope.editUser.lastName = $rootScope.user.last_name;
      var bday = new Date($rootScope.user.date_of_birth);
      var day = ("0" + bday.getDate()).slice(-2);
      var month = ("0" + (bday.getMonth() + 1)).slice(-2);
      var today = bday.getFullYear()+"-"+(month)+"-"+(day) ;
      $('#dateOfBirth').val(today);
      console.log(bday);
      $('#editProfileModal').modal({
        backdrop: 'static',
        keyboard: false,
        show : true
      });
    }
    jQuery('#fileId').change(function(e) {
      var reader = new FileReader();
      var imageInput = jQuery('#fileId');
      var imagePreview = jQuery('#picPreview');
      var imageFile = imageInput[0].files[0];
      var imageName = imageFile.name;
      reader.onload = function(e) {
        $scope.$apply();
        imagePreview.attr('src', e.target.result);
      };
      if ($scope.isImage(imageName)) {
          reader.readAsDataURL(imageFile);
          $scope.pictureChange = true;
      } else {
          handler.growler('Accepts only .jpg, .jpeg, .png image format');
          //alert();
          jQuery('#picPreview').attr('src', null);
          jQuery('#addInternetSimulationInput').val(null);
      }
    }); 
  }]);