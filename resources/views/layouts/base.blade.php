<!DOCTYPE html>
<html>
<head>
    <title>GPUL Labs - @yield('title')</title>
    <meta charset="utf-8"/>
    <meta name="Author" content="Santiago Saavedra"/>
    <link rel="stylesheet" href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}"/>
</head>
<body>

<div class="container">
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="http://labs.gpul.org">GPUL Labs</a>
            </div>

            <div class="navbar-collapse">
                <ul class="nav navbar-nav">
                    @section('navbar.left')
                        <li><p class="navbar-text">This is the master sidebar</p></li>
                    @show
                </ul>

                <div class="nav navbar-nav navbar-right">
                    @section('navbar-login')
                        @if (Auth::check())
                            <p class="navbar-text">
                                {{ sprintf(_("Hello, %s"), Auth::user()['username']) }}
                            </p>
                            <ul class="nav navbar-nav">
                                <li><a href="{{ action("UserController@profile") }}">{{ _("My Profile") }}</a></li>
                                <li><a href="{{ action('AuthController@logout') }}">{{ _("Logout") }}</a></li>
                            </ul>
                        @else
                            <ul>
                                <li><a href="{{ action('AuthController@login') }}">{{ _("Login") }}</a></li>
                            </ul>
                        @endif
                    @show
                </div>
            </div>

        </div>
    </nav>
    <div id="content">
        @yield('content')
    </div>
</div>

<script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>