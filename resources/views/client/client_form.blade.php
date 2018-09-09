@extends('layouts/main')
@php
    $title = @$client ? 'Edit Client' : 'Create New Client'
@endphp
@section('title', $title)
@section('headerTitle', $title)
@section('content')
<div id="main-content">
    <div class="container-fluid">
      <div class="row justify-content-md-center">
        <div class="campaign-form-progress-outer col-md-8">
          <ol class="campaign-form-progress list3">
            <li id="step_1" class="active"><span>Company Information</span></li>
            <!-- <li class="done"><span>Company Information</span></li> -->
            <li id="step_2"><span>Billing Information</span></li>
            <li id="step_3"><span>Client Settings</span></li>
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
            $clientId = @$client->client_id;
            $method = $clientId ? 'PUT' : 'POST';
            $route = $clientId ? route('clients.update',['id' => $clientId]) : route('clients.store');
          @endphp
          <form id="company-form" action="{{ $route }}" method="POST" enctype="multipart/form-data">
             @csrf
            <input type="hidden" name="_method" value="{{ $method }}">
            <div id="company_information_form">
              <div class="content-area__main client-area-form">
                <div class="form-section">
                  <h2 class="heading-desc-0">Company Information</h2>
                </div>
                <div class="form-section">
                  <div class="form-group">
                    <div class="form-input">
                      <label for="company-name">Company Name</label>
                      <input name="client_name" type="text" class="form-control" id="company-name" placeholder="" value="{{ @$client->client_name }}" required>
                    </div>
                  </div>
                  <div class="form-group">
                      <div class="form-input">
                        <label for="company-legal-name">Company Legal Name</label>
                        <input name="client_legal_name" type="text" class="form-control" id="company-legal-name" placeholder="" value="{{ @$client->client_legal_name }}" required>
                      </div>
                  </div>
                  <div class="form-group">
                    <div class="form-input">
                      <label for="user-in-charge">User In Charge</label>
                      <select name="client_in_charge_user_id" class="custom-select dropdown-select2" id="user-in-charge" required>
                        <option value="" {{ !@$client ? 'selected' : '' }} disabled hidden>Choose...</option>
                        @foreach ($users as $user)
                          @php
                            $selected = @$client->client_in_charge_user_id == $user->user_id ? 'selected' : '';
                          @endphp
                          <option value="{{ $user->user_id }} {{ $selected  }}">{{ $user->user_name }}</option>    
                        @endforeach
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
                      <select name="client_industry_category_pid" class="custom-select dropdown-select2" id="industry" required>
                        <option value="" {{ !@$client ? 'selected' : '' }} disabled hidden>Choose...</option>
                        @foreach ($settings->industryCategory as $industry)
                          @php
                            $selected = @$client->client_industry_category_pid == $industry->parameters_id ? 'selected' : '';
                            if(@$client->client_industry_category_pid == $industry->parameters_id) {
                            }
                          @endphp
                          <option value="{{ $industry->parameters_id }}" {{ $selected }}>{{ $industry->parameters_value }}</option>    
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <!-- /.col-md-6 -->
                  <div class="col-md-6">
                      <div class="form-group">
                        <h4 class="form-group__heading">Company Size</h4>
                        <div class="input-group">
                          @php $i = 0; @endphp
                          @foreach ($settings->employeeSizeCategory as $size)      
                            @php
                             $checked = '';
                             if(@$client->client_employee_size_category_pid == $size->parameters_id) {
                               $checked = 'checked';
                             }elseif(!@$client && $i == 0) {
                               $checked = 'checked';
                             }
                            @endphp
                            <div class="form-input form-check">
                              <input class="form-check-input" type="radio" name="client_employee_size_category_pid" id="company-size-1" value="{{ $size->parameters_id }}" {{ $checked }} nice-checkbox-radio required>
                              <label class="form-check-label" for="company-size-1">
                                <h5>{{ $size->parameters_value }}</h5>
                                <p>Lorem ipsum dolor sit amet, at has augue moderatius appellantur</p>
                              </label>
                            </div>
                            @php $i++; @endphp
                          @endforeach
                        </div>
                      </div>
                  </div>
                  <!-- /.col-md-6 -->
                </div>
                <div class="row">
                  <div class="col-6">
                    <div id="upload_button">
                        <label>
                          <input id="uploadInput" type="file" name="client_logo_image_url" accept="image/*">
                          <span class="btn btn-outline-primary btn-block">Upload Company Logo</span>
                        </label>
                        <p>Min. image 50 x 50 px</p>
                      </div>
                  </div>
                  <div class="col-6">
                    @if(@$client->client_logo_image_url)
                      <div id="uploadBox" style="display:block">
                        <input type="text" name="logo-name" id="uploadText" value="{{ @$client->client_logo_image_url }}" readonly>
                        <a href="#" class="clearFile"><img src="{{ asset('assets/img/icon-times.svg') }}" alt=""></a>
                      </div>
                    @else
                      <div id="uploadBox" style="display:none">
                          <input type="text" name="logo-name" id="uploadText" readonly>
                          <a href="#" class="clearFile"><img src="{{ asset('assets/img/icon-times.svg') }}" alt=""></a>
                      </div>
                    @endif
                  </div>
                </div>
                <!-- /.form-section.row -->
                
              </div>
              <!-- /.content-area__main -->
              <div class="form-section clearfix">
                <button type="submit" id="company_information_button" class="btn btn-wide-block btn-primary btn-add-client border-0">Save &amp; Next</button>
              </div>
            </div>
            <div id="client_billing_info_form">
                <div class="content-area__main">
                  <div class="form-section">
                    <h2 class="heading-desc-0">Billing Information</h2>
                  </div>
                  <div class="form-section">
                    <div class="form-group">
                      <div class="form-input">
                        <label for="tax-reg">Tax Registration Number (NPWP)</label>
                        <input name="client_tax_no" type="number" class="form-control" id="tax-reg" placeholder="" value="{{ @$client->client_tax_no }}">
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="form-input">
                          <label for="bill-address-1">Billing Address 1</label>
                          <input name="client_billing_address_line_1" type="text" class="form-control" id="bill-address-1" placeholder="" value="{{ @$client->client_billing_address_line_1 }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-input">
                          <label for="bill-address-2">Billing Address 2</label>
                          <input name="client_billing_address_line_2" type="text" class="form-control" id="bill-address-2" placeholder="" value="{{ @$client->client_billing_address_line_2 }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="province">Province</label>
                            <select name="client_billing_address_state_province_pid" class="custom-select dropdown-select2" id="province" data="address_city">
                              <option value="" {{ !@$client->client_billing_address_state_province_pid ? 'selected' : '' }} disabled hidden>Choose...</option>
                              @foreach ($settings->addressStateProvince as $province)
                                  @php
                                    $selected = @$client->client_billing_address_state_province_pid == $province->parameters_id ? 'selected' : '';
                                  @endphp
                                  <option value="{{ $province->parameters_id }}" {{ $selected }}>{{ $province->parameters_value }}</option>   
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <!-- /.col-md-6 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <select name="client_billing_address_city_pid" class="custom-select dropdown-select2" id="city" data="address_region">
                                <option value="" {{ !@$client->client_billing_address_city_pid ? 'selected' : '' }} disabled hidden>Choose...</option>
                                @if(@$client->client_billing_address_city_pid)
                                 @foreach ($settings->addressCity as $city)
                                    @php
                                      $selected = @$client->client_billing_address_city_pid == $city->parameters_id ? 'selected' : '';
                                    @endphp
                                  <option value="{{ $city->parameters_id }}" {{ $selected }}>{{ $city->parameters_value }}</option>   
                                  @endforeach
                                @endif
                                </select>
                            </div>
                        </div>
                        <!-- /.col-md-6 -->
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="area">Area</label>
                              <select name="client_billing_address_region_pid" class="custom-select dropdown-select2" id="area">
                                <option value="" {{ !@$client->client_billing_address_region_pid ? 'selected' : '' }} disabled hidden>Choose...</option>
                                @if(@$client->client_billing_address_region_pid)
                                 @foreach ($settings->addressRegion as $region)
                                    @php
                                      $selected = @$client->client_billing_address_region_pid == $region->parameters_id ? 'selected' : '';
                                    @endphp
                                  <option value="{{ $region->parameters_id }}" {{ $selected }}>{{ $region->parameters_value }}</option>   
                                  @endforeach
                                @endif
                              </select>
                            </div>
                          </div>
                          <!-- /.col-md-6 -->
                          <div class="col-md-6">
                              <div class="form-group">
                                <div class="form-input">
                                  <label for="zip-code">Zip Code</label>
                                  <input name="client_billing_address_postal_code" type="text" class="form-control" id="client_billing_address_postal_code" placeholder="" value="{{ @$client->client_billing_address_postal_code }}">
                                </div>
                              </div>
                          </div>
                          <!-- /.col-md-6 -->
                      </div>
                  </div>
                
                  <div class="slide-group">
                      <a href="#" id="client_billing_info_next" class="one">Next</a>
                      <a href="#" id="client_billing_info_skip" class="two"><span class="slideBtn">Skip</span><div class="bg"></div></a>
                  </div>
                  
                </div>
            </div>
            <div id="client_settings_form">
                <div class="content-area__main">
                  <div class="form-section">
                    <h2 class="heading">Client Settings</h2>
                    <p>Lorem ipsum dolor sit amet, at has augue moderatius appellantur, per ut summo quando latine. Ea cum solet detraxit splendide, enim wisi qui ex, quidam dignissim ne nam.</p>
                  </div>
                  <div class="form-section">
                      <div class="form-group">
                          <h4 class="form-group__heading">Allow client to create new campaigns without balance?</h4>
                          <div class="input-group">
                            <div class="form-input form-check radio-inline">
                              <input class="form-check-input" type="radio" name="client_allow_postpaid" id="campaign-method-1" value="0" {{ @$client->client_allow_postpaid == 0 ? 'checked' : '' }} nice-checkbox-radio>
                              <label class="form-check-label" for="campaign-method-1">
                                <h5>No, they cannot</h5>
                              </label>
                            </div>
                            <div class="form-input form-check radio-inline">
                              <input class="form-check-input" type="radio" name="client_allow_postpaid" id="campaign-method-2" value="1" {{ @$client->client_allow_postpaid == 1 ? 'checked' : '' }} nice-checkbox-radio>
                              <label class="form-check-label" for="campaign-method-2">
                                <h5>Yes, they can</h5>
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                            <div class="form-input">
                              <label for="outstand-limit">Client Outstanding Limit</label>
                              <input name="client_outstanding_limit" type="text" class="form-control" id="outstand-limit" placeholder="Number" value="{{ @$client->client_outstanding_limit }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <h4 class="form-group__heading">Does this client is also a merchant?</h4>
                            <div class="input-group">
                              <div class="form-input form-check radio-inline">
                                <input class="form-check-input" type="radio" name="client_is_also_merchant" id="client-merchant-1" value="0" {{ @$client->client_is_also_merchant == 0 ? 'checked' : '' }} nice-checkbox-radio>
                                <label class="form-check-label" for="client-merchant-1">
                                  <h5>No, they are not</h5>
                                </label>
                              </div>
                              <div class="form-input form-check radio-inline">
                                <input class="form-check-input" type="radio" name="client_is_also_merchant" id="client-merchant-2" value="1" {{ @$client->client_is_also_merchant == 1 ? 'checked' : '' }} nice-checkbox-radio>
                                <label class="form-check-label" for="client-merchant-2">
                                  <h5>Yes, they are</h5>
                                </label>
                              </div>
                            </div>
                          </div>
                  </div>
                  
                  <!-- /.form-section.row -->
                    <div class="slide-group">
                        <a href="#" id="client_settings_next" class="one">Next</a>
                        <a href="#" id="client_settings_skip" class="two"><span class="slideBtn">Skip</span><div class="bg"></div></a>
                    </div>
                </div>
            </div>
          </form>
          <!-- /#campign-form -->
        </div>
      </div>
    </div>
    <!-- /.main-content__body -->
  </div>
@endsection
@push('footer_scripts')
    <script type="text/javascript">
      $(document).ready(function(){
        $('#client_billing_info_form').hide();
        $('#client_settings_form').hide();

        $('#company_information_button').click(function(e){
          e.preventDefault();
          $('#company-form').validate({
          errorElement: "div",
          onkeyup: false,
          ignore: [],
          rules: {    
              client_name: {
                required: true,
              },
              client_legal_name: {
                required: true,
              },
              client_in_charge_user_id: {
                required: true,
              },
              client_industry_category_pid: {
                required: true,
              },
              client_employee_size_category_pid: {
                required: true,
              },
              client_billing_address_postal_code: {
                number: true,
                minlength:5,
                maxlength:5
              }
            },
            messages: {
              client_name: "this Field is required",
              client_legal_name: "this Field is required",
              client_in_charge_user_id: "this Field is required",
              client_industry_category_pid: "this Field is required",
              client_employee_size_category_pid: "this Field is required",
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
          $('#company_information_form').hide();
          $('#client_billing_info_form').show();
          $('#step_1').attr('class','done');
        });

        $('#client_billing_info_next').click(function(e){
          e.preventDefault();
          if ((!$('#company-form').valid())) {
       		  return false;
          }
          $('#client_billing_info_form').hide();
          $('#client_settings_form').show();
          $('#step_2').attr('class','done');
          $('#step_3').attr('class','active');
          alert($('#company-name').val());
        });

        $('#client_billing_info_skip').click(function(e){
          e.preventDefault();
          if ((!$('#company-form').valid())) {
       		  return false;
          }
          $('#client_billing_info_form').hide();
          $('#client_settings_form').show();
          $('#step_2').attr('class','done');
          $('#step_3').attr('class','active');
        });

        $('#client_settings_next').click(function(e){
          e.preventDefault();
          $('#company-form').submit();
        });

        $('#client_settings_skip').click(function(e){
            e.preventDefault();
           $('#company-form').submit();
        });


        $('#province').change(function()
        {
            $.get('/general-setting/' + $(this).attr('data') +'/'+ this.value, function(cities)
            {
                var $state = $('#city');

                $state.find('option').remove().end();
                $state.append('<option value="" selected disabled hidden>Choose...</option>');

                var $stateArea = $('#area');

                $stateArea.find('option').remove().end();
                $stateArea.append('<option value="" selected disabled hidden>Choose...</option>');
                console.log(cities);

                $.each(cities, function(index, city) {
                    $state.append('<option value="' + city.parameters_id + '">' + city.parameters_value + '</option>');
                });
            });
        });

        $('#city').change(function()
        {
            $.get('/general-setting/' + $(this).attr('data') +'/'+ this.value, function(region)
            {
                var $state = $('#area');

                $state.find('option').remove().end();
                console.log(region);
                $state.append('<option value="" selected disabled hidden>Choose...</option>');
                $.each(region, function(index, region) {
                    $state.append('<option value="' + region.parameters_id + '">' + region.parameters_value + '</option>');
                });
            });
        });

      })
    </script>
@endpush