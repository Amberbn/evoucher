@extends('layouts/main')
@section('title', 'Voucher List')
@section('headerTitle', 'Voucher Management')
@section('content')
@php
    $page = 'client';
@endphp
<div id="main-content">
    <div class="main-content__body container-fluid">
        <div class="row justify-content-md-center">
            <div class="content-area content-area__client-detail col-md-12">
                <div class="client-statistics-outer">
                    <div class="client-statistics clearfix">
                        <div class="client-stats-item">
                            <div class="client-stats-item__inner">
                                <a href="#">
                                    <h5 class="client-stats-item__name">Most Redeemed Voucher</h5>
                                    <div class="client-stats-item__value">820 pcs</div>
                                    <div class="client-stats-item__compare">
                                        <span class="client-stats-item__compare-number stats-up">5% <i class="fa fa-caret-up"></i></span>
                                        <span class="client-stats-item__compare-time">This Week</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- /.client-stats-item -->
                        <div class="client-stats-item">
                            <div class="client-stats-item__inner">
                                <a href="#">
                                    <h5 class="client-stats-item__name">Expired Vouchers</h5>
                                    <div class="client-stats-item__value">5500 pcs</div>
                                    <div class="client-stats-item__compare">
                                        <span class="client-stats-item__compare-number stats-down">12 <i class="fa fa-caret-down"></i></span>
                                        <span class="client-stats-item__compare-time">This Week</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- /.client-stats-item -->
                        <div class="client-stats-item">
                            <div class="client-stats-item__inner">
                                <a href="#">
                                    <h5 class="client-stats-item__name">Total Campaigns</h5>
                                    <div class="client-stats-item__value">IDR 7,932.00</div>
                                    <div class="client-stats-item__compare">
                                        <span class="client-stats-item__compare-number stats-up">13 <i class="fa fa-caret-up"></i></span>
                                        <span class="client-stats-item__compare-time">This Week</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- /.client-stats-item -->
                        <div class="client-stats-item">
                            <div class="client-stats-item__inner">
                                <a href="#">
                                    <h5 class="client-stats-item__name">Redeem Rate</h5>
                                    <div class="client-stats-item__value">74.25%</div>
                                    <div class="client-stats-item__compare">
                                        <span class="client-stats-item__compare-number stats-down">5% <i class="fa fa-caret-down"></i></span>
                                        <span class="client-stats-item__compare-time">This Week</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- /.client-stats-item -->
                        <div class="client-stats-item">
                            <div class="client-stats-item__inner">
                                <a href="#">
                                    <h5 class="client-stats-item__name">Redeem Rate</h5>
                                    <div class="client-stats-item__value">690.400</div>
                                    <div class="client-stats-item__compare">
                                        <span class="client-stats-item__compare-number stats-up">5% <i class="fa fa-caret-up"></i></span>
                                        <span class="client-stats-item__compare-time">This Week</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- /.client-stats-item -->
                    </div>
                    <!-- /.client-statistics -->
                </div>
                <!-- /.client-statistics-outer -->
                <div class="voucher-top-area row">
                    <div class="col-md-8">
                        <div class="voucher-filter-form">
                            <form action="" method="GET">
                                <div class="form-section row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-input">
                                                <label for="filter-by-tags">Tags</label>
                                                <select name="by-tags" class="custom-select select2-input-tags" id="filter-by-tags" multiple="multiple">
                                                    @foreach($tags as $tag)
                                                        <option value="{{ $tag->Tags }}">{{ $tag->Tags }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-6 -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="filter-by-keyword">Search</label>
                                            <div class="input-group">
                                                <input id="filter-by-keyword" name="s" type="text" class="form-control" placeholder="">
                                                <div class="input-group-append btn-group btn-has-dropdown-menu">
                                                    <button class="btn dropdown-toggle" type="button">Filter</button>
                                                    <div class="dropdown-menu">
                                                        <div class="filter-dropdown">
                                                            <div class="form-group filter-location">
                                                                <div class="form-row">
                                                                    <div class="col-md-4">
                                                                        <label for="filter-location">Location</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="input-group">
                                                                            <input id="filter-location" name="location" type="text" class="form-control add-clear-input" placeholder="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group filter-area">
                                                                <div class="form-row">
                                                                    <div class="col-md-4">
                                                                        <label for="filter-area">Area</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="input-group">
                                                                            <input id="filter-area" name="area" type="text" class="form-control add-clear-input" placeholder="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-row exp-date">
                                                                    <div class="col-md-4">
                                                                        <label>Exp Data</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="input-group form-check">
                                                                            <table>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <input class="form-check-input" type="radio" name="month" id="month-1" value="more than 1 month" checked nice-checkbox-radio>
                                                                                            <label for="month-1" class="form-check-label">> 1 Month</label>
                                                                                        </td>
                                                                                        <td>
                                                                                            <input class="form-check-input" type="radio" name="month" id="month-2" value="more than 2 month" checked nice-checkbox-radio>
                                                                                            <label for="month-2" class="form-check-label">> 2 Months</label>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <input class="form-check-input" type="radio" name="month" id="month-3" value="more than 6 month" checked nice-checkbox-radio>
                                                                                            <label for="month-1" class="form-check-label">> 6 Months</label>
                                                                                        </td>
                                                                                        <td>
                                                                                            <input class="form-check-input" type="radio" name="month" id="month-4" value="more than 1 year" checked nice-checkbox-radio>
                                                                                            <label for="month-1" class="form-check-label">> 1 Year</label>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-row">
                                                                    <div class="col-md-4">
                                                                        <label for="customRange1">Voucher Value</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="input-group voucher-input-range">
                                                                            <input type="range" id="input_slider" class="voucher-range" min="10000" max="100000000" step="500" data-default-val="500000" value="500000" data-rangeslider>
                                                                            <span class="range-output"><output class="output number-price"></output></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="filter-dropdown__buttons">
                                                                <div class="form-row">
                                                                    <div class="col-md-6">
                                                                        <a href="#" class="btn clear-all-filter">Clear all filter</a>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button class="btn cancel-filter">Cancel</button>
                                                                        <button class="btn apply-filter">Apply</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.filter-dropdown -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-6 -->
                                </div>
                                <!-- /.form-section.row -->
                            </form>
                        </div>
                        <!-- /.voucher-filter-form -->
                    </div>
                    <div class="col-md-4">
                        <div class="voucher-list-menu row">
                            <div class="col-md-3">
                                <div class="layout-switcher-group">
                                    <button class="btn switch-loop-layout-list" data-id="#loop-layout"><i class="fa fa-list"></i></button>
                                    <button class="btn switch-loop-layout-grid active" data-id="#loop-layout"><i class="fa fa-th"></i></button>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="btn-group btn-has-dropdown-menu">
                                    <button class="btn btn-primary dropdown-toggle create-new" type="button">Create New Voucher</button>
                                    <div class="dropdown-menu text-right">
                                        <ul class="list-unstyled">
                                            <li><a href="{{ route('voucher.create') }}">Create a Commercial Voucher</a></li>
                                            <li><a href="#">Merchants Customer Loyalty Voucher</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="campaign-history">
                    <form id="campaigns" action="" method="">
                        <div class="table-responsive">
                            <table id="voucherListTable" class="table campaign-list-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="first-col">
                                            <a class="popover-menu-btn" href="#">
                                                <img src="{{ asset('assets/img/icon-plus-blue.png') }}" alt="+" />
                                            </a>
                                            <div class="popover-menu-content">
                                                <ul class="list-unstyled">
                                                    <li><a href="#">Edit Checked Voucher</a></li>
                                                    <li><a href="#">Delete Checked Voucher</a></li>
                                                    <li><a href="#">Archive Checked</a></li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th>Voucher Name</i>
                                        </th>
                                        <th>Voucher Category</i>
                                        </th>
                                        <th>Merchant</i>
                                        </th>
                                        <th>Value</i>
                                        </th>
                                        <th>Amount</i>
                                        </th>
                                        <th>Validity Period</i>
                                        </th>
                                    </tr>
                                </thead>
                                {{--  <tbody>
                                    <tr>
                                        <td class="first">
                                            <div class="form-check">
                                                <input type="checkbox" value="campaign-1" class="form-check-input" nice-checkbox-radio />
                                            </div>
                                        </td>
                                        <td>CGV Buy 1 Get 1</td>
                                        <td>Entertainment</td>
                                        <td>CGV Cinemas</td>
                                        <td>100.000</td>
                                        <td>1.000</td>
                                        <td class="last">30 May - 30 Juni 2018</td>
                                    </tr>
                                    <tr>
                                        <td class="first">
                                            <div class="form-check">
                                                <input type="checkbox" value="campaign-2" class="form-check-input" nice-checkbox-radio />
                                            </div>
                                        </td>
                                        <td>Carrefour 100k Voucher</td>
                                        <td>Retail</td>
                                        <td>Carrefour</td>
                                        <td>100.000</td>
                                        <td>1.500</td>
                                        <td class="last">1 Jul - 30 Jul 2018</td>
                                    </tr>
                                    <tr>
                                        <td class="first">
                                            <div class="form-check">
                                                <input type="checkbox" value="campaign-3" class="form-check-input" nice-checkbox-radio />
                                            </div>
                                        </td>
                                        <td>Carrefour 100k Voucher</td>
                                        <td>Retail</td>
                                        <td>Carrefour</td>
                                        <td>100.000</td>
                                        <td>1.500</td>
                                        <td class="last">1 Jul - 30 Jul 2018</td>
                                    </tr>
                                </tbody>  --}}
                            </table>
                        </div>
                    </form>
                </div>
                <!-- /.campaign-history -->
            </div>
            <!-- /.content-area -->
        </div>
    </div>
    <!-- /.main-content__body -->
</div>

@endsection
@push('footer_scripts')
<script src="{{ asset('assets/vendor/rangeslider/rangeslider.min.js') }}"></script>
<script>
    $(document).ready( function () {
        var table = $('.campaign-list-table').DataTable(
            {
            "ajax": "{{ route('voucher.list.datatable') }}",
            "processing": true,
            "serverSide": true,
            "autoWidth": false,
            "lengthChange" : false,
            "pageLength": 10,
            "columns": [
                { "data": "action",className : 'p-20',searchable: false },
                { "data": "voucher_catalog_title",name:'voucher_catalog_title', className : 'p-20', searchable: true },
                { "data": "voucher_category_pid_title",name:'voucher_category_pid_title', className : 'p-20', searchable: true},
                { "data": "client_name", name:'client_name', className : 'p-20', searchable: true},
                { "data": "voucher_catalog_value_amount", name:'voucher_catalog_value_amount', className : 'p-20', searchable: true},
                { "data": "voucher_catalog_unit_price_amount", name:'voucher_catalog_unit_price_amount', className : 'p-20', searchable: true},
                { "data": "voucher_catalog_valid_end_date", name:'voucher_catalog_valid_end_date', className : 'p-20', searchable: true},
                { "data": "voucher_catalog_tags", name:'voucher_catalog_tags', className : 'p-20', searchable: true, regex:true,visible: false},
                { "data": "province", name:'province', className : 'p-20', searchable: true, regex:true,visible: false},
                { "data": "city", name:'city', className : 'p-20', searchable: true, regex:true,visible: false},
                { "data": "voucher_expiration", name:'voucher_expiration', className : 'p-20', searchable: true, regex:true,visible: false},
                { "data": "voucher_catalog_value_amount", name:'voucher_catalog_value_amount', className : 'p-20', searchable: true, regex:true,visible: false},
                { "data": "outlet_location", name:'outlet_location', className : 'p-20', searchable: true, regex:true,visible: false},
                { "data": "outlet_area", name:'outlet_area', className : 'p-20', searchable: true, regex:true,visible: false}
            ],
            "error" : function (xhr, error, thrown) {
                alert( 'You are not logged in' );
            },
            "columnDefs": [ {"targets": 0, "orderable": false} ],
            "pagingType": "full_numbers",
            "language": {
                "paginate": {
                "first": '&laquo',
                "last": '&raquo',
                "next": '&rsaquo;',
                "previous": '&lsaquo;'
                }
            }
            }
        );

         $('#filter-by-tags').on('change', function(){
            var search = [];

            $.each($('#filter-by-tags option:selected'), function(){
                    search.push($(this).val());
                    console.log($(this).val());
            });

            search = search.join('|');
            table.column(7).search(search, true, false).draw();  
        });


        $('#filter-by-keyword').on( 'keyup', function () {
            table.search( this.value ).draw();
        } );

        $('.filter-by-tags').change(function(){
            table.fnFilter($('select option:selected').text(),colNum); 
        });

        /*$('#filter-location').on('keyup', function(){
             table.search( this.value ).draw();
        });

        $('#filter-by-keyword').on( 'keyup', function () {
            table.search( this.value ).draw();
        } );
        */

        /*$.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var min = 0;
                var max = parseInt( $('#input_slider').val() );
                var price = parseInt( data[11] ); // use data for the age column
                console.log(price);

        
                if ( ( isNaN( min ) && isNaN( max ) ) ||
                    ( isNaN( min ) && price <= max ) ||
                    ( min <= price && isNaN( max ) ) ||
                    ( min <= price && price <= max ) )
                {
                    return true;
                }
                return false;
            }
        );*/
        

        $('.btn.apply-filter').click(function(e){
            e.preventDefault();
            let checkedVal = $('.form-check-input:checked').val();
            console.log($('#input_slider').val());
            
            let checked = null;

            if(checkedVal != null && checkedVal != '') {
                checked = checkedVal;
            }

            let location = $('#filter-location').val();
            let area = $('#filter-area').val();
            let keyword = $('#filter-by-keyword').val();

            
            var max = parseInt( $('#input_slider').val());
            //var price = parseFloat( table.column(11).data[11] ) || 0; 
            //console.log(price);

            table.columns(8).search($("#filter-location").val())
            .columns(9).search($("#filter-area").val())
            .columns(10).search(checked)
            .draw();

            /*$.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    console.log(data);
                    return parseInt(data[11]) <= max
                        ? true
                        : false
                }     
            );
            table.draw();
            $.fn.dataTable.ext.search.pop();
            */
        });

        $('#input_slider').change(function(){
                table.draw();
            })
    
        
    } );
    
</script>
@endpush