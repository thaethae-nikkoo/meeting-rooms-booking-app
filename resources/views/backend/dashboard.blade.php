@extends('layout.backmaster')
@section('tit', 'Admin Dashboard')
@section('breadcrumb1', 'E.F.R Meeting Room Management System')
@section('body')
    <div class="container-fluid">
        <div class="text-start mb-4">
            <p class="mt-3" style="font-weight:bold; color:#2e499e";>Upcoming Schedules for today are appeared here.</p>
        </div>
        @if (Session::has('booking_denied'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Denied!</strong> {{ Session::get('booking_denied') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (Session::has('booking_approved'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ Session::get('booking_approved') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="d-flex
                justify-content-center align-items-center flex-md-row flex-wrap flex-column">

            @if (count($schedules) < 1)
                <div class="no_schedule">
                    <p>There is no schedule today.</p>
                </div>
            @else
                <div class="container mt-2 table-responsive">
                    <table class="table">
                        <tr>
                            <td colspan="5">
                                <p class="text-muted">
                                    Showing <span class="text-primary">3</span> of entries
                                </p>

                            </td>
                            <td style="padding: 0" colspan="2">

                                {{-- <form action="/search" method="GET" role="search">
                                    @csrf <div class="input-group mt-2">
                                        <input type="text" class="form-control" placeholder="Search for schedule..."
                                            aria-label="Schedule" name="search" aria-describedby="button-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit" id="button-addon2"> <i
                                                    class="bi bi-search"></i> </button>
                                        </div>
                                </form> --}}

                </div>
                </td>

                </tr>
                <tr>
                    <th scope="col">Schedule ID</th>
                    <th scope="col">Topic</th>
                    <th scope="col">Time</th>
                    <th scope="col">Room</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
                @foreach ($schedules as $schedule)
                    <tr>
                        <th scope="col">M-00{{ $schedule->id }}</th>
                        <th scope="col">{{ $schedule->topic }}</th>

                        <th scope="col">
                            {{ date('h:i A', strtotime($schedule->start_time)) }}
                        </th>
                        <th scope="col">
                            @if ($schedule->room_id == 1)
                                VIP Conference Room
                            @elseif($schedule->room_id == 2)
                                EFR Group Meeting Room
                            @else
                                Ground Floor Meeting Room
                            @endif
                        </th>
                        <th scope="col">{{ $schedule->email }} </th>
                        <th scope="col">
                            @if ($schedule->status == 'pending')
                                <span class="text-warning font-italic">Pending</span>
                            @elseif($schedule->status == 'approved')
                                <span class="text-success font-italic">Approved</span>
                            @else
                                <span class="text-danger font-italic">Denied</span>
                            @endif
                        </th>

                        <th scope="col">
                            <a href="{{ url('/details/' . $schedule->id) }}"
                                class="badge badge-sm badge-warning text-dark">Details</a>
                            <br>

                            <a href="
                                    {{ url('/status/approved/' . $schedule->id) }}"
                                class="badge badge-sm badge-success text-white">Approve</a>
                            <br> <a data-toggle="modal" id="deniedBtn" data-target="#deniedModal"
                                data-attr="{{ url('/statusbydash/denied/' . $schedule->id) }}" href="#"
                                class="badge badge-sm badge-danger text-white">Denied</a>
                        </th>
                    </tr>
                @endforeach


                </table>
                <div class="d-lg-flex d-sm-block justify-content-end">
                    {{ $schedules->links() }}
                </div>

        </div>
        @endif

    </div>
    </div>



    <!--Denied Modal-->
    <div class="modal reasonModal fade" role="dialog" id="deniedModal" tabindex="-1" aria-labelledby="deniedModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel">The reason why we denied is...</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="" id="deniModal" method="post">
                        @csrf
                        <div class="row">

                            <div class="col-12 mb-3">
                                <label for="reason " class="form-label">Reason<em style="color:red">*</em></label>
                                <textarea name="reason" id="reason" class="form-control" cols="40" rows="6" required></textarea>

                            </div>



                            <div class="col-12">
                                <button type="submit" class="btn btn-danger">Submit</button>

                            </div>
                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>


    <!--Get Reason Modal-->
    <div class="modal reasonModal fade" role="dialog" id="reasonModal" tabindex="-1" aria-labelledby="reasonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel">The reason why we denied is...</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <p id="reason">
                        <textarea name="reasonInput" class="border-0 form-control" id="reasonInput" cols="30" rows="15"
                            value=""></textarea>

                    </p>
                </div>

            </div>
        </div>
    </div>

    <script>
        // display a modal (denied modal)
        $(document).on('click', '#deniedBtn', function(event) {
            event.preventDefault();

            let href = $(this).attr('data-attr');
            $('#deniModal').attr('action', href);
        });

        // display a modal (Get Denied Reason modal)
        $(document).on('click', '#deniedReasonBtn', function(event) {
            event.preventDefault();

            let str = $(this).attr('data-item');
            $(".modal-body #reasonInput").val(str);

        });
    </script>


@endsection
