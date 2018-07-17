{{--  @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="user_name" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="user_name" type="email" class="form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" name="user_name" value="{{ old('user_name') }}" required autofocus>

                                @if ($errors->has('user_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  --}}
<body class="login document-resize">
<div class="site clearfix">
@include('partials/header')
<form action="{{ route('login') }}" method="POST">
@csrf
 <div class="site full-screen">
      <div class="container-fluid">
        <div class="row no-gutters">
          {{-- <div class="login-left-col col-md-6" data-img-src="img/login-image-teaser.jpg"> --}}
          <div class="login-left-col col-md-6" data-img-src="{{ asset('assets/img/login-image-teaser.jpg') }}">
            <div class="login-left-col__content">
              <h1>Gifts for everyone.</h1>
              <p><strong>Prezent</strong> gives you the best deals to help you get discounts on the best places in your city.</p>
            </div>
          </div>
          <div class="login-right-col col-md-6">
            <div class="login-right-col__inner">
              <div class="d-flex h-100">
                <div class="login-form-block justify-content-center align-self-center">
                  <div class="logo-main">
                    <a href="#" title="Prezent">
                      {{-- <img class="img-logo" src="img/logo-600.png" alt="Prezent"> --}}
                      <img class="img-logo" src="{{ asset('assets/img/logo-600.png') }}" alt="Prezent">
                    </a>
                  </div>
                  <form class="login-form">
                    <h3 class="login-form__heading text-center">Login</h3>
                     @if (session('message'))
                      <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('message') }}
                        </div>
                    @endif
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email</label>
                      <input name="user_name" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                    <div class="form-group form-group__last-input">
                      <label for="exampleInputPassword1">Password</label>
                      <div class="has-show-hide-password">
                        <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        <div class="show-hide">
                          <i class="fa fa-eye"></i>
                          <span>Show</span>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-wide-block btn-primary border-0">Login</button>
                    <div class="login-form__info text-center">
                      <p>Didn't have an account? <a href="#">Contact Us</a> to create one, or try <a href="#">our demo</a> first.</p>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.container -->
    </div>
  </form>
@include('partials/footer')
</div>
</body>

