<!DOCTYPE html>
<html lang="en" ng-app="microblogApp"ng-cloak>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/microblog-2/">
    <link rel="stylesheet" type="text/css" href="dependencies/css/bootstrap.css">
    <!-- <link rel="stylesheet" type="text/css" href="dependencies/css/custom.min.css"> -->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script type = "text/javascript" src = "dependencies/angularjs/angular.min.js"></script>
    <script type = "text/javascript" src = "dependencies/angularjs/angular-route.min.js"></script>
    <title>Microblog</title>
  </head>
  <body>
    <header ng-controller="headerCtrl">
      <nav class="navbar navbar-dark fixed-top bg-warning flex-md-nowrap p-0 text-white">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Mircroblog 2</a>
        <input class="form-control  w-100 " type="text" placeholder="Search" aria-label="Search">
        <ul class="navbar-nav px-3">
          <li class="nav-item text-nowrap">
            <a class="nav-link" href="#">Sign out</a>
          </li>
        </ul>
      </nav>
    </header>
    <div class="container-fluid">
      <div class="row">
        <nav id="sidebar" class="col-md-2 d-none d-md-block bg-warning sidebar ">
          <div class="sidebar-sticky">
            <ul class="nav flex-column ">
              <li class="nav-item text-white">
                <a class="nav-link  text-white" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                  Home <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="#" >
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                  Compose a blog
                </a>
              </li>
            </ul>
          </div>
        </nav>
        <div ng-view>
        </div>
        <!-- <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Blogs</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary">Share</button>
                <button class="btn btn-sm btn-outline-secondary">Export</button>
              </div>
              <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
              </button>
            </div>
          </div>
          <div class="row">
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
          </div>
        </main> -->
      </div>
    </div>
    
    <script type="text/javascript" src="dependencies/js/jquery.min.js"></script>
		<script type="text/javascript" src="dependencies/js/popper.min.js"></script>
    <script type="text/javascript" src="dependencies/js/bootstrap.min.js"></script>
    <script type = "text/javascript" src = "dependencies/angularjs/angular-animate.min.js"></script>
    <script type = "text/javascript" src = "dependencies/angularjs/route-styles.js"></script>
    <script type = "text/javascript" src = "dependencies/angularjs/angular-sanitize.min.js"></script>
		<!-- <script type="text/javascript" src="dependencies/js/custom.js"></script> -->
  </body>
</html>