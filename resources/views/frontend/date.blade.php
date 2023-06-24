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
        <h2 id="heading">Schedule your meeting</h2>
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
        <form action="{{ url('schedule/start-time') }}" id="msform" class="mt-5" method="get">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room }}" id="room_id">
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
                </div>


                <div class="col-xl-7 col-12">
                    <div class="card py-5 px-4 shadow-lg">

                        <div class="d-flex align-items-center justify-content-center">
                            <div class="col-12">
                                <h2 class="my-3 bold-700">Your Information</h2>
                                <div class="mb-2">
                                    <label for="topic" class="form-label">Topic <em style="color:red">*</em></label>
                                    <input type="text" class="form-control" value="{{ old('topic') }}" name="topic"
                                        id="topic" placeholder="" />
                                </div>

                                <div class="mb-2">
                                    <label for="person_name" class="form-label">Username <em
                                            style="color:red">*</em></label>
                                    <input type="text" class="form-control" name="person_name"
                                        value="{{ old('person_name') }}" id="person_name" placeholder="" />
                                </div>

                                <div class="mb-2">
                                    <label for="email" class="form-label">Email <em style="color:red">*</em></label>
                                    <input type="email" class="form-control" value="{{ old('email') }}" name="email"
                                        id="email" placeholder="xyz@gmail.com" />
                                </div>

                                <div class="mb-2">
                                    <label for="contact_number" class="form-label">Contact-Number <em
                                            style="color:red">*</em></label>
                                    <input type="tel" class="form-control" id="contact_number" name="contact_number"
                                        placeholder="0912345678" pattern="(09|959)\d{5,10}"
                                        value="{{ old('contact_number') }}" />
                                </div>
                                <div class="form-card">
                                    <button class="btn my-3 shadow-none action-button" name="submit" type="submit">
                                        Next
                                    </button>
                                    <a href="{{ url('/') }}" class="btn my-3 shadow-none action-button" role="button"
                                        aria-pressed="true">Previous</a>

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