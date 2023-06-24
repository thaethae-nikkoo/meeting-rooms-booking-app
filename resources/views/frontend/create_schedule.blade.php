@extends('layout.frontmaster')
@section('front_body')
<style>
    .error {
        border: 2px solid red;

    }

    #radios label {
        cursor: pointer;
        position: relative;
    }

    #radios label+label {
        margin-left: 15px;
    }

    input[type="radio"] {
        opacity: 0;
        /* hidden but still tabable */
        position: absolute;
    }

    input[type="radio"]+span {
        font-family: 'Material Icons';
        color: #B3CEFB;
        border-radius: 50%;
        padding: 12px;
        transition: all 0.4s;
        -webkit-transition: all 0.4s;
    }

    input[type="radio"]:checked+span {
        color: #D9E7FD;
        background-color: #4285F4;
    }

    input[type="radio"]:focus+span {
        color: #fff;
    }
</style>

<div class="container">
    <div class=" col-xl-12 col-12 mb-xl-0 mb-5">
        <div class="card pt-4 pb-0 mt-3 mb-3">
            <h2 id="heading" class="mb-5">Schedule your meeting</h2>

            <form action="{{ route('schedule.store') }}" id="msform" method="post" class="form cf">
                @csrf
                <div class="row">
                    <div class="col-xl-6 mb-5 col-12">
                        <div class="card py-5 px-4 shadow-lg">

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

                            <h2 class="my-3 bold-700">How Long do you need?</h2>

                            <input type="hidden" class="form-control" name="person_name" value="{{ $person_name }}"
                                id="topic" placeholder="" />

                            <input type="hidden" class="form-control" name="email" value="{{ $email }}" id="topic"
                                placeholder="" />

                            <input type="hidden" class="form-control" name="contact_number"
                                value="{{ $contact_number }}" id="topic" placeholder="" />

                            <input type="hidden" class="form-control" name="topic" value="{{ $topic }}" id="topic"
                                placeholder="" />

                            <input id="dateInput" type="hidden" name="date" value="{{ $date }}"
                                class="datepicker @error('start_time') error @enderror form-control">

                            <input type="hidden" class="form-control" value="{{ $room }}" name="room_id" id="room_id"
                                placeholder="" />


                            <input type="hidden" class="form-control" value="{{ $start_time }}" name="start_time"
                                id="start_time" placeholder="" />

                            <section class="plan cf">

                                <div class="srow">


                                    @if ($durations)
                                    @for ($i = 0; $i < sizeof($durations); $i++) <div
                                        class="col-6 col-lg-4 mt-4 col-md-4 col-xs-6">
                                        <input type="radio" name="duration" id="{{ $durations[$i] }}" class="input"
                                            value="{{ $durations[$i] }}" />
                                        <label class="free-label label four col" for="{{ $durations[$i] }}">

                                            @if ($durations[$i] >= 60)
                                            {{ Str::of($durations[$i] / 60)->limit(1, ' ') }}
                                            H
                                            @else
                                            {{ Str::of($durations[$i] / 60)->limit(0, ' ') }}
                                            @endif
                                            @if ($durations[$i] % 60 > 0)
                                            {{ $durations[$i] % 60 }} M
                                            @endif

                                        </label>

                                </div>
                                @endfor
                                @endif

                        </div>
                        </section>




                    </div>
                </div>
                <div class="col-xl-6 col-12">
                    <div class="card py-5 px-4 shadow-lg">

                        <div class="d-flex align-items-center justify-content-center">
                            <div class="col-12">
                                <h2 class="my-3 bold-700">Invitation Link <span style="font-size:15px;">(for online
                                        meeting)</span></h2>
                                <div class="mb-2">

                                    <textarea name="link" class="form-control" rows="5"></textarea>

                                </div>

                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="col-12">
                                <h2 class="my-3 bold-700">Note to us</h2>
                                <div class="mb-2">

                                    <textarea name="notes" class="form-control" rows="4"></textarea>

                                </div>

                                <div class="form-card">
                                    <button class="btn my-3 shadow-none action-button" name="submit" type="submit">
                                        Submit
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
@endsection