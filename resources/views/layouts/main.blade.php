<body class="member-area document-resize">
@include('partials/header')
<div class="site clearfix">
@include('partials/admin_top_bar')
@include('partials/side_menu')

  @yield('content')
</div>
@include('partials/footer')
@stack('footer_scripts')
</body>
</html>