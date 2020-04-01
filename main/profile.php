<ul class="nav nav-tabs mb-4">
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#about">About me</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#blogs">My Blogs</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " data-toggle="tab" href="#followers">Followers</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " data-toggle="tab" href="#following">Following</a>
  </li>
</ul>
<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade" id="about">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div id="profileCard" class="card border-warning mb-3 ">
            <div class="card-header">About Me</div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <img id="profilePic" ng-src="pic-profiles/{{user.image}}" alt="..." alt="" >
                  <h4 class="card-title text-center">{{user.first_name}} {{user.last_name}}</h4>
                </div>
                <div class="col-md-9">
                <p class="card-text">Birthday : {{user.date_of_birth}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="tab-pane fade active show" id="blogs">
    my blogs
  </div>
  <div class="tab-pane fade" id="followers">
    followers
  </div>
  <div class="tab-pane fade" id="following">
    following
  </div>
</div>