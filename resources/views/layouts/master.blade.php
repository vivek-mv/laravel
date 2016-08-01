<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Details</title>

    <!-- Bootstrap CSS -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<!-- DataTables -->
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- App scripts -->
@stack('scripts')
</body>
</html>