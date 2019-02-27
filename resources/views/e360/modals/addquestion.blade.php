<!--- Add Subject modal start -->
  <div class="modal fade in modal-3d-flip-horizontal modal-primary" id="addQuestionModal" aria-hidden="true" aria-labelledby="addQuestionModal"
  role="dialog" tabindex="-1">
   
    <div class="modal-dialog ">
      <form class="form-horizontal" id="addQuestionForm" role="form" method="POST">
        <div class="modal-content">        
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title" id="training_title">Add Question</h4>
        </div>
        <div class="modal-body">         
               
          <div class="row row-lg col-xs-12">            
            <div class="col-xs-12"> 
              
              
              <div class="form-group">
                <h4 class="example-title">Question</h4>
             
               <textarea  name="question" class="form-control "></textarea>
              </div>
  
            </div>

              <input type="hidden" name="type" value="save_question">
              <input type="hidden"  name="det_id" value="{{$det->id}}" >
            <div class="clearfix hidden-sm-down hidden-lg-up"></div>            
          </div>        
        </div>
        <div class="modal-footer">
          <div class="col-xs-12">
              <!-- Example Textarea -->
              <div class="form-group">
               
                {{ csrf_field() }}
                <div class="text-xs-left"><input type="submit" class="btn btn-primary " id="sugtraining_btn" value="Save" >
               <input type="button" class="btn btn-default " value="Cancel"  data-dismiss="modal"></div>
              </div>
              <!-- End Example Textarea -->
            </div>
         </div>
       </div>
      </form>
    </div>
  </div>
  <!-- Add subject modal end -->