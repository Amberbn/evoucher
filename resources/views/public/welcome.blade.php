@extends('layouts/blank_page')
@section('content')
<div class="container-fluid">
<div class="change-password-box-outer">
    <div class="row">
        <div class="col-6 welcome-img">
            <img src="{{ asset('assets/img/img-welcome-screen.svg') }}" alt="" class="img-responsive">
        </div>
        <div class="col-6 welcome-txt">
            <h2>Welcome To Prezent</h2>
            <p>You will now be required to change your password as it is your first time logging in. You can choose any password you like. Your password must be minimum 8 characters long, include a Capital and a number. </p>
            <button type="submit" class="btn btn-primary border-0">Change Password</button>
        </div>
    </div>
</div>
</div>
@endsection
@push('footer_scripts')
<script>
   
</script>
@endpush