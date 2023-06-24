<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Meeting Booking System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <!--Bootstrap datepicker-->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!--Bootstrap-->
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>


    <!-- Bootstrap Icon -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" />

    {{-- <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'>
    </script> --}}

    {{-- Custom Css --}}

    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('css/confirmation.css') }}" rel="stylesheet">
    <link href="{{ asset('css/schedule.css') }}" rel="stylesheet">
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/rome.css') }}" rel="stylesheet">


    <!-- Fav icon-->

    {{--
    <link rel="icon" type="image/png" href="{{ asset('media/favicon.png') }}"> --}}
</head>

<body>

    <header class="pt-4">
        <nav class="navbar navbar-expand-lg navbar-light container">
            {{-- <a class="navbar-brand" href="#">
                <img src="{{ asset('media/logo1.jpg') }}" alt="blue png" width="100px"
                    class="img-fluid d-inline-block align-text-top" />
            </a> --}}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse pl-3" id="navbarNavAltMarkup">
                <ul class="navbar-nav d-flex justify-content-between">
                    <li class="nav-item"> <a class="nav-link active" aria-current="page" href="{{ url('/') }}">
                            Home</a></li>

                    <li class="nav-item"> <a class="nav-link active" aria-current="page"
                            href="{{ url('/schedule-calendar') }}">Calendar</a> </li>

                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Launch demo modal
                    </button> --}}
                    <li class="nav-item"> <a class="nav-link active" data-toggle="modal" data-target="#emailModal"
                            href="#">
                            @yield('bookings')</a> </li>

                    @if (Auth::user())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" target="_blank"
                                    href="{{ url('/administrations') }}">Admin-panel</a></li>
                            <li><a class="dropdown-item" href="{{ url('/logout') }}">Logout</a></li>

                        </ul>
                    </li>
                    @else
                    <li class="nav-item"> <a class="nav-link active" target="_blank"
                            href="{{ url('/administrations') }}">
                            Administrations</a></li>
                    @endif



                </ul>
            </div>

        </nav>

    </header>

    @yield('front_body')


    <!-- Custom JS -->

    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'>
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/rome.js') }}"></script>

    <script type='text/javascript'>
        var myLink = document.querySelector('a[href="#"]');
        myLink.addEventListener('click', function(e) {
            e.preventDefault();
        });
    </script>

</body>



</html>