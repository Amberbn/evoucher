@extends('layouts/main')
@section('content')
<div id="main-content">
    <div class="main-content__body container-fluid">
        <div class="row justify-content-md-center">
            <div class="content-area content-area__client-detail col-md-12">
                <div class="client-statistics-outer">
                    <div class="client-statistics clearfix">
                        <div class="client-stats-item">
                            <div class="client-stats-item__inner">
                                <a href="#">
                                    <h5 class="client-stats-item__name">Total Clients</h5>
                                    <div class="client-stats-item__value">348</div>
                                    <div class="client-stats-item__compare">
                                        <span class="client-stats-item__compare-number stats-up">13% <i class="fa fa-caret-up"></i></span>
                                        <span class="client-stats-item__compare-time">This Week</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- /.client-stats-item -->
                        <div class="client-stats-item">
                            <div class="client-stats-item__inner">
                                <a href="#">
                                    <h5 class="client-stats-item__name">Total Campaign Running</h5>
                                    <div class="client-stats-item__value">891</div>
                                    <div class="client-stats-item__compare">
                                        <span class="client-stats-item__compare-number stats-up">13% <i class="fa fa-caret-up"></i></span>
                                        <span class="client-stats-item__compare-time">This Week</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- /.client-stats-item -->
                        <div class="client-stats-item">
                            <div class="client-stats-item__inner">
                                <a href="#">
                                    <h5 class="client-stats-item__name">Total Points</h5>
                                    <div class="client-stats-item__value">12.45 M</div>
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
                                    <h5 class="client-stats-item__name">Total Deposit</h5>
                                    <div class="client-stats-item__value">132.45 B</div>
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
                                    <h5 class="client-stats-item__name">Total Account Receivable</h5>
                                    <div class="client-stats-item__value">3.54 B</div>
                                    <div class="client-stats-item__compare">
                                        <span class="client-stats-item__compare-number stats-down">5% <i class="fa fa-caret-down"></i></span>
                                        <span class="client-stats-item__compare-time">This Week</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- /.client-stats-item -->
                    </div>
                    <!-- /.client-statistics -->
                </div>
                
                <div class="campaign-history">
                        <form id="campaigns" action="" method="">
                            <div class="voucher-top-area row">
                                <div class="col-md-8">
                                    <div class="voucher-filter-form">
                                        <form action="" method="GET">
                                            <div class="form-section row">
                                            
                                            <!-- /.col-md-6 -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="filter-by-keyword">Search</label>
                                                    <div class="input-group">
                                                        <input id="filter-by-keyword" name="s" type="text" class="form-control" placeholder="">
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
                                        <div class="col-md-5 offset-md-6">
                                            <button type="button" class="btn btn-primary btn-add-client" data-toggle="modal" data-target="#userMenuModal">Create Voucher</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="userMGTTable" class="table campaign-list-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <a class="popover-menu-btn" href="#">
                                                <img src="{{ asset('assets/img/icon-plus-blue.png') }}" alt="+" />
                                                </a>
                                                <div class="popover-menu-content">
                                                    <ul class="list-unstyled">
                                                        <li><a href="#">Edit Checked User</a></li>
                                                        <li><a href="#">Delete Checked Users</a></li>
                                                        <li><a href="#">Archive Checked</a></li>
                                                    </ul>
                                                </div>
                                            </th>
                                            <th>Company Name</th>
                                            <th>PIC</th>
                                            <th>Phone Number</th>
                                            <th>Industry</th>
                                            {{--  <th>Deposit</th>
                                            <th>Campaign</th>
                                            <th>Payment Due</th>  --}}
                                        </tr>
                                    </thead>
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
<script>
    $(document).ready( function () {
        var table = $('.campaign-list-table').DataTable(
            {
            "ajax": "{{ route('client.list.datatable') }}",
            "processing": true,
            "serverSide": true,
            "autoWidth": false,
            "lengthChange" : false,
            "pageLength": 10,
            "columns": [
                { "data": "action",className : 'p-20',searchable: false },
                { "data": "client_name",name:'client_name', className : 'p-20', searchable: true },
                { "data": "client_legal_name",name:'client_legal_name', className : 'p-20', searchable: true},
                { "data": "client_tax_no", name:'client_tax_no', className : 'p-20', searchable: true},
                { "data": "industry_category_title", name:'industry_category_title', className : 'p-20', searchable: true}
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
    
        // #myInput is a <input type="text"> element
        $('#filter-by-keyword').on( 'keyup', function () {
            table.search( this.value ).draw();
        } );
    } );
    
</script>
@endpush