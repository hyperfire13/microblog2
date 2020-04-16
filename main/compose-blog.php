
<div class="container">
    <div class="row">
      <div class="col-md-12">
        <div id="profileCard" class="card border-warning mb-3">
          <div class="card-header">Compose a Blog
          
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="exampleTextarea">Compose here : </label>
                  <textarea id="blogId" ng-model="blogBody" ng-class="{'is-invalid' : blogBody.length > 150}" class="form-control" id="exampleTextarea" placeholder="What's up!" rows="3"></textarea>
                  <div class="invalid-feedback">Blog must be no more than 150 characters.</div>
                  <button ng-disabled="blogBody.length === 0" type="button" class="btn btn-outline-success" ng-click="savePost()">Save</button>
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
                  <textarea id="caption-{{$index}}" id="" rows="2" placeholder="short caption..."></textarea>
                    <img style="max-width: 50px;height: 50px;margin-bottom: 50px;" id="picPreview-{{$index}}" ng-show="photoSelected" class="profile-user-img img-responsive">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>