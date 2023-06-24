<div style="width:90%; display:block;margin:auto;">

    <div style="display:block!important;">

        <h2 style="text-align:center;" style="font-weight:bold">Booking Was Now {{ ucwords($status) }}!</h2>
        <p style="font-size:16px;padding-left:20px;">Dear {{ $booking->booking_person_name }},</p>
        <p style="padding-left:50px;font-size:16px;">I am sending this email to inform you that your meeting <span
                style="font-weight: bold; font-size:16px; font-style:italic;">
                "{{ $booking->topic }}" </span> booked
            on:
            <span
                style="font-weight: bold; font-size:16px; font-style:italic;">{{ date('l j \\ F Y', strtotime($booking->date)) }}
                &nbsp;
                ,
                {{ date('h:i A', strtotime($booking->start_time)) }} -
                {{ date('h:i A', strtotime($booking->end_time)) }} </span>was now {{ $status }}
            @if ($status == 'denied')
                by
                {{ $booking->action_by }}
            @endif

            @if ($status == 'denied')
                for the reason "{{ $booking->reason }}"
            @endif
            .

        </p>

        <div style="padding-left:50px;">

            <p style="font-size: 16px;"><span style="">Topic :</span>
                {{ $booking->topic }}</p>
            <p style="font-size: 16px;"><span style="">User :</span>
                {{ $booking->booking_person_name }}</p>
            <p style="font-size: 16px;"><span style="">Email :</span>
                {{ $booking->email }}</p>
            <p style="font-size: 16px;"><span style="">Contact Number :</span>
                {{ $booking->phone }}</p>
            <p style="font-size: 16px;"><span style="">Location
                    :</span>

                @switch($booking->room_id)
                    @case(1)
                        'VIP Conference Room'
                    @break

                    @case(2)
                        'EFR Group Meeting Room 1'
                    @break

                    @case(3)
                        'EFR Group Meeting Room 2'
                    @break

                    @default
                        'Unknown Location'
                @endswitch

            </p>
            @if ($booking->notes)
                <p style="font-size: 16px;"><span style="">Notes :</span>
                    {{ $booking->notes }}</p>
            @endif


            @if ($booking->link)
                <h3>Meeting Invitation Link is here.</h3>

                <a href="{{ $booking->link }}" style="text-decoration:none;" target="_blank"> {{ $booking->link }}</a>
            @endif

        </div>

        <p style="font-weight: 700;font-style:italic;padding-left:20px;">Best Regards,</p>
        <p style="font-weight: 700;font-style:italic;padding-left:20px;">EFR Information</p>
        <p style="font-weight: 700;font-style:italic;padding-left:20px;">info@efrgroupmm.com</p>

    </div>

</div>
