@extends('layouts/main')
@php
    $title = 'voucher profile';
    $headerTitle = @$voucher ? 'Edit Voucher Profile' : 'Create New Voucher Profile';
    $disabled = @$voucher->voucher_status == 'RELEASED' ? 'disabled' : '';
    $progressList = @$voucher->voucher_status == 'RELEASED' ? 'list2' : 'list3';
    $isReleased = @$voucher->voucher_status == 'RELEASED' ? true : false;
@endphp
@section('title', $title)
@section('headerTitle', $headerTitle)
@section('content')
<div id="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="campaign-form-progress-outer col-md-8">
                <ol class="campaign-form-progress {{ $progressList }}">
                    <li class="active"><span>Voucher Profile</span></li>
                    <li><span>Voucher Details</span></li>
                    @if(!@$isReleased)
                        <li><span>Merchant &amp; Outlet</span></li>
                    @endif
                </ol>
                <!-- /.campaign-form-progress -->
            </div>
            <!-- /.campaign-form-progress-outer -->
        </div>
    </div>
    @php
        $route = route('voucher.profile.store');
        if(@$voucher){
            $route = route('voucher.detail.edit',['id' => $voucher->voucher_catalog_id]);
        }
    @endphp
    <div class="main-content__body container-fluid">
        <form id="voucher_profile_form" action="{{ $route }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="content-area col-md-8">
                    <div class="content-area__main">
                        <div class="form-section">
                            <h2 class="heading">Voucher Profile</h2>
                            <p>Lorem ipsum dolor sit amet, at has augue moderatius appellantur, per ut summo quando latine. Ea cum solet detraxit splendide, enim wisi qui ex, quidam dignissim ne nam.</p>
                        </div>
                        <div class="form-section">
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="voucher-name">Voucher Name</label>
                                    <input name="voucher_catalog_title" type="text" class="form-control" id="voucher-name" 
                                        placeholder="" value="{{ @$voucher->voucher_catalog_title }}" {{ $disabled }}>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="short-description">Short Descriptions</label>
                                    <textarea name="voucher_catalog_short_information" class="form-control" id="short-description" 
                                        placeholder="" {{ $disabled }}>{{ @$voucher->voucher_catalog_short_information }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="full-information">Full Information</label>
                                    <textarea name="voucher_catalog_information" class="form-control prvInput" id="full-information" 
                                        placeholder="" {{ $disabled }}>{{ @$voucher->voucher_catalog_information }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-section row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="voucher-category">Voucher Category</label>
                                   <select name="voucher_catalog_category_pid" class="custom-select dropdown-select2" id="industry" {{ $disabled }} required>
                                        <option value="" {{ !@$voucher ? 'selected' : '' }} disabled hidden>Choose...</option>
                                        @foreach ($voucherCategory->voucherCategoryPid as $category)
                                        @php
                                            $selected = @$voucher->voucher_catalog_category_pid == $category->parameters_id ? 'selected' : '';
                                            if(@$voucher->voucher_catalog_category_pid == $category->parameters_id) {
                                            }
                                        @endphp
                                        <option value="{{ $category->parameters_id }}" {{ $selected }}>{{ $category->parameters_value }}</option>    
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.col-md-6 -->
                            @php
                                $tagArray = null;
                                if(@$voucher) {
                                    $tagArray = explode(',',$voucher->voucher_catalog_tags);
                                }
                            @endphp
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-input">
                                        <label for="voucher-tags">Tags</label>
                                        <select name="voucher_catalog_tags[]" class="custom-select select2-input-tags" id="voucher-tags" multiple="multiple" {{ $disabled }} required>
                                            @foreach ($tagsData as $tag)
                                                @php
                                                    $selected = null;
                                                    if(@$voucher) {
                                                        $selected = in_array($tag->Tags, $tagArray) ? 'selected' : '';
                                                    }
                                                @endphp
                                                    <option value="{{ strtolower($tag->Tags) }}" {{ $selected }}>{{ $tag->Tags }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-6 -->
                        </div>
                        <!-- /.form-section.row -->
                        @php
                            $editableDatePicker = @$voucher ? '' : 'form-group__validity-period';
                            $startDate = @$voucher ? sqlDateFormat(@$voucher->voucher_catalog_valid_start_date) : '';
                            $endDate = @$voucher ? sqlDateFormat(@$voucher->voucher_catalog_valid_end_date) : '';
                        @endphp
                        <div class="form-section expand-col-12 row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group {{ $editableDatePicker }}">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>Validity Start Date</label>
                                            <div class="form-input">
                                                <div class="input-group" id="pick-date-period-start" data-target-input="nearest">
                                                    <input type="text" placeholder="Start" name="voucher_catalog_valid_start_date" id="start_date" aria-label="Start" 
                                                        class="form-control datetimepicker-input" data-toggle="datetimepicker"
                                                        data-target="#pick-date-period-start" value="{{ $startDate }}" {{ $disabled }}/>
                                                    <div class="input-group-append" data-target="#pick-date-period-start" data-toggle="datetimepicker">
                                                        <button class="btn btn-outline-secondary" type="button"><i class="icon-ft_calendar"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Validity End Date</label>
                                            <div class="form-input">
                                                <div class="input-group" id="pick-date-period-end" data-target-input="nearest">
                                                    <input type="text" placeholder="End" name="voucher_catalog_valid_end_date" id="end_date" aria-label="End" 
                                                        class="form-control datetimepicker-input" data-toggle="datetimepicker" 
                                                        data-target="#pick-date-period-end" value="{{ $endDate }}" {{ $disabled }}/>
                                                    <div class="input-group-append" data-target="#pick-date-period-end" data-toggle="datetimepicker">
                                                        <button class="btn btn-outline-secondary" type="button"><i class="icon-ft_calendar"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-6 -->
                        </div>

                        <div class="form-section clearfix">
                            <button type="submit" id="voucher_profile_button" class="btn btn-wide-block btn-green btn-add-campaign border-0">Next</button>
                        </div>
                    </div>
                    <!-- /.content-area__main -->
                    <!-- /#campign-form -->
                </div>
                <!-- /.content-area -->
                <div class="sidebar-area col-md-4">
                    <div class="card card-form">
                        <div class="card-header">
                            <h5 class="card-title">My Voucher Name</h5>
                            <h5>Merchant</h5>
                        </div>
                        <div id="upload_button" class="card-body text-center">
                            @if(@$voucher->voucher_catalog_main_image_url)
                                @php
                                    $filePath = getImage($voucher->voucher_catalog_main_image_url,'voucher','original')
                                @endphp
                                <img src="{{ $filePath }}" alt="">
                            @else
                                <p id="prvImgRes" class="card-text">500 x 341 px</p>
                                <label id="prvUploadBtn">
                                    <input id="prvImgInput" name="voucher_catalog_main_image_url" type="file" accept="image/*" onchange="preview_image(event)">
                                    <span class="btn btn-green">Insert Image</span>
                                </label>
                                <div id="prvBox">
                                    <div id="prvRemoveBtn">
                                        <a href="#"><img src="{{ asset('assets/img/img-remove-button.svg') }}" alt=""></a>
                                    </div>
                                    <div id="prvImgBox">
                                        <img id="output_image" />
                                    </div>
                                </div>
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
                                    @if(@$voucher->voucher_catalog_information)
                                        {{ @$voucher->voucher_catalog_information }}
                                    @else
                                        <pre class="prvResult"></pre>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="nav-tc" role="tabpanel" aria-labelledby="nav-tc-tab">
                                    @if(@$voucher->voucher_catalog_terms_and_condition)
                                        {{ @$voucher->voucher_catalog_terms_and_condition }}
                                    @else
                                        <p></p>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="nav-tukar" role="tabpanel" aria-labelledby="nav-tukar-tab">
                                    @if(@$voucher->voucher_catalog_short_information)
                                        {{ @$voucher->voucher_catalog_short_information }}
                                    @else
                                        ...
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.campaign-template -->
                </div>
                <!-- /.sidebar-area -->
            </div>
        </form>
    </div>
    <!-- /.main-content__body -->
</div>
@endsection
@push('footer_scripts')
    <script>
        $(document).ready(function(){
            $('#voucher_profile_button').click(function(e){
               $('#voucher_profile_form').validate({
                errorElement: "div",
                onkeyup: false,
                rules: {    
                    voucher_catalog_title: {
                        required: true,
                        minlength : 5,
                        maxlength : 100
                    },
                    voucher_catalog_information: {
                        required: true,
                        minlength : 10
                    },
                    voucher_catalog_tags: {
                        required: true
                    },
                    voucher_catalog_category_pid: {
                        required: true
                    },
                    voucher_catalog_short_information: {
                        required: true
                    },
                    voucher_catalog_valid_start_date: {
                        required: true
                    },
                    voucher_catalog_valid_end_date: {
                        required: true
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
                if ((!$('#voucher_profile_form').valid())) {
                return false;
                }
                $('#voucher_profile_form').submit();
            });
        });
    </script>
@endpush