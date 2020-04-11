<div class="container-fluid">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Blogs{{user.id}}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group mr-2">
        <input type="text" name="search" class="form-control" placeholder="Search" id="search" required>
        <button class="btn btn-sm btn-outline-secondary"><span class="fa fa-search fa-lg"></span></button>
      </div>
      <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
        <span data-feather="calendar"></span>
        This week
      </button>
    </div>
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
      <img id="postProfilePic"  ng-src="pic-profiles/{{blog.User.image}}" alt="..." alt=""  class="rounded float-left">
      <div class="blogger-name text-warning">
        {{blog.User.first_name}} {{blog.User.last_name}}
        <small>({{blog.Post.modified}})</small>
        <span ng-show="blog.User.id === user.id" ng-click="deletePostPrompt(blog.Post.id,blog.Post.post)" data-toggle="tooltip" title="Delete post?"onmouseenter="$(this).tooltip('show');" class="fa fa-trash fa-lg"></span>
        <span ng-show="blog.User.id === user.id" ng-click="editPostPrompt(blog.Post)" data-toggle="tooltip" title="Edit post?"onmouseenter="$(this).tooltip('show');" class="fa fa-pen-square fa-lg"></span>
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
    <div class="d-flex justify-content-center">
        <div ng-show="fetching" class="spinner-border text-primary" role="status">
          <span  class="sr-only">Loading...</span>
        </div>
      </div>
    Page : <select class="custom-select" ng-init="request.page=1" ng-model="request.page" ng-change="viewAllBlogs()">
      <option ng-repeat="n in [].constructor(totalPages)  track by $index" valaue="{{$index+1}}">{{$index+1}}</option>
    </select> 
  </div>
  <!-- <div class="row">
    <div class="col-lg-3">
      <div class="card border-warning mb-3" style="max-width: 20rem;">
        <div class="card-header"><img src="pic-profiles/rick.png" alt="" width="50" height="50"> Kennetpogi</div>
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card border-warning mb-3" style="max-width: 20rem;">
        <div class="card-header"><img src="pic-profiles/rick.png" alt="" width="50" height="50"> Kennetpogi</div>
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div>
  </div> -->
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