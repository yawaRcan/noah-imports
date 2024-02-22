@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Calender</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
            <li class="breadcrumb-item active">Parcel Calender</li>
        </ol>
    </div>
    <div class="col-md-7 col-12 align-self-center d-none d-md-block">
        <div class="d-flex mt-2 justify-content-end">
            <div class="d-flex me-3 ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>THIS MONTH</small></h6>
                    <h4 class="mt-0 text-info">ƒ {{$cm_paid_parcels_amount}} ANG</h4>
                </div>
                <div class="spark-chart">
                    <div id="monthchart"></div>
                </div>
            </div>
            <div class="d-flex me-3 ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>LAST MONTH</small></h6>
                    <h4 class="mt-0 text-primary">ƒ {{$lm_paid_parcels_amount}} ANG</h4>
                </div>
                <div class="spark-chart">
                    <div id="lastmonthchart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="card-body calender-sidebar">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit modal content -->
<div class="modal fade" id="ni-currency-edit" tabindex="-1" aria-labelledby="ni-currency-edit" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Shipment Mode</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="currency-edit">

            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


@endsection

@push('footer-script')
<script>
    ! function($) {
        "use strict";
        var eventMyObj = '';
        var CalendarApp = function() {
            this.$body = $("body")
            this.$calendar = $('#calendar'),
                eventMyObj = this.$event = ('#calendar-events div.calendar-events'),
                this.$categoryForm = $('#add-new-event form'),
                this.$extEvents = $('#calendar-events'),
                this.$modal = $('#my-event'),
                this.$saveCategoryBtn = $('.save-category'),
                this.$calendarObj = null
        };


           /* on drop */
           CalendarApp.prototype.onDrop = function(eventObj, date) {
               
          
            },
            /* on click on event */
            CalendarApp.prototype.onEventClick = function(calEvent, jsEvent, view) {

                var $this = this;
                let url = "{{route('parcel.show',['id' => ':id'])}}";
                url = url.replace(':id', calEvent.id);
                window.open(url, "_blank");
            },
            /* on select */
            CalendarApp.prototype.onSelect = function(start, end, allDay) {

                var $this = this;


            },
            CalendarApp.prototype.enableDrag = function() {

                //init events
                $(this.$event).each(function() {
                    // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                    // it doesn't need to have a start or end
                    var eventObject = {
                        title: $.trim($(this).text()) // use the element's text as the event title
                    };
                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject);
                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 999,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0 //  original position after the drag
                    });
                });
            };
        $(document).on("mouseenter", ".fc-event-container", function() {
            $(this).draggable({
                // Event handler for when dragging starts
                start: function(calEvent, jsEvent, view) {
                    console.log("Dragging started");
                    // Perform any desired action here
                },

                // Event handler for when dragging stops
                stop: function(calEvent, jsEvent, view) {
                    console.log(calEvent);
                    // Perform any desired action here
                }
            });
        });
 



        /* Initializing */
        CalendarApp.prototype.init = function() {
                this.enableDrag();
                /*  Initialize the calendar  */
                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();
                var form = '';
                var today = new Date($.now());

                var events = [
                    @foreach($parcels as $val) {
                        title: "{{date('d-M', strtotime($val->es_delivery_date))}}",
                        start: "{{$val->es_delivery_date}}",
                        className: 'bg-info',
                        id: '{{$val->id}}',
                    },
                    @endforeach
                ];

                var $this = this; 
                $this.$calendarObj = $this.$calendar.fullCalendar({
                    slotDuration: '00:15:00',
                    /* If we want to split day time each 15minutes */
                    minTime: '08:00:00',
                    maxTime: '19:00:00',
                    defaultView: 'month',
                    handleWindowResize: true,

                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    events: events,
                    editable: true,
                    droppable: true, // this allows things to be dropped onto the calendar !!!
                    eventLimit: true, // allow "more" link when too many events
                    selectable: true,
                    drop: function(date) {
                        $this.onDrop($(this), date);
                    },
                    select: function(start, end, allDay) {
                        $this.onSelect(start, end, allDay);
                    },
                    eventClick: function(calEvent, jsEvent, view) {
                        $this.onEventClick(calEvent, jsEvent, view);
                    }

                });

                //on new event
                this.$saveCategoryBtn.on('click', function() {
                    var categoryName = $this.$categoryForm.find("input[name='category-name']").val();
                    var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
                    if (categoryName !== null && categoryName.length != 0) {
                        $this.$extEvents.append('<div class="calendar-events mb-3" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="fa fa-circle text-' + categoryColor + ' me-2" ></i>' + categoryName + '</div>')
                        $this.enableDrag();
                    }

                });
            },

            //init CalendarApp
            $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp

    }(window.jQuery),

    //initializing CalendarApp
    $(window).on('load', function() {

        $.CalendarApp.init()


    });
</script>
@endpush