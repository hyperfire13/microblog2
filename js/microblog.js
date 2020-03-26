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