<ul class="nav nav-tabs mb-4">
  <li class="nav-item">
    <a  class="nav-link active" data-toggle="tab" href="#about"><span class="fa fa-user "></span>&nbsp;About me</a>
  </li>
  <li class="nav-item">
    <a ng-click="showMyBlogs(true)" class="nav-link " data-toggle="tab" href="#blogs"><span class="fa fa-pen-square"></span>&nbsp;My Blogs</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " data-toggle="tab" href="#followers"><span class="fa fa-users"></span>&nbsp;Followers</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " data-toggle="tab" href="#following"><span class="fa fa-users"></span>&nbsp;Following</a>
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
    <div class="d-flex justify-content-center">
      <div ng-show="blogs.length === 0" class="spinner-border text-primary" role="status">
        <span  class="sr-only">Loading...</span>
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
            <img ng-repeat="n in [].constructor(blog.Post.images.length)  track by $index" id="postPic" ng-src="pic-posts/{{blog.Post.images[$index]}}" alt="">
          </div>
          <div ng-show="blog.Post.post_id">
            <div class="card border-default">
              <div class="card-body">
                <img id="postProfilePic"  ng-src="pic-profiles/{{blog.RetweetOwner.image}}" alt="..." alt=""  class="rounded float-left">
                <div class="blogger-name text-warning">
                  {{blog.RetweetOwner.first_name}} {{blog.RetweetOwner.last_name}}
                  <small>({{blog.Retweet.modified}})</small>
                </div>
                <p class="blogger-post">{{blog.Retweet.post}}</p>
                <div ng-show="blog.Retweet.images.length > 0">
                  <img ng-repeat="n in [].constructor(blog.Retweet.images.length)  track by $index" id="postPic" ng-src="pic-posts/{{blog.Retweet.images[$index]}}" alt="">
                </div>
              </div>
            </div>
          </div>
          <div class="float-right">
            <span ng-click="sharePost(blog.Post.post_id ? blog.Post.post_id : blog.Post.id)" class="badge badge-primary badge-pill" data-toggle="tooltip" title="Shares"onmouseenter="$(this).tooltip('show');"><i class="fa fa-retweet"></i>&nbsp;{{(blog.Share.length) + shareAdd}}&nbsp;</span>&nbsp;
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
      Page : <select class="custom-select" ng-init="request.page=1" ng-model="request.page" ng-change="showMyBlogs()">
        <option ng-repeat="n in [].constructor(totalPages)  track by $index" valaue="{{$index+1}}">{{$index+1}}</option>
      </select> 
    </div>
    <!-- <div id="paginator"
      class="float-right"
      paging
      page="request.page"
      page-size="pageSize"
      total="request.total"
      show-prev-next="true"
      show-first-last="true"
      text-first-class="btn btn-warning fa fa-fast-backward"
      text-last-class="btn btn-warning fa fa-fast-forward"
      text-next-class="btn btn-warning fa fa-arrow-right"
      text-prev-class="btn btn-warning fa fa-arrow-left"
      paging-action="showMyBlogs()"
      ng-if="blogs.length > 0">
    </div> -->
    <div class="clearfix"></div>
  </div>
  <div class="tab-pane fade" id="followers">
    followers
  </div>
  <div class="tab-pane fade" id="following">
    following
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
                <input ng-model="editUser.email" type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
              </div>
              <div class="form-group">
                <label class="col-form-label" for="inputDefault">Username</label>
                <input ng-model="editUser.username" type="text" name="username" class="form-control" placeholder="Enter username" id="username" required>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Old Password</label>
                <input ng-model="editUser.oldPassword" type="password" name="password" class="form-control" id="password" placeholder="Enter Old Password" required>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1"> New/Old Password</label>
                <input ng-model="editUser.password" type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Confirm Password</label>
                <input ng-model="confirmPassword" type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Confirm Password" required>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="col-form-label" for="inputDefault">Firstname</label>
                <input ng-model="editUser.firstName" type="text" name="firstName" class="form-control" placeholder="Enter firstname" id="firstName" required>
              </div>
              <div class="form-group">
                <label class="col-form-label" for="inputDefault">Middlename</label>
                <input ng-model="editUser.middleName" type="text" name="middleName" class="form-control" placeholder="Enter middlename" id="middleName" required>
              </div>
              <div class="form-group">
                <label class="col-form-label" for="inputDefault">Lastname</label>
                <input ng-model="editUser.lastName" type="text" name="lastName" class="form-control" placeholder="Enter lastname" id="lastName" required>
              </div>
              <div class="form-group">
                <label class="col-form-label" for="inputDefault">Birthday</label>
                <input  type="date" name="dateOfBirth" class="form-control" placeholder="Enter birthday" id="dateOfBirth" required>
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
              <label for="exampleTextarea">Compose here : {{editPost.images}} </label>
              <textarea ng-model="editPost.post" class="form-control" id="exampleTextarea" placeholder="What's up!" rows="3"></textarea>
            </div>
          </div>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-2"ng-repeat="n in [].constructor(editPost.images.length) track by $index">
                <img  style="max-width: 50px;height: 50px;" ng-src="pic-posts/{{editPost.images[$index]}}" class="profile-user-img img-responsive">
                <span ng-click="removeExistingPhoto($index)"  class="fa fa-times fa-lg"></span>
              </div>
              <div class="col-md-2">
                <button type="button" class="btn btn-outline-success" ng-click="addImageSelector()">Add Image</button>
              </div>
            </div>
            <div class="row" ng-repeat="n in [].constructor(imageGenerator) track by $index">
              <div class="col-md-6">
                <input onchange="angular.element(this).scope().viewImage(this)" class="form-control" accept=".png, .jpg, .jpeg" type="file" id="{{$index}}" name="file[]" multiple="multiple" required>
                <span ng-click="removeNewPhoto($index)"  class="fa fa-times fa-lg"></span>
              </div>
              <div class="col-md-6">
                <img style="max-width: 50px;height: 50px;" id="picPreview-{{$index}}" ng-show="photoSelected" class="profile-user-img img-responsive">
              </div>
            </div>
            
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
        <textarea ng-show="!saving" class="form-control" ng-model="myComment" id="comment" rows="3" placeholder="enter comment" required></textarea>
        <button ng-show="!saving" type="submit" class="btn btn-success" ng-click="saveComment($index,myComment)">Comment</button>
        <button ng-show="!saving" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
