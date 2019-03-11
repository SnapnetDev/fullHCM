@extends('layouts.master')
@section('stylesheets')


<link rel="stylesheet" href="{{ asset('global/vendor/fullcal/fullcalendar.min.css') }}"/>
  <link rel="stylesheet" href="{{asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
  <link rel="stylesheet" href="{{asset('global/vendor/bootstrap-maxlength/bootstrap-maxlength.css')}}">
  <link rel="stylesheet" href="{{ asset('global/vendor/jt-timepicker/jquery-timepicker.css') }}">
<style type="text/css">
  a.list-group-item:hover {
    text-decoration: none;
    background-color: #3f51b5;
}
</style>
@endsection
@section('content')
<div class="page ">
    <div class="page-header">
      <h1 class="page-title">Employee Shift Schedules</h1>
      <div class="page-header-actions">
    <div class="row no-space w-250 hidden-sm-down">

      <div class="col-sm-6 col-xs-12">
        <div class="counter">
          <span class="counter-number font-weight-medium">{{date("M j, Y")}}</span>

        </div>
      </div>
      <div class="col-sm-6 col-xs-12">
        <div class="counter">
          <span class="counter-number font-weight-medium" id="time">{{date('h:i s a')}}</span>

        </div>
      </div>
    </div>
  </div>
    </div>
    <div class="page-content container-fluid">
      <div class="panel panel-info panel-line">
                <div class="panel-heading">
                  <h3 class="panel-title">Employee Shift Schedules
                  <div class="panel-actions">
                    <button class="btn btn-info" data-toggle="modal" data-target="#exportShiftScheduleModal">Export Shift Schedule</button>
                    <button class="btn btn-info" data-toggle="modal" data-target="#uploadShiftScheduleModal">Schedule Shifts</button>
                  </div>
                </div>
                <div class="panel-body">
                  
                  <div id="calendar"></div>
                </div>
  </div>
  </div>
  </div>
  <!-- Site Action -->
 
   <!-- End Page -->
  <div class="modal fade in modal-3d-flip-horizontal modal-info" id="uploadShiftScheduleModal" aria-hidden="true" aria-labelledby="uploadShiftScheduleModal" role="dialog" tabindex="-1">
      <div class="modal-dialog " >
        <div class="modal-content">        
          <div class="modal-header" >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="training_title">Upload Shift Schedule</h4>
          </div>
            <div class="modal-body">         
                <div class="row row-lg col-xs-12">            
                  <form class="form-horizontal" id="uploadShiftScheduleForm"  method="POST" action="{{url('import_employee_shift')}}">
             
                    @csrf
                    <div class="form-group">
                      <h4 class="example-title">Upload Shift Schedule</h4>
                      <a href="{{url('shift_template_download')}}">Download Upload Template</a>
                      <input type="file" name="template" class="form-control">
                      <input type="hidden" name="import_shift">
                    </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-info pull-left ">Upload</button>
                    </div>
                  
                  
            </form>           
                </div>        
            </div>
            <div class="modal-footer">
              <div class="col-xs-12">
                
                  
                  <!-- End Example Textarea -->
                </div>
             </div>
         </div>
      </div>
    </div>
    <div class="modal fade in modal-3d-flip-horizontal modal-info" id="exportShiftScheduleModal" aria-hidden="true" aria-labelledby="exportShiftScheduleModal" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-lg" >
        <div class="modal-content">        
          <div class="modal-header" >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="training_title">Export Shift Schedule</h4>
          </div>
          <form  id="exportShiftScheduleForm"  method="Get" action="{{url('export_shift_Schedule')}}">
            <div class="modal-body">         
                          
                  
             
                    
                    <div class="form-group">
                      
                       <div class="input-group  " >
                    <span class="input-group-addon">
                     From <i class="icon fa fa-calendar" aria-hidden="true"></i>
                    </span>
                    <input type="text" class="form-control datepair-date datepair-start" id="startdate" data-plugin="datepicker" name="from" >
                   
                 
                    
                  </div>
                  </div>
                 
                     <div class="input-group  " >
                     <span class="input-group-addon">
                     To <i class="icon fa fa-calendar" aria-hidden="true"></i>
                    </span>
                   <input type="text" class="form-control datepair-date datepair-start" id="enddate" data-plugin="datepicker" name="to" >
                 </div>
                   
                    
                  
                  
           

                </div>        
            
            <div class="modal-footer">
             
                <div class="form-group">
                    <button type="submit" class="btn btn-info pull-left ">Export</button>
                    </div>
                  
                  <!-- End Example Textarea -->
                </div>
                 </form>
             </div>
         </div>
      </div>
    </div>
      <div class="modal fade in modal-3d-flip-horizontal modal-info" id="dayDetailsModal" aria-hidden="true" aria-labelledby="attendanceDetailsModal" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-lg" >
        <div class="modal-content">        
          <div class="modal-header" >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="training_title">Employee Shift Schedule For <span id="sdate"></span></h4>
          </div>
            <div class="modal-body">         
                <div class="row row-lg col-xs-12">            
                  <div class="col-xs-12" id="detailLoader"> 
                    
                  </div>
                  <div class="clearfix hidden-sm-down hidden-lg-up"></div>            
                </div>        
            </div>
            <div class="modal-footer">
              <div class="col-xs-12">
                
                  
                  <!-- End Example Textarea -->
                </div>
             </div>
         </div>
      </div>
    </div>

@section('scripts')


<script src="{{ asset('global/vendor/fullcal/lib/moment.min.js') }}"></script>
<script src="{{ asset('global/vendor/fullcal/fullcalendar.min.js') }}"></script>
  <script src="{{asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('global/vendor/jt-timepicker/jquery.timepicker.min.js')}}"></script>
  <script src="{{asset('global/vendor/datepair/datepair.min.js')}}"></script>
  <script src="{{asset('global/vendor/datepair/jquery.datepair.min.js')}}"></script>
{{-- {!! $calendar->script() !!} --}}
<script type="text/javascript">
$(function(){
  $(document).on('submit','#uploadShiftScheduleForm',function(event){
     event.preventDefault();
     var form = $(this);
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
        $.ajax({
            url         : '{{url('import_employee_shift')}}',
            data        : formdata ? formdata : form.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){

                toastr.success("Changes saved successfully",'Success');
               $('#addSalaryComponentModal').modal('toggle');
          $( "#ldr" ).load('{{url('payrollsettings/specific_salary_components')}}');

            },
            error:function(data, textStatus, jqXHR){
               jQuery.each( data['responseJSON'], function( i, val ) {
                jQuery.each( val, function( i, valchild ) {
                toastr.error(valchild[0]);
              });  
              });
            }
        });
      
    });
    $('#calendar').fullCalendar({
         noEventsMessage:'{{__('No Attendance For today')}}',
     allDayText:'{{__('Attendance for Today')}}',
     eventLimit: true,
      defaultView: 'month',
          header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek'
      },
      events: {
        url: '{{url('user_attendance_calendar')}}',
        error: function() {
          $('#script-warning').show();
        },
          color: '#263238',     // an option!
          textColor: '#ffffff' // an option!
        
      },
      eventClick: function(eventObj) {
        if(eventObj.id!=''){
         $("#detailLoader").load('{{ url('/attendance/getdetails') }}/'+eventObj.id);
         $('#attendanceDetailsModal').modal();
        
        }
    
      
    },
    dayClick: function(date, jsEvent, view) {
       $("#detailLoader").load('{{ url('/cust_shift_schedules') }}?date='+date.format());
$("#sdate").html(date.format());
         $('#dayDetailsModal').modal();
        

    // alert('Clicked on: ' + date.format());

    // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

    // alert('Current view: ' + view.name);

    // // change the day's background color just for fun
    // $(this).css('background-color', 'red');

  }
    
    });

});


</script>
@endsection