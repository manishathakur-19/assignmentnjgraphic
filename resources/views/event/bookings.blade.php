<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Bookings List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.bootstrap.min.css">

</head>
<body>

<div class="container mt-4">
  <a href="{{ url('/admin/events') }}"><button type="button" class="btn btn-primary" style="float: right;">Back</button></a>

    <a href="{{ url('/admin/logout') }}"><button type="button" class="btn btn-primary" style="float: left;">Logout</button></a>
    
    <br><br>
    <h2>{{ $event->name }} Bookings</h2>


    <!-- Table -->
    <table class="table table-bordered table-striped" id="myTable" style="margin-top: 3%;">
        <thead>
            <tr>
                <th>Sr.No. <i class="fas fa-sort"></i></th>
                <th>Name <i class="fas fa-sort"></i></th>
                <th>Email <i class="fas fa-sort"></i></th>
                <th>Booking Date <i class="fas fa-sort"></i></th>
            </tr>
        </thead>
        <tbody>
           @foreach ($event->bookings as $booking_key => $booking)
            <tr>
                <td>{{ $booking_key + 1 }}</td>
                <td>{{ $booking->user->name }}</td>
                <td>{{ $booking->user->email }}</td>
                <td>{{ $booking->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
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

});
</script>

</body>
</html>
