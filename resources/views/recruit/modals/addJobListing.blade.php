<div class="modal fade" id="addJoblistingModal" aria-labelledby="examplePositionSidebar" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
  <form id="addJobListingForm">
  <div class="modal-dialog modal-sidebar modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">List Job</h4>
      </div>
      <div class="modal-body">
        @csrf
         <div class="form-group " >
          <label class="form-control-label" for="department_id">Department</label>
          <select class="form-control" id="department_id" name="department_id"  onchange="departmentChange(this.value);" required>
            @forelse($departments as $department)
            <option value="{{$department->id}}" >{{$department->name}}</option>
            @empty
            <option value="0">Please Create a department</option>
            @endforelse
          </select>
        </div>

        <div class="form-group " >
          <label class="form-control-label" for="jobroles">Job Role</label>
          <select class="form-control" id="jobroles" name="job_id" required>
            @forelse($jobs as $job)
            <option value="{{$job->id}}" >{{$job->title}}</option>
            @empty
            <option value="0">Please Create a job role in department</option>
            @endforelse
          </select>
        </div>
        <div class="form-group">
          <label class="example-title" for="jtype">Display</label>
          
          <select required="" name="jtype" style="width:100%;" id="jtype" class="form-control " >
            <option  value='1'>Internal</option>
            <option  value='2'>Public</option>
              <option  value='3'>Internal and Public</option>
          </select>
        </div>
        <div class="form-group">
          <label class="example-title" for="type">Job Level</label>
          
          <select required="" name="level" style="width:100%;" id="level" class="form-control " >
            <option  value='1'>Graduate Trainee</option>
            <option  value='2'>Entry Level</option>
              <option  value='3'>Non Manager</option>
              <option  value='4'>Manager</option>
          </select>
        </div>
        <div class="form-group">
          <label class="example-title" for="salary_from">Salary </label>
           <div class=" input-group" >
                    <input type="number" class=" form-control"  name="salary_from" placeholder="From Amount" />
                    <span class="input-group-addon">to</span>
                    <input type="number" class="form-control"  name="salary_to"placeholder="To Amount" />
                </div>
        </div>
        <div class="form-group">
          <label class="example-title" for="salary_from"> Experience (Years)</label>
           <div class=" input-group" >
                    <input type="number" class=" form-control" i  name="experience_from" placeholder="From Year" />
                    <span class="input-group-addon">to</span>
                    <input type="number" class="form-control"  name="experience_to" placeholder="To Year" />
                </div>
          
        </div>
        <div class="form-group">
          <label class="example-title" for="expires">Expires</label>
          
          <input type="text" name="expires" class="form-control datepicker">
        </div>
        <div class="form-group">
           <label class="example-title" for="requirements">Extra Requirements</label>
          <textarea name="requirements" id="requirements" class="form-control" rows="6"></textarea>
        </div>
                <input type="hidden" name="type" value="save_listing">   
        </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-block waves-effect">Save changes</button>
        <button type="button" class="btn btn-default btn-block btn-pure waves-effect" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  </form>
</div>