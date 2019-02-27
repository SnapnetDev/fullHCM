@extends('layouts.master')
@section('stylesheets')
 <link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"> 
 <link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
 <link rel="stylesheet" href="{{ asset('global/vendor/morris/morris.css')}}">
 <link rel="stylesheet" href="{{ asset('assets/examples/css/apps/work.css')}}">
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
  <link rel="stylesheet" href="{{ asset('global/vendor/summernote/summernote.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/examples/css/charts/chartjs.css') }}">
@endsection
@section('content')
<!-- Page -->
  <div class="page ">
  	<div class="page-header">
  		<h1 class="page-title">{{__('Recruit')}}</h1>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
		    <li class="breadcrumb-item active">{{__('Recruit')}}</li>
		  </ol>
		  <div class="page-header-actions">
		    <div class="row no-space w-250 hidden-sm-down">

		      <div class="col-sm-6 col-xs-12">
		        <div class="counter">
		          <span class="counter-number font-weight-medium">{{date('Y-m-d')}}</span>

		        </div>
		      </div>
		      <div class="col-sm-6 col-xs-12">
		        <div class="counter">
		          <span class="counter-number font-weight-medium" id="time"></span>
		        </div>
		      </div>
		    </div>
		  </div>
	</div>
    
		<div class="page-content">
      <div class="row">
      <div class="col-md-9">
      	<div class="panel panel-bordered">
            <div class="panel-heading">
              <h3 class="panel-title">{{$joblisting->job?$joblisting->job->title:''}}</h3>
              <div class="panel-actions">
              	<input type="checkbox" class="active-toggle enable_job" id="{{$joblisting->id}}" {{$joblisting->status == 1?'checked':''}} >
              </div>
            </div>
            <div class="panel-body">
            	<div class="ribbon ribbon-clip ribbon-reverse ribbon-danger">
                        <span class="ribbon-inner"><a href="#" id="{{$joblisting->id}}" onclick="deleteJobListing(this.id)" style="color: #fff;">Delete</a></span>
                      </div>
                      <div class="ribbon ribbon-clip ribbon-primary">
                        <span class="ribbon-inner"><a href="#" onclick="prepareEditData({{$joblisting->id}});" style="color: #fff;">Edit</a></span>
                      </div>
               <h4><i class="icon md-graduation-cap"></i>Description</h4>
              {!! $joblisting->job->description !!}
              <h4><i class="icon md-graduation-cap"></i>Minimum Educational Qualification</h4>
              {{$joblisting->job->qualification?$joblisting->job->qualification->name:''}}
              <h4><i class="icon md-graduation-cap"></i>Expires</h4>
              {{date("F j, Y",strtotime($joblisting->expires))}}({{\Carbon\Carbon::parse($joblisting->expires)->diffForHumans()}})
              <h4><i class="icon md-graduation-cap"></i>Salary</h4>
              {{$joblisting->salary_from}} - {{$joblisting->salary_to}}
              <h4><i class="icon md-graduation-cap"></i>Experience</h4>
              {{$joblisting->experience_from}} - {{$joblisting->experience_to}} Years
              <h4><i class="icon md-graduation-cap"></i>Level</h4>
              @if($joblisting->level==1)Graduate Trainee @elseif($joblisting->level==2)Entry Level @elseif($joblisting->level==3)Non- Manager @elseif($joblisting->level==4) Manager @endif
               <h4><i class="icon md-graduation-cap"></i>Skills</h4>
               @if($joblisting->job->skills)
               <ul class="list-group list-group-dividered list-group-full">
                @php
                  $sn=1;
                @endphp
                 
               
               @foreach($joblisting->job->skills as $skill)
                <li class="list-group-item ">{{$sn}}.  {{strtoupper($skill->name)}} - {{$skill->pivot->competency->proficiency}}</li>
              @php
                $sn++;
              @endphp
              @endforeach
               </ul>
              @endif
              <h4><i class="icon md-graduation-cap"></i>Extra Requirements</h4>
              {!! $joblisting->requirements !!}
            </div>
          </div>
         </div>
         <div class="col-md-3">
           <div class="panel panel-bordered">
            <div class="panel-heading">
              <h3 class="panel-title">Skills</h3>
            </div>
            <div class="panel-body">
             <div class="example text-xs-center max-width">
                  <canvas id="skillChart" height="350"></canvas>
                </div>
            </div>
          </div>
         </div>

		</div> 

      	</div>
</div>
  <!-- End Page -->

   @include('recruit.modals.editJoblisting')
  
@endsection
@section('scripts')
<script src="{{asset('global/vendor/bootstrap-table/bootstrap-table.min.js')}}"></script>
  <script src="{{asset('global/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js')}}"></script>
  <script type="text/javascript" src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{ asset('global/vendor/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('global/vendor/datatables-fixedheader/dataTables.fixedHeader.js') }}"></script>
  <script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.js') }}"></script>

  <script type="text/javascript" src="{{ asset('global/vendor/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
    <script src="{{ asset('global/vendor/chart-js/Chart.js')}}"></script>
  <script src="{{ asset('global/vendor/raphael/raphael-min.js')}}"></script>
  <script src="{{ asset('global/vendor/morris/morris.min.js')}}"></script>
<script src="{{asset('global/vendor/summernote/summernote.min.js')}}"></script>
  <script type="text/javascript">
  	  $(document).ready(function() {
        $('#requirements').summernote();
    $('.datepicker').datepicker({
    autoclose: true
});

     $('.enable_job').bootstrapToggle({
      on: 'Enabled',
      off: 'Disabled',
      onstyle:'info',
      offstyle:'default'
    });
 $('.enable_job').on('change', function() {
      listing_id= $(this).attr('id');
      
       $.get('{{ url('/recruits/change_listing_status') }}/',{ listing_id: listing_id },function(data){
        if (data==1) {
          toastr.success("Job Listing is now Enabled",'Success');
        }
        if(data==2){
          toastr.warning("Job Listing is Disabled",'Success');
        }
        
       });
    });


     $(document).on('submit','#addSalaryComponentForm',function(event){
     event.preventDefault();
     var form = $(this);
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
        $.ajax({
            url         : '{{route('payrollsettings.store')}}',
            data        : formdata ? formdata : form.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){

                toastr.success("Changes saved successfully",'Success');
               $('#addSalaryComponentModal').modal('toggle');
          $( "#ldr" ).load('{{url('payrollsettings/salary_components')}}');

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

    });

      function departmentChange(department_id){
    event.preventDefault();
    $.get('{{ url('/users/department/jobroles') }}/'+department_id,function(data){
      
      
      if (data.jobs=='') {
         $("#jobroles").empty();
        $('#jobroles').append($('<option>', {value:0, text:'Please Create a Jobrole in Department'}));
      }else{
        $("#jobroles").empty();
        jQuery.each( data.jobroles, function( i, val ) {       
               $('#jobroles').append($('<option>', {value:val.id, text:val.title}));  
              });
      }
      
     });
  }

  function deleteJobListing(listing_id){
    $.get('{{ url('/recruits/delete_job_listing') }}/',{ listing_id: listing_id },function(data){
      if (data=='success') {
    toastr.success("Job Listing deleted successfully",'Success');
      }else{
        toastr.error("Error deleting Salary Component",'Success');
      }
     
    });
  }
      function prepareEditData(listing_id){
    $.get('{{ url('/recruits/get_job_listing_info') }}/',{ listing_id: listing },function(data){
      
     $('#editjtype').val(data.type);
     $('#editjlevel').val(data.level);
     $('#editscformula').val(data.formula);
     $('#editscconstant').val(data.constant);
      $('#editscgl_code').val(data.gl_code);
       $('#editscproject_code').val(data.project_code);
       $('#editsctaxable').val(data.taxable);
      $("#editscexemptions").find('option')
    .remove();
    console.log(data.type);
    if (data.type==1) {
      $("#editscallowance").prop("checked", true);
      $("#editscdeduction").prop("checked", false);
    }else{
      $("#editscdeduction").prop("checked", true);
      $("#editscallowance").prop("checked", false);
    }
    
     jQuery.each( data.exemptions, function( i, val ) {
       $("#editscexemptions").append($('<option>', {value:val.id, text:val.name,selected:'selected'}));
       // console.log(val.name);
              }); 
     $('#editscid').val(data.id);
    });
    $('#editSalaryComponentModal').modal();
  }

  var ctx = document.getElementById('skillChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'radar',

    // The data for our dataset
    data: {
        labels: [  @foreach($joblisting->job->skills as $skill)"{{strtoupper($skill->name)}}", @endforeach],
        pointLabelFontSize: 14,
        datasets: [{
            label: "Skill for Job",
             pointRadius: 4,
        borderDashOffset: 2,
            backgroundColor: 'rgba(98, 168, 234, 0.15)',
            borderColor: 'rgba(0, 0, 0,0)',
             pointBackgroundColor: Config.colors("primary", 600),
        pointBorderColor: "#fff",
        pointHoverBackgroundColor: "#fff",
        pointHoverBorderColor: Config.colors("primary", 600),
            data: [ @foreach($joblisting->job->skills as $skill){{$skill->pivot->competency->id}}, @endforeach],
        }]
    },

    // Configuration options go here
    options: {
      responsive: true,
        scale: {
          ticks: {
            beginAtZero: true
          }
        }
    }
});
  </script>
@endsection