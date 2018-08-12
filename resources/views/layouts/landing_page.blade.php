@include('partials/landing_header')
<body class="landing document-resize">
  @yield('content')
@include('partials/landing_footer')
@stack('footer_scripts')
</body>
</html>