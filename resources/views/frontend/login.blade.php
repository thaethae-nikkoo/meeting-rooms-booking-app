<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E.F.R Meeting Booking System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" />


    {{-- Custom Css --}}

    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('css/confirmation.css') }}" rel="stylesheet">
    <link href="{{ asset('css/schedule.css') }}" rel="stylesheet">

    <!-- Fav icon-->

    <link rel="icon" type="image/png" href="{{ asset('media/favicon.png') }}">
</head>

<body>

    <div class="container my-xl-5 my-3">
        <!-- Login Card -->
        <div class="card py-xl-5 py-4 bg-white border-0 shadow-lg">
            <div class="d-flex align-items-center justify-content-around flex-column-reverse flex-xl-row">
                <div class="col-xl-5 col-11">
                    <!-- Title -->
                    <h3 class="login-header text-uppercase my-4 text-xl-start text-center">
                        Login into Admin Panel
                    </h3>
                    <!-- Form -->
                    @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong style="color:rgb(104, 30, 30)">{{ Session::get('error') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form action="{{ url('administrations') }}" method="POST" class="">
                        <!-- Email -->
                        @csrf
                        <div
                            class="d-flex justify-content-start align-items-center border border-3 rounded-2 p-1 px-2 bg-white mb-4">
                            <i class="bi bi-person-fill fs-5"></i>
                            <input class="form-control border-0 shadow-none" type="email" name="email" id="email"
                                placeholder="Email" required />
                        </div>
                        <!-- Password -->
                        <div
                            class="d-flex justify-content-start align-items-center border border-3 rounded-2 p-1 px-2 bg-white mb-4">
                            <i class="bi bi-lock-fill fs-5"></i>
                            <input class="form-control border-0 shadow-none" type="password" name="password"
                                id="password" placeholder="Password" required />

                            <span class="show-btn"><i class="bi bi-eye-fill fs-5"></i></span>
                        </div>
                        <button class="btn btn-dark w-100 shadow-none py-2" type="submit" name="submit">Login</button>
                        <div class="my-4">
                            <a class="forget-pw text-decoration-none" href="#">Forgot Password? Contact
                                Admininstrator</a>
                        </div>
                        <div class="my-4">
                            <a href="{{ url('/') }}" style="text-decoration:none;color:#2e499e;"><i
                                    class="bi bi-arrow-left-circle"></i>
                                &nbsp;Go Back to home page</a>
                        </div>
                    </form>
                    <!-- Copyright footer -->
                    <div class="mb-3">
                        {{-- <small>
                            &copy; Copyright <span id="year"></span>. EFR Group Public
                            Company Limited
                        </small> --}}
                        <small class="mt-5 p-0 text-center text-dark">
                            &copy; Copyright <span id="year"></span>. All right reserved.
                        </small>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('js/script.js') }}"></script>

</body>



</html>