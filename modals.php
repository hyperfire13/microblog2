<?php $version = '5.0.0';?>
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
<!-- Success Modal -->
<div id="successModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-success text-white">
      <div class="modal-header">
        <h5 class="modal-title">Success</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="successMsg"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
<!-- Error Modal -->
<div id="errorModal" class="modal fade " tabindex="-1" role="dialog">
  <div class="modal-dialog"  role="document">
    <div class="modal-content bg-danger text-white">
      <div class="modal-header">
        <h5 id="errorTitle" class="modal-title">Oops...</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="errorMsg"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
<!-- Resend Modal -->
<div id="resendCodeModal" class="modal fade">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-info text-white">
      <div class="modal-header">
        <h5 class="modal-title">Resend Activation Code</h5>
      </div>
      <div class="modal-body">
        <div class="form-group has-danger">
          <label for="">Enter Username you provided</label>
          <input type="text" name="resendUsername" class="form-control " id="resendUsername"  placeholder="Enter username">
          <div class="invalid-feedback">Please enter username.</div>
        </div>
      </div>
      <div class="modal-footer">
        <button onclick="resendCode()" type="button" class="btn btn-primary">Resend Code</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>