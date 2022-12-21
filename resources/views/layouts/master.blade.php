<!DOCTYPE html>

<html lang="en">

@include('layouts.head')

<body>
    @include('layouts.menus')

    <div class="wrapper d-flex flex-column min-vh-100 bg-light">

        @include('layouts.header')

        @yield('content')

        <footer class="footer">
            <div><a href="#">CoreUI </a><a href="#">Bootstrap Admin Template</a> ©
                2022 creativeLabs.</div>
            <div class="ms-auto">Powered by&nbsp;<a href="#">CoreUI UI Components</a></div>
        </footer>
    </div>


    @include('layouts.js')

</body>

</html>
