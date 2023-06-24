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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
    <!-- Confirmation -->
    <div class="container">
        <div class="confirmation">

            {{-- <img src="{{ asset('media/check-mark1.png') }}" class="mx-auto d-block mb-3" width="100%" alt=""> --}}

            <h2 class="bold-700 mb-5 text-center" style="color: #2e499e;">Your Booking was
                confirmed.
            </h2>
            <div class="text-start" id="invite">

                <p class="confirm-time mb-2">
                    <strong><i class="bi bi-card-heading"></i> &nbsp;Topic : &nbsp;{{ $booking->topic }}

                    </strong>
                </p>
                <p class="confirm-time mb-2">
                    <strong><i class="bi bi-person"></i> &nbsp;User : &nbsp;{{ $booking->booking_person_name }}

                    </strong>
                </p>
                <p class="confirm-time mb-2">
                    <strong> <i class="bi bi-calendar-check"></i>
                        &nbsp;{{ date('l j \\ F Y', strtotime($booking->date)) }}
                        &nbsp;
                        ,
                        {{ date('h:i A', strtotime($booking->start_time)) }} -
                        {{ date('h:i A', strtotime($booking->end_time)) }} (Asia / Rangoon)
                    </strong>
                </p>
                <p class="confirm-time mb-2">
                    <strong><i class="bi bi-geo-alt-fill"></i> &nbsp;Location: &nbsp; @if ($booking->room_id == 1)
                        VIP Conference Room
                        @elseif($booking->room_id == 2)
                        EFR Group Meeting Room 1
                        @else
                        EFR Group Meeting Room 2
                        @endif

                    </strong>
                </p>

                @if ($booking->notes != null)
                <p class="mb-2 mt-3">
                    <strong>
                        <span style="font-size:20px; color:#2e499e; font-weight:bold;">Notes:</span> &nbsp;
                    </strong>
                    <b>
                        {{ $booking->notes }}</b>
                </p>
                @endif

                {{-- <p class="confirm-time mb-5">
                    For Online Meeting Invitation.<a class="text-primary text-decoration-none"
                        href="{{url('/invitation/create/'.$booking->id)}}">
                        click here</a>
                </p> --}}


                <p class="mt-5">
                    <a href="{{ url('/') }}" style="text-decoration:none;"><i class="bi bi-arrow-left-circle"></i>
                        &nbsp;Go Back to home page</a>
                </p>
            </div>
        </div>

    </div>
    <!-- footer -->
    <nav class="navbar fixed-bottom bg-light">
        <div class="container-fluid">
            <div class="container-fluid">
                <p class="mt-5 p-0 text-center text-dark">
                    &copy; Copyright <span id="year"></span>. All right reserved.
                </p>
            </div>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <!-- Custom JS -->
    {{-- <script type="text/javascript">
        $('#dateInput').datepicker({

startDate: new Date()

});

    </script> --}}
    <script src="{{ asset('js/script.js') }}"></script>

</body>



</html>