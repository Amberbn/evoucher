<div class="modal modal-user-menu fade clarfix" id="userMenuModal" tabindex="-1" role="dialog" aria-labelledby="userMenuModalLabel" aria-hidden="true">
    <div class="modal-user-menu__inner" role="document">
    <div class="user-menu-cards clearfix">
        <h2 class="modal-dialog user-menu-cards__heading">What do you want to do?</h2>
        <div class="modal-dialog modal-user-menu__content">
        <div class="modal-content">
            <div class="modal-body">
            <a href="#">
                <div class="modal-body__inner">
                <div class="cards-icon"></div>
                <h3>Create <br />
                    New Campaign</h3>
                </div>
            </a>
            </div>
        </div>
        </div>
        <!-- /.modal-dialog -->
        <div class="modal-dialog modal-user-menu__content">
        <div class="modal-content">
            <div class="modal-body">
            <a href="#">
                <div class="modal-body__inner">
                <div class="cards-icon"></div>
                <h3>Generate Vouchers</h3>
                </div>
            </a>
            </div>
        </div>
        </div>
        <!-- /.modal-dialog -->
        <div class="modal-dialog modal-user-menu__content">
        <div class="modal-content">
            <div class="modal-body">
            <a href="#">
                <div class="modal-body__inner">
                <div class="cards-icon"></div>
                <h3>Create <br />
                    New Vouchers</h3>
                </div>
            </a>
            </div>
        </div>
        </div>
        <!-- /.modal-dialog -->
        <div class="modal-dialog modal-user-menu__content">
        <div class="modal-content">
            <div class="modal-body">
            <a href="#">
                <div class="modal-body__inner">
                <div class="cards-icon"></div>
                <h3>Create Invoice</h3>
                </div>
            </a>
            </div>
        </div>
        </div>
        <!-- /.modal-dialog -->
        <div class="clearfix"></div>
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        </div>
    </div>
    </div>
</div>

<!-- /.site -->
<!-- jQuery Version 3.3.1 -->
<script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<!-- Moment Core JavaScript -->
<script src="{{ asset('assets/vendor/moment/moment.min.js') }}"></script>
<!-- Bootstrap Datetime Picker JavaScript -->
<script src="{{ asset('assets/vendor/tempusdominus/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- GreenSock JavaScript -->
<script src="{{ asset('assets/vendor/greensock/TweenMax.min.js') }}"></script>
<!-- Session JavaSctipt -->
{{-- <script src="vendor/session/jquery.session.js"></script> --}}
<script src="{{ asset('assets/vendor/session/jquery.session.js') }}"></script>
<!-- Zoom JavaScript -->
{{-- <script src="{{ asset('assets/vendor/zoom/zoom.js') }}"></script> --}}
<!-- Custom Theme JavaScript -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/vendor/add-clear/add-clear.min.js') }}"></script>
<script src="{{ asset('assets/vendor/checkradios/jquery.checkradios.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendor/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
<script>
    $(".alert").delay(4000).slideUp(200, function() {
            $(this).alert('close');
    });
</script>
<style>
    .error{
        color: red;
    }
</style>
