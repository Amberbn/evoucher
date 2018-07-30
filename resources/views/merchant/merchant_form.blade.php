@extends('layouts/main')
@section('content')
<div id="main-content">
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="campaign-form-progress-outer col-md-8">
                <ol class="campaign-form-progress list2">
                    <li class="active"><span>Merchant Information</span></li>
                    <li><span>Outlet Details</span></li>
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
                        <h2 class="heading">Merchant Information</h2>
                        <p>Lorem ipsum dolor sit amet, at has augue moderatius appellantur, per ut summo quando latine. Ea cum solet detraxit splendide, enim wisi qui ex, quidam dignissim ne nam.</p>
                    </div>
                    <div class="form-section bottom-30">
                        <div class="form-group">
                        <div class="form-input">
                            <label for="brand-name">Brand Name</label>
                            <input name="merchant_title" type="text" class="form-control" id="brand-name" placeholder="">
                        </div>
                    </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <div class="form-input">
                                <label for="choose-client">Client</label>
                                <select name="merchant_client_id" class="custom-select dropdown-select2" id="choose-client">
                                <!-- <option {{ !@$user->client_id ? 'selected' : '' }}>Choose...</option> -->
                                @foreach ($clients as $client)
                                <!-- @php
                                    $selected = @$user->client_id == $client['client_id'] ? 'selected' : '';
                                @endphp -->
                                <option value="{{ $client['client_id'] }}" {{ $selected }}>{{ $client['client_name'] }}</option>
                                @endforeach
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-only-a-link">
                            <a href="#" class="align-middle">Client is not registered yet? Click here to add new client</a>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <div class="form-input">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="business-category">Business Category</label>
                                <select name="business-category" class="custom-select dropdown-select2" id="business-category">
                                   <!-- <option {{ !@$user->merchant_bussiness_category_pid ? 'selected' : '' }}>Choose...</option> -->
                                @foreach ($bussinessCategory->bussinessCategory as $bc)

                                <!-- @php
                                    $selected = @$user->client_id == $client['client_id'] ? 'selected' : '';
                                @endphp -->
                                <option value="{{ $bc->parameters_id }}" {{ $selected }}>{{ $bc->parameters_value }}</option>
                                @endforeach
                                </select>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="campaign-tags">Tags</label>
                                    <select name="campaign-tags" class="custom-select select2-input-tags" id="campaign-tags" multiple="multiple">
                                    <option value="1">Tag One</option>
                                    <option value="2">Tag Two</option>
                                    <option value="3">Tag Three</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-section">
                        <h2 class="heading-desc-0">Social Media Accounts</h2>
                    </div>
                    <div class="form-section row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="socmed-facebook">Facebook</label>
                            <input name="socmed-facebook" type="text" class="form-control" id="socmed-facebook" placeholder="">
                            </div>
                        </div>
                        <!-- /.col-md-6 -->
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="socmed-instagram">Instagram</label>
                            <input name="socmed-instagram" type="text" class="form-control" id="socmed-instagram" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="form-section row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="socmed-twitter">Twitter</label>
                            <input name="socmed-twitter" type="text" class="form-control" id="socmed-twitter" placeholder="">
                            </div>
                        </div>
                        <!-- /.col-md-6 -->
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="socmed-line">Line</label>
                            <input name="socmed-line" type="text" class="form-control" id="socmed-line" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="form-section row bottom-30">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="socmed-linkedin">LinkedIn</label>
                                <input name="socmed-linkedin" type="text" class="form-control" id="socmed-linkedin" placeholder="">
                            </div>
                        </div>
                        <!-- /.col-md-6 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="socmed-pinterest">Pinterest</label>
                                <input name="socmed-pinterest" type="text" class="form-control" id="socmed-pinterest" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="form-section">
                        <h2 class="heading-desc-0">Upload Logo Merchant</h2>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div id="upload_button">
                                <label>
                                <input id="uploadInput" type="file" name="logo-file" accept="image/*">
                                <span class="btn btn-outline-primary btn-block">Upload Logo Merchant</span>
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
                    <!-- /.form-section.row -->
                    <div class="form-section clearfix">
                        <button type="submit" class="btn btn-wide-block btn-primary btn-add-client border-0" data-toggle="modal" data-target="#notifUserModal">Create Merchant</button>
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
    <!-- /#main-content -->
@endsection
