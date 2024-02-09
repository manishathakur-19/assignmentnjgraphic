<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Register</h2>

  @if(session()->has('message'))
  <div class="alert alert-success success_msg alert_msg_response">
  {{ session()->get('message') }}
  </div>
  @endif

  <form action="" method="post">
    @csrf
    <div class="form-group">
      <label for="name">Name : </label>
      <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
      
      @if ($errors->has('name'))
       <span class="text-danger">{{ $errors->first('name') }}</span>
      @endif
    </div>

    <div class="form-group">
      <label for="email">Email : </label>
      <input type="text" class="form-control" id="email" placeholder="Enter Email Address" name="email">

      @if ($errors->has('email'))
       <span class="text-danger">{{ $errors->first('email') }}</span>
      @endif
    </div>

    <div class="form-group">
      <label for="password">Password : </label>
      <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">

      @if ($errors->has('password'))
       <span class="text-danger">{{ $errors->first('password') }}</span>
      @endif
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

  <br>
  <p>Already have an Account? <a href="{{ url('/login') }}">Login</a> </p>

</div>

</body>
</html>

<script>
$(document).ready(function(){
    setTimeout(function(){
        $(".alert_msg_response").fadeOut("slow");
    }, 5000);
});
</script>