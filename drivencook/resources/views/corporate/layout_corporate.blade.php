<!doctype html>
<html lang="fr">
<head>
    <title>Drive 'N' Cook Corporate</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="/css/app.css" rel="stylesheet">
    <style>

        .sidebar-sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 54px; /* Height of navbar */
            height: calc(100vh - 54px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark sticky-top bg-dark2 text-light justify-content-between">
    <a class="navbar-brand" href="{{route('corporate_dashboard')}}">Administration Drive 'N' Cook</a>

    <div class="nav-item dropdown" style="margin-right: 10em;">
        <button class="btn btn-dark dropdown-toggle" type="button" id="userDropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user"></i>
        </button>
        <div class="dropdown-menu bg-dark" aria-labelledby="userDropdownMenuButton">
            <a class="dropdown-item text-light" href="#">Mon compte</a>
            <a class="dropdown-item text-light" href="#">Paramètres</a>
            <a class="dropdown-item text-light" href="#">Se déconnecter</a>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <nav class="col-2 d-block bg-dark sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column text-light">
                    @yield('sidebar')
                </ul>
            </div>
        </nav>
        <div class="col-10 pt-3 px-4">

            <h1>@yield('title', 'DriveNCook.fr')</h1>


            @yield('content')
        </div>
    </div>
</div>

<script type="text/javascript" src="/js/app.js"></script>
</body>
</html>