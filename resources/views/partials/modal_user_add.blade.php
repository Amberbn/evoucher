<div class="modal modal-user-menu fade clarfix" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-user-menu__inner" role="document">
        <div class="custom1-cards clearfix">
            <h2 class="modal-dialog custom1-cards__heading">What type of user would you like to add?</h2>
            <div class="modal-dialog modal-custom1__content">
                <div class="modal-content">
                    <div class="modal-body">
                        <a href="{{ route('user.create') }}?type=client">
                            <div class="modal-body__inner">
                                <img src="{{ asset('assets/img/img-client-user.svg') }}" alt="">
                                <h3>Client User</h3>
                                <p>Lorem ipsum dolor sit amet, nonumy eleifend at vel. His ei accusata principes.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.modal-dialog -->
            <div class="modal-dialog modal-custom1__content">
                <div class="modal-content">
                    <div class="modal-body">
                        <a href="{{ route('user.create') }}?type=present">
                            <div class="modal-body__inner">
                                <img src="{{ asset('assets/img/img-prezent-user.svg') }}" alt="">
                                <h3>Prezent User</h3>
                                <p>Lorem ipsum dolor sit amet, nonumy eleifend at vel. His ei accusata principes.</p>
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