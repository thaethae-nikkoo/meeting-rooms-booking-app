@extends('layout.frontmaster')
@section('front_body')

<!-- Page Content -->
<div class="content mx-2">


    <div class="container">


        @if (Session::has('booking_delete'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ Session::get('booking_delete') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif



        @if (Session::has('booking_denied'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Denied!</strong> {{ Session::get('booking_denied') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if (Session::has('no_booking'))
        <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Try Again!</strong>{{ Session::get('no_booking') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif



        <h4 class="mb-5 text-center" style="font-weight: bold;">Upcoming Schedules</h4>


        @if ($bookings)
        <div class="d-flex flex-wrap justify-content-around">

            @foreach ($bookings as $booking)
            <div class="col-lg-6 col-md-6 col-sm-12 mb-5">
                <div class="card rounded-lg shadow py-4">
                    <div class="pl-lg-4 text-center mb-2">
                        <div class="d-flex justify-content-between">
                            <h5 class="font-weight-bold text-center" style="color:#14283d;">
                                {{ $booking->topic }}
                            </h5>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center flex-lg-row flex-wrap flex-column">
                        <div class="">

                            <div class="pl-0 pb-lg-0 text-center">
                                <!-- <span class="badge badge-sm badge-pill badge-success">APPROVED</span> -->

                                @switch($booking->status)
                                @case('approved')
                                <span class="btn btn-sm btn-success text-bold">APPROVED</span>
                                @break

                                @case('pending')
                                <span class="btn btn-sm btn-warning text-bold">PENDING</span>
                                @break

                                @case('denied')
                                <a data-toggle="modal" data-target="#reasonModal" data-item="{{ $booking->reason }}"
                                    href="#" id="deniedReasonBtn"
                                    class=" btn btn-sm btn-danger text-white text-decoration-none">DENIED</a>

                                id="deniedReasonBtn"
                                class=" btn btn-sm btn-danger text-white text-decoration-none">DENIED</a> -->
                                @break

                                @default
                                @endswitch
                            </div>
                        </div>
                        <div class="pl-lg-5">
                            <div class="">
                                <span class="text-muted">
                                    <i class="bi bi-person-fill"></i> {{ $booking->booking_person_name }}
                                </span>
                            </div>
                            <div class="">
                                <span class="text-muted"> <i class="bi bi-geo-alt-fill"></i>
                                    @if ($booking->room_id == 1)
                                    VIP Conference Room
                                    @elseif($booking->room_id == 2)
                                    EFR Group Meeting Room 1
                                    @elseif($booking->room_id == 3)
                                    EFR Group Meeting Room 2
                                    @else
                                    Wrong meeting room ID
                                    @endif
                                </span>
                            </div>
                            <div class="">
                                <span class="text-muted">
                                    <i class="bi bi-calendar-event-fill"></i>
                                    <!-- Tuesday, 15 November 2022 -->
                                    {{ date('l j \\ F Y', strtotime($booking->date)) }}
                                </span>
                            </div>
                            <div class="">
                                <span class="text-muted">
                                    <i class="bi bi-clock-fill"></i>
                                    {{ date('h:i A', strtotime($booking->start_time)) }} to
                                    {{ date('h:i A', strtotime($booking->end_time)) }}


                                </span>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('schedule.edit', $booking->id) }}" class="btn btn-sm text-white"
                                    style="background-color: #14283d">Re-Schedule</a>
                                <a data-toggle="modal" id="deleteBtn" data-id="{{ $booking->id }}"
                                    data-target="#deleteModal" href="#"
                                    data-attr="{{ route('schedule.destroy', $booking->id) }}"
                                    class=" btn btn-sm btn-danger border-0 shadow-none text-decoration-none">
                                    CANCEL</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        @endif


        <!-- Delete Modal -->
        <div class="modal deleteModal fade" id="deleteModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Are
                            you sure want to
                            delete?</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="delModal" method="post">
                            @csrf
                            @method('DELETE')
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>



        <!--Get Reason Modal-->
        <div class="modal reasonModal fade" role="dialog" id="reasonModal" tabindex="-1"
            aria-labelledby="reasonModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">The reason why we denied is...
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <p id="reason">
                            <textarea name="reasonInput" class="border-0 form-control" id="reasonInput" cols="30"
                                rows="15" value=""></textarea>

                        </p>
                    </div>

                </div>
            </div>
        </div>


    </div>

</div>


<nav class="navbar bg-light ">
    <div class="container-fluid">
        <div class="container-fluid">
            <p class="mt-5 p-0 text-center text-dark">
                &copy; Copyright <span id="year"></span>. All right reserved.
            </p>
        </div>
    </div>
</nav>


<script>
    // display a modal (delete modal)
        $(document).on('click', '#deleteBtn', function(event) {
            event.preventDefault();

            let href = $(this).attr('data-attr');
            $('#delModal').attr('action', href);
        });


        // display a modal (Get Denied Reason modal)
        $(document).on('click', '#deniedReasonBtn', function(event) {
            event.preventDefault();

            let str = $(this).attr('data-item');
            $(".modal-body #reasonInput").val(str);

        });
</script>

@endsection