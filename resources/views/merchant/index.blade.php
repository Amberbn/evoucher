@extends('layouts/main')
@section('title', 'Merchant List')
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
                                                <!-- <div class="col-md-6">
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
                                                  </div> -->
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
                                            <button type="button" class="btn btn-primary btn-add-client"
                                            id="add_merchant" link-url="{{ route('merchant.create') }}">Add Merchant</button>
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
                                                        <li><a id="edit_checked_user">Edit Checked User</a></li>
                                                        <li><a id="delete_checked_user">Delete Checked Users</a></li>
                                                    </ul>
                                                </div>
                                            </th>
                                            <!-- <th></th> -->
                                            <th></th>
                                            <th>Merchant Name</th>
                                            <th>Category</th>
                                            <th>PIC</th>
                                            <th>Outlets</th>
                                            <!-- <th>Phone Number</th>
                                            <th>Monthly Revenua</th> -->
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
{{ csrf_field() }}
{{ method_field('PUT') }}
@endsection

@push('footer_scripts')
<script type="text/javascript">
    $(document).ready( function () {
        var table = $('.campaign-list-table').DataTable(
            {
            ajax: "{{ route('merchant.list.datatable') }}",
            processing: true,
            serverSide: true,
            autoWidth: false,
            lengthChange : false,
            pageLength: 10,
            "columns": [
                { "data": "action",className : 'p-20',searchable: false },
                { "data": "merchant_logo_image_url",name:'merchant_logo_image_url', className : 'p-20', searchable: true },
                { "data": "merchant_title",name:'merchant_title', className : 'p-20', searchable: true },
                { "data": "merchant_bussiness_category_title", name:'merchant_bussiness_category_title', className : 'p-20', searchable: true},
                { "data": "client_name",name:'client_name', className : 'p-20', searchable: true},
                { "data": "merchant_bussiness_category_pid", name:'merchant_bussiness_category_pid', className : 'p-20', searchable: true}
                
            ],
            error : function (xhr, error, thrown) {
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

        $('#add_merchant').click(function(){
        window.location = $(this).attr('link-url');
    });

      $('#filter-by-keyword').on( 'keyup', function () {
            table.search( this.value ).draw();
        } );

    $('#edit_checked_user').click(function(){
            let checkedValue = [];
            let checked = $('input:checked').val();
            $('input:checked').each(function(){
                checkedValue.push($(this).val());
            })
            let countChecked = checkedValue.length;

            if(countChecked > 1) {
                console.log(checkedValue);
                alert('sory you need only one item to be edited');
            }else if(countChecked == 1){
                window.location =  'merchant/'+checkedValue[0]+'/edit';
            }else{
                alert('sory you need one checked');
            }
            
    });

    $('#delete_checked_user').click(function(){
            let checkedValue = [];
            let checked = $('input:checked').val();
            $('input:checked').each(function(){
                checkedValue.push($(this).val());
            })
            let countChecked = checkedValue.length;
            console.log(countChecked);

            if(countChecked <= 0) {
               toastr.error('Please check item to be deleted');
            }else{                
                var formToken = $('input[name="_token"]').val(); 
                console.log("formToken" + formToken);
                var formMethod = $('input[name="_method"]').val();
                console.log("formMethod" + formMethod);
                var parent=$(this).parent().parent();
                
                var confirmation_text_default = 'Do you want to delete this record?';                
                
                $.confirm({
                    title: 'Confirmation Dialog',
                    content: confirmation_text_default,
                    buttons: {
                        confirm: function () {
                            $.ajax({
                                url: '{{ route('merchant.delete.custom') }}',
                                type: 'PUT',
                                data: {
                                    _token:formToken,
                                    _method:formMethod,
                                    data : checkedValue
                                },
                                success: function( data, status, xhr ) {
                                    console.log("dataaa: "+data);
                                    if ( status === 'success' ) {
                                        $(checkedValue).each(function(index, value){
                                            $('#'+value).parent().parent().parent().slideUp(300, function () {
                                            $(this).closest("tr").remove();
                                            toastr.success( 'success deleted' );
                                            console.log(checkedValue);
                                            table.draw();
                                        })
                                        })
                                    }
                                },
                                error: function( data ) {
                                    if ( status === 422 ) {
                                        toastr.error('Cannot delete this data');
                                    }
                                }
                            });
                        },
                        cancel: function () {
                        confirm = false;
                        }
                    }
                });
            }
            
        });
    });

    
</script>
@endpush