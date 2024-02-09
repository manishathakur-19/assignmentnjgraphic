<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.bootstrap.min.css">

</head>
<body>

<div class="container mt-4">

    <a href="{{ url('/user/dashboard') }}"><button type="button" class="btn btn-primary" style="float: left;">Dashboard</button></a>
    <a href="{{ url('/user/logout') }}"><button type="button" class="btn btn-primary" style="float: left;margin-left: 1%;">Logout</button></a>

    <!-- Table -->
    <table class="table table-bordered table-striped" id="myTable">
        <thead>
            <tr>
                <th>Sr.No. <i class="fas fa-sort"></i></th>
                <th>Name <i class="fas fa-sort"></i></th>
                <th>Start Date <i class="fas fa-sort"></i></th>
                <th>End Date <i class="fas fa-sort"></i></th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event_key => $event)
            <tr>
                <td>{{ $event_key + 1 }}</td>
                <td>{{ $event->name }}</td>
                <td>{{ $event->start_date }}</td>
                <td>{{ $event->end_date }}</td>
                <td>
                    @if ($event->isBooked)
                     <a href="javascript:void(0);"><button type="button" class="btn btn-success" disabled>Booked Already</button></a>
                    @else
                     <a href="{{ url('/user/event/booking/'.$event->id) }}"><button type="button" class="btn btn-primary">Book Now</button></a>
                    @endif
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
<form action="{{route('event.destroy','test')}}" method="post">
{{method_field('delete')}}
{{csrf_field()}}
<div class="modal-body">
<p class="text-center">
Are you sure you want to delete this?
</p>
<input type="hidden" name="del_event_id" id="del_event_id" value="">
</div>
<div class="modal-footer">
<button type="button" class="btn btn-success" data-dismiss="modal">No, Cancel</button>
<button type="submit" class="btn btn-warning">Yes, Delete</button>
</div>
</form>
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

jQuery('body').on('click', '.deleteEvent', function() {
 var eventId = jQuery(this).data('id');
 jQuery('#del_event_id').val( eventId );
});

});
</script>

</body>
</html>
