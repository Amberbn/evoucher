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
                                            <input name="outlets_title" type="text" class="form-control" id="outlet-name" placeholder="">
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
                                    <textarea class="form-control" name="outlets_description" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="outlet-address">Outlet Address</label>
                                    <input name="outlets_address_line" type="text" class="form-control" id="outlet-address" placeholder="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="province">Province</label>
                                        <select name="province" class="custom-select dropdown-select2" id="province" data="address_city">
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
                                        <select name="city" class="custom-select dropdown-select2" id="city" data="address_region">
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
                                        <select name="area" class="custom-select dropdown-select2" id="area">
                                        @foreach ($settings->addressRegion as $region)
                                             <option value="{{ $region->parameters_id }}" {{ $selected }}>{{ $region->parameters_value }}</option>   
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone-number">Phone Number</label>
                                        <input name="outlets_phone" type="number" class="form-control" id="phone-number" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input name="outlets_email" type="email" class="form-control" id="email" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="coordinate">Outlet Coordinate Location</label>
                                            <input name="outlets_location_coordinates" type="text" class="form-control" id="coordinate" placeholder="">
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
@push('footer_scripts')
<script type="text/javascript">
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
</script>
@endpush

