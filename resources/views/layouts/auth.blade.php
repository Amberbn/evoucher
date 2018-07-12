<body class="login document-resize">
<div class="site clearfix">
@include('partials/header')
<form action="{{ route('auth.login') }}" method="POST">
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
