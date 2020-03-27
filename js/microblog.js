$(document).ready(function() { 
  $('#addForm').submit(function(e) {
    e.preventDefault();
    addUser();
  });
});

function showSuccess(message) {
  $('#successMsg').text(message);
  $('#successModal').modal('show');
}

function showError(message,title) {
  $('#errorTitle').text(title);
  $('#errorMsg').text(message);
  $('#errorModal').modal('show');
}

function showLoading(show) {
  if (show === true) {
      $('#loadingModal').modal({
        backdrop: 'static',
        keyboard: false,
        show : show
      });
  } else {
      $('#loadingModal').modal('hide');
  }
}

$(document).on('hidden.bs.modal', '#successModal', function () {
  alert("redirect");
});
