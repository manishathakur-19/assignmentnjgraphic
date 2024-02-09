<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Task;
use App\Models\UserTask;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');

        $user_tasks = UserTask::where('user_id', $user_id)->get();

        $task_ids = array();

        foreach($user_tasks as $user_task)
        {
          $task_ids[] = $user_task->task_id;  
        }

        $data['tasks'] = Task::whereIn('id', $task_ids)->orderBy('created_at', 'desc')->paginate(10);

        return view('task.index', $data);
    }

    public function add(Request $request)
    {
        $user_id = $request->session()->get('user_id');

        if ($request->isMethod('get')){
          return view('task.add');
        }
        else{
            $request->validate([
            'name' => 'required',
            'due_date' => 'required',
            'priority' => 'required',
            ], [
            'name.required' => 'Please Enter Name',
            'due_date.required' => 'Please Select Due Date',
            'priority.required' => 'Please Select Priority',
            ]);

            $task_data = new Task;

            $task_data->name = $request->name;
            $task_data->description = $request->description;
            $task_data->due_date = $request->due_date;
            $task_data->priority = $request->priority;
            $task_data->created_at = date("Y-m-d H:i:s");

            $insert_task_data = $task_data->save();

            if($insert_task_data)
            {
                $user_task_data = new UserTask;

                $user_task_data->user_id = $user_id;
                $user_task_data->task_id = $task_data->id;
                $user_task_data->created_at = date("Y-m-d H:i:s");

                $insert_user_task_data = $user_task_data->save();
            }
            
            return redirect('/user/task');
        }
    }

    public function edit(Request $request, $id)
    {
        $data['task'] = Task::where('id', $id)->first();

        if ($request->isMethod('get')){
          return view('task.edit', $data);
        } else {
            $request->validate([
            'name' => 'required',
            'due_date' => 'required',
            'priority' => 'required',
            ], [
            'name.required' => 'Please Enter Name',
            'due_date.required' => 'Please Select Due Date',
            'priority.required' => 'Please Select Priority',
            ]);

            Task::updateOrCreate(
                ['id' => $id],
                $request->all()
            );
            return redirect('/user/task');
        }
        
    }

    public function destroy(Request $request)
    {
        Task::destroy($request->del_task_id);
        return redirect('/user/task');
    }

    public function get_users(Request $request)
    {
        $user_id = $request->session()->get('user_id');

        $taskId = $request->taskId;

        $users = User::where('id', '!=', $user_id)
                ->with(['userTasks' => function($query) use ($taskId) {
                    $query->where('task_id', $taskId);
                }])
                ->get();

        $users_html = '<table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th>Sr.No. <i class="fas fa-sort"></i></th>
                                <th>Name <i class="fas fa-sort"></i></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';
        $sr = 1;
        foreach ($users as $user)
        {
            $users_html .= '<tr>
                           <td> '.$sr.' </td>
                           <td> '.$user->name.' </td>';

            if($user->userTasks->isNotEmpty())
            {
             $users_html .= '<td> <a href="javascript:void(0);"><button type="button" class="btn btn-warning">Already Shared</button></a> </td>';
            }
            else
            {
             $users_html .= '<td> <button type="button" class="btn btn-primary share_user_task" data-id="'.$user->id.'" data-taskid="'.$taskId.'">Share</button> </td>';
            }

            $users_html .= '</tr>';
        }

        $users_html .= '</tbody></table>';

        $data = array(
          'confirm'  => 1,
          'users_html' => $users_html
        );

        echo json_encode($data);
    }

    public function add_user_task(Request $request)
    {
        $user_id = $request->session()->get('user_id');


        $userId = $request->userId;
        $taskId = $request->taskId;

        $user_task_data = new UserTask;

        $user_task_data->user_id = $userId;
        $user_task_data->task_id = $taskId;
        $user_task_data->created_at = date("Y-m-d H:i:s");

        $insert_user_task_data = $user_task_data->save();

        if($insert_user_task_data)
        {
           $users = User::where('id', '!=', $user_id)
                ->with(['userTasks' => function($query) use ($taskId) {
                    $query->where('task_id', $taskId);
                }])
                ->get();

           $users_html = '<table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th>Sr.No. <i class="fas fa-sort"></i></th>
                                <th>Name <i class="fas fa-sort"></i></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';
            $sr = 1;
            foreach ($users as $user)
            {
                $users_html .= '<tr>
                               <td> '.$sr.' </td>
                               <td> '.$user->name.' </td>';

                if($user->userTasks->isNotEmpty())
                {
                 $users_html .= '<td> <a href="javascript:void(0);"><button type="button" class="btn btn-warning">Already Shared</button></a> </td>';
                }
                else
                {
                 $users_html .= '<td> <button type="button" class="btn btn-primary share_user_task" data-id="'.$user->id.'" data-taskid="'.$taskId.'">Share</button> </td>';
                }

                $users_html .= '</tr>';
            }

            $users_html .= '</tbody></table>';

            $data = array(
              'confirm'  => 1,
              'users_html' => $users_html
            );

            echo json_encode($data);
        }
    }
}
