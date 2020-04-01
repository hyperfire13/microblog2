<!DOCTYPE html>
<html lang="en" ng-app="microblogApp"ng-cloak>
  <head>
    <?php $version = '3a';?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/microblog-2/">
    <link rel="stylesheet" type="text/css" href="dependencies/css/bootstrap.css">
    <!-- <link rel="stylesheet" type="text/css" href="dependencies/css/custom.min.css"> -->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <script type = "text/javascript" src = "dependencies/angularjs/angular.min.js"></script>
    <script type = "text/javascript" src = "dependencies/angularjs/angular-route.min.js"></script>
    <title>Microblog</title>
  </head>
  <body>
    <!-- <header ng-controller="headerCtrl">
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
    <div class="row">
      <nav id="sidebar"  class="col-md-2 d-none d-md-block bg-warning sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column ">
            <li class="nav-item text-white">
              <a class="nav-link  text-white" href="main/#!home">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Home <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="main/#!compose-blog" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                Compose a blog
              </a>
            </li>
          </ul>
        </div>
      </nav> -->
      <!-- <main ng-view>
      </main> -->
      <!-- <div role="main" ng-view class="col-md-9 ml-sm-auto col-lg-10 ">
      </div>
    </div> -->
    <div class="d-flex" id="wrapper">
      <!-- Sidebar -->
      <div class="bg-warning border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">Microblog 2</div>
        <div class="list-group list-group-flush ">
        <a class="nav-link bg-warning " href="main/#!home">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
          Home 
        </a>
        <a class="nav-link bg-warning " href="main/#!compose-blog">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
          Compose 
        </a>
        </div>
      </div>
      <!-- /#sidebar-wrapper -->
      <!-- Page Content -->
      <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom" ng-controller="headerCtrl">
          <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Hi Kenneth
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#">Settings</a>
                  <a class="dropdown-item" ng-click="logout()" href="">Logout</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
            </ul>
          </div>
        </nav>
        <div ng-view class="container-fluid">
          
        </div>
      </div>
    <!-- /#page-content-wrapper -->
    </div>
    
    <script type="text/javascript" src="dependencies/js/jquery.min.js"></script>
		<script type="text/javascript" src="dependencies/js/popper.min.js"></script>
    <script type="text/javascript" src="dependencies/js/bootstrap.min.js"></script>
    <script type="text/javascript" src ="dependencies/angularjs/angular-animate.min.js"></script>
    <script type="text/javascript" src ="dependencies/angularjs/route-styles.js"></script>
    <script type="text/javascript" src ="dependencies/angularjs/angular-sanitize.min.js"></script>
    <script type="text/javascript" src="dependencies/angularjs/angular-pagination-2.2.2/src/paging.js"></script>

    <script type="text/javascript" src ="js/main/main.js?v=<?php echo $version; ?>"></script>
    <script type="text/javascript" src ="js/main/main-ctrl.js?v=<?php echo $version; ?>"></script>
    <script type="text/javascript" src ="js/main/header-ctrl.js?v=<?php echo $version; ?>"></script>
    <script type="text/javascript" src ="js/main/handler.js?v=<?php echo $version; ?>"></script>
    <script type="text/javascript" src ="js/main/home.js?v=<?php echo $version; ?>"></script>
    <script type="text/javascript" src ="js/main/compose-blog.js?v=<?php echo $version; ?>"></script>
    <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
      });
    </script>
		<!-- <script type="text/javascript" src="dependencies/js/custom.js"></script> -->
  </body>
</html>