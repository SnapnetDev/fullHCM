<!-- Modal -->
                  <div class="modal fade modal-success" id="addUserForm" aria-hidden="false" aria-labelledby="addUserForm"
                  role="dialog" tabindex="-1">
                    <div class="modal-dialog  modal-top modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="exampleFillInModalTitle">New Employee</h4>
                        </div>
                        <div class="modal-body">
                          <form>
                            <div class="row">
                              <div class="col-xs-12 col-xl-6 form-group">
                                <div class="form-group " >
                                  <label class="form-control-label" for="name">Name</label>
                                  <input type="text" class="form-control" id="name"  name="name" placeholder="Name"
                                   required />
                                </div>
                              </div>
                              <div class="col-xs-12 col-xl-6 form-group">
                               <div class="form-group " >
                                  <label class="form-control-label" for="emp_num">Employee Number</label>
                                  <input type="text" class="form-control" id="emp_num"  name="emp_num" placeholder="Employee Number"
                                   required />
                                </div>
                              </div>
                              <div class="col-xs-12 col-xl-6 form-group">
                                <div class="form-group " >
                                  <label class="form-control-label" for="email">Email</label>
                                  <input type="email" class="form-control" id="email"  name="email" placeholder="Email"
                                   required />
                                </div>
                              </div>
                              <div class="col-xs-12 col-xl-6 form-group">
                               <div class="form-group " >
                                  <label class="form-control-label" for="phone">Phone Number</label>
                                  <input type="text" class="form-control" id="phone"  name="phone" placeholder="Phone Number"
                                   required />
                                </div>
                              </div>
                               <div class="col-xs-12 col-xl-6 form-group">
                                <div class="form-group " >
                                  <label class="form-control-label" for="sex">Sex</label>
                                  <select class="form-control" id="sex" name="sex">
                                    <option>Male</option>
                                    <option>Female</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-xs-12 col-xl-6 form-group">
                               <div class="form-group " >
                                  <label class="form-control-label" for="grade">Grade</label>
                                  <input type="text" class="form-control" id="grade"  name="grade" placeholder="Grade"
                                   required />
                                </div>
                              </div>
                              <div class="col-xs-12 col-xl-6 form-group">
                                <div class="form-group " >
                                  <label class="form-control-label" for="company_id">Company</label>
                                  <select class="form-control" id="company_id" name="company_id" required onchange="getDepartmentBranchesNew(this.value);">
                                    @forelse($companies as $company)
                                    <option value="{{$company->id}}" {{$company->is_parent==1?'selected':''}}>{{$company->name}}</option>
                                    @empty
                                    <option value="0">Please Create a company</option>
                                    @endforelse
                                  </select>
                                </div>
                              </div>
                              <div class="col-xs-12 col-xl-6 form-group">
                               <div class="form-group " >
                                  <label class="form-control-label" for="branch_id">Branch</label>
                                  <select class="form-control" id="branch_id" name="branch_id" required>
                                     @forelse($branches as $branch)
                                    <option value="{{$branch->id}}" >{{$branch->name}}</option>
                                    @empty
                                    <option value="0">Please Create a branch</option>
                                    @endforelse
                                  </select>
                                </div>
                              </div>
                              <div class="col-xs-12 col-xl-6 form-group">
                                <div class="form-group " >
                                  <label class="form-control-label" for="department_id">Department</label>
                                  <select class="form-control" id="department_id" name="department_id" required>
                                    @forelse($departments as $department)
                                    <option value="{{$department->id}}" >{{$department->name}}</option>
                                    @empty
                                    <option value="0">Please Create a department</option>
                                    @endforelse
                                  </select>
                                </div>
                              </div>
                              <div class="col-xs-12 col-xl-6 form-group">
                               <div class="form-group " >
                                  <label class="form-control-label" for="job_id">Job Role</label>
                                  <select class="form-control" id="job_id" name="job_id">
                                    <option>Branch 1</option>
                                    <option>Branch 2</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-success">Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Modal -->