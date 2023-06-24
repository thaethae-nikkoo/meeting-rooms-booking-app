<div style="width:90%; display:block;margin:auto; border:1px solid black;">

    <div style="display:block!important;">

        <h2 style="text-align:center;" style="font-weight:bold">Booking was updated.</h2>
        <p style="font-size:16px;padding-left:20px;">Dear {{ $booking->booking_person_name }},</p>
        <p style="padding-left:50px;font-size:16px;">I am sending this email to inform you that your meeting was updated
            to:
            <span
                style="font-weight: bold; font-size:16px; font-style:italic;">{{ date('l j \\ F Y', strtotime($booking->date)) }}
                &nbsp;
                ,
                {{ date('h:i A', strtotime($booking->start_time)) }} -
                {{ date('h:i A', strtotime($booking->end_time)) }} .</span>
            Please check the following details.
        </p>
        <div style="padding-left:70px;">

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
                @if ($booking->notes)
                    <p style="font-size: 16px;"><span style="">Notes :</span>
                        {{ $booking->notes }}</p>
                @endif
            <p style="font-size: 16px;">Status :
                <span
                    style="background-color: #efcc6c; font-weight:bold; font-style:italic; font-size:13px;color: black;padding: 4px 5px;text-align: center;border-radius: 19px;">
                    Pending</span>
            </p>

            @if ($booking->link)
                <h3>Meeting Invitation Link is here.</h3>

                <a href="{{ $booking->link }}" style="text-decoration:none;" target="_blank"> {{ $booking->link }}</a>
            @endif

        </div>
        <div style="padding: 10px 10px;">

            <a href="http://127.0.0.1:8000/schedule/{{ $booking->id }}/edit" style="text-decoration: none;">

                <button
                    style="display:block;margin:auto;font-size: 15px; border-radius:10px; font-weight: bold; border: 0;color: white; padding:15px 40px; background-color:#14283d;">
                    Edit Schedule
                </button>
            </a>

        </div>

    </div>
    <div></div>
</div>
<div style="">

    <p style="font-weight: 700;font-style:italic;">Best Regards,</p>
    <p style="font-weight: 700;font-style:italic;">EFR Information</p>
    <p style="font-weight: 700;font-style:italic;">info@efrgroupmm.com</p>

</div>
