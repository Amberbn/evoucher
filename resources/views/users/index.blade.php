@extends('layouts/main')
@section('content')
<div id="main-content">
    <div class="main-content__body container-fluid">
        <div class="row justify-content-md-center">
            <div class="content-area content-area__client-detail col-md-12">
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
                                        <button class="btn btn-primary btn-add-client"  data-toggle="modal" data-target="#userMenuModal">Add User</button>
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
                                        <th>Full Name</th>
                                        <th>Phone Number</th>
                                        <th>Company</th>
                                        <th>User Type</th>
                                        <th>User Role</th>
                                        {{-- <th>Last Login</th> --}}
                                    </tr>
                                </thead>
                                {{-- <tbody>
                                    <tr>
                                        <td class="first">
                                            <div class="form-check">
                                                <input type="checkbox" value="campaign-1" class="form-check-input" nice-checkbox-radio />
                                            </div>
                                        </td>
                                        <td>Annisa Kinanti</td>
                                        <td>0812 3378 2323</td>
                                        <td>PT Sprint Asia Technology</td>
                                        <td>Prezent User</td>
                                        <td>Manager</td>
                                        <td class="last">Yesterday - 13.35</td>
                                    </tr>
                                    <tr>
                                        <td class="first">
                                        <div class="form-check">
                                            <input type="checkbox" value="campaign-2" class="form-check-input" nice-checkbox-radio />
                                        </div>
                                        </td>
                                        <td>James Kurnia Wijaya</td>
                                        <td>0818 7890 5421</td>
                                        <td>PT Bank Central Asia</td>
                                        <td>Client User</td>
                                        <td>Campaign Builder</td>
                                        <td class="last">20 Feb 2018</td>
                                    </tr>
                                    <tr>
                                        <td class="first">
                                        <div class="form-check">
                                            <input type="checkbox" value="campaign-3" class="form-check-input" nice-checkbox-radio />
                                        </div>
                                        </td>
                                        <td>Rio Nainggolan</td>
                                        <td>0812 9942 1025</td>
                                        <td>PT Sprint Asia Technology</td>
                                        <td>Prezent User</td>
                                        <td>Manager</td>
                                        <td class="last">Today - 16.25</td>
                                    </tr>
                                    <tr>
                                        <td class="first">
                                        <div class="form-check">
                                            <input type="checkbox" value="campaign-3" class="form-check-input" nice-checkbox-radio />
                                        </div>
                                        </td>
                                        <td>Dede Hermana</td>
                                        <td>0812 0540 6465</td>
                                        <td>PT Sprint Asia Technology</td>
                                        <td>Prezent User</td>
                                        <td>Manager</td>
                                        <td class="last">Today - 18.45</td>
                                    </tr>
                                </tbody> --}}
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
            "ajax": "{{ route('user.list.datatable') }}",
            "processing": true,
            "serverSide": true,
            "autoWidth": false,
            "lengthChange" : false,
            "pageLength": 10,
            "columns": [
                { "data": "action",className : 'p-20',searchable: false },
                { "data": "user_profile_name",name:'user_profile_name', className : 'p-20', searchable: true },
                { "data": "user_phone",name:'user_phone', className : 'p-20', searchable: true},
                { "data": "company", name:'company', className : 'p-20', searchable: true},
                { "data": "company", name:'company', className : 'p-20', searchable: true},
                { "data": "user_roles", name:'user_roles', className : 'p-20', searchable: true, regex:true}
            ],
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
            //var table = $('.campaign-list-table').DataTable();
            //var selectedValue = $(this).val();
            //console.log(selectedValue);
            //table.search(selectedValue).draw();
        } );
    } );
</script>
@endpush