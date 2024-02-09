<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  
<div class="container text-center">    
  <h2>Welcome {{ $user_data->name }}</h2><br>
  <div class="row">
    <div class="col-sm-4">
      <a href="{{ url('/user/logout') }}"><button type="button" class="btn btn-primary">Logout</button></a>
    </div>
    <div class="col-sm-4">
      <a href="{{ url('/user/task') }}"><button type="button" class="btn btn-primary">Tasks</button></a>
    </div>
    <div class="col-sm-4"> 
      <a href="{{ url('/user/event') }}"><button type="button" class="btn btn-primary">Events</button></a>   
    </div>
  </div>
</div><br>
</body>
</html>
