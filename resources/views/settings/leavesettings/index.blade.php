<div class="page-header">
  		<h1 class="page-title">{{__('All Settings')}}</h1>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
		    <li class="breadcrumb-item ">{{__('Leave Settings')}}</li>
		    <li class="breadcrumb-item active">{{__('You are Here')}}</li>
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
      <div class="page-content container-fluid">
      	<div class="row">
        	<div class="col-md-12 col-xs-12">
        		
        		<div class="panel panel-info panel-line">
		            <div class="panel-heading">
		              <h3 class="panel-title">Leave</h3>
		              <div class="panel-actions">
                			
		              	<button class="btn btn-info" data-toggle="modal" data-target="#addLeaveModal">Add Leave</button>
              			</div>
		            	</div>
		            <div class="panel-body">
		            
	                  <table id="exampleTablePagination" data-toggle="table" 
		                  data-query-params="queryParams" data-mobile-responsive="true"
		                  data-height="400" data-pagination="true" data-search="true" class="table table-striped">
		                    <thead>
		                      <tr>
		                        <th style="width: 80%" >Name:</th>
		                        <th style="width: 20%">Action:</th>
		                      </tr>
		                    </thead>
		                    <tbody>
		                    	@forelse($leaves as $leave)
		                    	<tr>
		                    		<td>{{$leave->name}}</td>
		                    		<td><a class="dropdown-item" title="edit" class="btn btn-info" id="{{$leave->id}}" onclick="prepareLEditData(this.id);"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
		                    	</tr>
		                    	@empty
		                    	@endforelse
		                    	
		                    </tbody>
	                  </table>
	          		</div>
	          		</div>

	          		<div class="panel panel-info panel-line">
		            <div class="panel-heading">
		              <h3 class="panel-title">Leave Policy Settings</h3>
		              <div class="panel-actions">
                			

              			</div>
		            	</div>
		            	<form id="leavePolicyForm" enctype="multipart/form-data">
		            <div class="panel-body">
		            <div class="col-md-6">
		            	@csrf
		            		<div class="form-group" >
	          					<h4>Does your leave include weekends?</h4>
	          					<input type="checkbox" name="includes_weekend" class="active-toggle bstoggle"  {{$lp->includes_weekend==1?'checked':''}} value="1">
	          					<h4>Does your leave include holidays?</h4>
	          					<input type="checkbox" name="includes_holiday" class="active-toggle bstoggle"  {{$lp->includes_holiday==1?'checked':''}} value="1">
	          				</div>
	          				<div class="form-group" >
	          					<h4>Default Leave Length</h4>
	          					<input type="text" name="default_length" class="form-control" value="{{$lp->default_length}}">
	          				</div>
	          				<div class="form-group" >
	          					<h4>Approval Workflow</h4>
	          					<select class="form-control" name="workflow_id">
	          						@forelse($workflows as $workflow)
	          						<option value="{{$workflow->id}}" {{$lp->workflow_id==$workflow->id?'selected':''}}>{{$workflow->name}}</option>
	          						@empty
	          						<option value="0">Please Create a Workflow</option>
	          						@endforelse
	          						
	          					</select>
	          				</div>
	          				<input type="hidden" name=" type" value="leave_policy">
	          					            	
		            </div>
	                 
	          		</div>
	          		<div class="panel-footer">
	          			<div class="form-group">
	          					<button class="btn btn-info" >Save Changes</button>
	          				</div>
	          		</div>
	          		</form>
		          </div>
	          
	          	<div class="panel panel-info panel-line">
		            <div class="panel-heading">
		              <h3 class="panel-title">Holidays</h3>
		              <div class="panel-actions">
                			
		              	<button class="btn btn-info" data-toggle="modal" data-target="#addHolidayModal">Add Holiday</button>
              			</div>
		            	</div>
		            <div class="panel-body">
		            
	                  <table id="exampleTablePagination" data-toggle="table" 
		                  data-query-params="queryParams" data-mobile-responsive="true"
		                  data-height="400" data-pagination="true" data-search="true" class="table table-striped">
		                    <thead>
		                      <tr>
		                        <th style="width: 30%" >Title:</th>
		                        <th style="width: 25%">Date:</th>
		                        <th style="width: 25%">Created By:</th>
		                        <th style="width: 20%">Action:</th>
		                      </tr>
		                    </thead>
		                    <tbody>
		                    	@forelse($holidays as $holiday)
		                    	<tr>
		                    		<td>{{$holiday->title}}</td>
		                    		<td>{{date("F j, Y",strtotime($holiday->date))}}</td>
		                    		<td>{{$holiday->user?$holiday->user->name:''}}</td>
		                    		<td><a class="dropdown-item" title="edit" class="btn btn-info" id="{{$holiday->id}}" onclick="prepareHEditData(this.id);"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
		                    	</tr>
		                    	@empty
		                    	@endforelse
		                    	
		                    </tbody>
	                  </table>
	          		</div>
	          		</div>
	        	
	        	<div class="panel panel-info panel-line">
		            <div class="panel-heading">
		              <h3 class="panel-title">Shifts</h3>
		              <div class="panel-actions">
                			
		              	<button class="btn btn-info" data-toggle="modal" data-target="#addShiftModal">Add Shift</button>
              			</div>
		            	</div>
		            <div class="panel-body">
		            
	                  <table id="exampleTablePagination" data-toggle="table" 
		                  data-query-params="queryParams" data-mobile-responsive="true"
		                  data-height="400" data-pagination="true" data-search="true" class="table table-striped">
		                    <thead>
		                      <tr>
		                        <th style="width: 30%">Name:</th>
		                        <th style="width: 25%">StartTime:</th>
		                        <th style="width: 25%">EndTime:</th>
		                        <th style="width: 20%" >Action:</th>
		                      </tr>
		                    </thead>
		                    <tbody>
		                    	@forelse($shifts as $shift)
		                    	<tr>
		                    		<td>{{$shift->type}}</td>
		                    		<td>{{date("h:i A",strtotime($shift->start_time))}}</td>
		                    		<td>{{date("h:i A",strtotime($shift->end_time))}}</td>
		                    		<td><a class="dropdown-item" title="edit" class="btn btn-info" id="{{$shift->id}}" onclick="prepareSEditData(this.id);"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
		                    	</tr>
		                    	@empty
		                    	@endforelse
		                    	
		                    </tbody>
	                  </table>
	          		</div>
	          		</div>
	          		</div>
	        	</div>
	    	</div>
	    	<div class="col-md-12 col-xs-12">
	    		
	    	</div>
		</div>
	  </div>
	   @include('settings.leavesettings.modals.addleave')
	  {{-- edit holiday modal --}}
	   @include('settings.leavesettings.modals.editleave')
	   {{-- Add Grade Modal --}}
	   @include('settings.leavesettings.modals.addholiday')
	  {{-- edit holiday modal --}}
	   @include('settings.leavesettings.modals.editholiday')
	   {{-- Add Qualification Modal --}}
	   @include('settings.leavesettings.modals.addshift')
	  {{-- edit Qualification modal --}}
	   @include('settings.leavesettings.modals.editshift')
<script type="text/javascript">
	 $('.datepicker').datepicker({
    autoclose: true
});
	  $('.bstoggle').bootstrapToggle({
      on: 'Yes',
      off: 'No',
      onstyle:'info',
      offstyle:'default'
    });
	  $(document).on('submit','#leavePolicyForm',function(event){
		 event.preventDefault();
		 var form = $(this);
		    var formdata = false;
		    if (window.FormData){
		        formdata = new FormData(form[0]);
		    }
		    $.ajax({
		        url         : '{{route('leave_policy.store')}}',
		        data        : formdata ? formdata : form.serialize(),
		        cache       : false,
		        contentType : false,
		        processData : false,
		        type        : 'POST',
		        success     : function(data, textStatus, jqXHR){

		            toastr.success("Changes saved successfully",'Success');
		            
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
	   

	  $(document).on('submit','#addLeaveForm',function(event){
		 event.preventDefault();
		 var form = $(this);
		    var formdata = false;
		    if (window.FormData){
		        formdata = new FormData(form[0]);
		    }
		    $.ajax({
		        url         : '{{route('leaves.store')}}',
		        data        : formdata ? formdata : form.serialize(),
		        cache       : false,
		        contentType : false,
		        processData : false,
		        type        : 'POST',
		        success     : function(data, textStatus, jqXHR){

		            toastr.success("Changes saved successfully",'Success');
		            $('#addLeaveModal').modal('toggle');
					$( "#ldr" ).load('{{route('leavesettings')}}');
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
	 $(document).on('submit','#editLeaveForm',function(event){
		 event.preventDefault();
		 var form = $(this);
		    var formdata = false;
		    if (window.FormData){
		        formdata = new FormData(form[0]);
		    }
		    $.ajax({
		        url         : '{{route('leaves.store')}}',
		        data        : formdata ? formdata : form.serialize(),
		        cache       : false,
		        contentType : false,
		        processData : false,
		        type        : 'POST',
		        success     : function(data, textStatus, jqXHR){

		            toastr.success("Changes saved successfully",'Success');
		            $('#editLeaveModal').modal('toggle');
					$( "#ldr" ).load('{{route('leavesettings')}}');
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

	 $(document).on('submit','#addHolidayForm',function(event){
		 event.preventDefault();
		 var form = $(this);
		    var formdata = false;
		    if (window.FormData){
		        formdata = new FormData(form[0]);
		    }
		    $.ajax({
		        url         : '{{route('holidays.store')}}',
		        data        : formdata ? formdata : form.serialize(),
		        cache       : false,
		        contentType : false,
		        processData : false,
		        type        : 'POST',
		        success     : function(data, textStatus, jqXHR){

		            toastr.success("Changes saved successfully",'Success');
		            $('#addHolidayModal').modal('toggle');
					$( "#ldr" ).load('{{route('leavesettings')}}');
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
	 $(document).on('submit','#editHolidayForm',function(event){
		 event.preventDefault();
		 var form = $(this);
		    var formdata = false;
		    if (window.FormData){
		        formdata = new FormData(form[0]);
		    }
		    $.ajax({
		        url         : '{{route('holidays.store')}}',
		        data        : formdata ? formdata : form.serialize(),
		        cache       : false,
		        contentType : false,
		        processData : false,
		        type        : 'POST',
		        success     : function(data, textStatus, jqXHR){

		            toastr.success("Changes saved successfully",'Success');
		            $('#editHolidayModal').modal('toggle');
					$( "#ldr" ).load('{{route('leavesettings')}}');
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
  	
  	$(document).on('submit','#addShiftForm',function(event){
		 event.preventDefault();
		 var form = $(this);
		    var formdata = false;
		    if (window.FormData){
		        formdata = new FormData(form[0]);
		    }
		    $.ajax({
		        url         : '{{route('shifts.store')}}',
		        data        : formdata ? formdata : form.serialize(),
		        cache       : false,
		        contentType : false,
		        processData : false,
		        type        : 'POST',
		        success     : function(data, textStatus, jqXHR){

		            toastr.success("Changes saved successfully",'Success');
		            $('#addShiftModal').modal('toggle');
					$( "#ldr" ).load('{{route('leavesettings')}}');
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
	 $(document).on('submit','#editShiftForm',function(event){
		 event.preventDefault();
		 var form = $(this);
		    var formdata = false;
		    if (window.FormData){
		        formdata = new FormData(form[0]);
		    }
		    $.ajax({
		        url         : '{{route('shifts.store')}}',
		        data        : formdata ? formdata : form.serialize(),
		        cache       : false,
		        contentType : false,
		        processData : false,
		        type        : 'POST',
		        success     : function(data, textStatus, jqXHR){

		            toastr.success("Changes saved successfully",'Success');
		            $('#editShiftModal').modal('toggle');
					$( "#ldr" ).load('{{route('leavesettings')}}');
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
  	
  	function prepareLEditData(leave_id){
    $.get('{{ url('/settings/leave') }}/'+leave_id,function(data){
    	console.log(data.date);
     $('#editlid').val(data.id);
     $('#editlname').val(data.name);
    });

    $('#editLeaveModal').modal();
  }

  function prepareHEditData(holiday_id){
    $.get('{{ url('/settings/holiday') }}/'+holiday_id,function(data){
    	// console.log(data);
     $('#edithid').val(data.id);
     $('#edithdate').val(data.date);
     $('#edithtitle').val(data.title);
    });
    $('#editHolidayModal').modal();
  }

  function prepareSEditData(shift_id){
    $.get('{{ url('/settings/shift') }}/'+shift_id,function(data){
    	// console.log(data);
     $('#editsid').val(data.id);
     $('#editstype').val(data.type);
     $('#editsstart_time').val(data.start_time);
     $('#editsend_time').val(data.end_time);
    });
    $('#editShiftModal').modal();
  }
</script>