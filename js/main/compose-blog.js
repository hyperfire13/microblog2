microblogApp.controller('composeCtrl',
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

    $scope.photoSelected = false;
    $scope.imageGenerator = 0;
    var counter = $scope.imageGenerator;
    $scope.blogBody = '';

    $scope.savePost = function () {
      if ($scope.blogBody.length > 150) {
          handler.growler('your blog should not be more than ');
      } else {
          var form_data = new FormData();
          if ($scope.imageGenerator > 0) {
              for (let id = 0; id < $scope.imageGenerator; id++) {
                form_data.append("file[]", $("#"+i)[0].files[0]);
              }
              form_data.append("token", localStorage.getItem('token'));
              form_data.append("blog", $scope.blogBody);
              handler.showLoading(true,"Uploading your blog...");
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
      }
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

    $scope.addImageSelector  = function () {
      if ($scope.imageGenerator < 3) {
        $scope.imageGenerator++;
        counter = $scope.imageGenerator;
      }
    }

    $scope.viewImage = function (element, index) {
      var reader = new FileReader();
      var imageInput = jQuery('#'+element.id);
      var imagePreview = jQuery('#picPreview-'+element.id);
      var imageFile = imageInput[0].files[0];
      var imageName = imageFile.name;
      reader.onload = function(e) {
        $scope.$apply();
        imagePreview.attr('src', e.target.result);
      };
      if ($scope.isImage(imageName)) {
          reader.readAsDataURL(imageFile);
          $scope.photoSelected = true;
          
      } else {
          handler.growler('Accepts only .jpg, .jpeg, .png image format');
          //alert();
          $scope.photoSelected = false;
          jQuery('#picPreview-'+element.id).attr('src', null);
          jQuery('#'+element.id).val(null);
      }
    }
    
      // jQuery('#fileId').change(function(e) {
      //   alert($scope.imageGenerator);
      //   $scope.photoSelected = true;
      //   for (let id = 0; id < $scope.imageGenerator; id++) {
      //     var reader = new FileReader();
      //     var imageInput = jQuery('#fileId');
      //     var imagePreview = jQuery('#picPreview');
      //     var imageFile = imageInput[0].files[0];
      //     var imageName = imageFile.name;
      //     reader.onload = function(e) {
      //       $scope.$apply();
      //       imagePreview.attr('src', e.target.result);
      //     };
      //     if ($scope.isImage(imageName)) {
      //         reader.readAsDataURL(imageFile);
      //         $scope.pictureChange = true;
              
      //     } else {
      //         handler.growler('Accepts only .jpg, .jpeg, .png image format');
      //         //alert();
      //         $scope.pictureChange = false;
      //         jQuery('#picPreview').attr('src', null);
      //     }
      //   }
      // }); 
    
   
  }]);