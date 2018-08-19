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
                <form id="company-form" action="{{ route('merchant.outlet.store',['id' => $response->merchant_id]) }}" method="POST">
                     @csrf
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
                                            <input name="outlets_title" type="text" class="form-control" id="outlets_title" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="form-input row">
                                            <label for="outlet-code">Redeem PIN</label>
                                            <div class="col-10" id="requestInput">
                                                <input name="outlets_code" value="{{ $outletCode }}" type="number" class="form-control" id="outlets_code" readonly>
                                            </div>
                                            <div class="col-2" id="requestBtn">
                                                <a href="#" id="requestPIN" data-toggle="tooltip" data-placement="bottom" title="Change PIN">
                                                    <!-- <img src="img/img-refresh.svg" alt=""> -->
                                                    <img src="{{ asset('assets/img/img-refresh.svg') }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="outlet-description">Outlet Description</label>
                                    <textarea class="form-control" name="outlets_description" id="outlets_description" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="outlet-address">Outlet Address</label>
                                    <input name="outlets_address_line" type="text" class="form-control" id="outlets_address_line" placeholder="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="province">Province</label>
                                        <select name="outlets_address_province_pid" class="custom-select dropdown-select2" id="province" data="address_city" required>
                                            @foreach ($settings->addressStateProvince as $province)
                                             <!--  @php
                                                $selected = @$client->client_billing_address_state_province_pid == $province->parameters_id ? 'selected' : '';
                                              @endphp -->
                                              <option value="{{ $province->parameters_id }}" {{ $selected }}>{{ $province->parameters_value }}</option>   
                                          @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <select name="outlets_address_city_pid" class="custom-select dropdown-select2" id="city" data="address_region" required>
                                           <!--  @if(@$client->client_billing_address_city_pid) -->
                                             @foreach ($settings->addressCity as $city)
                                                <!-- @php
                                                  $selected = @$client->client_billing_address_city_pid == $city->parameters_id ? 'selected' : '';
                                                @endphp -->
                                              <option value="{{ $city->parameters_id }}" {{ $selected }}>{{ $city->parameters_value }}</option>   
                                              @endforeach
                                            <!-- @endif -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="area">Area</label>
                                        <select name="outlets_address_region_pid" class="custom-select dropdown-select2" id="area" required>
                                        @foreach ($settings->addressRegion as $region)
                                             <option value="{{ $region->parameters_id }}" {{ $selected }}>{{ $region->parameters_value }}</option>   
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone-number">Phone Number</label>
                                        <input name="outlets_phone" type="number" class="form-control" id="outlets_phone" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input name="outlets_email" type="email" class="form-control" id="outlets_email" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="coordinate">Outlet Coordinate Location</label>
                                            <input name="outlets_location_coordinates" type="text" class="form-control" id="outlets_location_coordinates" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- /.form-section.row -->
                        <div class="form-section clearfix btn-submit" align="center">
                            <button id="company_information_button" type="submit" class="btn font13 btn-green btn-add-client border-0" >Save</button>
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
@push('footer_scripts')
<script type="text/javascript">
$(document).ready(function(){
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

        $('#company_information_button').click(function(e){
            e.preventDefault();
            $('#company-form').validate({
                errorElement: "div",
                onkeyup: false,
                ignore: [],
                rules: {    
                  outlets_title: {
                    required: true,
                  },
                  outlets_code: {
                    required: true,
                  },
                  outlets_description: {
                    required: true,
                  },
                  outlets_address_line: {
                    required: true,
                  },
                  province: {
                    required: true,
                  },
                  city: {
                    required: true,
                  },
                  area: {
                    required: true,
                  },
                  outlets_phone: {
                    required: true,
                  },
                  outlets_email: {
                    required: true,
                  },
                  outlets_location_coordinates: {
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

