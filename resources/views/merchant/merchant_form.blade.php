@extends('layouts/main')
@php
    $title = @$merchant ? 'Edit Merchant' : 'Create New Merchant'
@endphp
@section('title', $title)
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
                @php
                    $merchantId = @$merchant->merchant_id;
                    $method = $merchantId ? 'PUT' : 'POST';
                    $route = $merchantId ? route('merchant.update',['id' => $merchantId]) : route('merchant.store');
                @endphp
                <form id="company-form" action="{{ $route }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="{{ $method }}">
                <div class="content-area__main">
                    <div class="form-section bottom-30">
                        <h2 class="heading">Merchant Information</h2>
                        <p>Lorem ipsum dolor sit amet, at has augue moderatius appellantur, per ut summo quando latine. Ea cum solet detraxit splendide, enim wisi qui ex, quidam dignissim ne nam.</p>
                    </div>
                    <div class="form-section bottom-30">
                        <div class="form-group">
                        <div class="form-input">
                            <label for="brand-name">Brand Name</label>
                            <input name="merchant_title" id="merchant_title" type="text" class="form-control" value="{{ @$merchant->merchant_title }}" id="brand-name" placeholder="">
                        </div>
                    </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <div class="form-input">
                                <label for="choose-client">Client</label>
                                <select name="merchant_client_id" id="merchant_client_id" class="custom-select dropdown-select2" id="choose-client" required>
                                <option {{ !@$merchant->merchant_client_id ? 'selected' : '' }} disabled hidden>Choose...</option>
                                @foreach ($clients as $client)
                                @php
                                    $selected = @$merchant->merchant_client_id == $client['client_id'] ? 'selected' : '';
                                @endphp
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
                            <textarea class="form-control" name="merchant_description" id="merchant_description" cols="30" rows="3">{{ @$merchant->merchant_description }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="business-category">Business Category</label>
                                <select name="merchant_bussiness_category_pid" id="merchant_bussiness_category_pid" class="custom-select dropdown-select2" id="business-category" required>
                                   <option {{ !@$merchant->merchant_bussiness_category_pid ? 'selected' : '' }} disabled hidden>Choose...</option>
                                @foreach ($bussinessCategory->bussinessCategory as $bc)

                                @php
                                    $selected = @$merchant->merchant_bussiness_category_pid == $bc->parameters_id ? 'selected' : '';
                                @endphp
                                <option value="{{ $bc->parameters_id }}" {{ $selected }}>{{ $bc->parameters_value }}</option>
                                @endforeach
                                </select>
                            </div>
                            </div>

                            @php
                                $tagArray = null;
                                if(@$merchant) {
                                    $tagArray = explode(',',$merchant->merchant_tags);
                                }
                            @endphp
                            <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="campaign-tags">Tags</label>
                                    <select name="merchant_tags[]" id="merchant_tags" class="custom-select select2-input-tags" id="campaign-tags" multiple required>
                                    @foreach ($tags as $tg => $tag)
                                        @php
                                            $selected = null;
                                            if(@$merchant) {
                                                $selected = in_array($tag, $tagArray) ? 'selected' : '';
                                            }
                                        @endphp
                                        <option value="{{ strtolower($tag) }}" {{ $selected }}>{{ $tag }}</option>
                                    @endforeach
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
                            <input name="merchant_socmed_url_facebook" type="text" value="{{ @$merchant->merchant_socmed_url_facebook }}" class="form-control" id="socmed-facebook" placeholder="">
                            </div>
                        </div>
                        <!-- /.col-md-6 -->
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="socmed-instagram">Instagram</label>
                            <input name="merchant_socmed_url_instagram" type="text" value="{{ @$merchant->merchant_socmed_url_instagram }}" class="form-control" id="socmed-instagram" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="form-section row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="socmed-twitter">Twitter</label>
                            <input name="merchant_socmed_url_twitter" type="text" value="{{ @$merchant->merchant_socmed_url_twitter }}" class="form-control" id="socmed-twitter" placeholder="">
                            </div>
                        </div>
                        <!-- /.col-md-6 -->
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="socmed-line">Line</label>
                            <input name="merchant_socmed_url_line" value="{{ @$merchant->merchant_socmed_url_line }}" type="text" class="form-control" id="socmed-line" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="form-section row bottom-30">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="socmed-linkedin">LinkedIn</label>
                                <input name="merchant_socmed_url_linkedin" type="text" value="{{ @$merchant->merchant_socmed_url_linkedin }}" class="form-control" id="socmed-linkedin" placeholder="">
                            </div>
                        </div>
                        <!-- /.col-md-6 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="socmed-pinterest">Pinterest</label>
                                <input name="merchant_socmed_url_pinterest" type="text" value="{{ @$merchant->merchant_socmed_url_pinterest }}" class="form-control" id="socmed-pinterest" placeholder="">
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
                                <input id="uploadInput" type="file" name="merchant_logo_image_url" accept="image/*">
                                <span class="btn btn-outline-primary btn-block">Upload Logo Merchant</span>
                                </label>
                                <p>Min. image 50 x 50 px</p>
                            </div>
                        </div>
                        <div class="col-6">
                            @if(@$merchant->merchant_logo_image_url)
                            <div id="uploadBox">
                                <input type="text" name="logo-name" id="uploadText" value="{{ @$merchant->merchant_logo_image_url }}" readonly>
                                <a href="#" class="clearFile"><img src="{{ asset('assets/img/icon-times.svg') }}" alt=""></a>
                            </div>
                             @else
                             <div id="uploadBox">
                                <input type="text" name="logo-name" id="uploadText" readonly>
                                <a href="#" class="clearFile"><img src="{{ asset('assets/img/icon-times.svg') }}" alt=""></a>
                            </div>
                            @endif
                        </div>
                    </div>
                        
                        <!-- /.form-section.row -->
                    <!-- /.form-section.row -->
                    <div class="form-section clearfix">
                        <button type="submit" id="company_information_button" class="btn btn-wide-block btn-primary btn-add-client border-0" data-toggle="modal" data-target="#notifUserModal">Create Merchant</button>
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

@push('footer_scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('#company_information_button').click(function(e){
            e.preventDefault();
            $('#company-form').validate({
                errorElement: "div",
                onkeyup: false,
                ignore: [],
                rules: {    
                  merchant_title: {
                    required: true,
                  },
                  merchant_client_id: {
                    required: true,
                  },
                  merchant_description: {
                    required: true,
                  },
                  merchant_bussiness_category_pid: {
                    required: true,
                  },
                  merchant_tags: {
                    required: true,
                  }
                },
                errorPlacement: function(error, element) {
                console.log(element.prop('nodeName'));
                    if (element.prop('nodeName') == 'SELECT') {
                        error.appendTo(element.parent());
                        console.log('here');
                    }
                    else {
                        error.insertAfter(element);
                    }
                }
            });
            if ((!$('#company-form').valid())) {
              return false;
            }
            $('#company-form').submit();
        })
    });
</script>
@endpush
