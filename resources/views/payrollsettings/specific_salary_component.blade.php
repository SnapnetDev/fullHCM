	<div class="page-header">
  		<h1 class="page-title">{{__('All Settings')}}</h1>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
		    <li class="breadcrumb-item ">{{__('Employee Settings')}}</li>
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
		              <h3 class="panel-title">Specific Salary Components</h3>
		              <div class="panel-actions">
                			<button class="btn btn-info" data-toggle="modal" data-target="#addSpecificSalaryComponentModal">Add Specific Salary Component</button>

              			</div>
		            	</div>
		            <div class="panel-body">
		            <div class="table-responsive">
	                  <table  class="table table-striped " id="dataTable">
		                    <thead>
		                      <tr>
		                        <th>Name:</th>
		                        <th>Type:</th>
		                        <th>Employee Name:</th>
		                        <th>Amount:</th>
		                        <th>Comment:</th>
		                        <th>Duration:</th>
		                        <th>Grants:</th>
		                        <th>Status</th>
	                          	<th>Alter Status</th>
	                          	<th>Action</th>
		                      </tr>
		                    </thead>
		                    <tbody>
		                    	@forelse($sscs as $salary_component)
		                    	<tr>
		                    		<td>{{$salary_component->name}}</td>
		                    		<td>{{$salary_component->type == 1 ? 'Allowance' : 'Deduction' }}</td>
		                    		<td>{{$salary_component->user->name}}</td>
		                    		<td>₦{{$salary_component->amount}}</td>
		                    		<td>{{$salary_component->comment}}</td>
		                    		<td>{{$salary_component->duration}}</td>
		                    		<td>{{$salary_component->grants}}</td>
		                    		<td>{{'Completed'}}</td>
		                    		<td><button class="btn sc-status btn-sm {{ $salary_component->status == 1 ? 'btn-success' : 'btn-warning' }}" title="{{ $salary_component->status == 1 ? 'Pause' : 'Resume' }}" id="{{$salary_component->id}}" on><i class="fa fa-{{ $salary_component->status == 1 ? 'play' : 'pause' }}" ></i></button></td>
		                    		
		                    		
		                    		<td>
		                    			<div class="btn-group" role="group">
					                    <button type="button" class="btn btn-primary dropdown-toggle" id="exampleIconDropdown1"
					                    data-toggle="dropdown" aria-expanded="false">
					                      Action
					                    </button>
				                    <div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu">
				                       <a class="dropdown-item" id="{{$salary_component->id}}" onclick="deleteSalaryComponent(this.id)"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete Salary Component</a>
				                      
				                    </div>
				                  </div></td>
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
	  {{-- Add Grade Modal --}}
	   @include('payrollsettings.modals.addspecificsalarycomponent')
	 
	  <!-- End Page -->
	    <script type="text/javascript">
	    	 $(document).ready( function () {
    $('#dataTable').DataTable();
} );
  	$(function() {
  

  	$(document).on('submit','#addSpecificSalaryComponentForm',function(event){
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
  });


  	$(function() {
  	$(document).on('click','.sc-status',function(event){
  		salary_component_id= $(this).attr('id');
  		
  		 $.get('{{ url('/payrollsettings/change_specific_salary_component_status') }}/',{ specific_salary_component_id: salary_component_id },function(data){
  		 	if (data==1) {
  		 		toastr.success("Salary Component Activated",'Success');
  		 	}
  		 	if(data==2){
  		 		toastr.warning("Salary Component Paused",'Success');
  		 	}
  		 	$( "#ldr" ).load('{{url('payrollsettings/specific_salary_components')}}');
  		 });
  	});
  });
  	


  function deleteSalaryComponent(salary_component_id){
    $.get('{{ url('/payrollsettings/delete_salary_component') }}/',{ salary_component_id: salary_component_id },function(data){
    	if (data=='success') {
 		toastr.success("Salary Component deleted successfully",'Success');
 		$( "#ldr" ).load('{{url('payrollsettings/salary_components')}}');
    	}else{
    		toastr.error("Error deleting Salary Component",'Success');
    	}
     
    });
  }

  
 
 $(function(){

  $('#emps').select2({
  	placeholder: "Employee Name",
  	 multiple: false,
  	id: function(bond){ return bond._id; },
	   ajax: {
		 delay: 250,
		 processResults: function (data) {
					return {				
		results: data
			};
		},
		url: function (params) {
		return '{{url('users')}}/search';
		}	
		}
		
	});
  
  });
  </script>
