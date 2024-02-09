<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Edit</title>
    <!-- Include Bootstrap CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Update Event</h2>
    <form method="post">
        @csrf
        <div class="form-group">
            <label for="name">Event Name : </label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Event Name" value="{{ $event->name }}">

            @if ($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="description">Event Description : </label>
            <textarea class="form-control" name="description" rows="3" placeholder="Enter Event Description">{{ $event->description }}</textarea>
        </div>

        <div class="form-group">
          <label for="datepicker">Start Date : </label>
          <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i') }}">

          @if ($errors->has('start_date'))
           <span class="text-danger">{{ $errors->first('start_date') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label for="datepicker">End Date : </label>
          <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i') }}">

          @if ($errors->has('end_date'))
           <span class="text-danger">{{ $errors->first('end_date') }}</span>
          @endif
        </div>

        <!-- Submit Button -->
        <a href="{{ url('/admin/events') }}"> <button type="button" class="btn btn-primary">Back</button> </a>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>