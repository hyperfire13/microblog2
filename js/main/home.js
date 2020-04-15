microblogApp.controller('homeCtrl',
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
    $scope.findBlog = '';
    $scope.pageSize = 5;
    $scope.searchRequesttotalPages =0;
    $scope.totalPages = 0;
    $scope.request = {
      page : 1,
      total : 0
    };
    $scope.searchRequest = {
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
      images : [],
      imageCaptions : []
    };
    $scope.personProfile = null;
    $scope.showProfile = function (id) {
      $scope.fetching = true;
      $('#profileModal').modal({
        backdrop: 'static',
        keyboard: false,
        show : true
      });
      $http({
        method:'GET',
        url:'apis/users/showProfile'+'?token='+localStorage.getItem('token')+'&search_id='+id+'&user_id='+$rootScope.user.id,
          headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
      }).then(function mySuccess(response) {
        $scope.fetching = false;
        if (response.data.status === 'success') {
            $scope.personProfile = response.data.record;
        } else if (response.data.status === 'failed') {
            $scope.personProfile = null;
            handler.growler(response.data.message);
        } else if (!response.data.status) {
            $scope.personProfile = null;
            $scope.fetching = false;
            handler.unknown();
        }
      },function myError () {
          $scope.personProfile = null;
          $scope.fetching = false;
          handler.unknown();
      });
    }
    $scope.searchBlogs = function (page) {
      $scope.searchBlogResult = [];
      $('#searchModal').modal({
        backdrop: 'static',
        keyboard: false,
        show : true
      });
      $scope.searchRequest.page = page;
      $scope.fetching = true;
      $timeout(function () {
        $http({
          method:'GET',
          url:'apis/posts/searchAllBlogs'+'?token='+localStorage.getItem('token')+'&id='+$rootScope.user.id+'&page='+$scope.searchRequest.page+'&size='+$scope.pageSize+'&search='+$scope.findBlog,
          headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
        }).then(function mySuccess(response) {
          $timeout(function () {
            // handler.showLoading(false,"");
          }, 2000);
          if (response.data.status === 'success') {
              $scope.searchBlogResult  = response.data.record;
              $scope.searchRequest.total = response.data.total;
              $scope.searchRequesttotalPages = response.data.totalPages;
              $scope.fetching = false;
          } else if (response.data.status === 'failed') {
              $scope.searchBlogResult = [];
              $scope.fetching = false;
              handler.growler(response.data.message);
          } else {
              handler.unknown();
          }
          $('#paginatorBtn2').text("Page "+ $scope.searchRequest.page);
        });
      }, 2000);
      
    }
    $scope.removeNewPhoto = function () {
      $scope.imageGenerator--;
    }
    $scope.removeExistingPhoto = function (index) {
      $scope.editPost.images.splice(index,1);
    }
    $scope.addImageSelector  = function () {
      if (($scope.editPost.images.length + $scope.imageGenerator)  > 2) {
          handler.growler('Max of 3 images only');
      } else {
          $scope.imageGenerator++;
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
    $scope.saveEditPost = function () {
      if ($scope.editPost.post.length > 150) {
          handler.growler('your blog should not be more than 150 characters');
      } 
      else {
          var form_data = new FormData();
          if ($scope.imageGenerator > 0) {
              for (let id = 0; id < $scope.imageGenerator; id++) {
                form_data.append("file[]", $("#"+id)[0].files[0]);
              }
          }
          form_data.append("token", localStorage.getItem('token'));
          form_data.append("user_id", $rootScope.user.id);
          form_data.append("post_id", $scope.editPost.id);
          form_data.append("post", $scope.editPost.post);
          form_data.append("existing_pics",JSON.stringify($scope.editPost.images));
          handler.showLoading(true,"Editing your blog...");
          $timeout(function () {
            $.ajax({
              method: 'POST',
              data: form_data ,
              processData: false,
              contentType: false,
              url: 'apis/posts/editPost',
              success: function(data) {
                var response = data;
                $timeout(function () {
                  handler.showLoading(false,"");
                }, 2000);
                if (response.status === 'success') {
                    handler.growler(response.message);
                    $scope.editPost = {
                      id : '',
                      post : '',
                      images : ''
                    };
                    $scope.imageGenerator = 0;
                    $('#editPostModal').modal('hide');
                    $scope.viewAllBlogs();
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
    $scope.editPostPrompt = function (post) {
     
      $scope.imageGenerator = 0;
      $scope.editPost.id = post.id;
      $scope.editPost.post = post.post;
      if (post.images !== null) {
        $scope.editPost.images = post.images.slice();
      }
      
      $('#editPostModal').modal({
        backdrop: 'static',
        keyboard: false,
        show : true
      });
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
              $scope.viewAllBlogs();
          } else if (response.data.status === 'failed') {
              handler.growler(response.data.message);
          } else {
              handler.unknown();
          }
        });
      }, 2000);
    }
    $scope.viewAllBlogs = function (pageNum) {
      //$scope.blogs = null;
      $scope.fetching = true;
      if (pageNum) {
          $scope.request.page = pageNum;
      }
      $('#paginatorBtn').text("Page "+ $scope.request.page);
      $timeout(function () {
        $http({
          method:'GET',
          url:'apis/posts/viewAllBlogs'+'?token='+localStorage.getItem('token')+'&id='+$rootScope.user.id+'&page='+$scope.request.page+'&size='+$scope.pageSize,
          headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
        }).then(function mySuccess(response) {
          $timeout(function () {
           // handler.showLoading(false,"");
          }, 2000);
          if (response.data.status === 'success') {
              $scope.blogs  = response.data.record;
              $scope.request.total = response.data.total;
              $scope.totalPages = response.data.totalPages;
              $scope.fetching = false;
          } else if (response.data.status === 'failed') {
              $scope.blogs = [];
              $scope.fetching = false;
              handler.growler(response.data.message);
          } else {
              handler.unknown();
          }
        });
      }, 2000);
      // $timeout(function () {
      //   $scope.viewAllBlogs($scope.request.page);
      // },3000);
    }
    $scope.likePost = function (postId,index) {
      $http({
        method:'POST',
        url:'apis/likes/likePost',
        data : {
          token : localStorage.getItem('token'),
          user_id : $rootScope.user.id,
          post_id : postId
        },
        headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
      }).then(function mySuccess(response) {
        if (response.data.status === 'success') {
          $scope.likeAdd = 0;
           $('#commentModal').modal('hide');
           $scope.blogs[index].Like.push('');
           //$scope.likeAdd = 1;
        } else if (response.data.status === 'unlike') {
            $scope.blogs[index].Like.splice(0,1);
        } else {
            
        }
      });
    }
    $scope.promptSharePost = function (post,owner) {
      $scope.retweet = post;
      $scope.owner = owner;
      console.log(JSON.stringify(owner));
      $('#retweetModal').modal({
        backdrop: 'static',
        keyboard: false,
        show : true
      });
    }
    $scope.sharePost = function (postId,retweetCaption) {
      $http({
        method:'POST',
        url:'apis/posts/sharePost',
        data : {
          token : localStorage.getItem('token'),
          user_id : $rootScope.user.id,
          post_id : postId,
          post : retweetCaption
        },
        headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
      }).then(function mySuccess(response) {
        if (response.data.status === 'success') {
           handler.growler('you shared this post');
           $('#commentModal').modal('hide');
           $('#retweetModal').modal('hide');
           $scope.resharePost = '';
           $scope.viewAllBlogs();
        } else if (response.data.status === 'failed') {
            handler.growler(response.data.message);
        } else {
            handler.unknown();
        }
      });
    }
    $scope.showComments = function (postId,index) {
      bakcupIndex = index;
      backupPostId = postId;
      $scope.displayComments = [];
      $('#searchModal').modal('hide');
      $('#commentModal').modal({
        backdrop: 'static',
        keyboard: false,
        show : true
      });
      $timeout(function () {
        
        $http({
          method:'GET',
          url:'apis/comments/viewComments'+'?token='+localStorage.getItem('token')+'&id='+$rootScope.user.id+'&postId='+postId,
          headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
        }).then(function mySuccess(response) {
          $timeout(function () {
           // handler.showLoading(false,"");
          }, 2000);
          if (response.data.status === 'success') {
              
              $scope.displayComments  = response.data.record;
          } else if (response.data.status === 'failed') {
              $scope.displayComments = null;
          } else {
              handler.unknown();
          }
        });
      }, 2000);
    }
    $scope.saveComment = function (index,myComment) {
      if (myComment === undefined) {
          handler.growler('enter a comment');
      } else {
          $scope.saving = true;
          $http({
            method:'POST',
            url:'apis/comments/saveComment',
            data : {
              token : localStorage.getItem('token'),
              user_id : $rootScope.user.id,
              post_id : backupPostId,
              comment : myComment
            },
            headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
          }).then(function mySuccess(response) {
            if (response.data.status === 'success') {
              $scope.saving = false;
              handler.growler('comment saved');
              $scope.myComment = '';
              $('#commentModal').modal('hide');
              $scope.viewAllBlogs($scope.request.page);
              $scope.showComments(backupPostId);
            } else if (response.data.status === 'failed') {
                handler.growler(response.data.message);
                $scope.saving = false;
            } else {
                handler.unknown();
                $scope.saving = false;
            }
          });
      }
    }
    jQuery('#commentModal').on('hidden.bs.modal', function() {
      $scope.myComment = '';
    });
    $scope.viewAllBlogs();

  }]);