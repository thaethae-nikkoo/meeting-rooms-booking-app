@extends('layout.frontmaster')
@section('front_body')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />


    <style>
        .fc-today {
            background: #dbdcdf59 !important
        }
    </style>

    <div class="container">

        <div class="card shadow-lg p-4">
            <div id='calendar' class="m-1"></div>
        </div>
    </div>


    <div class="modal fade" id="modalEvento" tabindex="-1" role="dialog" aria-labelledby="mymodalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title bold-700" id="mtitulo"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="date">Date : </label>
                            <input type="text" name="date" class="border-0 " id="date" value="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="time">Time : </label>
                            <input type="text" name="time" class="border-0" id="time" value="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="username">User : </label>
                            <input type="text" name="username" size="40" class="border-0" id="username"
                                value="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="email">Email : </label>
                            <input type="text" name="email" size="40" class="border-0" id="email"
                                value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="location">Location : </label>
                            <input type="text" name="location" size="40" class="border-0" id="location"
                                value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="status">Stauts : </label>
                            <input type="text" name="status" size="40" class="border-0" id="status"
                                value="">
                        </div>
                    </div>



                </div>

            </div>
        </div>
    </div>




    <script>
        $(document).ready(function() {
            var schedules = @json($events);


            $('#calendar').fullCalendar({

                header: {
                    left: 'prev, next',
                    center: 'title',
                    right: 'today'
                },
                events: schedules,
                selectable: true,
                selectHelper: true,
                showNonCurrentDates: false,
                fixedWeekCount: false,
                contentHeight: 600,
                timeFormat: 'HH:mm',
                eventDisplay: 'list-item',
                eventLimit: true, // for all non-agenda views
                views: {
                    agenda: {
                        eventLimit: 2 // adjust to 6 only for agendaWeek/agendaDay
                    }
                },
                eventClick: function(event, jsEvent, view) {
                    $('#mtitulo').html(event.title);
                    $('#date').val(event.date);
                    $('#time').val(event.time);
                    $('#username').val(event.username);
                    $('#email').val(event.email);
                    $('#location').val(event.location);
                    $('#status').val(event.status);
                    $('#modalEvento').modal();
                },


            })

        });
    </script>
@endsection
