<div class="page-header">
  		<h1 class="page-title">{{__('All Settings')}}</h1>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
		    <li class="breadcrumb-item ">{{__('System Settings')}}</li>
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
        		{{-- <div class="panel panel-info panel-line">
		            <div class="panel-heading">
		              <h3 class="panel-title">Has Subsidiaries</h3>
		              <div class="panel-actions">
                			<input type="checkbox" class="active-toggle" id="hasSubsidiaries" {{$has_sub->value==1?'checked':''}}>

              			</div>
		            	</div>
		            <div class="panel-body">
		            <p>Enable if you have subsidiaries and disable if you do not have subsidiaries</p>
	                  
	          		</div>
	          		
		          </div> --}}
<<<<<<< HEAD
		          <div class="panel panel-info panel-line">
		            <div class="panel-heading">
		              <h3 class="panel-title">System Name and Logo Settings</h3>
		              <div class="panel-actions">
                			

              			</div>
		            	</div>
		            	<form id="whiteLabelForm" enctype="multipart/form-data">
		            <div class="panel-body">
		            <div class="col-md-6">
		            	@csrf
		            		<div class="form-group">
	          					<h4>Logo</h4>
	          					 <img class=" img-bordered  text-center" width="150" height="auto" src="{{file_exists(public_path('uploads/logo'.$logo->value))?asset('uploads/logo'.$logo->value): asset('assets/images/logo.png') }}" id='img-upload'>
					      
					        <div class="input-group">
					            <span class="input-group-btn">
					                <span class="btn btn-default btn-file">
					                    Browse… <input type="file" id="imgInp" name="logo" accept="image/*">
					                </span>
					            </span>
					           
					        </div>
	          				</div>
	          				<div class="form-group" >
	          					<h4>System Name</h4>
	          					<input type="text" name="name" class="form-control" value="{{$name->value}}">
	          				</div>
	          				
	          					            	
		            </div>
	                 
	          		</div>
	          		<div class="panel-footer">
	          			<div class="form-group">
	          					<button class="btn btn-info" >Save Changes</button>
	          				</div>
	          		</div>
	          		</form>
		          </div>
=======
>>>>>>> 756669c79ba12453137381addef2325f0d752945
		          <div class="panel panel-info panel-line">
		            <div class="panel-heading">
		              <h3 class="panel-title">Use Parent Company Settings Across</h3>
		              <div class="panel-actions">
                			<input type="checkbox" class="active-toggle" id="useParent" {{$use_parent_setting->value==1?'checked':''}}>

              			</div>
		            	</div>
		            <div class="panel-body">
		            <p>Enable if you have subsidiaries and disable if you do not have subsidiaries</p>
	                  
	          		</div>
	          		
		          </div>
		          <div class="panel panel-info panel-line">
		            <div class="panel-heading">
		              <h3 class="panel-title">Configure Allowed IP Address</h3>
		              <div class="panel-actions">
                			<button class="btn btn-info" data-toggle="modal" data-target="#addIPModal">Add IP Address</button>

              			</div>
		            	</div>
		            <div class="panel-body">
		            
	                  <table id="exampleTablePagination" data-toggle="table" 
		                  data-query-params="queryParams" data-mobile-responsive="true"
		                  data-height="400" data-pagination="true" data-search="true" class="table table-striped">
		                    <thead>
		                      <tr>
		                        <th >S/N:</th>
		                        <th >Address:</th>
		                        <th >Action:</th>
		                      </tr>
		                    </thead>
		                    <tbody>
		                    	
		                    	
		                    </tbody>
	                  </table>
	          		</div>
	          		</div>
	        	</div>
	    	</div>
	    	<div class="col-md-12 col-xs-12">
	    		
	    	</div>
		</div>
	  </div>
{{-- Add IP Modal --}}
	   @include('settings.systemsettings.modals.addip')
	  {{-- edit IP modal --}}
	   @include('settings.systemsettings.modals.editip')
<script type="text/javascript">
  $(function() {
    $('#hasSubsidiaries').bootstrapToggle({
      on: 'Enabled',
      off: 'Disabled',
      onstyle:'info',
      offstyle:'default'
    });

    $('#useParent').bootstrapToggle({
      on: 'Enabled',
      off: 'Disabled',
      onstyle:'info',
      offstyle:'default'
    });
    
    


    $('#hasSubsidiaries').change(function() {
    	if ($(this).prop('checked')==true) {
    		
    		$('#useParent').bootstrapToggle('enable');

    	}else{
    		$('#useParent').bootstrapToggle({onstyle:'default'});
    		$('#useParent').bootstrapToggle('disable');
    	}

    	$.get('{{ url('/settings/system/switchhassub') }}/',function(data){
  		 	if (data==1) {
  		 		toastr.success("Has Subsidiary Enabled",'Success');
  		 	}
  		 	if(data==2){
  		 		toastr.warning("Has Subsidiary Disabled",'Success');
  		 	}
  		 	$( "#ldr" ).load('{{route('systemsettings')}}');
  		 });
        
    })

    $('#useParent').on('change', function() {

		 $.get('{{ url('/settings/system/switchuseparent') }}/',function(data){
  		 	if (data==1) {
  		 		toastr.success("Parent Setting Use Enabled",'Success');
  		 	}
  		 	if(data==2){
  		 		toastr.warning("Parent Setting Use Disabled",'Success');
  		 	}
  		 	$( "#ldr" ).load('{{route('systemsettings')}}');
  		 });
		});
  });
  $(function() {
  
$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [label]);
		});

		// $('.btn-file :file').on('fileselect', function(event, label) {
		    
		//     var input = $(this).parents('.input-group').find(':text'),
		//         log = label;
		    
		//     if( input.length ) {
		//         input.val(log);
		//     } else {
		//         if( log ) alert(log);
		//     }
	    
		// });

		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        
		        reader.onload = function (e) {
		            $('#img-upload').attr('src', e.target.result);
		        }
		        
		        reader.readAsDataURL(input.files[0]);
		    }
		}

		$("#imgInp").change(function(){
		    readURL(this);
		}); 

  	
  	$(document).on('submit','#whiteLabelForm',function(event){
		 event.preventDefault();
		 var form = $(this);
		    var formdata = false;
		    if (window.FormData){
		        formdata = new FormData(form[0]);
		    }
		    $.ajax({
		        url         : '{{route('systemsettings.store')}}',
		        data        : formdata ? formdata : form.serialize(),
		        cache       : false,
		        contentType : false,
		        processData : false,
		        type        : 'POST',
		        success     : function(data, textStatus, jqXHR){

		            toastr["success"]("Changes saved successfully",'Success');
		          
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
 
</script>