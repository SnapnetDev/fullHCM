<div class="modal fade in modal-3d-flip-horizontal modal-info" id="addSkillModal" aria-hidden="true" aria-labelledby="addSkillModal" role="dialog" tabindex="-1">
	    <div class="modal-dialog ">
	      <form class="form-horizontal" id="addSkillForm"  method="POST">
	        <div class="modal-content">        
	        <div class="modal-header" >
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title" id="training_title">Add New Skill</h4>
	        </div>
            <div class="modal-body">         
                <div class="row row-lg col-xs-12">            
                  <div class="col-xs-12"> 
                  	@csrf
                  	
                    <div class="form-group">
                      <h4 class="example-title">Skill</h4>
                       <input type="text"  required placeholder="Name" name="name"   class="form-control">
                    </div>
                  	<div class="form-group">
                  		<h4 class="example-title">Experience (Years)</h4>
                  		 <input type="text"  required placeholder="Experience" name="experience"   class="form-control">
                  	</div>
                    <div class="form-group">
                      <h4 class="example-title">Rating</h4>
                       <select name="rating" class="form-control" required>
                         <option value="1">Beginner</option>
                         <option value="2">Amateur</option>
                         <option value="3">Intermediate</option>
                         <option value="4">Professional</option>
                         <option value="5">Expert</option>
                       </select>
                    </div>
                    <div class="form-group">
                      <h4 class="example-title">Remark</h4>
                      <textarea class="form-control" name="remark"></textarea>
                    </div>
                  	
                  	 <input type="hidden" name="user_id" value="{{$user->id}}">
                     <input type="hidden" name="type" value="skill">
                  </div>
                  <div class="clearfix hidden-sm-down hidden-lg-up"></div>            
                </div>        
            </div>
            <div class="modal-footer">
              <div class="col-xs-12">
              
                  <div class="form-group">
                    
                    <button type="submit" class="btn btn-info pull-left">Save</button>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                  </div>
                  <!-- End Example Textarea -->
                </div>
             </div>
	       </div>
	      </form>
	    </div>
	  </div>