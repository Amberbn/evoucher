@extends('layouts/main')
@php
    $title = 'voucher merchant';
@endphp
@section('title', $title)
@section('headerTitle', 'Create New Voucher Merchant')
@section('content')
<div id="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="campaign-form-progress-outer col-md-8">
                <ol class="campaign-form-progress list3">
                    <li class="done"><span>Voucher Profile</span></li>
                    <li class="done"><span>Voucher Details</span></li>
                    <li class="active"><span>Merchant &amp; Outlet</span></li>
                </ol>
                <!-- /.campaign-form-progress -->
            </div>
            <!-- /.campaign-form-progress-outer -->
        </div>
    </div>
    <div class="main-content__body container-fluid">
        <div class="row">
            <div class="content-area col-md-8">
                <form id="voucher_merchant_form" action="{{ route('voucher.merchant.store',['id' => $voucher['voucher_catalog_id']]) }}" method="POST">
                    @csrf
                    <div class="content-area__main">
                        <div class="form-section">
                            <h2 class="heading">Merchant &amp; Outlets</h2>
                            <p>Lorem ipsum dolor sit amet, at has augue moderatius appellantur, per ut summo quando latine. Ea cum solet detraxit splendide, enim wisi qui ex, quidam dignissim ne nam.</p>
                        </div>
                        <!-- /.form-section -->
                        <div class="form-section row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-input">
                                        <label for="search-merchant">Merchant</label>
                                        <select name="search-merchant" class="custom-select dropdown-select2" id="search-merchant">
                                            @foreach($merchantDropdown as $merchant)
                                                <option value="{{ $merchant->merchant_id }}">{{ $merchant->merchant_title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-only-a-link">
                                    <button id="addMerchant" type="button" class="btn btn-wide-block btn-green btn-add-campaign border-0">Add To List</button>
                                    <!-- <a href="#" class="align-middle">Create new Merchant</a> -->
                                </div>
                            </div>
                        </div>
                        <!-- /.form-section.row -->
                        <!-- merchant lists -->
                        <ul id="accordion"></ul>
                        <!-- end merchant lists -->

                        <div class="form-section clearfix">
                            <button type="submit" id="voucher_merchant_button" class="btn btn-wide-block btn-green btn-add-campaign border-0">Next</button>
                        </div>
                    </div>
                    <!-- /.content-area__main -->
                </form>
                <!-- /#campign-form -->
            </div>
            <!-- /.content-area -->
            <div class="sidebar-area col-md-4">
                <div class="card card-form">
                    <div class="card-header">
                        <h5 class="card-title">{{ $voucher['voucher_catalog_title'] }}</h5>
                        {{--  <h5 class="card-subtitle">CGV Cinemas</h5>  --}}
                    </div>
                    <div class="card-body text-center">
                        @if($voucher['voucher_catalog_main_image_url'])
                            @php
                                $path = 'storage/voucher/thumbnail/';
                                $filePath = $path.'/'.$voucher['voucher_catalog_main_image_url'];
                            @endphp
                            <img src="{{ asset($filePath) }}" alt="">
                        @else
                            <img src="{{ asset('assets/img/user/starwars-movie-poster-medium.jpg') }}" alt="">
                        @endif
                    </div>
                    <div class="card-footer text-muted">
                        <nav class="voucher-tab">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">Informasi</a>
                                <a class="nav-item nav-link" id="nav-tc-tab" data-toggle="tab" href="#nav-tc" role="tab" aria-controls="nav-tc" aria-selected="false">T &amp; C</a>
                                <a class="nav-item nav-link" id="nav-tukar-tab" data-toggle="tab" href="#nav-tukar" role="tab" aria-controls="nav-tukar" aria-selected="false">Penukaran</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                               {{ $voucher['voucher_catalog_information'] }}
                            </div>
                            <div class="tab-pane fade" id="nav-tc" role="tabpanel" aria-labelledby="nav-tc-tab">
                                {{ $voucher['voucher_catalog_terms_and_condition'] }}
                            </div>
                            <div class="tab-pane fade" id="nav-tukar" role="tabpanel" aria-labelledby="nav-tukar-tab">
                                <pre class="prvResult"></pre>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.campaign-template -->
            </div>
            <!-- /.sidebar-area -->
        </div>
    </div>
    <!-- /.main-content__body -->
    <div id="merchantTemplate" style="display: none">
        <li class="merchantList">
            <div id="cardMerchant" class="card bottom-20">
                <div class="card-header" id="headingMerchant">
                    <h5 class="mb-0 clearfix"><span class="headTitle"></span>
                        <div class="float-right">
                            <button class="border-0 btn-removelist" type="button" href="#" onclick="removeList(this)">
                                <i class="fas fa-times"></i>
                            </button>
                            <button id="collapseMerchantBtn" type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseMerchant" aria-expanded="true" aria-controls="collapseMerchant">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </h5>
                </div>
                <div id="collapseMerchant" class="collapse show" aria-labelledby="headingMerchant" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="form-input form-check radio-inline">
                                    <input class="form-check-input" type="radio" name="voucher-outlet_" id="all-outlet_" value="true" onclick="checkOutlet(this)">
                                    <label class="form-check-label" for="all-outlet_">Redeemable At All Outlet</label>
                                </div>
                                <div class="form-input form-check radio-inline">
                                    <input class="form-check-input" type="radio" name="voucher-outlet_" id="selected-outlet_" value="false" checked onclick="checkOutlet(this)">
                                    <label class="form-check-label" for="selected-outlet_">Redeemable At Selected Outlet</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="parent_id_">
                        <div class="form-group">
                            <div class="form-input">
                                <label for="add-outlet_">Add Outlet</label>
                                <select name="add-outlet_" class="custom-select" id="add-outlet_" multiple="multiple">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-input">
                                <label for="exclude-outlet_">Exclude Outlet</label>
                                <select name="exclude-outlet_" class="custom-select" id="exclude-outlet_" multiple="multiple">
                                   
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </div>
</div>
@endsection
@push('footer_scripts')
    <script src="{{ asset('assets/js/merchant-list.js') }}"></script>
     <script>
        $(document).ready(function(){
            
            $('#addMerchant').click(function(){
                createSelect2Component('select[id^="add-outlet','add-outlet_');
                createSelect2Component('select[id^="exclude-outlet','exclude-outlet_');
            });

            function createSelect2Component(selector,idComponent) {
                 $(selector).each(function(){
                    let groupNumber = $(this).attr('group-number');
                    console.log(groupNumber);
                    let merchantId = $(this).attr('selected-parent');
                    let thisId = $(this).attr('id');
                    $('#'+idComponent+groupNumber).select2({
                        ajax: {
                            url: '/outlet-by-merchant/'+merchantId,
                            processResults: function (data) {
                                console.log(data);
                                return {
                                    results: $.map(data, function (item) {
                                        console.log(item);
                                        return {
                                            text: item.outlets_title,
                                            id: item.outlets_id
                                        }
                                    })
                                };
                            }
                        }
                    });
                });
            }

            $(document).on('change','select[id^="add-outlet"]',function(){
                let groupNumber = $(this).attr('group-number');
                let valueLength = $(this).val().length;
                let el = $(this).parent().parent().parent().find('#exclude-outlet_'+groupNumber);
                if(valueLength < 1) {
                     $(el).prop('disabled', false); 
                }else{
                     $(el).prop('disabled', true);
                     $('#add-outlet_'+groupNumber+'-error').remove();
                     $('#exclude-outlet_'+groupNumber+'-error').remove();
                }
            });

            $(document).on('change','select[id^="exclude-outlet"]',function(){
                let groupNumber = $(this).attr('group-number');
                let valueLength = $(this).val().length;
                let el = $(this).parent().parent().parent().find('#add-outlet_'+groupNumber);
                if(valueLength < 1) {
                     $(el).prop('disabled', false); 
                }else{
                     $(el).prop('disabled', true);
                     $('#add-outlet_'+groupNumber+'-error').remove();
                     $('#exclude-outlet_'+groupNumber+'-error').remove();
                }
            });

            $('#voucher_merchant_button').click(function(e){
                let isEmptyCard = $('form').find('.merchantList').length;
                e.preventDefault();
                $('select[id^="add-outlet"]').each(function(){
                    $(this).prop('required',true);
                });
                 $('select[id^="exclude-outlet"]').each(function(){
                    $(this).prop('required',true);
                });
                $('#voucher_merchant_form').validate({ errorElement: "div"});
                if(isEmptyCard > 0) {
                    $('#voucher_merchant_form').submit();
                }else{
                    toastr.error('Please add some form to be submitted');
                }
            });
            
        });
    </script>
@endpush