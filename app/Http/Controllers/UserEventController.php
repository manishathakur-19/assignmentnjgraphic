<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Event;
use App\Models\UserBooking;
use App\Models\Task;
use App\Models\UserTask;

class UserEventController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');

        $events = Event::all();

        $events->each(function ($event) use ($user_id) {
        $booking = UserBooking::where('user_id', $user_id)
        ->where('event_id', $event->id)
        ->where('payment_completed', 1)
        ->first();

        $event->isBooked = $booking ? true : false;
        });

        $data['events'] = $events;

        return view('userEvent.index', $data);
    }

    public function book_event(Request $request, $id)
    {
        $user_id = $request->session()->get('user_id');

        $event_data = Event::find($id);

        $data['event'] = $event_data;

        if ($request->isMethod('get')){
          return view('userEvent.booking', $data);
        } else {
            $booking_data = new UserBooking;

            $booking_data->user_id = $user_id;
            $booking_data->event_id = $id;
            $booking_data->payment_completed = 1;
            $booking_data->created_at = date("Y-m-d H:i:s");

            $insert_booking_data = $booking_data->save();
            
            if($insert_booking_data)
            {
             return redirect('/user/event');   
            }
        }
        
    }
}
