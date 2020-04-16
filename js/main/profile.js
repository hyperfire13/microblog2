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
    var backupPostId;
    var bakcupIndex;
    $scope.saving = false;
    $scope.likeAdd = 0;
    $scope.shareAdd = 0;
    $scope.commentAdd = 0;
    $scope.photoSelected = false;
    $scope.pageSize = 5;
    $scope.totalPages = 0;
    $scope.request = {
      page : 1,
      total : 0
    };
    $scope.people = [];
    $scope.searchName = '';
    $scope.peoplePageSize = 10;
    $scope.peopleTotalPages = 0;
    $scope.peopleRequest = {
      page : 1,
      total : 0
    };
    $scope.searchFollowingRequest = {
      page : 1,
      total : 0
    };

    $scope.followerPageSize = 10;
    $scope.followerTotalPages = 0;
    $scope.followingTotalPages = 0;
    $scope.followerRequest = {
      page : 1,
      total : 0
    };
    $scope.followingRequest = {
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
    $scope.followings = [];
    $scope.followers = [];
    $scope.displayComments = [];
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
    $scope.blogs = [];
    $scope.imageGenerator = 0;
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
    $scope.removeNewPhoto = function () {
      $scope.imageGenerator--;
    }
    $scope.removeExistingPhoto = function (index) {
      $scope.editPost.images.splice(index,1);
      if ($scope.editPost.imageCaptions.length > 0) {
        $scope.editPost.imageCaptions.splice(index,1);
      }
    }
    $scope.addImageSelector  = function () {
      if (($scope.editPost.images.length + $scope.imageGenerator)  > 2) {
          handler.growler('Max of 3 images only');
      } else {
          $scope.imageGenerator++;
      }
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
           $scope.showMyBlogs();
        } else if (response.data.status === 'failed') {
            handler.growler(response.data.message);
        } else {
            handler.unknown();
        }
      });
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
              $scope.showMyBlogs($scope.request.page);
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
    $scope.showComments = function (postId,index) {
      bakcupIndex = index;
      backupPostId = postId;
      $scope.displayComments = [];
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
    $scope.saveEditPost = function () {
      if ($scope.editPost.post.length > 150) {
          handler.growler('your blog should not be more than 150 characters');
      } 
      else {
          var form_data = new FormData();
          var measurer = true;
          if ($scope.editPost.images.length > 0) {
              $scope.editPost.imageCaptions = [];
              for (let index = 0; index < $scope.editPost.images.length; index++) {
                  $scope.editPost.imageCaptions.push($('#caption-'+index).val());
              }
          }
          if ($scope.imageGenerator > 0) {
              for (let id = 0; id < $scope.imageGenerator; id++) {
                form_data.append("file[]", $("#"+id)[0].files[0]);
                if ($('#newcaption-'+id).val() !== "") {
                    $scope.editPost.imageCaptions.push($('#newcaption-'+id).val());
                }
              }
          }
          for (let id = 0; id < $scope.editPost.imageCaptions.length; id++) {
            if ($scope.editPost.imageCaptions[id].length < 20) {
                continue;
            } else {
                measurer = false;
                handler.growler('Picture number '+(id+1)+'\'s caption is over 20 characters');
                break;
            }
          }
          if (measurer) {
              form_data.append("token", localStorage.getItem('token'));
              form_data.append("user_id", $rootScope.user.id);
              form_data.append("post_id", $scope.editPost.id);
              form_data.append("post", $scope.editPost.post);
              form_data.append("existing_pics",JSON.stringify($scope.editPost.images));
              form_data.append("image_captions",JSON.stringify($scope.editPost.imageCaptions));
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
                        $scope.showMyBlogs();
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
          $scope.go = true;
          $scope.photoSelected = true;
          
      } else {
          handler.growler('Accepts only .jpg, .jpeg, .png image format');
          //alert();
          $scope.photoSelected = false;
          jQuery('#picPreview-'+element.id).attr('src', null);
          jQuery('#'+element.id).val(null);
      }
    }
    $scope.editPostPrompt = function (post) {
      alert(JSON.stringify(post))
      $scope.imageGenerator = 0;
      $scope.go = false;
      $scope.editPost.id = post.id;
      $scope.editPost.post = post.post;
      if (post.images !== null) {
          $scope.editPost.images = post.images.slice();
      }
      if (post.image_captions !== null) {
          $scope.editPost.imageCaptions = post.image_captions.slice();
      }
      
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
                $timeout(function () {
                  $rootScope.getProfile();
                }, 2000);
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
    $scope.showMyBlogs = function (pageNum) {
      $scope.fetching = true;
      if (pageNum) {
          $scope.request.page = pageNum;
      }
      $('#paginatorBtn').text("Page "+ $scope.request.page);
      $scope.fetching = true;
      $timeout(function () {
        $http({
          method:'GET',
          url:'apis/posts/viewMyBlogs'+'?token='+localStorage.getItem('token')+'&id='+$rootScope.user.id+'&page='+$scope.request.page+'&size='+$scope.pageSize,
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
     
    }
    $scope.showPeople = function (pageNum) {
      $scope.fetching = true;
      if (pageNum) {
        $scope.followerRequest.page = pageNum;
      }
      $timeout(function () {
        $http({
          method:'GET',
          url:'apis/followers/viewPeople'+'?token='+localStorage.getItem('token')+'&id='+$rootScope.user.id+'&page='+$scope.followerRequest.page+'&size='+$scope.followerPageSize,
          headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
        }).then(function mySuccess(response) {
          $scope.fetching = false;
          if (response.data.status === 'success') {
              $scope.followers  = response.data.followers;
              $scope.followings  = response.data.followings;
              $scope.followerRequest.total = response.data.totalFollowers;
              $scope.followingRequest.total = response.data.totalFollowings;
              $scope.followerTotalPages = response.data.followerTotalPages;
              $scope.followingTotalPages = response.data.followingTotalPages;
          } else if (response.data.status === 'failed') {
              $scope.followers = [];
              $scope.following = [];
          } else {
              handler.unknown();
          }
          $('#paginatorBtn2').text("Page "+ $scope.followerRequest.page);
        });
      }, 2000);
    };
    $scope.searchPeople = function (pageNum) {
      $('#searchModal').modal({
        backdrop: 'static',
        keyboard: false,
        show : true
      });
      if (pageNum) {
        $scope.peopleRequest.page = pageNum;
      }
      $scope.fetching = true;
      $scope.people = [];
      $timeout(function () {
        $http({
          method:'GET',
          url:'apis/followers/searchPeople'+'?token='+localStorage.getItem('token')+'&id='+$rootScope.user.id+'&page='+$scope.peopleRequest.page+'&size='+$scope.peoplePageSize+'&search='+$scope.searchName,
          headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
        }).then(function mySuccess(response) {
          $scope.fetching = false;
          if (response.data.status === 'success') {
              $scope.people  = response.data.people;
              $scope.peopleRequest.total = response.data.total;
              $scope.peopleTotalPages = response.data.totalPages;
          } else if (response.data.status === 'failed') {
              $scope.people = [];
          } else {
              handler.unknown();
          }
          $('#paginatorBtn3').text("Page "+ $scope.peopleRequest.page);
        });
      }, 2000);
    }
    $scope.unfollow = function (id) {
      $scope.fetching = true;
      $http({
        method:'POST',
        url:'apis/followers/unfollow',
        data : {
          token : localStorage.getItem('token'),
          user_id : $rootScope.user.id,
          id : id
        },
        headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
      }).then(function mySuccess(response) {
        if (response.data.status === 'success') {
            $scope.showPeople();
            $('#searchModal').modal('hide');
        } else if (response.data.status === 'failed') {
            handler.growler(response.data.message);
        } else {
            
        }
      });
    }
    $scope.follow = function (id) {
      $scope.fetching = true;
      $http({
        method:'POST',
        url:'apis/followers/follow',
        data : {
          token : localStorage.getItem('token'),
          user_id : $rootScope.user.id,
          following_id : id
        },
        headers:{'Content-Type' : 'application/x-www-form-urlencoded'}
      }).then(function mySuccess(response) {
        if (response.data.status === 'success') {
            $scope.showPeople();
            $('#searchModal').modal('hide');
        } else if (response.data.status === 'failed') {
            handler.growler(response.data.message);
        } else {
            
        }
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
    jQuery('#commentModal').on('hidden.bs.modal', function() {
      $scope.myComment = '';
    });
    //$scope.showMyBlogs();
  }]);
 