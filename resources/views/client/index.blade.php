@extends('layouts/main')
@section('content')
<div id="main-content">
  <div class="main-content__body container-fluid">
    <div class="row justify-content-md-center">
      <div class="content-area col-md-9">
        <form id="client-form" action="" method="POST">
          <div class="content-area__main">
            <div class="form-section">
              <h2 class="heading">User Profile</h2>
              <p>Lorem ipsum dolor sit amet, at has augue moderatius appellantur, per ut summo quando latine. Ea cum solet detraxit splendide, enim wisi qui ex, quidam dignissim ne nam.</p>
            </div>
            <div class="form-section">
              <div class="form-group">
                <div class="form-input">
                  <label for="client-name">Full Name</label>
                  <input name="client-name" type="text" class="form-control" id="client-name" placeholder="">
                </div>
              </div>
            </div>
            <!-- /.form-section -->
            
            <div class="form-section last">
              <div class="form-group">
                <div class="form-input">
                  <label for="client-role">Role</label>
                  <input name="client-role" type="text" class="form-control" id="client-role" placeholder="">
                </div>
              </div>
            </div>
            <!-- /.form-section.last -->
            <div class="form-section row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="form-input">
                    <label for="client-email">Email</label>
                    <input name="client-email" type="text" class="form-control" id="client-email" placeholder="">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="form-input">
                    <label for="client-phone">Phone Number</label>
                    <input name="client-phone" type="text" class="form-control" id="client-phone" placeholder="">
                  </div>
                </div>
              </div>
            </div>
            <!-- /.form-section.row -->
            <div class="form-section clearfix">
              <button type="submit" class="btn btn-wide-block btn-primary btn-add-client border-0">Add User</button>
            </div>
          </div>
          <!-- /.content-area__main -->
        </form>
        <!-- /#client-form -->
      </div>
      <!-- /.content-area -->
    </div>
  </div>
  <!-- /.main-content__body -->
</div>
@endsection