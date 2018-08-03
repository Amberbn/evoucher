@extends('layouts/main')

@section('content')
<div id="main-content">
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="campaign-form-progress-outer col-md-8">
                <ol class="campaign-form-progress list2">
                    <li class="done"><span>Merchant Information</span></li>
                    <li class="active"><span>Outlet Detail</span></li>
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
                    <div class="content-area__main">
                        <div class="form-section bottom-30">
                            <h2 class="heading">Outlet Details</h2>
                            <p>Lorem ipsum dolor sit amet, at has augue moderatius appellantur, per ut summo quando latine. Ea cum solet detraxit splendide, enim wisi qui ex, quidam dignissim ne nam.</p>
                        </div>
                        <div class="form-section bottom-30">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="form-input">
                                            <label for="outlet-name">Outlet Name</label>
                                            <input name="outlet-name" type="text" class="form-control" id="outlet-name" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="form-input row">
                                            <label for="outlet-code">Redeem PIN</label>
                                            <div class="col-10" id="requestInput">
                                                <input name="outlet-code" type="number" class="form-control" id="outlet-code" placeholder="98449848" disabled>
                                            </div>
                                            <div class="col-2" id="requestBtn">
                                                <a href="#" id="requestPIN" data-toggle="tooltip" data-placement="bottom" title="Change PIN"><img src="img/img-refresh.svg" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="outlet-description">Outlet Description</label>
                                    <textarea class="form-control" name="outlet-description" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="outlet-address">Outlet Address</label>
                                    <input name="outlet-address" type="text" class="form-control" id="outlet-address" placeholder="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="province">Province</label>
                                        <select name="province" class="custom-select dropdown-select2" id="province">
                                            <option selected>Choose...</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <select name="city" class="custom-select dropdown-select2" id="city">
                                            <option selected>Choose...</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="area">Area</label>
                                        <select name="area" class="custom-select dropdown-select2" id="area">
                                            <option selected>Choose...</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone-number">Phone Number</label>
                                        <input name="phone-number" type="number" class="form-control" id="phone-number" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input name="email" type="email" class="form-control" id="email" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="coordinate">Outlet Coordinate Location</label>
                                            <input name="coordinate" type="text" class="form-control" id="coordinate" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- /.form-section.row -->
                        <div class="form-section clearfix btn-submit" align="center">
                            <button type="submit" class="btn font13 btn-green btn-add-client border-0" >Save</button>
                            <button type="button" class="btn font13 btn-green btn-add-client border-0" >Add New Outlet</button>
                        </div>
                    </div>
                    <!-- /.content-area__main -->
                </form>
                <!-- /#campign-form -->
            </div>
        </div>
    </div>
    <!-- /.main-content__body -->
</div>
@endsection