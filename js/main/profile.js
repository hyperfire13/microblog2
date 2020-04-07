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

    $scope.pageSize = 3;
    $scope.totalPages = 0;
    $scope.request = {
      page : 1,
      total : 0
    };
    $scope.delete = {
      id : '',
      post : ''
    };
    $scope.editPost = {
      id : '',
      post : '',
      images : ''
    };
    $scope.pictureChange = false;
    $scope.editUser = {
      id : '',
      email : '',
      username : '',
      oldPassword : '',
      password : '',
      firstName : '',
      middleName : '',
      password : '',
      birthDate : '',
    };
    $scope.blogs = null;

    $scope.editPostPrompt = function (post) {
      $scope.editPost.id = post.id;
      $scope.editPost.post = post.post;
      $scope.editPost.images = post.images;
      $('#editPostModal').modal({
        backdrop: 'static',
        keyboard: false,
        show : true
      });
    }

    $scope.deletePost = function (id) {
        handler.showLoading(true,"Deleting this post...");
        $timeout(function () {
          $http({
            method:'POST',
            url:'apis/posts/deletePost',
            data : {
              token : localStorage.getItem('token'),
              user_id : $rootScope.user.id,
              post_id : id
            },
            headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
          }).then(function mySuccess(response) {
            $timeout(function () {
              handler.showLoading(false,"");
            }, 2000);
            if (response.data.status === 'success') {
                handler.growler("Post successfuilly deleted!");
                $('#deleteModal').modal('hide');
                $scope.showMyBlogs();
            } else if (response.data.status === 'failed') {
                handler.growler(response.data.message);
            } else {
                handler.unknown();
            }
          });
        }, 2000);
    }

    $scope.deletePostPrompt = function (id,post) {
      $scope.delete.id = id;
      $scope.delete.post = post;
      $('#deleteModal').modal({
        backdrop: 'static',
        keyboard: false,
        show : true
      });
    }

    $scope.resetVariables = function () {
      $scope.editUser = {
        id : '',
        email : '',
        username : '',
        oldPassword : '',
        password : '',
        firstName : '',
        middleName : '',
        password : '',
        birthDate : '',
      };
      $scope.confirmPassword = '';
    }
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
      $timeout(function () {
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
      }, 2000);
    }
    $scope.showEditProfile = function () {
      $scope.editUser.id = $rootScope.user.id;
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
    $scope.saveEditProfile = function () {
      $scope.editUser.birthDate = $('#dateOfBirth').val();
      if ($scope.editUser.password !== $scope.confirmPassword) {
          handler.growler("Your New Password was not confirmed correctly");
      } else {
          handler.showLoading(true,"Updating your profile info...");
          $timeout(function () {
            $http({
              method:'POST',
              url:'apis/users/editProfile',
              data : {
                token : localStorage.getItem('token'),
                id : $scope.editUser.id,
                first_name: $scope.editUser.firstName,
                middle_name: $scope.editUser.middleName,
                last_name: $scope.editUser.lastName,
                date_of_birth : $scope.editUser.birthDate,
                email : $scope.editUser.email,
                username : $scope.editUser.username,
                password : $scope.editUser.password,
                old_password : $scope.editUser.oldPassword
              },
              headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
            }).then(function mySuccess(response) {
              $timeout(function () {
                handler.showLoading(false,"");
              }, 2000);
              if (response.data.status === 'success') {
                  handler.growler("Profile successfuilly updated!");
                  $scope.editProfileForm.$setPristine();
                  $scope.editProfileForm.$setUntouched();
                  $scope.resetVariables();
                  $('#editProfileModal').modal('hide');
                  $rootScope.getProfile();
              } else if (response.data.status === 'failed') {
                  handler.growler(response.data.message);
              } else {
                  handler.unknown();
              }
            });
          }, 2000);
      }
     
    }
    $scope.showMyBlogs = function () {
      $scope.blogs = null;
      handler.showLoading(true,"Getting your blogs...");
      $timeout(function () {
        $http({
          method:'GET',
          url:'apis/posts/viewMyBlogs'+'?token='+localStorage.getItem('token')+'&id='+$rootScope.user.id+'&page='+$scope.request.page+'&size='+$scope.pageSize,
          // data : {
          //   token : localStorage.getItem('token'),
          //   id : $rootScope.user.id,
          //   page: $scope.page,
          //   size: $scope.size
          // },
          headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
        }).then(function mySuccess(response) {
          $timeout(function () {
            handler.showLoading(false,"");
          }, 2000);
          if (response.data.status === 'success') {
              $scope.blogs  = response.data.record;
              $scope.request.total = response.data.total;
              $scope.totalPages = response.data.totalPages;
              console.log($scope.blogs);
          } else if (response.data.status === 'failed') {
              handler.growler(response.data.message);
          } else {
              handler.unknown();
          }
        });
      }, 2000);
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
    //$scope.showMyBlogs();
  }]);
 