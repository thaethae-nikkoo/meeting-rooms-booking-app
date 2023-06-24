@extends('layout.frontmaster')
@section('front_body')
@section('bookings', 'Schedules')
<!--Email Modal-->

<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title bold-700" id="emailModalLabel">Fill email to check your bookings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('schedule/show/') }}" method="get">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" class="form-control" name="booking_email" id="email"
                            placeholder="xyz@gmail.com" required />
                    </div>
                    <div class="col-12">

                        <div class="row">
                            <div class="mt-2 mb-2">
                                <button class="btn btn-lg btn-dark btn_custom" type="submit" name="submit">Go</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- Banner -->
<section class="home_banner">
    <div class="container">
        <div class="row">
            <!-- left banner -->
            <div class="col-lg-12 col-xs-12 home_banner_left">

                @if (Session::has('no_data'))
                <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">

                    <strong style="color:rgb(104, 30, 30)">{{ Session::get('no_data') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <p class="mb-1 pl-3 home_banner_content1">Hi There!</p>
                <p class="mb-1 pl-3 home_banner_content2 text-uppercase">Schedule For Your Meeting</p>
                <div>
                    <div class="list-group list-group-flush">
                        <div class="container-12 mt-5">

                            <div class="col-lg-3 col-xs-10 ">
                                <a href="{{ url('/schedule/create/1/date') }}"
                                    class="list-group-item list-group-item-action">

                                    <span class="text-white text-uppercase">VIP Conference Room</span>
                                </a>
                            </div>

                            <div class="col-lg-4 col-xs-10 my-3 ">
                                <a href="{{ url('/schedule/create/2/date') }}"
                                    class="list-group-item active list-group-item-action">
                                    <span class="text-white text-uppercase">EFR Group Meeting Room 1</span>

                                </a>
                            </div>

                            <div class="col-lg-5 col-xs-10 ">
                                <a href="{{ url('/schedule/create/3/date') }}"
                                    class="list-group-item active list-group-item-action">

                                    <span class="text-white text-uppercase">EFR Group Meeting Room 2</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Right Banner -->
            {{-- <div class="col-lg-4 col-xs-12">
                <div class="mb-3">

                    <img src="{{ asset('media/home.gif') }}" width="100%" alt="reception png" />

                </div>

            </div> --}}
        </div>

    </div>

</section>
<!-- footer -->
<nav class="navbar bg-light">
    <div class="container-fluid">
        <div class="container-fluid">
            <p class="mt-5 p-0 text-center text-dark">
                &copy; Copyright <span id="year"></span>. All right reserved.
            </p>
        </div>
    </div>
</nav>
@endsection