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
                                        <button class="btn btn-primary btn-add-client" type="button">Add User</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table campaign-list-table datatable" data-sort="table">
                                <thead>
                                    <tr>
                                        <th class="first-col">
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
                                        <th>Full Name <i class="fa fa-caret-down"></i></th>
                                        <th>Phone Number <i class="fa fa-caret-down"></i></th>
                                        <th>Company <i class="fa fa-caret-down"></i></th>
                                        <th>User Type <i class="fa fa-caret-down"></i></th>
                                        <th>User Role <i class="fa fa-caret-down"></i></th>
                                        <th>Last Login <i class="fa fa-caret-down"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                    <tr class="spacer">
                                        <td></td>
                                         <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="first">
                                            <div class="form-check">
                                                <input type="checkbox" value="campaign-1" class="form-check-input" nice-checkbox-radio />
                                            </div>
                                        </td>
                                        <td>sefriandsz anang</td>
                                        <td>08562605588</td>
                                        <td>PT Cloud corporation</td>
                                        <td>cloud User</td>
                                        <td>developer</td>
                                        <td class="last">Yesterday - 13.35</td>
                                    </tr>
                                    <tr class="spacer">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    {{-- <tr>
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
                                    <tr class="spacer">
                                        <td></td>
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
                                        <td class="last">Today - 16.45</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <nav aria-label="Page navigation">
                        <ul class="pagination float-right">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- /.campaign-history -->
            </div>
            <!-- /.content-area -->
        </div>
    </div>
    <!-- /.main-content__body -->
</div>
@endsection