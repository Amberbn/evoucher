@extends('layouts/blank_page')
@section('content')
<div class="container-fluid">
    <div class="change-password-box-outer">
        <div class="change-password-box">
        <div class="logo-main">
            <a href="#" title="Prezent"><img src="{{ asset('assets/img/logo-300.png') }}" alt="Prezent"></a>
        </div>
        <form class="login-form" action="" method="POST">
            <div class="form-group">
            <label for="new-password">New Password</label>
            <div class="has-show-hide-password">
                <input name="password" type="password" class="form-control" id="new-password" placeholder="New Password">
                <div class="show-hide">
                <i class="fa fa-eye"></i>
                <span>Show</span>
                </div>
            </div>
            </div>
            <div class="form-group form-group__last-input">
            <label for="exampleInputPassword1">Type it again</label>
            <div class="has-show-hide-password">
                <input name="new-password" type="password" class="form-control" id="retype-new-password" placeholder="New Password">
                <div class="show-hide">
                <i class="fa fa-eye"></i>
                <span>Show</span>
                </div>
            </div>
            </div>
            <button type="submit" class="btn btn-wide-block btn-primary border-0">Change Password</button>
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
   
</script>
@endpush