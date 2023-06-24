<?php

use Carbon\Carbon;
use App\Models\Bookings\Rooms;

use App\Models\Bookings\Schedule;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use App\Models\Bookings\Durations;
use App\Models\Ground;
use App\Models\Timepicker\Time_slots;
use App\Models\Timepicker\Vip;
use GuzzleHttp\Psr7\Request;

//Index Page

Route::get('/', function () {
    return view('frontend.index');
});

//Login / Logout to Admin Panel

Route::get('/administrations', "Auth\AuthController@login");

Route::post('/administrations', "Auth\AuthController@checkLogin");

Route::get('/logout', "Auth\AuthController@logout");

//User Frontend Schedules
//Get Schedule Calendar
Route::get('/schedule-calendar', 'Bookings\ScheduleController@index');
// Get DatePicker

Route::get('/schedule/create/{room_id}/date', function ($room_id) {
    $room = $room_id;
    return view('frontend.date', compact('room'));
});

// User View Bookings

Route::group(['namespace' => 'Bookings'], function () {
    //Strat Time Picker
    Route::get('/schedule/start-time', 'ScheduleController@startTimePicker');
    //Start Time Picker for edit page
    Route::get('/start-time-edit', 'ScheduleController@startTimePickerEdit');
    //Create Schedule Page
    Route::get('/schedule/create', 'ScheduleController@create');
    //Edit Schedule Page
    Route::get('/create-edit', 'ScheduleController@createEdit');
    // Store, Edit, Delete Schedule to database
    Route::resource('/schedule', "ScheduleController", ['except' => 'show']);
    // Show Schedule to database
    Route::get('schedule/show/', 'ScheduleController@show');
    Route::post('schedule/show/', 'ScheduleController@show');

    // Show bookings of specific user
    Route::get('/showbookings', "ScheduleController@bookings");
    // Route::post('/schedule/delete/{booking_id}', "ScheduleController@delete");
    // Clear Schedules before yesterday
    // Route::get('/clear-all-schedules', 'Bookings\ScheduleController@clear');
});

//Admin Panel // Booking Pages

Route::group(['middleware' => 'Admin', 'namespace' => 'Admin'], function () {
    // Bookings for admin panel
    Route::resource('/bookings', 'BookingsController');
    //Edit schedule for admin panel
    Route::get('/adm-start-time-edit', 'BookingsController@admstartTimePickerEdit');
    Route::get('adm-create-edit', 'BookingsController@admcreateEdit');
    //Multiple Delete
    Route::post('/multiple-delete', 'BookingsController@multipleDelete')->name('multiple-delete');
    // Approve or denied by status
    Route::get('/status/{status}/{booking_id}', 'BookingsController@updateStatus');
    //Enter Reason Denied Schedule
    Route::post('/status/{status}/{booking_id}', 'BookingsController@deniedReason');
    //Enter Reason Denied Schedule from dashboard
    Route::post('/statusbydash/{status}/{booking_id}', 'AdminPagesController@deniedfromdash');
    // Schedule Details
    Route::get('/details/{id}', 'BookingsController@getdetails');
    // Search Dashboard
    // Route::get('/search', 'BookingsController@search');

});


// Admin Panel // Dashboard

Route::group(['middleware' => 'Admin'], function () {
    Route::get('administrations/dashboard', "Admin\AdminPagesController@dashboard");
});

// Admin Panel // Administrator

Route::group(['prefix' => 'administrations', 'middleware' => 'AdminRole', 'namespace' => 'Admin'], function () {
    Route::resource('/admin', 'AdminController');
});

// Start Time

// Route::get('/s-t', function () {
//     return view('frontend.start_time');
// });

// Insert time slots to time picker table manually
// Route::get('getslots', function () {
//     Ground::create([
//         'time_slots' => '09:00:00',
//     ]);
//     Ground::create([
//         'time_slots' => '09:30:00',
//     ]);
//     Ground::create([
//         'time_slots' => '10:00:00',
//     ]);
//     Ground::create([
//         'time_slots' => '10:30:00',
//     ]);
//     Ground::create([
//         'time_slots' => '11:00:00',
//     ]);
//     Ground::create([
//         'time_slots' => '11:30:00',
//     ]);
//     Ground::create([
//         'time_slots' => '12:00:00',
//     ]);
//     Ground::create([
//         'time_slots' => '12:30:00',
//     ]);
//     Ground::create([
//         'time_slots' => '13:00:00',
//     ]);

//     Ground::create([
//         'time_slots' => '13:30:00',
//     ]);
//     Ground::create([
//         'time_slots' => '14:00:00',
//     ]);
//     Ground::create([
//         'time_slots' => '14:30:00',
//     ]);
//     Ground::create([
//         'time_slots' => '15:00:00',
//     ]);
//     Ground::create([
//         'time_slots' => '15:30:00',
//     ]);
//     Ground::create([
//         'time_slots' => '16:00:00',
//     ]);
//     Ground::create([
//         'time_slots' => '16:30:00',
//     ]);
//     Ground::create([
//         'time_slots' => '17:00:00',
//     ]);
//     return "ok";
// });

// Testing

// Route::get('/testing', function () {
//     return view('frontend.testing');
// });


// Admin Panel // Schedule Status
// Route::group(['middleware'=>'Admin'], function () {
// Route::get('/status/{status}/{booking_id}', 'Admin\BookingsController@updateStatus');
// Route::get('administrations/dashboard', "Admin\AdminpagesController@dashboard");
// Route::get('/schedule/{room_id}', 'Rooms\ScheduleController@show');

//Enter Reason Denied Schedule
// Route::post('/status/{status}/{booking_id}', 'Rooms\ScheduleController@deniedReason');
// });

//Insert rooms to rooms table manually
// Route::get('/insert', function () {
//     Rooms::create([
//         'room_name'=>'VIP Conference Room',
//     ]);
//     Rooms::create([
//         'room_name'=>'EFR Group Meeting Room',
//     ]);
//     Rooms::create([
//         'room_name'=>'Ground Meeting Room',
//     ]);
//     return 'ok';
// });

//Insert Time Slots to time_slots table
// Route::get('/insert', function () {
//     Time_slots::create([
//         'time_slots' => '09:00:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '09:30:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '10:00:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '10:30:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '11:00:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '11:30:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '12:00:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '12:30:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '13:00:00',
//     ]);

//     Time_slots::create([
//         'time_slots' => '13:30:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '14:00:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '14:30:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '15:00:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '15:30:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '16:00:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '16:30:00',
//     ]);
//     Time_slots::create([
//         'time_slots' => '17:00:00',
//     ]);
// });
