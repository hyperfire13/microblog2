<ul class="nav nav-tabs mb-4">
  <li class="nav-item">
    <a  class="nav-link active" data-toggle="tab" href="#about"><span class="fa fa-user "></span>&nbsp;About me</a>
  </li>
  <li class="nav-item">
    <a ng-click="showMyBlogs()" class="nav-link " data-toggle="tab" href="#blogs"><span class="fa fa-pen-square"></span>&nbsp;My Blogs</a>
  </li>
  <li class="nav-item">
    <a ng-click="showPeople()" class="nav-link " data-toggle="tab" href="#followers"><span class="fa fa-users"></span>&nbsp;Followers</a>
  </li>
  <li class="nav-item">
    <a ng-click="showPeople()" class="nav-link " data-toggle="tab" href="#following"><span class="fa fa-users"></span>&nbsp;Following</a>
  </li>
</ul> 
<div id="myTabContent" class="tab-content">
  <div class="tab-pane show  active fade" id="about">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div id="profileCard" class="card border-warning mb-3">
            <div class="card-header">About Me
            <span ng-click="showEditProfile()" data-toggle="tooltip" title="Edit"onmouseenter="$(this).tooltip('show');" class="fa fa-pen-square fa-lg float-right"></span>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <img id="profilePic" ng-show="!pictureChange" ng-src="pic-profiles/{{user.image}}" alt="..." alt="" >
                  <img id="picPreview" ng-show="pictureChange" class="profile-user-img img-responsive">
                  <button ng-show="pictureChange" ng-click="saveProfilePic()" type="button" class="btn btn-outline-success">Save</button>
                  <button ng-show="pictureChange" ng-click="cancelProfilePic()" type="button" class="btn btn-outline-danger">Cancel</button>
                  <form role="form" class="form-horizontal" ng-submit="" name="profilePicForm" id="profilePicForm" method="post">
                    <input class="form-control inputfile inputfile-1" accept=".png, .jpg, .jpeg" type="file" id="fileId" name="file[]">
                    <label for="fileId" style="max-width: 300px;text-align: center;height: auto;display: block;margin: 0 auto;" ng-click="editEmployeeActivator(8)"><span class="fa fa-camera-retro fa-lg">&nbsp;&nbsp;Change photo </span></label>
                  </form>
                  <h4 class="card-title text-center">{{user.first_name}} {{user.last_name}}</h4>
                </div>
                <div class="col-md-9">
                <p class="card-text">Birthday : {{user.date_of_birth}}</p>
                <p class="card-text">Username : {{user.username}}</p>
                </div> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="tab-pane fade  show" id="blogs" ng-cloak>
    <div ng-show="!fetching" class=" text-primary" role="status">
        <button ng-click="showMyBlogs()" type="submit" class="btn btn-warning" >Refresh</button>
    </div>
    <div class="d-flex justify-content-center">
      <div ng-show="fetching" class="spinner-border text-primary" role="status">
        <span  class="sr-only">Loading...</span>
      </div>
      <div ng-show="blogs.length === 0" class=" text-primary" role="status">
        <p >No blogs yet</p>
      </div>
      
    </div>
    <ul ng-show="blogs.length > 0" class="list-group">
      <li class="list-group-item  align-items-center blog-post" ng-repeat="blog in blogs">
        <img id="postProfilePic"  ng-src="pic-profiles/{{user.image}}" alt="..." alt=""  class="rounded float-left">
        <div class="blogger-name text-warning">
          {{blog.User.first_name}} {{blog.User.last_name}}
          <small>({{blog.Post.modified}})</small>
          <span ng-click="deletePostPrompt(blog.Post.id,blog.Post.post)" data-toggle="tooltip" title="Delete post?"onmouseenter="$(this).tooltip('show');" class="fa fa-trash fa-lg"></span>
          <span ng-click="editPostPrompt(blog.Post)" data-toggle="tooltip" title="Edit post?"onmouseenter="$(this).tooltip('show');" class="fa fa-pen-square fa-lg"></span>
        </div>
        <div class="blogger-post">
          {{blog.Post.post}}
          <div ng-cloak ng-show="blog.Post.images.length > 0">
            <div class="row">
              <div class="col-md-3" ng-repeat="n in [].constructor(blog.Post.images.length) track by $index">
                <figure>
                  <img  id="postPic" ng-src="pic-posts/{{blog.Post.images[$index]}}" alt="">
                  <figcaption><i>{{blog.Post.image_captions[$index]}}</i></figcaption>
                </figure>
              </div>
            </div>
          </div>
          <div ng-show="blog.Post.post_id">
            <div class="card border-default" style="margin-top: 29px;">
              <div class="card-body" ng-show="blog.Retweet.deleted">
                <img id="postProfilePic"  ng-src="pic-profiles/{{blog.RetweetOwner.image}}" alt="..." alt=""  class="rounded float-left">
                <div class="blogger-name text-warning">
                  {{blog.RetweetOwner.first_name}} {{blog.RetweetOwner.last_name}}
                  <small>({{blog.Retweet.modified}})</small>
                </div>
                <p class="blogger-post" style="margin-top: 30px;padding-left: 0px;">{{blog.Retweet.post}}</p>
                <div ng-show="blog.Retweet.images.length > 0">
                  <div class="row">
                    <div class="col-md-3" ng-repeat="n in [].constructor(blog.Retweet.images.length)  track by $index">
                      <figure>
                        <img  id="postPic" ng-src="pic-posts/{{blog.Retweet.images[$index]}}" alt="">
                        <figcaption><i>{{blog.Retweet.image_captions[$index]}}</i></figcaption>
                      </figure>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body" ng-show="!blog.Retweet.deleted"> 
              <p class="blogger-post">Blog is not available right now...</p>
            </div>
            </div>
          </div>
          <div class="float-right">
            <span ng-click="promptSharePost(blog.Post.post_id ? blog.Retweet : blog.Post,blog.Post.post_id ? blog.RetweetOwner : blog.User)"  class="badge badge-primary badge-pill" data-toggle="tooltip" title="Shares"onmouseenter="$(this).tooltip('show');"><i class="fa fa-retweet"></i>&nbsp;{{(blog.Share.length) + shareAdd}}&nbsp;</span>&nbsp;
            <span ng-click="showComments(blog.Post.id,index)" class="badge badge-primary badge-pill" data-toggle="tooltip" title="Comments"onmouseenter="$(this).tooltip('show');"><i class="fa fa-comments"></i>&nbsp;{{blog.Comment.length}}&nbsp;</span>&nbsp;
            <span ng-click="likePost(blog.Post.id,$index)" class="badge badge-primary badge-pill" data-toggle="tooltip" title="Likes"onmouseenter="$(this).tooltip('show');"><i class="fa fa-thumbs-up"></i>&nbsp;{{(blog.Like.length + likeAdd)}}&nbsp;</span>&nbsp;
          </div>
        </div>
      </li>
    </ul>
    <div class="float-left">
      Showing <b>{{(pageSize * (request.page - 1)) + 1}}</b> to <b>{{(pageSize * (request.page - 1)) + blogs.length}}</b> of <b class="text-primary">{{request.total}}</b> blogs
    </div>
    <div class="float-right">
      <div class="d-flex justify-content-center">
        <div ng-show="fetching" class="spinner-border text-primary" role="status">
          <span  class="sr-only">Loading...</span>
        </div>
      </div>
      <div class="btn-group" ng-show="totalPages > 1" role="group" aria-label="Button group with nested dropdown">
        <button id="paginatorBtn" type="button" class="btn btn-success">Page</button>
        <div class="btn-group" role="group">
          <button id="btnGroupDrop2" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop2">
            <a ng-click="showMyBlogs($index+1)" ng-repeat="n in [].constructor(totalPages)  track by $index" class="dropdown-item" href="">{{$index+1}}</a>
          </div>
        </div>
      </div> 
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="tab-pane fade" id="followers">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2  border-bottom">
      <div class="btn-group mr-2">
        <input type="text" ng-model="searchName" name="search" class="form-control" placeholder="find people." id="search" >
        <button ng-click="searchPeople()" class="btn btn-sm btn-outline-secondary"><span class="fa fa-search fa-lg"></span></button>
      </div>
    </div>
    <div class="col-md-6">
      <div class="d-flex justify-content-center">
        <div ng-show="fetching" class="spinner-border text-primary" role="status">
          <span  class="sr-only">Loading...</span>
        </div>
        <div ng-show="followers.length === 0" class=" text-primary" role="status">
          <p>No Followers yet</p>
        </div>
      </div>
      <ul class="list-group" ng-show="followers.length > 0">
        <li ng-repeat="follower in followers" class="list-group-item align-items-center blog-post" style="padding-bottom: 0px;">
          <img id="postProfilePic"  ng-src="pic-profiles/{{follower.MyFollower.image}}" alt="..." alt=""  class="rounded float-left">
          <div class="blogger-name text-warning"style=" margin-bottom: 0px;margin-top: 8px;">
            <a href="" ng-click="showProfile(follower.MyFollower.id)" class="text-warning" style="text-decoration: none;">{{follower.MyFollower.first_name}} {{follower.MyFollower.last_name}}</a>
            <span ng-show="follower.MyFollower.followed" class="badge badge-warning float-right">Following</span>
            <button ng-show="!follower.MyFollower.followed" ng-click="follow(follower.MyFollower.id)" type="submit" class="btn btn-outline-warning float-right" >Follow</button>
        </li>
      </ul>
    </div>
    <div class="float-left" ng-show="followers.length > 0">
      Showing <b>{{(followerPageSize * (followerRequest.page - 1)) + 1}}</b> to <b>{{(followerPageSize * (followerRequest.page - 1)) + followers.length}}</b> of <b class="text-primary">{{followerRequest.total}}</b> followers
    </div>
    <div class="float-right">
      <div class="d-flex justify-content-center">
        <div ng-show="fetching" class="spinner-border text-primary" role="status">
          <span  class="sr-only">Loading...</span>
        </div>
      </div>
      <!-- Page : <select class="custom-select " ng-init="followerRequest.page=1" ng-model="followerRequest.page" ng-change="showPeople()">
        <option ng-repeat="n in [].constructor(followerTotalPages)  track by $index" valaue="{{$index+1}}">{{$index+1}}</option>
      </select>  -->
      <div class="btn-group" ng-show="followerTotalPages > 1" role="group" aria-label="Button group with nested dropdown">
        <button id="paginatorBtn2" type="button" class="btn btn-success">Page</button>
        <div class="btn-group" role="group">
          <button id="btnGroupDrop2" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop2">
            <a ng-click="showPeople($index+1)" ng-repeat="n in [].constructor(followerTotalPages)  track by $index" class="dropdown-item" href="">{{$index+1}}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="tab-pane fade" id="following">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2  border-bottom">
      <div class="btn-group mr-2">
        <input type="text" ng-model="searchName" name="search" class="form-control" placeholder="find people." id="search" >
        <button ng-click="searchPeople()" class="btn btn-sm btn-outline-secondary"><span class="fa fa-search fa-lg"></span></button>
      </div>
    </div>
    <div class="col-md-6">
      <div class="d-flex justify-content-center">
        <div ng-show="fetching" class="spinner-border text-primary" role="status">
          <span  class="sr-only">Loading...</span>
        </div>
        <div ng-show="followings.length === 0" class=" text-primary" role="status">
          <p>You did not followed any people yet</p>
        </div>
      </div>
      <ul class="list-group" ng-show="followings.length > 0">
        <li ng-repeat="following in followings" class="list-group-item align-items-center blog-post" style="padding-bottom: 0px;">
          <img id="postProfilePic"  ng-src="pic-profiles/{{following.MyFollowing.image}}" alt="..." alt=""  class="rounded float-left">
          <div class="blogger-name text-warning"style=" margin-bottom: 0px;margin-top: 8px;">
            <a href="" ng-click="showProfile(following.MyFollowing.id)" class="text-warning" style="text-decoration: none;">{{following.MyFollowing.first_name}} {{following.MyFollowing.last_name}}</a>
            <button ng-click="unfollow(following.Follower.id)" type="submit" class="btn btn-outline-warning float-right" >Unfollow</button>
        </li>
      </ul>
    </div>
    <div class="float-left" ng-show="followings.length > 0">
      Showing <b>{{(followerPageSize * (followerRequest.page - 1)) + 1}}</b> to <b>{{(followerPageSize * (followerRequest.page - 1)) + followings.length}}</b> of <b class="text-primary">{{$scope.followingRequest.total}}</b> followed
    </div>
    <div class="float-right">
      <div class="d-flex justify-content-center">
        <div ng-show="fetching" class="spinner-border text-primary" role="status">
          <span  class="sr-only">Loading...</span>
        </div>
      </div>
      <!-- Page : <select class="custom-select " ng-init="followerRequest.page=1" ng-model="followerRequest.page" ng-change="showPeople()">
        <option ng-repeat="n in [].constructor(followerTotalPages)  track by $index" valaue="{{$index+1}}">{{$index+1}}</option>
      </select>  -->
      <div class="btn-group" ng-show="followingTotalPages > 1" role="group" aria-label="Button group with nested dropdown">
        <button id="paginatorBtn2" type="button" class="btn btn-success">Page</button>
        <div class="btn-group" role="group">
          <button id="btnGroupDrop2" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop2">
            <a ng-click="showPeople($index+1)" ng-repeat="n in [].constructor(followingTotalPages)  track by $index" class="dropdown-item" href="">{{$index+1}}</a>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="float-right">
      Page : <select class="custom-select" ng-init="followerRequest.page=1" ng-model="followerRequest.page" ng-change="showPeople()">
        <option ng-repeat="n in [].constructor(followingTotalPages)  track by $index" valaue="{{$index+1}}">{{$index+1}}</option>
      </select> 
    </div> -->
  </div>
</div>
<!-- edit Profile Modal -->
<div id="editProfileModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="editProfileForm" name="editProfileForm" method="POST" ng-submit="saveEditProfile()" autocomplete="off">
      <div class="modal-content bg-warning text-white">
        <div class="modal-header">
          <h5 class="modal-title">Edit Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input ng-class="{'is-invalid' : editUser.email.length === 0}" ng-model="editUser.email" type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" >
                <div class="invalid-feedback">Missing email</div>
              </div>
              <div class="form-group">
                <label class="col-form-label" for="inputDefault">Username</label>
                <input ng-class="{'is-invalid' : editUser.username.length === 0}" ng-model="editUser.username" type="text" name="username" class="form-control" placeholder="Enter username" id="username" >
                <div class="invalid-feedback">Missing username</div>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Old Password</label>
                <input ng-class="{'is-invalid' : editUser.oldPassword === 0}" ng-model="editUser.oldPassword" type="password" name="password" class="form-control" id="password" placeholder="Enter Old Password">
                <div class="invalid-feedback">Missing old password</div>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1"> New/Old Password</label>
                <input ng-class="{'is-invalid' : editUser.password === 0}" ng-model="editUser.password" type="password" name="password" class="form-control" id="password" placeholder="Enter Password" >
                <div class="invalid-feedback">Missing new/old password</div>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Confirm Password</label>
                <input ng-class="{'is-invalid' : confirmPassword === 0}" ng-model="confirmPassword" type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Confirm Password" >
                <div class="invalid-feedback">Missing confirm password</div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="col-form-label" for="inputDefault">Firstname</label>
                <input ng-class="{'is-invalid' : editUser.firstName.length === 0}" ng-model="editUser.firstName" type="text" name="firstName" class="form-control" placeholder="Enter firstname" id="firstName" >
                <div class="invalid-feedback">Missing firstname</div>
              </div>
              <div class="form-group">
                <label class="col-form-label" for="inputDefault">Middlename</label>
                <input ng-class="{'is-invalid' : editUser.middleName.length === 0}" ng-model="editUser.middleName" type="text" name="middleName" class="form-control" placeholder="Enter middlename" id="middleName" >
                <div class="invalid-feedback">Missing middlename</div>
              </div>
              <div class="form-group">
                <label class="col-form-label" for="inputDefault">Lastname</label>
                <input ng-class="{'is-invalid' : editUser.lastName.length === 0}" ng-model="editUser.lastName" type="text" name="lastName" class="form-control" placeholder="Enter lastname" id="lastName" >
                <div class="invalid-feedback">Missing lastname</div>
              </div>
              <div class="form-group">
                <label class="col-form-label" for="inputDefault">Birthday</label>
                <input  type="date" name="dateOfBirth" class="form-control" placeholder="Enter birthday" id="dateOfBirth" >
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-success" >Save</button>
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- delete post Modal -->
<div id="deleteModal" class="modal fade " tabindex="-1" role="dialog">
  <div class="modal-dialog"  role="document">
    <div class="modal-content bg-warning text-white">
      <div class="modal-header">
        <h5  class="modal-title"> Are you sure you want to delete this post? :</h5>
      </div>
      <div class="modal-body d-flex justify-content-center">
        
        <p ng-model="delete.post">{{delete.post}}</p>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-success" ng-click="deletePost(delete.id)">Delete</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
    </div>
  </div>
</div>
<!-- edit post Modal -->
<div id="editPostModal" class="modal fade " tabindex="-1" role="dialog">
  <div class="modal-dialog"  role="document">
    <div class="modal-content bg-warning text-white">
      <div class="modal-header">
        <h5  class="modal-title"> Are you sure you want to Edit this post? :</h5>
      </div>
      <div class="modal-body d-flex justify-content-center">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleTextarea">Compose here : </label>
              <textarea ng-model="editPost.post" class="form-control" id="exampleTextarea" placeholder="What's up!" rows="3"></textarea>
            </div>
          </div>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-4"ng-repeat="n in [].constructor(editPost.images.length) track by $index">
                <figure>
                  <span ng-click="removeExistingPhoto($index)"  class="fa fa-times fa-lg"></span>
                  <img id="postPic" ng-src="pic-posts/{{editPost.images[$index]}}" alt="">
                  <figcaption><textarea style="width: 150px;" id="caption-{{$index}}" ng-bind="editPost.imageCaptions[$index]" rows="2" placeholder="short caption..."></textarea></figcaption>
                </figure>
              </div>
              <div class="col-md-2">
                <button type="button" class="btn btn-outline-success" ng-click="addImageSelector()">Add Image</button>
              </div>
            </div>
            <div class="row" ng-repeat="n in [].constructor(imageGenerator) track by $index">
              <div class="col-md-4">
                <input onchange="angular.element(this).scope().viewImage(this)" class="form-control" accept=".png, .jpg, .jpeg" type="file" id="{{$index}}" name="file[]" multiple="multiple" >
                <span ng-click="removeNewPhoto($index)"  class="fa fa-times fa-lg"></span>
              </div>
              <div class="col-md-2">
                <img style="width: 70px;height: 60px;" id="picPreview-{{$index}}" ng-show="photoSelected" class="profile-user-img img-responsive">
              </div>
              <div class="col-md-4">
                <textarea ng-show="go" id="newcaption-{{$index}}" rows="2" placeholder="short caption..."></textarea>
              </div>
            </div>
            <!-- <div class="row" ng-repeat="n in [].constructor(imageGenerator) track by $index">
              <div class="col-md-6">
                <input onchange="angular.element(this).scope().viewImage(this)" class="form-control" accept=".png, .jpg, .jpeg" type="file" id="{{$index}}" name="file[]" multiple="multiple" >
                <span ng-click="removeNewPhoto($index)"  class="fa fa-times fa-lg"></span>
              </div>
              <div class="col-md-6">
                <img style="max-width: 50px;height: 50px;" id="picPreview-{{$index}}" ng-show="photoSelected" class="profile-user-img img-responsive">
              </div>
            </div> -->
          </div>
        </div>
      </div>
      <div class="modal-footer">
      <button ng-disabled=" editPost.post.length === 0" type="submit" class="btn btn-success" ng-click="saveEditPost()">Save</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
    </div>
  </div>
</div>
<!-- comment modal Modal -->
<div id="commentModal" class="modal fade " tabindex="-1" role="dialog">
  <div class="modal-dialog"  role="document">
    <div class="modal-content bg-warning text-white">
      <div class="modal-header">
        <h5  class="modal-title">Comments</h5>
      </div>
      <div ng-show="displayComments.length <= 0" class="modal-body d-flex justify-content-center">
       
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
      <div>
      <div ng-show="!displayComments" class="modal-body d-flex justify-content-center">
        <p >No comments yet</p>
      </div>
        <ul class="list-group">
          <li ng-repeat="comment in displayComments" class="list-group-item  align-items-center blog-post" style="padding-bottom: 0px;">
            <img id="postProfilePic"  ng-src="pic-profiles/{{comment.User.image}}" alt="..." alt=""  class="rounded float-left">
            <div class="blogger-name text-warning">
              {{comment.User.first_name}} {{comment.User.last_name}}
              <small>({{comment.Comment.modified}})</small>
              <hr style=" margin-top: 0px;margin-bottom: 0px;">
            </div>
            <div class="blogger-post text-primary">
              <p>"{{comment.Comment.comment}}"</p>
            </div>
          </li>
        </ul>
      </div>
      <div class="modal-footer" style="margin-bottom: 0px;margin-top: 0px;padding-top: 0px;">
        <div ng-show="saving" class="modal-body d-flex justify-content-center">
          <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
        <textarea ng-show="!saving" class="form-control" ng-model="myComment" id="comment" rows="3" placeholder="enter comment" ></textarea>
        <button ng-show="!saving" type="submit" class="btn btn-success" ng-click="saveComment($index,myComment)">Comment</button>
        <button ng-show="!saving" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- search modal Modal -->
<div id="searchModal" class="modal fade " tabindex="-1" role="dialog">
  <div class="modal-dialog"  role="document">
    <div class="modal-content bg-warning text-white">
      <div class="modal-header">
        <h5  class="modal-title">People related to "{{searchName}}"</h5>
      </div>
      <div ng-show="fetching" class="modal-body d-flex justify-content-center">
       
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
      <div>
      <div ng-show="people.length <= 0 && !fetching" class="modal-body d-flex justify-content-center">
        <p >No results Found</p>
      </div>
      <ul class="list-group" ng-show="people.length > 0">
        <li ng-repeat="person in people" class="list-group-item align-items-center blog-post" style="padding-bottom: 0px;">
          <img id="postProfilePic"  ng-src="pic-profiles/{{person.User.image}}" alt="..." alt=""  class="rounded float-left">
          <div class="blogger-name text-warning"style=" margin-bottom: 0px;margin-top: 8px;">
            <a href="" ng-click="showProfile(person.User.id)" class="text-warning" style="text-decoration: none;">{{person.User.first_name}} {{person.User.last_name}}</a>
            <button ng-show="!person.User.myFollowing" ng-click="follow(person.User.id)" type="submit" class="btn btn-outline-warning float-right" >Follow</button>
            <button ng-show="person.User.myFollowing" ng-click="unfollow(person.User.myFollowingId)" type="submit" class="btn btn-outline-warning float-right" >Unfollow</button>
            <span ng-show="person.User.myFollower" class="badge badge-warning float-right">Follows you</span>
        </li>
      </ul>
      </div>
      <div class="modal-footer" style="margin-bottom: 0px;margin-top: 0px;padding-top: 0px;">
        <div class="btn-group" ng-show="peopleTotalPages > 1" role="group" aria-label="Button group with nested dropdown">
          <button id="paginatorBtn3" type="button" class="btn btn-success">Page</button>
          <div class="btn-group" role="group">
            <button id="btnGroupDrop2" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop2">
              <a ng-click="searchPeople($index+1)" ng-repeat="n in [].constructor(peopleTotalPages)  track by $index" class="dropdown-item" href="">{{$index+1}}</a>
            </div>
          </div>
        </div>
        <button ng-show="!saving" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- retweet Modal -->
<div id="retweetModal" class="modal fade " tabindex="-1" role="dialog">
  <div class="modal-dialog"  role="document">
    <div class="modal-content bg-warning text-primary">
      <div class="modal-header">
      </div>
      <div class="row" ng-show="!fetching">
        <div class="col-md-12">
          <div id="profileCard" class="card border-warning mb-3">
            <div class="card-header">Retweet
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <textarea ng-model="resharePost" class="form-control" id="exampleTextarea" placeholder="Say something about the retweet!" rows="3"></textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="blogger-post">
                    <div class="card border-default" style="margin-top: 29px;">
                      <div class="card-body" ng-show="retweet.deleted">
                        <img id="postProfilePic"  ng-src="pic-profiles/{{owner.image}}" alt="..." alt=""  class="rounded float-left">
                        <div class="blogger-name text-warning">
                          {{owner.first_name}} {{owner.last_name}}
                          <small>({{retweet.modified}})</small>
                        </div>
                        <p class="blogger-post">{{retweet.post}}</p>
                        <div ng-show="retweet.images.length > 0">
                          <img ng-repeat="n in [].constructor(retweet.images.length)  track by $index" id="postPic" ng-src="pic-posts/{{retweet.images[$index]}}" alt="">
                        </div>
                      </div>
                      <div class="card-body" ng-show="!retweet.deleted"> 
                        <p class="blogger-post">Blog is not available right now...</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="margin-bottom: 0px;margin-top: 0px;padding-top: 0px;">
        <button type="button" class="btn btn-success" ng-click="sharePost(retweet.id,resharePost)" >Retweet</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- profile Modal -->
<div id="profileModal" class="modal fade " tabindex="-1" role="dialog">
  <div class="modal-dialog"  role="document">
    <div class="modal-content bg-warning text-primary">
      <div class="modal-header">
      </div>
      <div ng-show="fetching" class="modal-body d-flex justify-content-center">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
      <div class="row" ng-show="!fetching">
        <div class="col-md-12">
          <div id="profileCard" class="card border-warning mb-3">
            <div class="card-header">About
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <img id="profilePic" ng-src="pic-profiles/{{personProfile.User.image}}" alt="..." alt="" >
                  <h4 class="card-title text-center">{{personProfile.User.first_name}} {{personProfile.User.last_name}}</h4>
                </div>
                <div class="col-md-6">
                <p class="card-text">Birthday : {{personProfile.User.date_of_birth}}</p>
                <p class="card-text">Username : {{personProfile.User.username}}</p>
                </div> 
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="margin-bottom: 0px;margin-top: 0px;padding-top: 0px;">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
