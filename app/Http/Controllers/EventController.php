<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Event;
use App\Models\Task;
use App\Models\UserTask;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $data['events'] = Event::orderBy('id', 'desc')->paginate(10);

        return view('event.index', $data);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('get')){
          return view('event.add');
        }
        else{
            $request->validate([
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            ], [
            'name.required' => 'Please Enter Name',
            'start_date.required' => 'Please Select Start Date',
            'end_date.required' => 'Please Select End Date',
            ]);

            $event_data = new Event;

            $event_data->name = $request->name;
            $event_data->description = $request->description;
            $event_data->start_date = $request->start_date;
            $event_data->end_date = $request->end_date;
            $event_data->created_at = date("Y-m-d H:i:s");

            $insert_event_data = $event_data->save();
            
            if($insert_event_data)
            {
             return redirect('/admin/events');   
            }
        }
    }

    public function edit(Request $request, $id)
    {
        $event_data = Event::find($id);

        $data['event'] = $event_data;

        if ($request->isMethod('get')){
          return view('event.edit', $data);
        } else {
            $request->validate([
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            ], [
            'name.required' => 'Please Enter Name',
            'start_date.required' => 'Please Select Start Date',
            'end_date.required' => 'Please Select End Date',
            ]);

            $event_data->name = $request->name;
            $event_data->description = $request->description;
            $event_data->start_date = $request->start_date;
            $event_data->end_date = $request->end_date;
            $event_data->updated_at = date("Y-m-d H:i:s");

            $update_event_data = $event_data->update();

            if($update_event_data)
            {
               return redirect('/admin/events');
            }
        }
        
    }

    public function show_bookings(Request $request, $id)
    {
      $data['event'] = Event::with(['bookings.user'])->find($id);
      
      return view('event.bookings', $data);
    }

    public function destroy(Request $request)
    {
        Event::destroy($request->del_event_id);
        return redirect('/admin/events');
    }
}
