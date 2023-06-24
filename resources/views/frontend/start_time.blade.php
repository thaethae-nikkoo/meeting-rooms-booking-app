@extends('layout.frontmaster')
@section('front_body')
<!-- Scheldule -->
<div class="container">
    <div class=" col-xl-12 col-12 mb-xl-0 mb-5">
        <div class="card pt-4 pb-0 mt-3 mb-3">
            <h2 id="heading" class="mb-5">Schedule your meeting</h2>
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

                @if ($avai_slots_keys)
                <h2 class="my-3 bold-700">Choose Your Start Time</h2>
                <form action="{{ url('/schedule/create') }}" method="get" class="form cf">
                    @csrf
                    <input type="hidden" class="form-control" name="topic" value="{{ $topic }}" id="topic"
                        placeholder="" />

                    <input type="hidden" class="form-control" name="person_name" value="{{ $person_name }}" id="topic"
                        placeholder="" />

                    <input type="hidden" class="form-control" name="email" value="{{ $email }}" id="topic"
                        placeholder="" />

                    <input type="hidden" class="form-control" name="contact_number" value="{{ $contact_number }}"
                        id="topic" placeholder="" />


                    <input id="dateInput" type="hidden" name="date" value="{{ $date }}" class="datepicker form-control">

                    <input type="hidden" class="form-control" value="{{ $room }}" name="room_id" id="room_id"
                        placeholder="" />

                    <section class="plan cf">

                        <div class="srow">


                            @for ($i = 0; $i < sizeof($avai_slots_keys); $i++) <div class="col-lg-2 col-md-4 col-sm-12">
                                <input class="input" type="radio" name="start_time"
                                    id="  {{ date('h:i A', strtotime($available_slots[$avai_slots_keys[$i]])) }}"
                                    value="{{ $available_slots[$avai_slots_keys[$i]] }}" />
                                <label class="label" class="free-label four col"
                                    for="  {{ date('h:i A', strtotime($available_slots[$avai_slots_keys[$i]])) }}">
                                    {{ date('h:i A', strtotime($available_slots[$avai_slots_keys[$i]])) }}</label>

                        </div>
                        @endfor



                    </section>

                    <div class="mt-5" id="msform">

                        <div class="form-card">
                            <button class="btn my-3 shadow-none action-button" name="submit" type="submit">
                                Next
                            </button>

                            <a href="{{ url()->previous() }}" class="btn my-3 shadow-none action-button" role="button"
                                aria-pressed="true">Previous</a>


                        </div>

                    </div>
                </form>
                @else
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                        <strong style="color: red;">Sorry!</strong> This meeting room is already
                        occupied in {{ date(' d.m.Y', strtotime($date)) }}.
                        {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> --}}
                    </div>
                    <p></p>
                </div>


            </div>
            @endif
        </div>

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