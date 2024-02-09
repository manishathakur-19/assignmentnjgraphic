<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Add</title>
    <!-- Include Bootstrap CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Create Task</h2>
    <form method="post">
        @csrf
        <div class="form-group">
            <label for="name">Name : </label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Task Name">

            @if ($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="description">Description : </label>
            <textarea class="form-control" name="description" rows="3" placeholder="Enter Description"></textarea>
        </div>

        <div class="form-group">
          <label for="datepicker">Due Date : </label>
          <input type="date" class="form-control" id="" name="due_date" placeholder="Select Task Due Date">

          @if ($errors->has('due_date'))
           <span class="text-danger">{{ $errors->first('due_date') }}</span>
          @endif
        </div>

        <div class="form-group">
            <label for="priority">Priority : </label>
            <select class="form-control" id="priority" name="priority">
                <option value="">Select Priority</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>

          @if ($errors->has('priority'))
           <span class="text-danger">{{ $errors->first('priority') }}</span>
          @endif
        </div>

        <!-- Submit Button -->
        <a href="{{ url('/user/task') }}"> <button type="button" class="btn btn-primary">Back</button> </a>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>