
<div class="container">
    <div class="row">
      <div class="col-md-12">
        <div id="profileCard" class="card border-warning mb-3">
          <div class="card-header">Compose a Blog
          <span ng-click="showEditProfile()" data-toggle="tooltip" title="Edit"onmouseenter="$(this).tooltip('show');" class="fa fa-pen-square fa-lg float-right"></span>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="exampleTextarea">Compose here : </label>
                  <textarea ng-model="blogBody" class="form-control" id="exampleTextarea" placeholder="What's up!" rows="3"></textarea>
                  <button ng-disabled="blogBody.length > 150 || blogBody.length === 0" type="button" class="btn btn-outline-success" ng-click="savePost()">Save</button>
                </div>
              </div>
              <div class="col-md-9" >
                <label for="exampleTextarea">Want to upload image? : </label>
                <button type="button" class="btn btn-outline-warning" ng-click="addImageSelector()">Add Image</button>
                <div class="row" ng-repeat="n in [].constructor(imageGenerator) track by $index">
                  <div class="col-md-4">
                    <input onchange="angular.element(this).scope().viewImage(this)" class="form-control" accept=".png, .jpg, .jpeg" type="file" id="{{$index}}" name="file[]" multiple="multiple" required>
                  </div>
                  <div class="col-md-4">
                    <img style="max-width: 50px;height: 50px;" id="picPreview-{{$index}}" ng-show="photoSelected" class="profile-user-img img-responsive">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>