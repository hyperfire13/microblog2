microblogApp.service('handler',
  [
    '$timeout',
    '$log',
  function(
    $timeout,
    $log
  ) {

    this.growler = function (growl){
      var growlMessage = growl;
      jQuery.jGrowl(growlMessage, {
        header: 'Ooppss',
        position: 'top-right',
        sticky : true
      });
    };
    this.showLoading = function(show,title) {
      console.log(title);
      $('#loadingTitle').text(title);
      if (show === true) {
          $('#loadingModal').modal({
            backdrop: 'static',
            keyboard: false,
            show : show
          });
      } else {
          $('#loadingModal').modal('hide');
      }
    };
    this.unknown = function () {
      $timeout(function() {
        $timeout(function() {
          jQuery.jGrowl('Something went wrong. Please try again.', {
            header: 'Ooppss',
            position: 'top-right',
            sticky : true
          });
        }, 500);
      }, 1000);
    };
    this.noConnection = function () {
      $timeout(function() {
        $timeout(function() {
          jQuery.jGrowl('Cannot connect to the server. Please make sure that you have internet connection.', {
            header: 'Ooppss',
            position: 'top-right',
            sticky : true
          });
        }, 500);
      }, 1000);
    };
  }]);