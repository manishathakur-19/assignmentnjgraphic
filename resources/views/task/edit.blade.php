<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Edit</title>
    <!-- Include Bootstrap CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Edit Task</h2>
    <form method="post">
        @csrf
        <div class="form-group">
            <label for="name">Name : </label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Task Name" value="{{ $task->name }}">

            @if ($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="description">Description : </label>
            <textarea class="form-control" name="description" rows="3" placeholder="Enter Description">{{ $task->description }}</textarea>
        </div>

        <div class="form-group">
          <label for="datepicker">Due Date : </label>
          <input type="date" class="form-control" name="due_date" placeholder="Select Task Due Date" value="{{ $task->due_date }}">

          @if ($errors->has('due_date'))
           <span class="text-danger">{{ $errors->first('due_date') }}</span>
          @endif
        </div>

        <div class="form-group">
            <label for="priority">Priority : </label>
            <select class="form-control" id="priority" name="priority">
                <option value="">Select Priority</option>
                <option value="low" @if($task->priority == 'low') selected @endif>Low</option>
                <option value="medium" @if($task->priority == 'medium') selected @endif>Medium</option>
                <option value="high" @if($task->priority == 'high') selected @endif>High</option>
            </select>

          @if ($errors->has('priority'))
           <span class="text-danger">{{ $errors->first('priority') }}</span>
          @endif
        </div>

        <a href="{{ url('/user/task') }}"><button type="button" class="btn btn-primary">Back</button></a>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>