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
    $scope.imageCaptions = [];
    $scope.savePost = function () {
      if ($scope.blogBody.length > 150) {
          $("#blogId").addClass("is-invalid");
      } else {
          var form_data = new FormData();
          var measurer = true;
          if ($scope.imageGenerator > 0) {
              for (let id = 0; id < $scope.imageGenerator; id++) {
                form_data.append("file[]", $("#"+id)[0].files[0]);
                if ($("#caption-"+id).val().length < 20) {
                    $scope.imageCaptions.push($("#caption-"+id).val());
                    continue;
                } else {
                    measurer = false;
                    $scope.imageCaptions = [];
                    handler.growler('Picture number '+(id+1)+'\'s caption is over 20 characters');
                    break;
                }
              }
              form_data.append('image_captions',JSON.stringify($scope.imageCaptions));
          }
          form_data.append("token", localStorage.getItem('token'));
          form_data.append("user_id", $rootScope.user.id);
          form_data.append("post", $scope.blogBody);
          if (measurer) {
              handler.showLoading(true,"Uploading your blog...");
              $timeout(function () {
                $.ajax({
                  method: 'POST',
                  data: form_data ,
                  processData: false,
                  contentType: false,
                  url: 'apis/posts/addPost',
                  success: function(data) {
                    var response = data;
                    $timeout(function () {
                      handler.showLoading(false,"");
                    }, 2000);
                    if (response.status === 'success') {
                        handler.growler(response.message);
                        $scope.blogBody = '';
                        $scope.imageGenerator = 0;
                    } else if (response.status === 'failed') {
                        handler.growler(response.message);
                    } else if (response.status !== 'success') {
                        handler.unknown();
                    }
                  },
                  error: function() {
                    setTimeout(function() {
                      handler.showLoading(false,"");
                    }, 1000);
                    setTimeout(function() {
                      handler.growler("Something went wrong","It's not on you,It's on us");
                    },1000);
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
      } else {
          handler.growler('Max of 3 images only');
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