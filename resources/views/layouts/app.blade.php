
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.headerlink')
@yield('style')
@if (Auth::check())
@endif
<body class="">
    <div id="app">
      
        @yield('content')
     
    </div>
    @include('layouts.footerlink')
    @yield('scripts')
</body>
</html>

