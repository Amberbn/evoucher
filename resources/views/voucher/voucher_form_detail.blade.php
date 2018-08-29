@extends('layouts/main')
@php
    $title = 'voucher detail';
    $headerTitle = @$notEditable ? 'Edit Voucher Detail' : 'Create New Voucher Detail';
    $disabled = @$notEditable ? 'disabled' : '';
    $progressList = @$notEditable ? 'list2' : 'list3';
@endphp
@section('title', $title)
@section('headerTitle', $headerTitle)
@section('content')
<div id="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="campaign-form-progress-outer col-md-8">
                <ol class="campaign-form-progress {{ $progressList }}">
                    <li class="done"><span>Voucher Profile</span></li>
                    <li class="active"><span>Voucher Details</span></li>
                    @if(!@$notEditable)
                        <li><span>Merchant &amp; Outlet</span></li>
                    @endif
                </ol>
                <!-- /.campaign-form-progress -->
            </div>
            <!-- /.campaign-form-progress-outer -->
        </div>
    </div>
    <div class="main-content__body container-fluid">
        <div class="row">
            <div class="content-area col-md-8">
                @php
                 $route = route('voucher.detail.store',['id' => $voucher['voucher_catalog_id']]);
                 if(@$notEditable) {
                     $route =  route('voucher.detail.update',['id' => $voucher['voucher_catalog_id']]);
                 }
                @endphp
                <form id="voucher_detail_form" action="{{ $route }}" method="POST">
                    @csrf
                    @if(@$notEditable)
                        <input type="hidden" name="_method" value="PUT">
                    @endif
                    <div class="content-area__main">
                        <div class="form-section">
                            <h2 class="heading">Voucher Details</h2>
                            <p>Lorem ipsum dolor sit amet, at has augue moderatius appellantur, per ut summo quando latine. Ea cum solet detraxit splendide, enim wisi qui ex, quidam dignissim ne nam.</p>
                        </div>
                        <div class="form-section">
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="terms-conditions">Terms &amp; Conditions</label>
                                    <textarea name="voucher_catalog_terms_and_condition" class="form-control prvInput" 
                                        id="terms-conditions" 
                                        placeholder="" {{ $disabled }}>{{ @$voucher['voucher_catalog_terms_and_condition'] }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="instruction-customer">Instruction for customer</label>
                                    <textarea name="voucher_catalog_instruction_customer" class="form-control" 
                                        id="instruction-customer" 
                                        placeholder="" {{ $disabled }}>{{ @$voucher['voucher_catalog_instruction_customer'] }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="instruction-outlet">Instruction for outlet</label>
                                    <textarea name="voucher_catalog_instruction_outlet" class="form-control" 
                                        id="instruction-outlet" 
                                        placeholder="" {{ $disabled }}>{{ @$voucher['voucher_catalog_instruction_outlet'] }}</textarea>
                                </div>
                            </div>
                        </div>
                        @php
                            $priceAmount = @$voucher['voucher_catalog_unit_price_amount'];
                            $priceAmountrupiah = formatRupiah($priceAmount);

                            $valueAmount = @$voucher['voucher_catalog_value_amount'];
                            $valueAmountrupiah = formatRupiah($valueAmount);
                        @endphp
                        <div class="form-section row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="voucher-stock">Stock Voucher</label>
                                    <input name="voucher_catalog_stock_level" type="text" class="form-control" 
                                        id="voucher-stock" placeholder="" value="{{ @$voucher['voucher_catalog_stock_level'] }}">
                                </div>
                            </div>
                            <!-- /.col-md-6 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price-amount">Unit Price Amount</label>
                                    <input name="voucher_catalog_unit_price_amount" type="text" class="form-control" 
                                        id="price-amount" placeholder="" value="{{ $priceAmountrupiah }}" {{ $disabled }}>
                                </div>
                            </div>
                            <!-- /.col-md-6 -->
                        </div>
                        <div class="form-section row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="value-amount">Value Amount</label>
                                    <input name="voucher_catalog_value_amount" type="text" class="form-control" 
                                        id="value-amount" placeholder="" value="{{ $valueAmountrupiah }}" {{ $disabled }}>
                                </div>
                            </div>
                            <!-- /.col-md-6 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price-point">Unit Price Point</label>
                                    <input name="voucher_catalog_unit_price_point" type="text" class="form-control" 
                                        id="price-point" placeholder="" value="{{ @$voucher['voucher_catalog_unit_price_point'] }}" {{ $disabled }}>
                                </div>
                            </div>
                            <!-- /.col-md-6 -->
                        </div>
                        <div class="form-section row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="value-point">Value Point</label>
                                    <input name="voucher_catalog_value_point" type="text" class="form-control" 
                                        id="value-point" placeholder="" value="{{ @$voucher['voucher_catalog_value_point'] }}" {{ $disabled }}>
                                </div>
                            </div>
                            <!-- /.col-md-6 -->
                        </div>

                        <div class="form-section clearfix">
                            <button type="submit" id="voucher_detail_button" class="btn btn-wide-block btn-green btn-add-campaign border-0">Next</button>
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
                        @if(@$voucher['voucher_catalog_main_image_url'])
                                @php
                                    $filePath = getImage($voucher['voucher_catalog_main_image_url'],'voucher','original')
                                @endphp
                                <img src="{{ $filePath }}" alt="">
                        @else
                            <img src="{{ asset('assets/img/user/starwars-movie-poster-medium.jpg') }}" alt="">
                        @endif
                    </div>
                    <div class="card-footer text-muted">
                        <nav class="voucher-tab">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">Informasi</a>
                                <a class="nav-item nav-link active" id="nav-tc-tab" data-toggle="tab" href="#nav-tc" role="tab" aria-controls="nav-tc" aria-selected="false">T &amp; C</a>
                                <a class="nav-item nav-link" id="nav-tukar-tab" data-toggle="tab" href="#nav-tukar" role="tab" aria-controls="nav-tukar" aria-selected="false">Penukaran</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                                {{ $voucher['voucher_catalog_information'] }}
                            </div>
                            <div class="tab-pane fade show active" id="nav-tc" role="tabpanel" aria-labelledby="nav-tc-tab">
                                {{ @$voucher['voucher_catalog_terms_and_condition'] }}
                            </div>
                            <div class="tab-pane fade" id="nav-tukar" role="tabpanel" aria-labelledby="nav-tukar-tab">
                                {{ @$voucher['voucher_catalog_short_information'] }}
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
</div>
@endsection
@push('footer_scripts')
     <script>
        $(document).ready(function(){
            $('#voucher_detail_button').click(function(e){
               $('#voucher_detail_form').validate({
                errorElement: "div",
                onkeyup: false,
                rules: {    
                    voucher_catalog_terms_and_condition: {
                        required: true,
                        minlength : 10
                    },
                    voucher_catalog_instruction_customer: {
                        required: true,
                        minlength : 10
                    },
                    voucher_catalog_instruction_outlet: {
                        required: true,
                        minlength : 10
                    },
                    voucher_catalog_stock_level: {
                        required: true,
                        number: true
                    },
                    voucher_catalog_unit_price_amount: {
                        required: true,
                        number: true
                    },
                    voucher_catalog_value_amount: {
                        required: true,
                        number: true
                    },
                    voucher_catalog_unit_price_point: {
                        required: true,
                        number: true
                    },
                    voucher_catalog_value_point: {
                        required: true,
                        number: true
                    }
                },
                errorPlacement: function(error, element) {
                let findDatePicker = element.parent().find('input.form-control.datetimepicker-input');
                console.log(element.prop('nodeName'));
                    if (element.prop('nodeName') == 'SELECT') {
                        error.appendTo(element.parent());
                    }
                    else if(findDatePicker.length > 0){
                        let getIdAttribute = $(element).parent().attr('id');
                        let errorElement = $(element).find('#datetimepicker-input').children();
                        let appendError = error.insertAfter('#'+getIdAttribute+' > .input-group-append');
                    } else {
                        error.insertAfter(element);
                    }
                }
                });
                if ((!$('#voucher_detail_form').valid())) {
                return false;
                }
                $('#voucher_detail_form').submit();
            });
        });
    </script>
@endpush