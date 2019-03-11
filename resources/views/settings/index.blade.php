@extends('layouts.master')
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-table/bootstrap-table.css') }}">
  <link rel="stylesheet" href="{{ asset('global/vendor/alertify/alertify.min.css') }}">
  <link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
   <link rel="stylesheet" href="{{ asset('global/vendor/ascolorpicker/asColorPicker.css')}}">

  <link rel="stylesheet" href="{{ asset('global/vendor/clockpicker/clockpicker.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('global/vendor/datatables/datatables.min.css')}}">
   <link rel="stylesheet" href="{{ asset('global/vendor/switchery/switchery.css')}}">
   <link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
   <link rel="stylesheet" href="{{ asset('global/vendor/editable-table/editable-table.css')}}">
  <style type="text/css">
  	 .btn[disabled]{
  	 	pointer-events: none;
  	 	cursor: not-allowed;
  	 }
     .hide{
      display:none;
     }
     .block{
      display:block;
     }

  </style>
@endsection

@section('content')
<!-- Page -->
  <div class="page ">
  	<div class="page-aside">
      <!-- Contacts Sidebar -->
      <div class="page-aside-switch">
        <i class="icon md-chevron-left" aria-hidden="true"></i>
        <i class="icon md-chevron-right" aria-hidden="true"></i>
      </div>
      <div class="page-aside-inner page-aside-scroll">
        <div data-role="container">
          <div data-role="content">
            <div class="page-aside-section">
              <div class="list-group">
                @if (Auth::user()->role->permissions->contains('constant', 'group_access'))
                <a class="list-group-item active setting-linker" href="{{ route('companies') }}">
                 <i class="icon fa fa-building" aria-hidden="true"></i>{{__('Company Settings')}}
                </a>
                <a class="list-group-item setting-linker" href="{{ route('employeesettings') }}">
                 <i class="icon fa fa-users" aria-hidden="true"></i>{{__('Employee Settings')}}
                </a>
                @endif
                {{-- <a class="list-group-item setting-linker" href="{{route('employeedesignationsettings')}}">
                 <i class="icon fa fa-address-card" aria-hidden="true"></i>{{__('Employee Designation Settings')}}
                </a> --}}
                <a class="list-group-item setting-linker" href="{{ route('attendancesettings') }}">
                 <i class="icon fa fa-calendar" aria-hidden="true"></i>{{__('Attendance Settings')}}
                </a>
                <a class="list-group-item setting-linker" href="{{ route('leavesettings') }}">
                 <i class="icon fa fa-calendar-o" aria-hidden="true"></i>{{__('Leave Settings')}}
                </a>
                {{-- <a class="list-group-item setting-linker" href="javascript:void(0)">
                 <i class="icon fa fa-bell" aria-hidden="true"></i>{{__('Notification & Alert Settings')}}
                </a> --}}
                 @if (Auth::user()->role->permissions->contains('constant', 'group_access'))
                <a class="list-group-item setting-linker" href="{{ route('systemsettings') }}">
                 <i class="icon fa fa-wrench" aria-hidden="true"></i>{{__('System Settings')}}
                </a>
                    @endif
                 <a class="list-group-item setting-linker" href="{{ url('performances')}}/settings">
                 <i class="icon fa fa-wrench" aria-hidden="true"></i>{{__('Performance Settings')}}
                </a>
                <a class="list-group-item setting-linker" href="{{ url('bscsettings')}}">
                 <i class="icon fa fa-wrench" aria-hidden="true"></i>{{__('Balance Score Card Settings')}}
                </a>
<<<<<<< HEAD
=======
                <a class="list-group-item setting-linker" href="{{ url('e360settings')}}">
                 <i class="icon fa fa-circle-o-notch" aria-hidden="true"></i>{{__('360 Review Settings')}}
                </a>
>>>>>>> 756669c79ba12453137381addef2325f0d752945
                
               
              </div>
            </div>
            
            
            
            
          </div>
        </div>
      </div>
    </div>
    <div class="page-main">
    <div id="ldr">
  	
	
		
	</div>
	</div>
    
    
  	
	</div>
  <!-- End Page -->

@endsection
@section('scripts')
<script src="{{asset('global/vendor/bootstrap-table/bootstrap-table.min.js')}}"></script>
  <script src="{{asset('global/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js')}}"></script>
  <script type="text/javascript" src="{{ asset('global/vendor/alertify/alertify.js') }}"></script>
  <script type="text/javascript" src="{{ asset('global/vendor/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
  <script src="{{ asset('global/vendor/clockpicker/bootstrap-clockpicker.min.js')}}"></script>
  <script src="{{ asset('global/vendor/switchery/switchery.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('global/vendor/editable-table/mindmup-editabletable.js')}}"></script>
  <script src="{{ asset('global/vendor/editable-table/numeric-input-example.js')}}"></script>
<<<<<<< HEAD
  <script src="{{ asset('global/vendor/jscolor/jscolor.js')}}"></script>

=======
>>>>>>> 756669c79ba12453137381addef2325f0d752945
<script type="text/javascript">
	
	$(function(){


		$('#rolestable').DataTable();
    
<<<<<<< HEAD
		// $( "#ldr" ).load( "{{route('companies')}}" );
=======
		$( "#ldr" ).load( "{{route('companies')}}" );
>>>>>>> 756669c79ba12453137381addef2325f0d752945

	});
	$(function(){

    url=sessionStorage.getItem('href')!=null ? sessionStorage.getItem('href') : "{{url('payrollsettings/account')}}";
    // console.log(url);
    $( ".setting-linker" ).each(function() {
        $( this ).attr( "href" )==sessionStorage.getItem('href')?$(this).addClass( "active" ):$(this).removeClass( "active" );
      });
    
  href = $(this).attr('href');
    $( "#ldr" ).load(url);

  });
  $(document).on('click','.linker',function(event){
    event.preventDefault();
  href = $(this).attr('href');
  sessionStorage.setItem('href',href);
  // console.log(href);
  $( "#ldr" ).load( href );
  });


  $(document).on('click','.setting-linker',function(event){
    event.preventDefault();
    $( ".setting-linker" ).each(function() {
        $( this ).removeClass( "active" );
      });
    $(this).addClass( "active" );
  href = $(this).attr('href');
  sessionStorage.setItem('href',href);
  $( "#ldr" ).load( href );
  });
</script>

  
@endsection
