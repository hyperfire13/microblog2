<!DOCTYPE html>
<html  ng-app="microblogApp" >
  <head>
    <?php $version = '3.0.0';?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/microblog-2/">
    <link rel="stylesheet" type="text/css" href="dependencies/css/bootstrap.css">
    <!-- <link rel="stylesheet" type="text/css" href="dependencies/css/custom.min.css"> -->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link rel = "stylesheet" type = "text/css" href = "dependencies/fontawesome/css/all.min.css">
    <link rel = "stylesheet" type = "text/css" href = "dependencies/fontawesome/css/fontawesome-animation.min.css">
    <link href="dependencies/bootstrap-select-1.13.1/css/bootstrap-select.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dependencies/jGrowl-1.2.7/jquery.jgrowl.css">
    <script type = "text/javascript" src = "dependencies/angularjs/angular.min.js"></script>
    <script type = "text/javascript" src = "dependencies/angularjs/angular-route.min.js"></script>
    <title>Microblog</title>
  </head>
  <body ng-cloak>
    <div class="d-flex" id="wrapper">
      <!-- Sidebar -->
      <div class="bg-warning border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">Microblog 2</div>
        <div class="list-group list-group-flush ">
        <a class="nav-link bg-warning " href="main/#!home">
        <span  class = "fa fa-home fa-1x"></span>
          Home 
        </a>
        <a class="nav-link bg-warning " href="main/#!profile">
        <span  class = "fa fa-user fa-1x"></span>
          Profile 
        </a>
        <a class="nav-link bg-warning " href="main/#!compose-blog">
        <span  class = "fa fa-file "></span>
          Compose 
        </a>
        </div>
      </div>
      <!-- /#sidebar-wrapper -->
      <!-- Page Content -->
      <div id="page-content-wrapper" >
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom" ng-controller="headerCtrl">
          <img id="menu-toggle" ng-src="pic-profiles/{{user.image}}" alt="..." alt="" style="width: 100%;max-width: 50px;height: 50px;border-radius: 50%;border-width: medium" class="rounded">
          <!-- <button class="btn btn-primary" id="menu-toggle">{{user.image}}</button> -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Hi {{user.first_name}}
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

    <!-- loading Modal -->
    <div id="loadingModal" class="modal fade " tabindex="-1" role="dialog">
      <div class="modal-dialog"  role="document">
        <div class="modal-content bg-info text-white">
          <div class="modal-header">
            <h5 id="loadingTitle" class="modal-title"></h5>
          </div>
          <div class="modal-body d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <script type="text/javascript" src="dependencies/js/jquery.min.js"></script>
		<script type="text/javascript" src="dependencies/js/popper.min.js"></script>
    <script type="text/javascript" src="dependencies/js/bootstrap.min.js"></script>
    <script type="text/javascript" src ="dependencies/angularjs/angular-animate.min.js"></script>
    <script type="text/javascript" src ="dependencies/angularjs/route-styles.js"></script>
    <script type="text/javascript" src ="dependencies/angularjs/angular-sanitize.min.js"></script>
    <script type="text/javascript" src="dependencies/angularjs/angular-pagination-2.2.2/src/paging.js"></script>
    <script src="dependencies/jGrowl-1.2.7/jquery.jgrowl.js"></script>
    <script src="dependencies/bootstrap-select-1.13.1/js/bootstrap-select.min.js" charset="utf-8" charset="utf-8"></script>

    <script type="text/javascript" src ="js/main/main.js?ver=<?php echo $version; ?>"></script>
    <script type="text/javascript" src ="js/main/main-ctrl.js?ver=<?php echo $version; ?>"></script>
    <script type="text/javascript" src ="js/main/header-ctrl.js?ver=<?php echo $version; ?>"></script>
    <script type="text/javascript" src ="js/main/handler.js?ver=<?php echo $version; ?>"></script>
    <script type="text/javascript" src ="js/main/home.js?ver=<?php echo $version; ?>"></script>
    <script type="text/javascript" src ="js/main/profile.js?ver=<?php echo $version; ?>"></script>
    <script type="text/javascript" src ="js/main/compose-blog.js?ver=<?php echo $version; ?>"></script>
    <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
      });
    </script>
		<!-- <script type="text/javascript" src="dependencies/js/custom.js"></script> -->
  </body>
</html>