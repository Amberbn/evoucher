@extends('layouts/blank_page')
@section('title', 'Change Password')
@section('content')
<div class="container-fluid">
    <div class="change-password-box-outer">
        <div class="change-password-box">
        <div class="logo-main">
            <a href="#" title="Prezent"><img src="{{ asset('assets/img/logo-300.png') }}" alt="Prezent"></a>
        </div>
        <form class="login-form" id="change_password_form" action="{{ route('user.change.password') }}" method="POST">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ $errors->first()}}
                </div>
            @endif
            <div class="form-group">
            <label for="old-password">Old Password</label>
            <div class="has-show-hide-password">
                <input name="old_password" type="password" class="form-control" id="old-password" placeholder="Old Password" required>
                <div class="show-hide">
                <i class="fa fa-eye"></i>
                <span>Show</span>
                </div>
            </div>
            </div>
            <div class="form-group">
            <label for="new-password">New Password</label>
            <div class="has-show-hide-password">
                <input name="password" type="password" class="form-control" id="password" placeholder="New Password" required>
                <div class="show-hide">
                <i class="fa fa-eye"></i>
                <span>Show</span>
                </div>
            </div>
            </div>
            <div class="form-group form-group__last-input">
            <label for="exampleInputPassword1">Type it again</label>
            <div class="has-show-hide-password">
                <input name="password_confirmation" type="password" class="form-control" id="retype-new-password" placeholder="New Password" required>
                <div class="show-hide">
                <i class="fa fa-eye"></i>
                <span>Show</span>
                </div>
            </div>
            </div>
            <button type="submit" id="change_password_button" class="btn btn-wide-block btn-primary border-0">Change Password</button>
            <div class="login-form__info text-center">
            <p>Didnt have an account? <a href="#">Contact Us</a> to create one, or try <a href="#">our demo</a> first.</p>
            </div>
        </form>
        </div>
    </div>
    </div>
@endsection
@push('footer_scripts')
<script>
    $(document).ready(function(){
        $('#change_password_form').validate({
            errorElement: "div",
            rules: {    
                old_password: {
                    required: true,
                    minlength : 6
                },
                password: {
                    required: true,
                    minlength : 6
                },
                password_confirmation: {
                    required: true,
                    minlength : 6,
                    equalTo: "#password"
                }
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.parent().parent());
            }
        });
    });
   $('#change_password_button').click(function(){
    $('#change_password_form').submit();
   });
</script>
@endpush