@extends('layout.backmaster')

@section('body')


    <!-- Page Content -->
    <div class="content mx-2">
        <div>
            <h4 class="mt-0 font-weight-bold">
                @foreach ($room_name as $r_name)
                    {{ $r_name }}
                @endforeach
            </h4>

            @if (Session::has('booking_delete'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ Session::get('booking_delete') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (Session::has('nobooking_delete'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Try again</strong> {{ Session::get('nobooking_delete') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (Session::has('booking_update'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ Session::get('booking_update') }}
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

            @if (Session::has('booking_approved'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ Session::get('booking_approved') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (Session::has('no_booking'))
                <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('no_booking') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif


            @if ($bookings)
                <div class="container mt-2 table-responsive">
                    <form action="{{ url('/multiple-delete') }}" method="POST">
                        @csrf
                        <table class="table">
                            <tr>
                                <td colspan="5">
                                    <a href="{{ url('/') }}" class="btn btn-info btn-sm active" role="button"
                                        aria-pressed="true">Add New <i class="bi bi-plus-circle-fill"></i></a>


                                    <button type="submit" class="btn btn-danger btn-sm active" role="button"
                                        aria-pressed="true">
                                        Bulk Delete<i class="bi bi-trash"></i></button>
                                </td>
                                <td colspan="2">
                                    <p class="text-muted">
                                        Showing <span class="text-primary">5</span> of entries
                                    </p>

                                </td>


                            </tr>
                            <tr>
                                <th>
                                    <input type="checkbox" name="" id="chkCheckAll">

                                </th>
                                <th scope="col">Schedule ID</th>
                                <th scope="col">Topic</th>
                                <th scope="col">Schedule</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                            @foreach ($bookings as $schedule)
                                <tr>
                                    <th><input type="checkbox" class="checkBoxClass" name="ids[{{ $schedule->id }}]"
                                            value="{{ $schedule->id }}" id=""></th>
                                    <th scope="col">M-00{{ $schedule->id }}</th>
                                    <th scope="col">{{ $schedule->topic }}</th>
                                    <th scope="col">
                                        {{-- {{ $schedule->date }} --}}
                                        {{ date('j \\ F Y', strtotime($schedule->date)) }} <br>
                                        {{ date('h:i A', strtotime($schedule->start_time)) }} -
                                        {{ date('h:i A', strtotime($schedule->end_time)) }}
                                    </th>


                                    <th scope="col">{{ $schedule->email }}</th>

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


                                        <a href="{{ route('bookings.edit', $schedule->id) }}"
                                            class="badge badge-sm badge-primary text-white">Edit</a>

                                        <a data-toggle="modal" id="deleteBtn" data-id="{{ $schedule->id }}"
                                            data-target="#deleteModal" href="#"
                                            data-attr="{{ route('bookings.destroy', $schedule->id) }}"
                                            class="badge badge-sm badge-danger text-white">Delete</a>

                                        <br>
                                        @if ($schedule->status == 'denied')
                                            <a href="#" class="badge badge-sm badge-success text-white disabled"
                                                style="opacity: 0.4;">Approve</a>
                                        @else
                                            <a href="
                                        {{ url('/status/approved/' . $schedule->id) }}"
                                                class="badge badge-sm badge-success text-white">Approve</a>
                                        @endif

                                        <a data-toggle="modal" id="deniedBtn" data-target="#deniedModal"
                                            data-attr="{{ url('/status/denied/' . $schedule->id) }}" href="#"
                                            class="badge badge-sm badge-danger text-white">Deny</a>

                                    </th>
                                </tr>
                            @endforeach


                        </table>
                    </form>
                    <div class="d-lg-flex d-sm-block justify-content-end">
                        {{ $bookings->links() }}
                    </div>

                </div>
            @endif

        </div>

    </div>




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


    <!--Denied Modal-->
    <div class="modal reasonModal fade" role="dialog" id="deniedModal" tabindex="-1"
        aria-labelledby="deniedModalLabel" aria-hidden="true">
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
        // display a modal (delete modal)
        $(document).on('click', '#deleteBtn', function(event) {
            event.preventDefault();

            let href = $(this).attr('data-attr');
            $('#delModal').attr('action', href);
        });

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

    <script>
        $(function(e) {
            $("#chkCheckAll").click(function() {
                $(".checkBoxClass").prop("checked", $(this).prop('checked'));
            });
        });
    </script>

@endsection
