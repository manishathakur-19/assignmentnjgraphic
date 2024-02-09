<!DOCTYPE html>
<html lang="en">
<head>
  <title>Booking</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  
<div class="container text-center">    
  <h2>Please Pay Rs 1500 for Event Booking</h2><br>
  <form method="post">
  @csrf
  <div class="row">
    <button type="submit" class="btn btn-primary">Pay Now</button>
  </div>
 </form>
</div><br>
</body>
</html>
