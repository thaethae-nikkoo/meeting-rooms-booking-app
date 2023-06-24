<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bookings\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPagesController extends Controller
{
    public function dashboard()
    {

        $schedules = Schedule::where('date', '=', Carbon::today())
            ->orderBy('start_time', 'ASC')->paginate(3);
        return view('backend.dashboard', compact('schedules'));
    }
    // Denied schedule (dashboard)
    public function deniedfromdash(Request $request, $status, $booking_id)
    {
        $schedule_id = $booking_id;
        Schedule::where('id', $schedule_id)->update([
            'status' => $status,
            'action_by' => Auth::user()->name,
            'reason' => $request->reason,

        ]);
        return redirect(url('administrations/dashboard'))->with('booking_denied', 'Successfully denied booking.');
    }
}
