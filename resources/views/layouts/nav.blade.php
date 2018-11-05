<div class="site-menubar">
    <div class="site-menubar-body">
      <div>
        <div>
          <ul class="site-menu" data-plugin="menu">
            <li class="site-menu-item ">
              <a href="{{ route('home') }}" dropdown-tag="false">
                <i class="site-menu-icon md-home" aria-hidden="true"></i>
                <span class="site-menu-title">Home</span>
                <span class="site-menu-arrow"></span>
              </a>
            </li>
            @if(Auth::user()->role->permissions->contains('constant', 'view_hr_reports')||Auth::user()->role->permissions->contains('constant', 'view_attendance_report')||Auth::user()->role->permissions->contains('constant', 'view_leave_report'))
            <li class="site-menu-item has-sub ">
              <a href="javascript:void(0)" dropdown-tag="false" title="People Analytics">
                <i class="site-menu-icon fa fa-area-chart" aria-hidden="true"></i>
                <span class="site-menu-title">People Analytics</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                @if(Auth::user()->role->permissions->contains('constant', 'view_hr_reports'))
                <li class="site-menu-item ">
                  <a class="animsition-link" href="{{route('executive_view')}}">
                    <span class="site-menu-title">HR</span>
                  </a>
                </li>
                @endif
                @if(Auth::user()->role->permissions->contains('constant', 'view_attendance_report'))
                <li class="site-menu-item ">
                  <a class="animsition-link" href="{{route('executive_view_attendance')}}">
                    <span class="site-menu-title">Attendance</span>
                  </a>
                </li>
                @endif
                @if(Auth::user()->role->permissions->contains('constant', 'view_leave_report'))
                <li class="site-menu-item ">
                  <a class="animsition-link" href="{{route('executive_view_leave')}}">
                    <span class="site-menu-title">Leave</span>
                  </a>
                </li>
                @endif
              </ul>
            </li>
            @endif
            
            <li class="site-menu-item has-sub ">
              <a href="javascript:void(0)" dropdown-tag="false">
                <i class="site-menu-icon fa fa-sitemap" aria-hidden="true"></i>
                <span class="site-menu-title">Self Service</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
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
                <li class="site-menu-item ">
                  <a class="animsition-link" href=" {{url('loan/my_loan_requests')}}">
                    <span class="site-menu-title">Loan Requests </span>
                  </a>
                </li>
                <li class="site-menu-item ">
                  <a class="animsition-link" href="{{ url('compensation/user_payroll_list') }}">
                    <span class="site-menu-title">View payslip </span>
                  </a>
                </li>
                <li class="site-menu-item ">
                  <a class="animsition-link" href="#">
                    <span class="site-menu-title">My Expenses </span>
                  </a>
                </li>
                <li class="site-menu-item ">
                  <a class="animsition-link" href="#">
                    <span class="site-menu-title">Job Openings </span>
                  </a>
                </li>
                <li class="site-menu-item ">
                  <a class="animsition-link" href="#">
                    <span class="site-menu-title">Health </span>
                  </a>
                </li>
               
              </ul>
            </li>
             <li class="site-menu-item ">
              <a href="{{ url('projects') }}" dropdown-tag="false">
                <i class="site-menu-icon fa fa-list" aria-hidden="true"></i>
                <span class="site-menu-title">Project Management</span>
                <span class="site-menu-arrow"></span>
              </a>
            </li>
            @if(Auth::user()->role->permissions->contains('constant', 'manage_user'))
            <li class="site-menu-item ">
              <a href="{{url('recruits')}}" dropdown-tag="false">
                <i class="site-menu-icon fa fa-user-plus" aria-hidden="true"></i>
                <span class="site-menu-title">Recruit</span>
                <span class="site-menu-arrow"></span>
              </a>
            </li>
            @endif
            @if(Auth::user()->role->permissions->contains('constant', 'manage_user')||Auth::user()->role->permissions->contains('constant', 'view_timesheet')||Auth::user()->role->permissions->contains('constant', 'export_timesheet')||Auth::user()->role->permissions->contains('constant', 'view_attendance')||Auth::user()->role->permissions->contains('constant', 'view_shift_schedule')||Auth::user()->role->permissions->contains('constant', 'approve_shift_swap')||Auth::user()->role->permissions->contains('constant', 'succession_planning'))
            <li class="site-menu-item has-sub ">
              <a href="javascript:void(0)" dropdown-tag="false">
                <i class="site-menu-icon fa fa-address-book" aria-hidden="true"></i>
                <span class="site-menu-title">Core Adminsitrative HR</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                @if(Auth::user()->role->permissions->contains('constant', 'manage_user'))
                <li class="site-menu-item ">
                  <a class="animsition-link" href="{{url('users')}}">
                    <span class="site-menu-title">Manage Employee</span>
                  </a>
                </li>
                @endif
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
                <li class="site-menu-item ">
                  <a class="animsition-link" href="#">
                    <span class="site-menu-title">Attendance 360</span>
                  </a>
                </li>
                <li class="site-menu-item ">
                  <a class="animsition-link" href="#">
                    <span class="site-menu-title">Succession Planning</span>
                  </a>
                </li>
              </ul>
            </li>
          @endif
           @if(Auth::user()->role->permissions->contains('constant', 'run_payroll')|| Auth::user()->role->permissions->contains('constant', 'create_payslip')|| Auth::user()->role->permissions->contains('constant', 'view_loan_request')|| Auth::user()->role->permissions->contains('constant', 'approve_loan_request'))
          
             <li class="site-menu-item has-sub ">
              <a href="javascript:void(0)" dropdown-tag="false">
                <i class="site-menu-icon fa fa-money" aria-hidden="true"></i>
                <span class="site-menu-title">Compensation and Benefits</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                 @if(Auth::user()->role->permissions->contains('constant', 'run_payroll'))
                <li class="site-menu-item ">
                  <a class="animsition-link" href="{{ url('compensation') }}">
                    <span class="site-menu-title">Payroll</span>
                  </a>
                </li>
                @endif
                 @if(Auth::user()->role->permissions->contains('constant', 'view_loan_request'))
                <li class="site-menu-item ">
                  <a class="animsition-link" href="{{ url('loan/loan_requests') }}">
                    <span class="site-menu-title">Loan Requests</span>
                  </a>
                </li>
                @endif
              </ul>
            </li>
            @endif
            @if(Auth::user()->role->permissions->contains('constant', 'edit_performance'))
            <li class="site-menu-item has-sub ">
              <a href="javascript:void(0)" dropdown-tag="false">
                <i class="site-menu-icon fa fa-mortar-board" aria-hidden="true"></i>
                <span class="site-menu-title">Training and Development</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item ">
                  <a class="animsition-link" href="#">
                    <span class="site-menu-title">Recommended Traning</span>
                  </a>
                </li>
                <li class="site-menu-item ">
                  <a class="animsition-link" href="#">
                    <span class="site-menu-title">Select Elective Training</span>
                  </a>
                </li>
                <li class="site-menu-item ">
                  <a class="animsition-link" href="#">
                    <span class="site-menu-title">Training Status </span>
                  </a>
                </li>
                <li class="site-menu-item ">
                  <a class="animsition-link" href="#">
                    <span class="site-menu-title">Traning Schedule for Fiscal Year </span>
                  </a>
                </li>
                <li class="site-menu-item ">
                  <a class="animsition-link" href="#">
                    <span class="site-menu-title">Traning Surveys </span>
                  </a>
                </li>
                <li class="site-menu-item ">
                  <a class="animsition-link" href="#">
                    <span class="site-menu-title">Enrolled Training Status </span>
                  </a>
                </li>
              </ul>
            </li>
            @endif
            @if(Auth::user()->role->permissions->contains('constant', 'edit_performance'))
            <li class="site-menu-item ">
              <a href="{{ url('performances') }}" dropdown-tag="false">
                <i class="site-menu-icon fa fa-area-chart" aria-hidden="true"></i>
                <span class="site-menu-title">Performance Management</span>
                <span class="site-menu-arrow"></span>
              </a>
            </li>
            @endif
            @if(Auth::user()->role->permissions->contains('constant', 'edit_settings'))
          <li class="site-menu-item ">
              <a href="{{url('settings')}}" dropdown-tag="false">
                <i class="site-menu-icon md-settings" aria-hidden="true"></i>
                <span class="site-menu-title">Settings</span>
                <span class="site-menu-arrow"></span>
              </a>
            </li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>