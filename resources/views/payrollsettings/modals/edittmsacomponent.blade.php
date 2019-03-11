<div class="modal fade in modal-3d-flip-horizontal modal-info" id="editTmsaComponentModal" aria-hidden="true" aria-labelledby="editTmsaComponentModal" role="dialog" tabindex="-1">
      <div class="modal-dialog ">
        <form class="form-horizontal" id="editTmsaComponentForm"  method="POST">
          <div class="modal-content">        
          <div class="modal-header" >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="training_title">Edit TMSA Component</h4>
          </div>
            <div class="modal-body">         
                <div class="row row-lg col-xs-12">            
                  <div class="col-xs-12"> 
                    @csrf
                    <div class="form-group" >
                      <h4 class="example-title">Type</h4>
                      <input type="radio" id="edittcallowance" name="tctype" value="1"> Allowance
                      <input type="radio" id="edittcdeduction" name="tctype" value="0"> Deduction
                    </div>
                    <div class="form-group">
                      <h4 class="example-title">Name</h4>
                      <input type="text" name="name" id="edittcname" class="form-control">
                    </div>
                    <div class="form-group">
                      <h4 class="example-title">Comment (A note about this component)</h4>
                      <textarea name="comment" id="edittccomment" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                      <h4 class="example-title">Amount</h4>
                      <input type="text" name="amount" id="edittcamount" class="form-control">
                    </div>
                    <div class="form-group">
                      <h4 class="example-title">Constant</h4>
                      <input type="text" name="constant" id="edittcconstant" class="form-control">
                    </div>
                    <div class="form-group">
                      <label class="example-title" for="edittaxable">Taxable</label>
                      
                      <select required="" name="taxable" style="width:100%;" id="edittctaxable" class="form-control " >
                        <option selected value='0'>No</option>
                        <option selected value='1'>Yes</option></select>
                    </div>
                    <div class="form-group">
                      <h4 class="example-title">General Ledger Code</h4>
                      <input type="text" name="gl_code" id="edittcgl_code" class="form-control">
                    </div>
                    <div class="form-group">
                      <h4 class="example-title">Project Code</h4>
                      <input type="text" name="project_code" id="edittcproject_code" class="form-control">
                    </div>
                    <div class="form-group">
                      <label class="example-title" for="constant">Applies to All Employee Except</label>
                      <!-- <input class="form-control" type="text" name="constant" value="{{ old('constant') }}"/> -->
                      <select name="exemptions[]" style="width:100%;" id="edittcexemptions" multiple></select>
                    </div>
                    <input type="hidden" name="tmsa_component_id" id="edittcid">
                    <input type="hidden" name="type" value="tmsa_component">
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