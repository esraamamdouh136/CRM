<style>
    html{
            height: 0 !important;

    }
    .area{
   
    height: 90px !important;

    }
    .center{
        text-align: center;
        
    }
    .add{
        margin-top: 20px !important;
        border-radius: none !important;
        
    }

    .conttt{
        display: none;
    }
/*
    .col{
        background-color: #33415a !important;
        color: aliceblue !important;
    }
*/
    .clos{
        color:white !important ;
        z-index: 100 !important;
       font-size: 30px !important;
        opacity: 1 !important;
    }
    
    .input-text{
        
        min-width: 80%;
        min-height: 40%;
        font-weight: bold;
        font-size: 20px;
        padding: 20px;
    }
    .DeleteEvent
    {
      background-color: red !important;
    }
  
    @media only screen and (max-width: 400px) {
          .fc-toolbar .fc-right {
               display: inline-block;
    float: right;
    width: 74%;
    margin-top: 20px;
    margin-bottom: 10px;
}
        .fc-left{
           display: inline-block;
        }
        .fc-toolbar .fc-left {
    float: none !important
        ;
}
        
}

</style>
<?php $this->load->view("header") ?>

  <!-- Content Wrapper. Contains page content -->

  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
      
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
  
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
                <input id="new-event" type="text" class="form-control" placeholder="Event Title" style="margin-bottom:20px">
<textarea id="new-event-detail" type="text" class="form-control area" placeholder="Event Details"></textarea>
                <div class="center">
                  <button id="add-new-event" type="button" class="btn btn-primary btn-flat add">Add</button>
                </div>
                <!-- /btn-group -->
              </div>
              <!-- /input-group -->
            </div>
          </div>
                    <div class="box box-solid">
            <div class="box-header with-border">
              <h4 class="box-title">Draggable Events</h4>
            </div>
            <div class="box-body">
              <span class='conttt'></span><span class='title'></span>
              <!-- the events -->
              <div id="external-events">
               
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
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>


                <div class="modal fade myModal" role="dialog">
                  <div class="modal-dialog">
                  
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header box-header with-border">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <div class="center">
              <!--              <h3 class="box-title">Create Event</h3>-->
                              <h4 class="modal-title">Event Details</h4>
                              <h4 class="modal-id" style="display:none"></h4>
                          </div>
                          
                        
                      </div>
                      <div class="modal-body center " style="min-height: 310px;">
          
                          <textarea readonly class="input-text"></textarea>
                      </div>
                      <div class="modal-footer center" >
                          <div class="center"><button type="button" class="btn btn-default col DeleteEvent" data-dismiss="modal">Delete Event  <i class="fa fa-trash" aria-hidden="true"></i>
                                   </button></div>
                      </div>
                    </div>
                    
                  </div>
                </div>

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
  </div>
  <!-- /.content-wrapper -->



  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

<!-- ./wrapper -->

<?php $this->load->view("footer"); ?>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Slimscroll -->
<script src=" plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src=" plugins/fullcalendar/fullcalendar.min.js"></script>
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
          title: $.trim($(this).find(".title").text()), // use the element's text as the event title
          cont: $.trim($(this).find(".conttt").text() )
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
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

      events:function(start, end, timezone, callback) {
        $.ajax({
             type: 'post',
            datatype:"json",    
            url: "<?= $url ?>index.php/mainPage/MyCalender",
            data: {},
            success: function(doc) {
                var Dataarray = $.parseJSON(doc);
                var events = [];
                for (var i = 0; i < Dataarray['MyData'].length; i++) {
                  if (Dataarray['MyData'][i]['dayto'] == "0000-00-00 00:00:00") {
                    events.push({
                        title: Dataarray['MyData'][i]['Notes'],
                        start: Dataarray['MyData'][i]['fayfrom'],
                        id: Dataarray['MyData'][i]['calender_id'],
                        cont: Dataarray['MyData'][i]['content'],
                        allDay: true,
                        editable:true,
                        backgroundColor: Dataarray['MyData'][i]['color'], //Blue
                        borderColor: Dataarray['MyData'][i]['color'] //Blue
                    });
                  }else{
                    events.push({
                        title: Dataarray['MyData'][i]['Notes'],
                        start: Dataarray['MyData'][i]['fayfrom'],
                        end: Dataarray['MyData'][i]['dayto'],
                        id: Dataarray['MyData'][i]['calender_id'],
                        cont: Dataarray['MyData'][i]['content'],
                        editable:true,
                        backgroundColor: Dataarray['MyData'][i]['color'], //Blue
                        borderColor: Dataarray['MyData'][i]['color'] //Blue
                    });
                  }
                  
                }
                
                callback(events);
            }
        });
    },
      //Random default events
      eventClick: function(event) {
            $(".modal-title").text(event['title']);
          $(".modal-id").text(event['id']);
            $(".input-text").text(event['cont']);
            
            $(".myModal").modal('show');
          
            return false;
        
    },
      eventDrop: function (event, delta, revertFunc) {
              //inner column movement drop so get start and call the ajax function......
              //console.log(event.start.format("YYYY-MM-DD hh:mm:ss"));
              //alert(event.id);
              var defaultDuration = moment.duration($('#calendar').fullCalendar('option', 'defaultTimedEventDuration'));
              var end = event.end || event.start.clone().add(defaultDuration);
              //console.log('end is ' + end.format("YYYY-MM-DD hh:mm:ss"));

              var id = event.id ;
              var start = event.start.format("YYYY-MM-DD HH:mm:ss");
              var end = end.format("YYYY-MM-DD HH:mm:ss")

              $.ajax({
                type: 'post',
                datatype:"json",    
                url: "<?= $url ?>index.php/mainPage/updateCalender",
                data: {start: start ,end: end ,id : id },
                success: function(ret){
                }   
              });
              //alert(event.title + " was dropped on " + event.start.format());

          },

          editable: true,
      droppable: true,
          eventResize: function (event, delta, revertFunc) {
              //console.log(event.id);
              //alert("Start time: " + event.start.format() + "end time: " + event.end.format());

              var id = event.id ;
              var start = event.start.format("YYYY-MM-DD HH:mm:ss");
              var end = event.end.format("YYYY-MM-DD HH:mm:ss")

              $.ajax({
                type: 'post',
                datatype:"json",    
                url: "<?= $url ?>index.php/mainPage/updateCalender",
                data: {start: start ,end: end ,id : id },
                success: function(ret){
                }   
              });

          },
       // this allows things to be dropped onto the calendar !!!
      drop: function (date, allDay) { // this function is called when something is dropped
          
        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject');

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject);

        // assign it the date that was reported
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;
        copiedEventObject.backgroundColor = $(this).css("background-color");
        copiedEventObject.borderColor = $(this).css("border-color");
        var Me = $(this);
        var textN = originalEventObject["title"];
        var Content =originalEventObject["cont"];
        var color = $(this).css("background-color");
        var dateALL=moment(date, 'DD.MM.YYYY').format('YYYY-MM-DD HH:mm:SS');

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        

        $.ajax({
              type: 'post',
              datatype:"json",    
              url: "<?= $url ?>index.php/mainPage/AddToCalender",
              data: {date: dateALL ,name: textN ,color : color ,Content:Content},
              success: function(ret){
             
                copiedEventObject.id = ret;
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
              }   
            });

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove();
        }

      }

    });

    /* ADDING EVENTS */
    var currColor = "#3c8dbc"; //Red by default
    //Color chooser button
    var colorChooser = $("#color-chooser-btn");
    $("#color-chooser > li > a").click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css("color");
      //Add color effect to button
      $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
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
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      event.html("<i id='delete-event2' class='fa fa-times'></i>"+"<span class='conttt'>"+$("#new-event-detail").val()+"</span><span class='title'>"+val+"</span>");
      $('#external-events').prepend(event);

      //Add draggable funtionality
      ini_events(event);

      //Remove event from text input
      $("#new-event").val("");
        $("#new-event-detail").val("");
        
    });
  });

$(document).on("click",".DeleteEvent",function(){
  var id = $(this).parents(".modal-content").find(".modal-id").text();
  $.ajax({
      type: 'post',
      datatype:"json",    
      url: "<?= $url ?>index.php/mainPage/deletecalender",
      data: {id: id},
      success: function(ret){
          if(ret != "ERROR"){
              window.location.href = "<?= $url ?>mainPage/calender"
          }else{
            toastr.error("ERROR While Delete.");
          }
        
      }   
    });
});
  

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

</body>
</html>