<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E.F.R Meeting Room Management System</title>
    {{-- Google font/ Roboto Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!--Custom CSS -->
    {{--
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> --}}
    <!--Style CSS-->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <!-- Fav icon-->
    <link rel="icon" type="image/png" href="{{ asset('media/favicon.png') }}" />


    <!-- Bootstrap CSS  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" />

    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Bootstrap Icon -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" />


</head>

<body>
    <!-- ======= Header ======= -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top"
            style="background-color: #14283d !important">
            <a class="navbar-brand mr-auto" href="{{ url('/administrations/dashboard') }}">
                <img src="{{ asset('media/logo.png') }}" alt="logo" width="250" />
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-toggle="collapse"
                data-target="#navbarText" aria-controls="navbarText" aria-expanded="false"
                aria-label="Toggle navigation">
                <span><i class="bi bi-list text-white nav_menu"></i></span>
            </button>
            <div class="collapse navbar-collapse nav-text" id="navbarText">
                <ul class="navbar-nav mr-auto"></ul>
                <span class="navbar-nav d-flex justify-content-center align-items-center">
                    <h6 class="pt-2">
                        <a href="#">
                            <p class="navbar-text" style="color: #f4ef86 !important">
                                <i class="bi bi-person-circle ml-2 pl-5"></i>
                                @if (Auth::user() != null)
                                {{ Auth::user()->name }}
                                @endif
                            </p>
                        </a>
                    </h6>

                    <h6 class="pt-2 ml-4">
                        <a href="{{ url('/logout') }}">
                            <p class="navbar-text" style="color: #f4ef86 !important">
                                Log out<i class="bi bi-box-arrow-right m-2"></i>
                            </p>
                        </a>
                    </h6>
                </span>
            </div>
        </nav>
    </header>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <section class="container-fluid wrapper">
        <!-- Sidebar  -->
        <nav class="sidebar">
            {{-- <h6 class="sidebar-headercolor text-md text-muted p-3 m-2"> <a href="{{url('/')}}" target="_blank"><i
                        class="bi bi-globe m-1"></i>GO
                    SITE</a> </h6> --}}
            <div class="sidebar-header p-2 m-1 rounded">
                <a href="{{ url('/') }}" target="_blank">
                    <h6 id="sidebar-headercolor text-md" style="color: #14283d">
                        <i class="bi bi-globe mr-1"></i>Go To Site
                    </h6>
                </a>
            </div>
            <div class="sidebar-header p-2 m-1 rounded">
                <a href="{{ url('/administrations/dashboard') }}">
                    <h6 id="sidebar-headercolor text-md" style="color: #14283d">
                        <i class="bi bi-columns-gap mr-1"></i>Dashboard
                    </h6>
                </a>
            </div>
            <h6 class="sidebar-headercolor text-md text-muted p-3 m-1">BOOKING PAGES</h6>
            <ul class="list-unstyled pl-4">
                <li class="p-1 rounded mr-1">
                    <a href="#homeSubmenu" aria-expanded="false" class="dropdown-toggle" data-toggle="collapse"
                        style="position: relative">
                        <i class="bi bi-calendar-check-fill m-2"></i>Bookings</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li class="pl-5">
                            <a href="{{ url('/bookings/1') }}">VIP Conference Room</a>
                        </li>
                        <li class="pl-5">
                            <a href="{{ url('/bookings/2') }}">EFR Group Meeting Room 1</a>
                        </li>

                        <li class="pl-5">
                            <a href="{{ url('/bookings/3') }}">EFR Group Meeting Room 2</a>
                        </li>

                        {{-- <li class="pl-5">
                            <a href="{{ url('/bookings/3') }}">Ground FLoor Meeting Room</a>
                        </li> --}}
                    </ul>
                </li>
            </ul>

            @if (Auth::user()->role == 'Super Admin')
            <h6 class="sidebar-headercolor text-md text-muted p-3 m-2">
                ADMIN PAGES
            </h6>
            <ul class="list-unstyled">
                <li class="pl-4">
                    <a href="{{ url('/administrations/admin/show') }}"><i
                            class="bi bi-people-fill m-2"></i>Administrators</a>
                </li>

            </ul>
            {{-- <h6 class="sidebar-headercolor text-md text-muted p-3 m-2">
                SETTINGS
            </h6>
            <ul class="list-unstyled">
                <li class="pl-4">
                    <a href="#"><i class="bi bi-people-fill m-2"></i>Site
                        Settings</a>
                </li>
            </ul> --}}
            {{-- @else
            <h6 class="sidebar-headercolor text-md text-muted p-3 m-2">
                ADMINISTRATORS
            </h6>
            <ul class="list-unstyled">
                <li class="pl-4 disabled ">
                    <a href="#" class="text-muted btn-link disabled" style="pointer-events: none;"><i
                            class="bi bi-people-fill m-2"></i>Administrators</a>
                </li>
                <li class="pl-4 disabled">
                    <a href="#" class="text-muted btn-link disabled"><i
                            class="bi bi-card-checklist m-2"></i>Register</a>
                </li>
            </ul> --}}
            {{-- <h6 class="sidebar-headercolor text-md text-muted p-3 m-2">
                SETTINGS
            </h6>
            <ul class="list-unstyled">
                <li class="pl-4 disabled ">
                    <a href="#" class="text-muted btn-link disabled"><i class="bi bi-sliders2 m-2"></i>Site
                        Settings</a>
                </li>

            </ul> --}}
            @endif
        </nav>
        <!-- Page Content -->
        <div class="content mt-4 mx-1">
            <button type="button" class="sidebarCollapse btn btn_bg btn-bg btn-outline-dark shadow-none border-3">
                <i class="bi bi-list text-dark p-2"></i>
            </button>
            <div>
                <h4 style="font-weight: bold;" class="mt-3">@yield('tit')</h4>
            </div>
            <div class="container mt-4">
                @yield('body')
            </div>

            <p class="mt-5 p-0 text-center text-dark">
                &copy; Copyright <span id="year"></span>. All right reserved.
            </p>

        </div>

    </section>

    <!-- End Sidebar-->



    <!-- End Footer -->
    {{-- <script>
        // Prevent form resubmission
        if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
        }

    </script> --}}
    <script>
        document.getElementById("year").innerHTML = new Date().getFullYear();

        // *Sidebar toggle
        $(document).ready(function() {
            $(".sidebarCollapse").on("click", function() {
                $(".sidebar").toggleClass("active");
            });
        });
    </script>
    <!-- Jquery -->

    <!-- JS Bootstrap v 4.3.1 -->
    {{-- <script type="text/javascript"
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    </script> --}}

</body>
<!-- Jquery-->
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
--}}
<!-- JS Bootstrap v 4.5 -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Table -->
<script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>

<!-- Custom JS -->
<script src="{{ asset('js/javascripts.js') }}"></script>



</html>