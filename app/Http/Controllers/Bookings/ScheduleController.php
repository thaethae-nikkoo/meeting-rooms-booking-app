<?php

namespace App\Http\Controllers\Bookings;

use App\Http\Controllers\Controller;
use App\Http\Controllers\VIPSlotsController;
use App\Mail\ConfirmScheduleMail;
use App\Mail\EditScheduleMail;
use App\Mail\StatusMail;
use App\Models\Bookings\Durations;
use App\Models\Bookings\GroupSlot;
use App\Models\Bookings\Schedule;

use App\Models\Bookings\VipSlot;
use App\Models\Ground;
use App\Models\Group;
use App\Models\GroupSlot2;
use App\Models\Timepicker\Time_slots;
use App\Models\Timepicker\Vip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ScheduleController extends Controller
{
    public function index()
    {
        $events = array();
        $all_schedules = Schedule::where('status', '<>', 'denied')->get();

        foreach ($all_schedules as $each_schedule) {
            $start = date('Y-m-d H:i:s', strtotime("$each_schedule->date  $each_schedule->start_time"));
            $end = date('Y-m-d H:i:s', strtotime("$each_schedule->date  $each_schedule->end"));
            $date = date('d-m-Y', strtotime($each_schedule->date));
            $start_to_end = "$each_schedule->start_time - $each_schedule->end_time";
            $location = "";
            switch ($each_schedule->room_id) {
                case 1:
                    $location = 'VIP Conference Room';
                    break;
                case 2:
                    $location = 'EFR Group Meeting Room 1';
                    break;
                case 3:
                    $location = 'EFR Group Meeting Room 2';
                    break;
            }
            $events[] = [
                'title' => $each_schedule->topic,
                'start' => $start,
                'end' => $end,
                'date' => $date,
                'username' => $each_schedule->booking_person_name,
                'email' => $each_schedule->email,
                'color' => 'white',
                'textColor' => 'black',
                'time' => $start_to_end,
                'location' => $location,
                'status' =>  $each_schedule->status,
            ];
        }


        return view('frontend.schedule_calendar', ['events' => $events]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function startTimePicker(Request $request)
    {
        $room =  $request->room_id;
        $topic = $request->topic;
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
        } elseif ($room == 3) {

            $unavailable_time = "";
            $unavailable = GroupSlot2::where('date', $date)
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
        } else {
            return 'wrong room_id';
        }
        return view('frontend.start_time', compact('room', 'topic', 'date', 'person_name', 'email', 'contact_number', 'available_slots', 'avai_slots_keys'));
    }

    public function startTimePickerEdit(Request $request)
    {

        $old_start_time = $request->start_time;
        $old_duration = $request->duration;
        $notes = $request->notes;
        $schedule_id = $request->id;
        $room =  $request->room_id;
        $topic = $request->topic;
        $link = $request->link;
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
            if ($room == 1) {
                $old_start_slot =  VipSlot::select('unavailable_slots')->where('schedule_id', $schedule_id)->get();
            } elseif ($room == 2) {
                $old_start_slot =  GroupSlot::select('unavailable_slots')->where('schedule_id', $schedule_id)->get();
            } elseif ($room == 3) {
                $old_start_slot =  GroupSlot2::select('unavailable_slots')->where('schedule_id', $schedule_id)->get();
            }
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
            if ($room == 1) {
                $old_start_slot =  VipSlot::select('unavailable_slots')->where('schedule_id', $schedule_id)->get();
            } elseif ($room == 2) {
                $old_start_slot =  GroupSlot::select('unavailable_slots')->where('schedule_id', $schedule_id)->get();
            } elseif ($room == 3) {
                $old_start_slot =  GroupSlot2::select('unavailable_slots')->where('schedule_id', $schedule_id)->get();
            }
            $avai_slots_keys = array_keys($available_slots);

            // $slots = Group::select('time_slots')->get();
        } elseif ($room == 3) {
            $unavailable_time = "";
            $unavailable = GroupSlot2::where('date', $date)
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
            if ($room == 1) {
                $old_start_slot =  VipSlot::select('unavailable_slots')->where('schedule_id', $schedule_id)->get();
            } elseif ($room == 2) {
                $old_start_slot =  GroupSlot::select('unavailable_slots')->where('schedule_id', $schedule_id)->get();
            } elseif ($room == 3) {
                $old_start_slot =  GroupSlot2::select('unavailable_slots')->where('schedule_id', $schedule_id)->get();
            }
        } else {
            return 'wrong room_id';
        }
        return view('frontend.start_time_edit', compact('schedule_id', 'old_start_time', 'old_duration', 'room', 'topic', 'date', 'person_name', 'link', 'email', 'contact_number', 'notes', 'available_slots', 'avai_slots_keys'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        // $slots = Time_slots::select('slots')->get();
        $person_name = $request->person_name;
        $email = $request->email;
        $contact_number = $request->contact_number;
        $room = $request->room_id;
        $date = $request->date;
        $topic  = $request->topic;
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
        } elseif ($room == 3) {
            $var = GroupSlot2::select('start_time')
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

        return view('frontend.create_schedule', compact('room', 'person_name', 'contact_number', 'email', 'date', 'start_time', 'topic', 'durations'));
    }

    public function createEdit(Request $request)
    {

        $schedule_id = $request->id;
        $person_name = $request->person_name;
        $email = $request->email;
        $contact_number = $request->contact_number;
        $room = $request->room_id;
        $date = $request->date;
        $link = $request->link;
        $topic  = $request->topic;
        $notes = $request->notes;
        $old_duration = $request->old_duration;
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
        } elseif ($room == 3) {
            $var = GroupSlot2::select('start_time')
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


        return view('frontend.create_schedule_edit', compact('schedule_id', 'room', 'old_duration', 'person_name', 'contact_number', 'link', 'email', 'date', 'notes', 'start_time', 'topic', 'durations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $link = $request->link;
        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $link, $match);

        $meeting_link = implode($match[0]);
        Schedule::create([
            'room_id' => $room,
            'date' =>  $date,
            'start_time' => $request->start_time,
            'end_time' => $endTime,
            'duration' => $request->duration,
            'topic' => $request->topic,
            'booking_person_name' => $request->person_name,
            'email' => $request->email,
            'phone' => $request->contact_number,
            'link' => $meeting_link,
            'notes' => $request->notes,
            'status' => 'pending',
            'reason' => null,
        ]);

        $booking = Schedule::latest()->first();
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

            VipSlot::create([

                'date' => $booking->date,
                'start_time' => $booking->start_time,
                'schedule_id' => $booking->id,
                'unavailable_slots' => $unavailable_slots,
                'status' => 'pending',

            ]);
        } elseif ($booking->room_id == 2) {
            GroupSlot::create([

                'date' => $booking->date,
                'start_time' => $booking->start_time,
                'schedule_id' => $booking->id,
                'unavailable_slots' => $unavailable_slots,
                'status' => 'pending',

            ]);
        } elseif ($booking->room_id == 3) {
            GroupSlot2::create([

                'date' => $booking->date,
                'start_time' => $booking->start_time,
                'schedule_id' => $booking->id,
                'unavailable_slots' => $unavailable_slots,
                'status' => 'pending',

            ]);
        } else {
            return 'wrong room id';
        }

        return view('frontend.confirm', compact('booking'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $email  =  $request->booking_email;
        if ($email == null) {
            return view('frontend.index');
        } else {
            $bookings = Schedule::where('email', $email)
                ->where('date', '>=', Carbon::today())
                ->orderBy('date', 'ASC')
                ->orderBy('start_time', 'ASC')->get();

            if ($bookings->count() > 0) {
                return view('frontend.show_bookings', compact('bookings'));
            } else {
                return redirect(url('/'))->with('no_data', 'No booking with this email. Please book first');
            }
        }
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
        return view('frontend.date_edit', compact('booking'));
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
        $link = $request->link;
        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $link, $match);
        $meeting_link = implode($match[0]);
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
            'link' => $meeting_link,
            'notes' => $request->notes,
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
        } elseif ($booking->room_id == 3) {
            GroupSlot2::where('schedule_id', $schedule_id)->update([

                'date' => $booking->date,
                'start_time' => $booking->start_time,
                'unavailable_slots' => $unavailable_slots,
                'status' => 'pending',

            ]);
        } else {
            return 'wrong room id';
        }

        Mail::to($booking->email)->send(new EditScheduleMail($booking));


        return view('frontend.confirm', compact('booking'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $booking = Schedule::findorFail($id);
        $schedule_id = $booking->id;

        if ($booking->room_id == 1) {
            VipSlot::where('schedule_id', $schedule_id)->delete();
        } elseif ($booking->room_id == 2) {
            GroupSlot::where('schedule_id', $schedule_id)->delete();
        } elseif ($booking->room_id == 3) {
            GroupSlot2::where('schedule_id', $schedule_id)->delete();
        } else {
            return 'wrong room id';
        }

        Mail::to($booking->email)->send(new StatusMail($booking, 'Cancelled'));

        $booking->delete();

        return redirect()->back()->with('booking_delete', 'Successfully deleted your booking');
    }
    // public function clear()
    // {
    //     $yesterday = Carbon::yesterday();
    //     $booking = Schedule::where('date', '<', $yesterday)->get();
    //     $booking->delete();
    //     return 'You cleared the schedule before yesterday';
    // }
}
