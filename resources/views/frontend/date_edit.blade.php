@extends('layout.frontmaster')
@section('front_body')
<style>
    .error {
        border: 2px solid red;
    }
</style>


<!-- Scheldule -->
<div class="container my-5">
    <div class="mb-5">
        <h2 id="heading">Re-schedule your meeting</h2>
    </div>
    <div class="">

        @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
        <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
            <strong style="color:rgb(104, 30, 30)">{{ $error }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endforeach
        @endif
        <form action="{{ url('/start-time-edit') }}" id="msform" class="form mt-5" method="get">
            @csrf

            <input type="hidden" name="room_id" value="{{ $booking->room_id }}" id="room_id">
            <input type="hidden" name="start_time" value="{{ $booking->start_time }}" id="start_time">
            <input type="hidden" name="duration" value="{{ $booking->duration }}" id="duration">
            <input type="hidden" name="link" value="{{ $booking->link }}" id="duration">
            <div class="row">
                <div class="col-xl-5 col-12">

                    <div class="mb-3">
                        {{-- <label for="date">Reservation Date <em style="color:red">*</em></label> --}}
                        <div class="input-group">
                            <input type="hidden" name="date" class="form-control datepicker" id="result"
                                autocomplete="off" readonly>

                            <div class="col-md-12">
                                <div id="inline_cal"></div>
                            </div>

                        </div>
                    </div>


                    <section class="plan cf mb-3">

                        <div class="srow">
                            <div class="col-lg-11 col-md-4 col-sm-12">
                                <input class="input" type="radio" name="room_id" id="vip" value="1" {{ $booking->room_id
                                == '1' ? 'checked' : '' }} />
                                <label class="label" class="free-label four col" for="vip">
                                    VIP Conference Room</label>

                            </div>

                            <div class="col-lg-11 col-md-4 col-sm-12">
                                <input class="input" type="radio" name="room_id" id="group" value="2" {{
                                    $booking->room_id == '2' ? 'checked' : '' }} />
                                <label class="label" class="free-label four col" for="group">
                                    EFR Group Meeting Room 1</label>
                            </div>

                            <div class="col-lg-11 col-md-4 col-sm-12">
                                <input class="input" type="radio" name="room_id" id="group" value="2" {{
                                    $booking->room_id == '3' ? 'checked' : '' }} />
                                <label class="label" class="free-label four col" for="group">
                                    EFR Group Meeting Room 2</label>
                            </div>
                        </div>

                    </section>

                </div>


                <div class="col-xl-7 col-12">
                    <div class="card py-5 px-4 shadow-lg">

                        <div class="d-flex align-items-center justify-content-center">
                            <div class="col-12">
                                <h2 class="my-3 bold-700">Your Information</h2>
                                <input type="hidden" name="notes" value="{{ $booking->notes }}">
                                <input type="hidden" name="id" value="{{ $booking->id }}">
                                <div class="mb-2">
                                    <label for="topic" class="form-label">Topic <em style="color:red">*</em></label>
                                    <input type="text" class="form-control" name="topic" id="topic"
                                        value="{{ $booking->topic }}" placeholder="" />
                                </div>

                                <div class="mb-2">
                                    <label for="person_name" class="form-label">Username <em
                                            style="color:red">*</em></label>
                                    <input type="text" class="form-control" name="person_name"
                                        value="{{ $booking->booking_person_name }}" id="person_name" placeholder="" />
                                </div>

                                <div class="mb-2">
                                    <label for="email" class="form-label">Email <em style="color:red">*</em></label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{ $booking->email }}" placeholder="xyz@gmail.com" />
                                </div>

                                <div class="mb-2">
                                    <label for="contact_number" class="form-label">Contact-Number <em
                                            style="color:red">*</em></label>
                                    <input type="text" class="form-control" id="contact_number" name="contact_number"
                                        value="{{ $booking->phone }}" placeholder="0912345678"
                                        pattern="(09|959)\d{5,10}" />
                                </div>
                                <div class="form-card">
                                    <button class="btn my-3 shadow-none action-button" name="submit" type="submit">
                                        Next
                                    </button>

                                    <a href="{{ url()->previous() }}" class="btn my-3 shadow-none action-button"
                                        role="button" aria-pressed="true">Previous</a>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
<!-- footer -->
<nav class="navbar mt-5 bg-light">
    <div class="container-fluid">
        <div class="container-fluid">
            <p class="mt-5 p-0 text-center text-dark">
                &copy; Copyright <span id="year"></span>. All right reserved.
            </p>
        </div>
    </div>
</nav>

<script>
    $('.datepicker').datepicker({


            startDate: new Date()

        });
</script>
<script type="text/javascript">
    $(function() {

            // rome(inline_cal, { time: false });


            rome(inline_cal, {
                time: false,
                inputFormat: 'MMMM DD, YYYY',


            }).on('data', function(value) {
                result.value = value;
            });

        });
</script>
@endsection