<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }

    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <!-- Home -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    HOME
                </a>
                @if ( Auth::check() )
                    <a class="navbar-brand" href="{{ url('/dashboard') }}">
                        DASHBOARD
                    </a>
                    <a class="navbar-brand" href="{{ url('/details') }}">
                        DETAILS
                    </a>
                    <a class="navbar-brand" href="{{ url('/logout') }}">
                        LOGOUT
                    </a>
                @else
                    <a class="navbar-brand" href="{{ url('/register') }}">
                        SIGN UP
                    </a>
                    <a class="navbar-brand" href="{{ url('/login') }}">
                        LOG IN
                    </a>
                @endif
            </div>

        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/editPermissions.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>
</html>
