<!-- fullCalendar 2.2.5-->
<link rel="stylesheet" href="<?php echo base_url(); ?>resource/adminlte/plugins/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>resource/adminlte/plugins/fullcalendar/fullcalendar.print.css"
      media="print">
<section class="content-header">
    <h1>
        Calendar
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Calendar</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">Draggable Events</h4>
                </div>
                <div class="box-body">
                    <!-- the events -->
                    <div id="external-events">
                        <div class="external-event bg-green">Lunch</div>
                        <div class="external-event bg-yellow">Go home</div>
                        <div class="external-event bg-aqua">Do homework</div>
                        <div class="external-event bg-light-blue">Work on UI design</div>
                        <div class="external-event bg-red">Sleep tight</div>
                        <div class="checkbox">
                            <label for="drop-remove">
                                <input type="checkbox" id="drop-remove">
                                remove after drop
                            </label>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Event</h3>
                </div>
                <div class="box-body">
                    <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                        <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                        <ul class="fc-color-picker" id="color-chooser">
                            <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                            <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                            <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                            <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                            <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                            <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                            <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                            <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                            <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                            <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                            <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                            <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                            <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                        </ul>
                    </div>
                    <!-- /btn-group -->
                    <div class="input-group">
                        <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                        <div class="input-group-btn">
                            <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add</button>
                        </div>
                        <!-- /btn-group -->
                    </div>
                    <!-- /input-group -->
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-body no-padding">
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<!-- fullCalendar 2.2.5 -->
<!-- Page specific script -->
<script>

    $(function () {

        /* initialize the external events
         -----------------------------------------------------------------*/
        function ini_events(ele) {
            ele.each(function () {

                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                };

                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject);

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 1070,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                });

            });
        }

        ini_events($('#external-events div.external-event'));

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date();
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear();
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today: 'today',
                month: 'month',
                week: 'week',
                day: 'day'
            },

            //Random default events
            events: {
                url: '<?php echo site_url('c=calendar&m=data2');?>',
                data: function () {
                    return {
                        dynamic_value: Math.random()
                    }
                },
                error: function () {
                    toastr.error('数据加载失败');
                }
            },
            eventClick: function (calEvent, jsEvent, view) {
                art_open1('修改事件', BASE_URL + '?c=calendar&m=edit&id=' + calEvent.id);
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end) {
                art_open1('Add Event', BASE_URL + '?c=calendar&m=add&start=' + start.format('YYYY-MM-DD HH:mm:ss') + '&end=' + end.format('YYYY-MM-DD HH:mm:ss') + '&_t=' + Math.random());
                $('#calendar').fullCalendar('rerenderEvents');
                $('#calendar').fullCalendar('unselect');
            },
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function (date, event) { // this function is called when something is dropped

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');

                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);

                // assign it the date that was reported
                copiedEventObject.start = date.format();
                copiedEventObject.allDay = true;
                copiedEventObject.backgroundColor = $(this).css("background-color");
                copiedEventObject.borderColor = $(this).css("border-color");

                var event_title = copiedEventObject.title;
                var event_date = date.format();
                var event_backgroundColor = copiedEventObject.backgroundColor;
                var event_borderColor = copiedEventObject.borderColor;

                $.ajax({
                    url: BASE_URL+'?c=calendar&m=save',
                    type: 'post',
                    data: {
                        title: event_title,
                        backgroundColor: event_backgroundColor,
                        borderColor: event_borderColor,
                        start: event_date,
                        end: event_date,
                        isallday: 1,
                        isend: 0,
                        e_hour:'00',
                        e_minute:'00',
                        s_hour:'00',
                        s_minute:'00'
                    },
                    success: function(response){

                    },
                    error: function(){
                        alert("error");
                    }
                });

                copiedEventObject = {
                    id: 3,
                    title: event_title,
                    backgroundColor: event_backgroundColor,
                    borderColor: event_borderColor,
                    start: event_date,
                    end: event_date,
                    isallday: 1,
                    isend: 0,
                    e_hour:'00',
                    e_minute:'00',
                    s_hour:'00',
                    s_minute:'00'
                }

                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }

            },
            eventDrop: function (event, dayDelta, minuteDelta, allDay, revertFunc) {

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');

                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);

                console.log(copiedEventObject);

                $.post(BASE_URL +'?c=calendar&m=drag',{
                    id:copiedEventObject.id,
                    start:dayDelta,
                    end:copiedEventObject.end,
                    allday:copiedEventObject.allDay
                },function(msg){
                    if(msg!=1){
                        alert(msg);
                        revertFunc();
                    }
                });

            },
            eventResize: function (event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view) {
                console.log("sb");
            }
        });

        function art_open1(title, url, tableid) {
            var d = dialog({
                id: 'dialog2',
                title: title,
                url: url,
                width: 768,
                fixed: true,
                onremove: function () {
                    $('#calendar').fullCalendar('refetchEvents');
//                    $('#calendar').fullCalendar('removeEventSources');
//                    $('#calendar').fullCalendar('refetchEvents');
                }
            });
            d.showModal();
        }

        /* ADDING EVENTS */
        var currColor = "#3c8dbc"; //Red by default
        //Color chooser button
        var colorChooser = $("#color-chooser-btn");
        $("#color-chooser > li > a").click(function (e) {
            e.preventDefault();
            //Save color
            currColor = $(this).css("color");
            //Add color effect to button
            $('#add-new-event').css({
                "background-color": currColor,
                "border-color": currColor
            });
        });
        $("#add-new-event").click(function (e) {
            e.preventDefault();
            //Get value and make sure it is not null
            var val = $("#new-event").val();
            if (val.length == 0) {
                return;
            }

            //Create events
            var event = $("<div />");
            event.css({
                "background-color": currColor,
                "border-color": currColor,
                "color": "#fff"
            }).addClass("external-event");
            event.html(val);
            $('#external-events').prepend(event);

            //Add draggable funtionality
            ini_events(event);

            //Remove event from text input
            $("#new-event").val("");
        });
    });
</script>	
