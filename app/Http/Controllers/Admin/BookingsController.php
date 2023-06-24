<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EditScheduleMail;
use App\Mail\StatusMail;
use App\Models\Bookings\GroupSlot;
use App\Models\Bookings\Rooms;
use App\Models\Bookings\Schedule;
use App\Models\Bookings\VipSlot;
use App\Models\Timepicker\Time_slots;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Input\Input;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function admstartTimePickerEdit(Request $request)
    {
        $notes = $request->notes;
        $schedule_id = $request->id;
        $room =  $request->room_id;
        $topic = $request->topic;
        $old_start_time = $request->start_time;
        $link = $request->link;
        $old_duration = $request->duration;
        $date = $request->date;
        $person_name = $request->person_name;
        $email = $request->email;
        $contact_number = $request->contact_number;

        $this->validate($request, [
            'date' => 'required',
            'date' => 'after:yesterday',
            'topic' => 'required',
            'person_name' => 'required',
            'email' => 'required',
            'contact_number' => 'required',
        ], [
            'topic.required' => 'You cannot leave topic field.',
            'date.required' => 'Please choose a specific date.',
            'date.after' => 'Schedule for your meeting so that your schedule is later than now.',
            'person_name.required' => 'You cannot leave username.',
            'email.required' => 'You cannot leave email field.',
            'contact_number' => 'You cannot leave contact number.',
        ]);

        $date = Carbon::parse($request->date)->format('Y-m-d');


        if ($room ==  1) {
            $unavailable_time = "";
            $unavailable = VipSlot::where('date', $date)

                ->where('schedule_id', '<>', $schedule_id)
                ->where('status', '<>', 'denied')
                ->get();
            foreach ($unavailable as $un) {
                $unavailable_time .= $un->unavailable_slots;
            }
            $cancel = explode(',', $unavailable_time);

            $all_slots = "";
            $slots = Time_slots::select('time_slots')->get();
            foreach ($slots as $s) {
                $all_slots .= $s->time_slots . ",";
            }
            $all = explode(',', $all_slots);
            $available_slots = array_diff($all, $cancel);

            $avai_slots_keys = array_keys($available_slots);
        } elseif ($room == 2) {
            $unavailable_time = "";
            $unavailable = GroupSlot::where('date', $date)
                ->where('schedule_id', '<>', $schedule_id)
                ->where('status', '<>', 'denied')
                ->get();
            foreach ($unavailable as $un) {
                $unavailable_time .= $un->unavailable_slots;
            }
            $cancel = explode(',', $unavailable_time);

            $all_slots = "";
            $slots = Time_slots::select('time_slots')->get();
            foreach ($slots as $s) {
                $all_slots .= $s->time_slots . ",";
            }
            $all = explode(',', $all_slots);
            $available_slots = array_diff($all, $cancel);

            $avai_slots_keys = array_keys($available_slots);

            // $slots = Group::select('time_slots')->get();
        } else {
            return 'wrong room_id';
        }
        return view('backend.backend_start_time_edit', compact('schedule_id', 'old_start_time', 'link', 'old_duration', 'room', 'topic', 'date', 'person_name', 'email', 'contact_number', 'notes', 'available_slots', 'avai_slots_keys'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function admcreateEdit(Request $request)
    {
        $schedule_id = $request->id;
        $person_name = $request->person_name;
        $email = $request->email;
        $contact_number = $request->contact_number;
        $room = $request->room_id;
        $date = $request->date;
        $link = $request->link;
        $topic  = $request->topic;

        $old_duration = $request->old_duration;
        $notes = $request->notes;
        $start_time = $request->start_time;
        $datetime = $date . ' ' . $start_time;

        $this->validate($request, [
            'start_time' => 'required',
        ], [
            'start_time.required' => 'Time Slot must be choosed.',
        ]);

        $request->merge([
            'start_time' => $datetime,
        ]);
        $this->validate($request, [
            'start_time' => 'after:' . date('Y-m-d H:i', time()),
        ], [
            'start_time.after' => 'Schedule for your meeting so that your schedule is later than now',
        ]);
        if ($room == 1) {
            $var =  VipSlot::select('start_time')
                //  start_time column from database > start_time from user request
                ->where('date', '=', $date)
                ->where('start_time', '>', $start_time)
                ->where('status', '<>', 'denied')
                ->first();
        } elseif ($room == 2) {
            $var = GroupSlot::select('start_time')
                ->where('date', '=', $date)
                ->where('start_time', '>', $start_time)
                ->where('status', '<>', 'denied')
                ->first();
        } else {
            return 'wrong room id';
        }

        $request_start_time = Carbon::parse($start_time);

        $normal_end_time = '17:30:00';

        if ($var) {
            $unavailable_start_time = Carbon::parse($var->start_time);
        } else {
            $unavailable_start_time = Carbon::parse($normal_end_time);
        }

        $totalDuration = $unavailable_start_time->diffInMinutes($request_start_time);

        $durations = [];

        for ($i = 0; $totalDuration >= 30; $i++) {

            $durations[$i] = $totalDuration;
            $totalDuration = $totalDuration - 30;
        }

        return view('backend.backend_create_schedule_edit', compact('schedule_id', 'old_duration', 'link', 'room', 'person_name', 'contact_number', 'email', 'date', 'notes', 'start_time', 'topic', 'durations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($room_id)
    {
        $room = $room_id;
        $bookings = Schedule::where('room_id', $room)
            ->where('date', '>', Carbon::yesterday())
            ->paginate(5);

        $room_name = Rooms::select('room_name')->where('id', $room)->with('schedule')->pluck('room_name');


        return view('backend.bookings', compact('bookings', 'room_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking = Schedule::find($id);
        return view('backend.backend_date_edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $schedule_id = $request->id;
        $date = Carbon::parse($request->date)->format('Y-m-d');

        $room = $request->room_id;
        $this->validate($request, [
            // 'end_time' => 'required|after:start_time'
            'duration' => 'required',
        ], [
            'duration.required' => 'At least one slot must be choosed.',

        ]);

        $endTime = Carbon::parse($request->end_time);
        $startTime = Carbon::parse($request->start_time);
        // $duration = $startTime->diff($endTime)->format('%H:%I');
        $endTime = Carbon::parse($request->start_time)->addMinutes($request->duration);

        Schedule::where('id', $schedule_id)->update([
            'room_id' => $room,
            'date' =>  $date,
            'start_time' => $request->start_time,
            'end_time' => $endTime,

            'duration' => $request->duration,
            'topic' => $request->topic,
            'booking_person_name' => $request->person_name,
            'email' => $request->email,
            'phone' => $request->contact_number,
            'notes' => $request->notes,
            'link' => $request->link,
            'status' => 'pending',
            'reason' => null,
        ]);

        $booking = Schedule::where('id', $schedule_id)->first();

        $meeting_start_time = $booking->start_time;
        $meeting_end_time = $booking->end_time;
        $unavailable_slots = "";
        $unavailable_meeting =  Time_slots::select('time_slots')
            ->whereBetween('time_slots', [$meeting_start_time, $meeting_end_time])->get();

        foreach ($unavailable_meeting as $key => $unavaiabe) {
            // array_push($unavailable_slots, $unavaiabe['time_slots']);
            $unavailable_slots .= $unavaiabe['time_slots'] . ',';
        }

        if ($booking->room_id == 1) {

            VipSlot::where('schedule_id', $schedule_id)->update([

                'date' => $booking->date,
                'start_time' => $booking->start_time,
                'unavailable_slots' => $unavailable_slots,
                'status' => 'pending',

            ]);
        } elseif ($booking->room_id == 2) {
            GroupSlot::where('schedule_id', $schedule_id)->update([

                'date' => $booking->date,
                'start_time' => $booking->start_time,
                'unavailable_slots' => $unavailable_slots,
                'status' => 'pending',

            ]);
        } else {
            return 'wrong room id';
        }

        Mail::to($booking->email)->send(new EditScheduleMail($booking));

        if ($room == 1) {
            return redirect(url('bookings/1'))->with('booking_update', 'Successfully updated your booking');
        } elseif ($room == 2) {
            return redirect(url('bookings/2'))->with('booking_update', 'Successfully updated your booking');
        } else {
            return redirect(url('bookings/3'))->with('booking_update', 'Successfully updated your booking');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room_id = Schedule::select('room_id')->where('id', $id)->first();
        $booking = Schedule::find($id);
        $schedule_id = $booking->id;

        if ($booking->room_id == 1) {

            VipSlot::where('schedule_id', $schedule_id)->delete();
        } elseif ($booking->room_id == 2) {
            GroupSlot::where('schedule_id', $schedule_id)->delete();
        } else {
            return 'wrong room id';
        }

        $booking->delete();


        Mail::to($booking->email)->send(new StatusMail($booking, 'Cancelled'));


        if ($room_id->room_id == 1) {
            return redirect(url('bookings/1'))->with('booking_delete', 'Successfully deleted your booking');
        } elseif ($room_id->room_id == 2) {
            return redirect(url('bookings/2'))->with('booking_delete', 'Successfully deleted your booking');
        } else {
            return redirect(url('bookings/3'))->with('booking_delete', 'Successfully deleted your booking');
        }
    }

    public function updateStatus($status, $booking_id)
    {
        $schedule_id = $booking_id;
        // Get Room Id for return blade file
        $data = Schedule::select('room_id', 'email')->where('id', $schedule_id)->get();

        $email = '';
        $ro_id = '';
        foreach ($data as $d) {
            $ro_id = $d->room_id;
            $email = $d->email;
        }



        // Update Status
        if ($status == 'approved') {
            Schedule::where('id', $schedule_id)->update([
                'status' => $status,
                'reason' => null,
                'action_by' => Auth::user()->name,
            ]);


            if ($ro_id == "1") {
                VipSlot::where('schedule_id', $schedule_id)->update([
                    'status' => $status,

                ]);
            } elseif ($ro_id == "2") {
                GroupSlot::where('schedule_id', $schedule_id)->update([
                    'status' => $status,

                ]);
            } else {
                return 'wrong room id';
            }

            $booking = Schedule::where('id', $schedule_id)->first();

            Mail::to($email)->send(new StatusMail($booking, 'Approved'));
            // return redirect(url('/schedule/'.$ro_id));
            return redirect()->back()->with('booking_approved', 'Successfully approved this booking');
        }
    }
    // Denied schedule (bookings for there rooms)
    public function deniedReason(Request $request, $status, $booking_id)
    {
        $schedule_id = $booking_id;
        // Get Room Id for return blade file
        $room_id = Schedule::select('room_id')->where('id', $schedule_id)->get();

        $ro_id = '';
        foreach ($room_id as $r_id) {
            $ro_id = $r_id->room_id;
        }

        Schedule::where('id', $schedule_id)->update([
            'status' => $status,
            'action_by' => Auth::user()->name,
            'reason' => $request->reason,
        ]);

        if ($ro_id == "1") {
            VipSlot::where('schedule_id', $schedule_id)->update([
                'status' => $status,

            ]);
        } elseif ($ro_id == "2") {
            GroupSlot::where('schedule_id', $schedule_id)->update([
                'status' => $status,

            ]);
        } else {
            return 'wrong room id';
        }
        $booking = Schedule::where('id', $schedule_id)->first();
        Mail::to($booking->email)->send(new StatusMail($booking, 'Denied'));
        return redirect(url('/bookings/' . $ro_id))->with('booking_denied', 'Successfully denied booking.');
    }


    public function getdetails($id)
    {
        $meeting =  Schedule::where('id', $id)->get();

        return view('backend.details', compact('meeting'));
    }

    //Multiple Delete
    public function multipleDelete(Request $request)
    {
        $ids = $request->ids;

        if ($ids) {
            Schedule::whereIn('id', $ids)->delete();
            VipSlot::whereIn('schedule_id', $ids)->delete();
            GroupSlot::whereIn('schedule_id', $ids)->delete();
            return redirect()->back()->with('booking_delete', 'Successfully deleted your booking');
        } else {
            return redirect()->back()->with('nobooking_delete', 'Choose at least one schedule to delete');
        }
    }
}
