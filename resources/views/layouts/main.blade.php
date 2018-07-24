@include('partials/header')
<body class="member-area document-resize">
<div class="site clearfix">
@include('partials/admin_top_bar')
@include('partials/side_menu')

  @yield('content')
</div>
@stack('modal')
@include('partials/footer')
@stack('footer_scripts')
</body>
</html>