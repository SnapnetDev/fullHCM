<div class="site-menubar bg-white blue-grey-800">
    <div class="site-menubar-body">
      <div>
        <div>
          <ul class="site-menu" data-plugin="menu">
            @if(Auth::user()->role->manages=='none')
             <li class="site-menu-item ">
              <a href="{{ route('home') }}" dropdown-tag="false">
                <i class="site-menu-icon md-home" aria-hidden="true"></i>
                <span class="site-menu-title">Home</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->role->manages=='all')
            <li class="dropdown site-menu-item has-sub">
              <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                <i class="site-menu-icon fa fa-sitemap" aria-hidden="true"></i>
                <span class="site-menu-title">Home</span>
                <span class="site-menu-arrow"></span>
              </a>
              <div class="dropdown-menu">
                <div class="site-menu-scroll-wrap is-list">
                  <div>
                    <div>
                      <ul class="site-menu-sub site-menu-normal-list">
                         @if(Auth::user()->role->permissions->contains('constant', 'run_payroll'))
                        <li class="site-menu-item ">
                          <a class="animsition-link" href="{{ url('compensation') }}">
                            <span class="site-menu-title">Payroll</span>
                          </a>
                        </li>
                        @endif
                         @if(Auth::user()->role->permissions->contains('constant', 'manage_user'))
                <li class="site-menu-item ">
                  <a class="animsition-link" href="{{url('users')}}">
                    <span class="site-menu-title">Manage Employee</span>
                  </a>
                </li>
                @endif
                {{--  @if(Auth::user()->role->permissions->contains('constant', 'manage_user'))
                <li class="site-menu-item ">
                  <a class="animsition-link" href="{{url('groups')}}">
                    <span class="site-menu-title">Manage User Groups</span>
                  </a>
                </li>
                @endif --}}
                @if(Auth::user()->role->permissions->contains('constant', 'view_timesheet')||Auth::user()->role->permissions->contains('constant', 'export_timesheet'))
                <li class="site-menu-item ">
                  <a class="animsition-link" href="{{ url('timesheets') }}">
                    <span class="site-menu-title">TimeSheets</span>
                  </a>
                </li>
                @endif
                @if(Auth::user()->role->permissions->contains('constant', 'view_attendance'))
                <li class="site-menu-item ">
                  <a class="animsition-link" href="{{url('attendance/reports')}}">
                    <span class="site-menu-title">View Attendance</span>
                  </a>
                </li>
                @endif
                @if(Auth::user()->role->permissions->contains('constant', 'view_shift_schedule'))
                <li class="site-menu-item ">
                  <a class="animsition-link" href="{{ route('shift_schedules') }}">
                    <span class="site-menu-title">Shift Schedules</span>
                  </a>
                </li>
                @endif
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            
@endif
           
            <li class="dropdown site-menu-item has-sub">
              <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                <i class="site-menu-icon fa fa-sitemap" aria-hidden="true"></i>
                <span class="site-menu-title">Self Service</span>
                <span class="site-menu-arrow"></span>
              </a>
              <div class="dropdown-menu">
                <div class="site-menu-scroll-wrap is-list">
                  <div>
                    <div>
                      <ul class="site-menu-sub site-menu-normal-list">
                         <li class="site-menu-item ">
                          <a class="animsition-link" href="{{ route('shift_schedule.user',['user_id'=>Auth::user()->id]) }}">
                            <span class="site-menu-title">My Shift Schedule</span>
                          </a>
                        </li>
                         <li class="site-menu-item ">
                          <a class="animsition-link" href="{{ route('attendance.user',['user_id'=>Auth::user()->id]) }}">
                            <span class="site-menu-title">My attendance</span>
                          </a>
                        </li>
                        <li class="site-menu-item ">
                          <a class="animsition-link" href="{{ url('leave/myrequests') }}">
                            <span class="site-menu-title">Leave Requests</span>
                          </a>
                        </li>
                        {{-- 
                        <li class="site-menu-item ">
                          <a class="animsition-link" href=" {{url('loan/my_loan_requests')}}">
                            <span class="site-menu-title">Loan Requests </span>
                          </a>
                        </li> --}}
                        <li class="site-menu-item ">
                          <a class="animsition-link" href="{{ url('compensation/user_payroll_list') }}">
                            <span class="site-menu-title">View payslip </span>
                          </a>
                        </li>
                        <li class="site-menu-item ">
                          <a class="animsition-link" href="{{ url('document/mydocument') }}">
                            <span class="site-menu-title">My Documents </span>
                          </a>
                        </li>{{-- 
                        <li class="site-menu-item ">
                          <a class="animsition-link" href="#">
                            <span class="site-menu-title">My Expenses </span>
                          </a>
                        </li> --}}
                        <li class="site-menu-item ">
                          <a class="animsition-link" href="{{url('recruits/myjobs')}}">
                            <span class="site-menu-title">Job Openings </span>
                          </a>
                        </li>
                        <li class="site-menu-item ">
                          <a class="animsition-link" href="{{url('directory')}}">
                            <span class="site-menu-title">Employee Directory </span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </li>
           
             
            @if(Auth::user()->role->permissions->contains('constant', 'edit_performance'))
             <li class="dropdown site-menu-item has-sub">
              <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                <i class="site-menu-icon fa fa-area-chart" aria-hidden="true"></i>
                <span class="site-menu-title">Evaluation</span>
                <span class="site-menu-arrow"></span>
              </a>
              <div class="dropdown-menu">
                <div class="site-menu-scroll-wrap is-list">
                  <div>
                    <div>
                      <ul class="site-menu-sub site-menu-normal-list">
                       
                        <li class="site-menu-item ">
                          <a class="animsition-link" href="{{ url('performances') }}">
                            <span class="site-menu-title">Perfomance</span>
                          </a>
                        </li>
                        <li class="site-menu-item ">
                          <a class="animsition-link" href="{{ url('bsc')}}">
                            <span class="site-menu-title">Balance Scorecard</span>
                          </a>
                        </li>
<<<<<<< HEAD
                     
=======
                        @endif
                        {{--  @if(Auth::user()->role->permissions->contains('constant', 'view_loan_request'))
                        <li class="site-menu-item ">
                          <a class="animsition-link" href="{{ url('loan/loan_requests') }}">
                            <span class="site-menu-title">Loan Requests</span>
                          </a>
                        </li>
                        @endif --}}
>>>>>>> 756669c79ba12453137381addef2325f0d752945
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            @endif
<<<<<<< HEAD
=======
            @if(Auth::user()->role->permissions->contains('constant', 'edit_performance'))
             <li class="dropdown site-menu-item has-sub">
              <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                <i class="site-menu-icon fa fa-area-chart" aria-hidden="true"></i>
                <span class="site-menu-title">Performance</span>
                <span class="site-menu-arrow"></span>
              </a>
              <div class="dropdown-menu">
                <div class="site-menu-scroll-wrap is-list">
                  <div>
                    <div>
                      <ul class="site-menu-sub site-menu-normal-list">
                       
                        <li class="site-menu-item ">
                          <a class="animsition-link" href="{{ url('performances') }}">
                            <span class="site-menu-title">Perfomance</span>
                          </a>
                        </li>
                        <li class="site-menu-item ">
                          <a class="animsition-link" href="{{ url('bsc')}}">
                            <span class="site-menu-title">Balance Scorecard</span>
                          </a>
                        </li>
                     
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            @endif
           
             <li class="dropdown site-menu-item has-sub">
              <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                <i class="site-menu-icon fa fa-circle-o-notch" aria-hidden="true"></i>
                <span class="site-menu-title">Review 360</span>
                <span class="site-menu-arrow"></span>
              </a>
              <div class="dropdown-menu">
                <div class="site-menu-scroll-wrap is-list">
                  <div>
                    <div>
                      <ul class="site-menu-sub site-menu-normal-list">
                       @if(Auth::user()->role->permissions->contains('constant', 'upload_review_questions'))
                        <li class="site-menu-item ">
                          <a class="animsition-link" href="{{ url('e360settings/template') }}">
                            <span class="site-menu-title">Department Review Questions</span>
                          </a>
                        </li>
                        @endif
                       
                        @if(Auth::user()->role->permissions->contains('constant', 'view_review_report'))
                        <li class="site-menu-item ">
                          <a class="animsition-link" href="{{ url('e360/select_report_department')}}">
                            <span class="site-menu-title">Employee Review Report</span>
                          </a>
                        </li>
                        @endif
                      <li class="site-menu-item ">
                          <a class="animsition-link" href="{{ url('e360/select_department')}}">
                            <span class="site-menu-title">Employee Review</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            
>>>>>>> 756669c79ba12453137381addef2325f0d752945
            <li class="dropdown site-menu-item has-section has-sub">
              <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                <i class="site-menu-icon fa fa-ellipsis-h" aria-hidden="true"></i>
                <span class="site-menu-title">More</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="dropdown-menu site-menu-sub site-menu-section-wrap blocks-md-3" >
                 @if(Auth::user()->role->permissions->contains('constant', 'view_hr_reports')||Auth::user()->role->permissions->contains('constant', 'view_attendance_report')||Auth::user()->role->permissions->contains('constant', 'view_leave_report'))
                <li class="site-menu-section site-menu-item has-sub">
                  <header>
                   <i class="site-menu-icon fa fa-users" aria-hidden="true"></i>
                    <span class="site-menu-title">Talent Management</span>
                    <span class="site-menu-arrow"></span>
                  </header>
                  <div class="site-menu-scroll-wrap is-section">
                    <div>
                      <div>
                        <ul class="site-menu-sub site-menu-section-list">
                          <li class="site-menu-item">
                            <a class="animsition-link" href="{{url('jobs_departments')}}">
                              <span class="site-menu-title">Jobs</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="{{url('recruits')}}">
                              <span class="site-menu-title">Recruit</span>
                            </a>
                          </li>
                          <li class="site-menu-item has-sub">
                            <a href="javascript:void(0)">
                              <span class="site-menu-title">Training And Development</span>
                              <span class="site-menu-arrow"></span>
                            </a>
                            <ul class="site-menu-sub">
                              <li class="site-menu-item ">
                                <a class="animsition-link" href="{{url('newtraining')}}">
                                  <span class="site-menu-title">New Training</span>
                                </a>
                              </li>
                              <li class="site-menu-item ">
                                <a class="animsition-link" href="{{url('training')}}">
                                  <span class="site-menu-title">Recommended Training</span>
                                </a>
                              </li>
                              <li class="site-menu-item ">
                                <a class="animsition-link" href="{{url('mytraining')}}">
                                  <span class="site-menu-title">My Training</span>
                                </a>
                              </li>
                              <li class="site-menu-item ">
                              <a class="animsition-link" href="{{url('training/budget')}}">
                                <span class="site-menu-title">Training Budget</span>
                              </a>
                            </li>
                            </ul>
                          </li>
                          
                          {{-- <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/dropdowns.html">
                              <span class="site-menu-title">Successiion Planning</span>
                            </a>
                          </li> --}}
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
                @endif
                  @if(Auth::user()->role->permissions->contains('constant', 'view_hr_reports')||Auth::user()->role->permissions->contains('constant', 'view_attendance_report')||Auth::user()->role->permissions->contains('constant', 'view_leave_report'))
                <li class="site-menu-section site-menu-item has-sub">
                  <header>
                    <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                    <span class="site-menu-title">People Analytics</span>
                    <span class="site-menu-arrow"></span>
                  </header>
                  <div class="site-menu-scroll-wrap is-section">
                    <div>
                      <div>
                        <ul class="site-menu-sub site-menu-section-list">
                           @if(Auth::user()->role->permissions->contains('constant', 'view_hr_reports'))
                            <li class="site-menu-item ">
<<<<<<< HEAD
                              <a class="animsition-link" href="{{url('people_analytics_hr')}}">
=======
                              <a class="animsition-link" href="{{url('bi-report')}}?page=hr">
>>>>>>> 756669c79ba12453137381addef2325f0d752945
                                <span class="site-menu-title">HR</span>
                              </a>
                            </li>
                            @endif
                            @if(Auth::user()->role->permissions->contains('constant', 'view_hr_reports'))
                            <li class="site-menu-item ">
<<<<<<< HEAD
                              <a class="animsition-link" href="{{url('people_analytics_employee')}}">
=======
                              <a class="animsition-link" href="{{url('bi-report')}}?page=demographics">
>>>>>>> 756669c79ba12453137381addef2325f0d752945
                                <span class="site-menu-title">Employee</span>
                              </a>
                            </li>
                            @endif
                            @if(Auth::user()->role->permissions->contains('constant', 'view_hr_reports'))
                            <li class="site-menu-item ">
<<<<<<< HEAD
                              <a class="animsition-link" href="{{url('people_analytics_jobrole')}}">
=======
                              <a class="animsition-link" href="{{url('bi-report')}}?page=job_roles">
>>>>>>> 756669c79ba12453137381addef2325f0d752945
                                <span class="site-menu-title">Job Roles</span>
                              </a>
                            </li>
                            @endif
<<<<<<< HEAD
                             @if(Auth::user()->role->permissions->contains('constant', 'view_hr_reports'))
                            <li class="site-menu-item ">
                              <a class="animsition-link" href="{{url('people_analytics_payroll')}}">
                                <span class="site-menu-title">Payroll</span>
=======
                             @if(Auth::user()->role->permissions->contains('constant', 'view_leave_report'))
                            <li class="site-menu-item ">
                              <a class="animsition-link" href="{{url('bi-report')}}?page=payroll">
                                <span class="site-menu-title">Payroll</span>
                              </a>
                            </li>
                            @endif
                             @if(Auth::user()->role->permissions->contains('constant', 'view_leave_report'))
                            <li class="site-menu-item ">
                              <a class="animsition-link" href="{{url('bi-report')}}?page=loan_request">
                                <span class="site-menu-title">Leave</span>
>>>>>>> 756669c79ba12453137381addef2325f0d752945
                              </a>
                            </li>
                            @endif
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
                @endif
                <li class="site-menu-section site-menu-item ">
                 
                 
                     <a class="animsition-link" href="{{url('projects')}}">
                      <i class="site-menu-icon  fa fa-list" aria-hidden="true"></i>
                    <span class="site-menu-title">Project Management</span>
                 
                  </a>
                </li>
               {{--   <li class="site-menu-section site-menu-item has-sub" style="z-index: 9999999999;">
                  <header>
                    <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                    <span class="site-menu-title">Import Data</span>
                    <span class="site-menu-arrow"></span>
                  </header>
                  <div class="site-menu-scroll-wrap is-section">
                    <div>
                      <div>
                        <ul class="site-menu-sub site-menu-section-list">
                           
                            <li class="site-menu-item ">
                              <a class="animsition-link" href="{{url('import/employees')}}">
                                <span class="site-menu-title">Import Employees</span>
                              </a>
                            </li>
                            <li class="site-menu-item ">
                              <a class="animsition-link" href="{{url('import/branches')}}">
                                <span class="site-menu-title">Import Branches</span>
                              </a>
                            </li>
                           
                            <li class="site-menu-item ">
                              <a class="animsition-link" href="{{url('import/departments')}}">
                                <span class="site-menu-title">Import Departments</span>
                              </a>
                            </li>
                            <li class="site-menu-item ">
                              <a class="animsition-link" href="{{url('import/jobroles')}}">
                                <span class="site-menu-title">Import Jobroles</span>
                              </a>
                            </li>
                            
                        </ul>
                      </div>
                    </div>
                  </div>
                </li> --}}

              </ul>
            </li>
            
          </ul>
        </div>
      </div>
    </div>
  </div>