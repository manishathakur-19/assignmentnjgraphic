<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.bootstrap.min.css">

</head>
<body>

<div class="container mt-4">
    
    <a href="{{ url('/user/task/add') }}"><button type="button" class="btn btn-primary" style="float: right;">Add Task</button></a>

    <a href="{{ url('/user/dashboard') }}"><button type="button" class="btn btn-primary" style="float: left;">Dashboard</button></a>
    <a href="{{ url('/user/logout') }}"><button type="button" class="btn btn-primary" style="float: left;margin-left: 1%;">Logout</button></a>


    <!-- Table -->
    <table class="table table-bordered table-striped" id="myTable">
        <thead>
            <tr>
                <th>Sr.No. <i class="fas fa-sort"></i></th>
                <th>Name <i class="fas fa-sort"></i></th>
                <th>Due Date <i class="fas fa-sort"></i></th>
                <th>Priority <i class="fas fa-sort"></i></th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task_key => $task)
            <tr>
                <td>{{ $task_key + 1 }}</td>
                <td>{{ $task->name }}</td>
                <td>{{ $task->due_date }}</td>
                <td>{{ $task->priority }}</td>
                <td>
                  <a href="{{ url('/user/task/edit/' . $task->id) }}" class="edit" title="" data-toggle="tooltip" data-original-title="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                  <a href="javascript:void(0);" class="delete deleteTask" title="" data-id="{{$task->id}}" data-toggle="modal" data-original-title="Delete" data-target="#delete"><i class="fa fa-trash"></i></a>

                  <a href="javascript:void(0);" class="share shareTask" title="" data-id="{{$task->id}}"><button type="button" class="btn btn-primary">Share</button></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- Delete modal -->
<div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
</div>
<form action="{{route('task.destroy','test')}}" method="post">
{{method_field('delete')}}
{{csrf_field()}}
<div class="modal-body">
<p class="text-center">
Are you sure you want to delete this?
</p>
<input type="hidden" name="del_task_id" id="del_task_id" value="">
</div>
<div class="modal-footer">
<button type="button" class="btn btn-success" data-dismiss="modal">No, Cancel</button>
<button type="submit" class="btn btn-warning">Yes, Delete</button>
</div>
</form>
</div>
</div>
</div>

<!-- Share Task modal -->
<div class="modal modal-danger fade" id="shareTask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title text-center" id="myModalLabel">Users</h4>
</div>

<div class="share_users_table_area"></div>

</div>
</div>
</div>

<!-- Include jQuery and Popper.js -->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<!-- Include Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- Include TableSorter JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/widgets/widget-storage.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/widgets/widget-filter.min.js"></script>

<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function () {
// Initialize TableSorter
$("#myTable").tablesorter({
    widgets: ['zebra', 'filter'],
    widgetOptions: {
        filter_external: '.search',
        filter_defaultFilter: { 1: '~{query}' }, // Set default filter to contains
        filter_placeholder: { search: 'Search...' },
        filter_saveFilters: true,
        filter_reset: '.reset',
        filter_hideFilters: true // Hide main filter input
    }
});

jQuery('body').on('click', '.deleteTask', function() {
 var taskId = jQuery(this).data('id');
 jQuery('#del_task_id').val( taskId );
});

jQuery('body').on('click', '.shareTask', function() {
 var taskId = jQuery(this).data('id');

 jQuery.ajax({
    method:'GET',
    url:"{{ route('get_users.action') }}",
    dataType: 'json',
    data: {_token: CSRF_TOKEN,taskId: taskId},
     beforeSend:function(){
       
      },
    success:function(data){
     if(data.confirm == 1)
     {
       $('.share_users_table_area').html(data.users_html);  

       $('#shareTask').modal('show');  
     }
    }
  });
 //jQuery('#del_task_id').val( taskId );
});

jQuery('body').on('click', '.share_user_task', function() {
 var userId = jQuery(this).data('id');
 var taskId = jQuery(this).data('taskid');

 jQuery.ajax({
    method:'GET',
    url:"{{ route('add_user_task.action') }}",
    dataType: 'json',
    data: {_token: CSRF_TOKEN,userId: userId,taskId: taskId},
     beforeSend:function(){
       
      },
    success:function(data){
     if(data.confirm == 1)
     {
       $('.share_users_table_area').html(data.users_html);
       //$('#shareTask').modal('show');  
     }

    }
  });
});

});
</script>

</body>
</html>
