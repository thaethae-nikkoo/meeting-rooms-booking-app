@extends('layout.backmaster')
@section('tit', 'Details')
@section('breadcrumb1', 'E.F.R Meeting Room Management System')
@section('body')



    <div class="container">

        <div class="container-fluid row">

            <div class="col-lg-12 col-12 text-muted font-weight-bold mb-5 pb-5">

                @foreach ($meeting as $meet)
                    <p> <span class="font-weight-bold text-dark">Schedule ID :</span> {{ $meet->id }}</p>

                    <hr>

                    <p> <span class="font-weight-bold text-dark"> Topic :</span> {{ $meet->topic }} </p>

                    <hr>

                    <p><span class="font-weight-bold text-dark"> Schedule :</span>
                        {{ date('j \\ F Y', strtotime($meet->date)) }} ,
                        {{ date('h:i A', strtotime($meet->start_time)) }} -
                        {{ date('h:i A', strtotime($meet->end_time)) }} (Asia / Yangon)</p>

                    <hr>

                    <p><span class="font-weight-bold text-dark"> Location :</span>

                        @if ($meet->room_id == 1)
                            VIP Conference Room
                        @elseif($meet->room_id == 2)
                            EFR Group Meeting Room
                        @else
                            EFR Ground Meeting Room
                        @endif
                    </p>
                    <hr>

                    <p><span class="font-weight-bold text-dark"> Booking Person Name :</span>
                        {{ $meet->booking_person_name }}</p>
                    <hr>

                    <p><span class="font-weight-bold text-dark"> Email :</span> {{ $meet->email }}</p>

                    <hr>

                    <p><span class="font-weight-bold text-dark"> Contact Number :</span> {{ $meet->phone }}</p>

                    <hr>

                    <p><span class="font-weight-bold text-dark"> Note :</span> {{ $meet->notes }}</p>

                    <hr>

                    {{-- <p><span class="font-weight-bold text-dark"> Meeting Invitation Link :</span> <span
                            class="text-primary">{{ $meet->link }}</span></p>

                    <hr> --}}

                    <p><span class="font-weight-bold text-dark"> Status :</span> {{ ucwords($meet->status) }}</p>

                    <hr>

                    @if ($meet->status == 'denied')
                        <p><span class="font-weight-bold text-dark"> Reason :</span> {{ $meet->reason }}</p>

                        <hr>
                    @endif

                    @if ($meet->status != 'pending')
                        <p><span class="font-weight-bold text-dark"> Action By :</span> {{ $meet->action_by }}</p>

                        <hr>
                    @endif

                    <p><span class="font-weight-bold text-dark"> Created at :</span> {{ $meet->created_at }}</p>

                    <hr>

                    <p><span class="font-weight-bold text-dark"> Updated at :</span> {{ $meet->updated_at }}</p>
                @endforeach



            </div>


        </div>



    </div>





@endsection
