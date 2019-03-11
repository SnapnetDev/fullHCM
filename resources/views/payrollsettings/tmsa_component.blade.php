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
		              <h3 class="panel-title">Tmsa Components</h3>
		              <div class="panel-actions">
                			<button class="btn btn-info" data-toggle="modal" data-target="#addTmsaComponentModal">Add Tmsa Component</button>

              			</div>
		            	</div>
		            <div class="panel-body">
		            <div class="table-responsive">
	                  <table  class="table table-striped " id="dataTable">
		                    <thead>
		                      <tr>
		                        <th>Name:</th>
		                        <th>Type:</th>
		                        <th>Constant:</th>
		                        <th>Amount</th>
		                         <th>GL Code</th>
		                          <th>Project Code</th>
		                        <th>Comment</th>
		                        <th>Taxable</th>
		                        <th>Status</th>
		                         <th>Exemption List</th>
		                          <th>Action</th>
		                      </tr>
		                    </thead>
		                    <tbody>
		                    	@forelse($tcs as $tmsa_component)
		                    	<tr>
		                    		<td>{{$tmsa_component->name}}</td>
		                    		<td>{{ $tmsa_component->type == 1 ? 'Allowance' : 'Deduction' }}</td>
		                    		<td>{{$tmsa_component->constant}}</td>
		                    		<td>{{$tmsa_component->amount}}</td>
		                    		<td>{{$tmsa_component->gl_code}}</td>
		                    		<td>{{$tmsa_component->project_code}}</td>
		                    		<td>{{$tmsa_component->comment}}</td>
		                    		<td><input type="checkbox" class="active-toggle sc-taxable" id="{{$tmsa_component->id}}" {{$tmsa_component->taxable == 1?'checked':''}} data-size="mini">
		                    		<td><input type="checkbox" class="active-toggle sc-status" id="{{$tmsa_component->id}}" {{$tmsa_component->status == 1?'checked':''}} data-size="mini">
		            				
		                    		<td>
		                    			
		                    			@foreach($tmsa_component->exemptions as $user)
		                    			@if ($loop->last)
									        {{$user->name}}
								        @else
								        	{{$user->name}},
									    @endif
		                    			
		                    			
		                    			 
		                    			@endforeach
		                    		</td>
		                    		
		                    		<td>
		                    			<div class="btn-group" role="group">
					                    <button type="button" class="btn btn-primary dropdown-toggle" id="exampleIconDropdown1"
					                    data-toggle="dropdown" aria-expanded="false">
					                      Action
					                    </button>
				                    <div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu">
				                      <a class="dropdown-item" id="{{$tmsa_component->id}}" onclick="prepareEditData(this.id)"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit TMSA Component</a>
				                       <a class="dropdown-item" id="{{$tmsa_component->id}}" onclick="deleteSalaryComponent(this.id)"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete TMSA Component</a>
				                      
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
	   @include('payrollsettings.modals.addtmsacomponent')
	  {{-- edit grade modal --}}
	   @include('payrollsettings.modals.edittmsacomponent')
	  <!-- End Page -->
	    <script type="text/javascript">
	    	 $(document).ready( function () {
    $('#dataTable').DataTable();
    $('.sc-status').bootstrapToggle({
      on: 'on',
      off: 'off',
      onstyle:'info',
      offstyle:'default'
    });
    $('.sc-taxable').bootstrapToggle({
      on: 'on',
      off: 'off',
      onstyle:'info',
      offstyle:'default'
    });
} );
  	$(function() {
  

  	$(document).on('submit','#addTmsaComponentForm',function(event){
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
		           $('#addTmsaComponentModal').modal('toggle');
					$( "#ldr" ).load('{{url('payrollsettings/tmsa_components')}}');

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
  	$(document).on('submit','#editTmsaComponentForm',function(event){
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
		            $('#editTmsaComponentModal').modal('toggle');
					$( "#ldr" ).load('{{url('payrollsettings/tmsa_components')}}');
		        },
		        error:function(data, textStatus, jqXHR){
		        	 jQuery.each( data['responseJSON'], function( i, val ) {
							  jQuery.each( val, function( i, valchild ) {
							  toastr["error"](valchild[0]);
							});  
							});
		        }
		    });
      
		});
  });

  // 	$(function() {
  // 	$(document).on('click','.sc-status',function(event){
  		
  // 		salary_component_id= $(this).attr('id');
  		
  // 		 $.get('{{ url('/payrollsettings/change_salary_component_status') }}/',{ salary_component_id: salary_component_id },function(data){
  // 		 	if (data==1) {

  // 		 		toastr.success("Salary Component Enabled",'Success');
  // 		 		$(this).removeClass('btn-warning');
  // 		 		$(this).addClass('btn-success');
  // 		 	}
  // 		 	if(data==2){
  // 		 		toastr.warning("Salary Component Disabled",'Success');
  // 		 		$(this).addClass('btn-warning');
  // 		 		$(this).removeClass('btn-success');
  // 		 	}
  		 	
  // 		 });
  		 
  // 	});
  // });
  	
  	function prepareEditData(tmsa_component_id){
    $.get('{{ url('/payrollsettings/tmsa_component') }}/',{ tmsa_component_id: tmsa_component_id },function(data){
    	
     $('#edittcname').val(data.name);
     $('#edittccomment').val(data.comment);
     $('#edittcamount').val(data.amount);
     $('#edittcconstant').val(data.constant);
      $('#edittcgl_code').val(data.gl_code);
       $('#edittcproject_code').val(data.project_code);
       $('#edittctaxable').val(data.taxable);
      $("#edittcexemptions").find('option')
    .remove();
    console.log(data.type);
    if (data.type==1) {
    	$("#edittcallowance").prop("checked", true);
    	$("#edittcdeduction").prop("checked", false);
    }else{
    	$("#edittcdeduction").prop("checked", true);
    	$("#edittcallowance").prop("checked", false);
    }
    
     jQuery.each( data.exemptions, function( i, val ) {
       $("#edittcexemptions").append($('<option>', {value:val.id, text:val.name,selected:'selected'}));
       // console.log(val.name);
              });	
     $('#edittcid').val(data.id);
    });
    $('#editTmsaComponentModal').modal();
  }

  function deleteTmsaComponent(tmsa_component_id){
    $.get('{{ url('/payrollsettings/delete_tmsa_component') }}/',{ tmsa_component_id: tmsa_component_id },function(data){
    	if (data=='success') {
 		toastr.success("TMSA Component deleted successfully",'Success');
 		$( "#ldr" ).load('{{url('payrollsettings/tmsa_components')}}');
    	}else{
    		toastr.error("Error deleting TMSA Component",'Success');
    	}
     
    });
  }

  
 
 $(function(){

  $('#exemptions').select2({
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
  $('#edittcexemptions').select2({
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
	$(function() {
  	 $('.sc-status').on('change', function() {
  		tmsa_component_id= $(this).attr('id');
  		
  		 $.get('{{ url('/payrollsettings/change_tmsa_component_status') }}/',{ tmsa_component_id: tmsa_component_id },function(data){
  		 	if (data==1) {
  		 		toastr.success("TMSA Component Enabled",'Success');
  		 	}
  		 	if(data==2){
  		 		toastr.warning("TMSA Component Disabled",'Success');
  		 	}
  		 	$( "#ldr" ).load('{{url('payrollsettings/tmsa_components')}}');
  		 });
  	});
  	 	});

	$(function() {
  	 $('.sc-taxable').on('change', function() {
  		tmsa_component_id= $(this).attr('id');
  		
  		 $.get('{{ url('/payrollsettings/change_tmsa_component_taxable') }}/',{ tmsa_component_id: tmsa_component_id },function(data){
  		 	if (data==1) {
  		 		toastr.success("TMSA Component is now Taxable",'Success');
  		 	}
  		 	if(data==2){
  		 		toastr.warning("TMSA Component is no more Taxable",'Success');
  		 	}
  		 	$( "#ldr" ).load('{{url('payrollsettings/tmsa_components')}}');
  		 });
  	});
  	 	});
  </script>

