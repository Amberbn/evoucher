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
                                    <h5 class="client-stats-item__name">Total Merchant</h5>
                                    <div class="client-stats-item__value">482</div>
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
                                    <h5 class="client-stats-item__name">Expired Vouchers</h5>
                                    <div class="client-stats-item__value">1343 pcs</div>
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
                                    <h5 class="client-stats-item__name">Total Campaign</h5>
                                    <div class="client-stats-item__value">154</div>
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
                                    <h5 class="client-stats-item__name">All Outlets</h5>
                                    <div class="client-stats-item__value">35</div>
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
                                    <h5 class="client-stats-item__name">Total Account Payable</h5>
                                    <div class="client-stats-item__value">690000</div>
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
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      <div class="form-input">
                                                        <label for="filter-by-tags">Tags</label>
                                                        <select name="by-tags" class="custom-select select2-input-tags" id="filter-by-tags" multiple="multiple">
                                                          <option value="food-beverages">Food & Beverages</option>
                                                          <option value="retails">Retails</option>
                                                          <option value="entertainment">Entertainment</option>
                                                          <option value="beauty">Beauty</option>
                                                          <option value="hotels">Hotels</option>
                                                          <option value="holiday-packages">Holiday Packages</option>
                                                          <option value="relaxations">Relaxations</option>
                                                          <option value="others">Others</option>
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
                                            <button type="button" class="btn btn-primary btn-add-client" data-toggle="modal" data-target="#userMenuModal">Add Merchant</button>
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
                                            <th></th>
                                            <th>Merchant Name</th>
                                            <th>Category</th>
                                            <th>PIC</th>
                                            <th>Outlets</th>
                                            <th>Phone Number</th>
                                            <th>Monthly Revenua</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="first">
                                                <div class="form-check">
                                                    <input type="checkbox" value="campaign-1" class="form-check-input" nice-checkbox-radio />
                                                </div>
                                            </td>
                                            <td><img src="img/img-logo-carrefour.svg" alt=""></td>
                                            <td>Carrefour</td>
                                            <td>Retail</td>
                                            <td>Bondan Prakoso</td>
                                            <td>20</td>
                                            <td>0812 3378 2323</td>
                                            <td class="last">325.546.250</td>
                                        </tr>
                                        <tr>
                                            <td class="first">
                                            <div class="form-check">
                                                <input type="checkbox" value="campaign-2" class="form-check-input" nice-checkbox-radio />
                                            </div>
                                            </td>
                                            <td><img src="img/img-logo-cgv.svg" alt=""></td>
                                            <td>CGV Cinemas</td>
                                            <td>Entertainment</td>
                                            <td>Sukma Melati</td>
                                            <td>15</td>
                                            <td>0818 7890 5421</td>
                                            <td class="last">245.607.800</td>
                                        </tr>
                                        <tr>
                                            <td class="first">
                                            <div class="form-check">
                                                <input type="checkbox" value="campaign-3" class="form-check-input" nice-checkbox-radio />
                                            </div>
                                            </td>
                                            <td><img src="img/img-logo-goldgym.svg" alt=""></td>
                                            <td>Gold's Gym</td>
                                            <td>Activity</td>
                                            <td>Barry Prima</td>
                                            <td>35</td>
                                            <td>0812 9942 1025</td>
                                            <td class="last">234.988.500</td>
                                        </tr>
                                    </tbody>
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
<!-- <script">
    $(document).ready( function () {
        var table = $('.campaign-list-table').DataTable(
            {
            "ajax": "{{ route('merchant.list.datatable') }}",
            "processing": true,
            "serverSide": true,
            "autoWidth": false,
            "lengthChange" : false,
            "pageLength": 10,
            "columns": [
                { "data": "action",className : 'p-20',searchable: false },
                { "data": "merchant_title",name:'merchant_title', className : 'p-20', searchable: true },
                // { "data": "user_profile_name",name:'user_profile_name', className : 'p-20', searchable: true},
                // { "data": "user_phone", name:'user_phone', className : 'p-20', searchable: true},
                { "data": "merchant_bussiness_category_title", name:'merchant_bussiness_category_title', className : 'p-20', searchable: true}
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
</script> -->
@endpush