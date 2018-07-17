@extends('layouts/main')
@section('content')
<div id="main-content">
    <div class="container-fluid">
      <div class="row justify-content-md-center">
        <div class="campaign-form-progress-outer col-md-8">
          <ol class="campaign-form-progress list3">
            <li class="active"><span>Company Information</span></li>
            <!-- <li class="done"><span>Company Information</span></li> -->
            <li><span>Billing Information</span></li>
            <li><span>Client Settings</span></li>
          </ol>
          <!-- /.campaign-form-progress --> 
        </div>
        <!-- /.campaign-form-progress-outer -->
      </div>
    </div>
    <div class="main-content__body container-fluid">
      <div class="row justify-content-md-center">
        <div class="content-area col-md-9">
          <form id="company-form" action="" method="POST">
            <div class="content-area__main client-area-form">
              <div class="form-section">
                <h2 class="heading-desc-0">Company Information</h2>
              </div>
              <div class="form-section">
                <div class="form-group">
                  <div class="form-input">
                    <label for="company-name">Company Name</label>
                    <input name="company-name" type="text" class="form-control" id="company-name" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                    <div class="form-input">
                      <label for="company-legal-name">Company Legal Name</label>
                      <input name="company-legal-name" type="text" class="form-control" id="company-legal-name" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                  <div class="form-input">
                    <label for="user-in-charge">User In Charge</label>
                    <select name="user-in-charge" class="custom-select dropdown-select2" id="user-in-charge">
                      <option selected>Choose...</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-section">
                <h2 class="heading-desc-0">Company Category</h2>
              </div>
              <div class="form-section row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="industry">Industry</label>
                    <select name="industry" class="custom-select dropdown-select2" id="industry">
                      <option selected>Choose...</option>
                      @foreach ($industries as $industry)
                        <option value="{{ $industry->parameters_id }}">{{ $industry->parameters_value }}</option>    
                      @endforeach
                    </select>
                  </div>
                </div>
                <!-- /.col-md-6 -->
                <div class="col-md-6">
                    <div class="form-group">
                      <h4 class="form-group__heading">Company Size</h4>
                      <div class="input-group">
                        <div class="form-input form-check">
                          <input class="form-check-input" type="radio" name="company-size" id="company-size-1" value="company-size-1" checked nice-checkbox-radio>
                          <label class="form-check-label" for="company-size-1">
                            <h5>&#60; 1.000 Employees</h5>
                            <p>Lorem ipsum dolor sit amet, at has augue moderatius appellantur</p>
                          </label>
                        </div>
                        <div class="form-input form-check">
                          <input class="form-check-input" type="radio" name="company-size" id="company-size-2" value="company-size-2" nice-checkbox-radio>
                          <label class="form-check-label" for="company-size-2">
                            <h5>&#62; 1.000 Employees</h5>
                            <p>Lorem ipsum dolor sit amet, at has augue moderatius appellantur</p>
                          </label>
                        </div>
                        <div class="form-input form-check">
                          <input class="form-check-input" type="radio" name="company-size" id="company-size-3" value="company-size-3" nice-checkbox-radio>
                          <label class="form-check-label" for="company-size-3">
                            <h5>&#62; 10.000 Employees</h5>
                            <p>Lorem ipsum dolor sit amet, at has augue moderatius appellantur</p>
                          </label>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
              </div>
              <div class="row">
                <div class="col-6">
                  <div id="upload_button">
                      <label>
                        <input id="uploadInput" type="file" name="logo-file" accept="image/*">
                        <span class="btn btn-outline-primary btn-block">Upload Company Logo</span>
                      </label>
                      <p>Min. image 50 x 50 px</p>
                    </div>
                </div>
                <div class="col-6">
                  <div id="uploadBox">
                      <input type="text" name="logo-name" id="uploadText" readonly>
                      <a href="#" class="clearFile"><img src="img/icon-times.svg" alt=""></a>
                  </div>
                </div>
              </div>
              
              <!-- /.form-section.row -->
              
            </div>
            <!-- /.content-area__main -->
            <div class="form-section clearfix">
              <button type="submit" class="btn btn-wide-block btn-primary btn-add-client border-0">Save &amp; Next</button>
            </div>
          </form>
          <!-- /#campign-form -->
        </div>
      </div>
    </div>
    <!-- /.main-content__body -->
  </div>
@endsection