<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','emp_num','sex','dob','phone','marital_status','password','company_id','branch_id','job_id','hiredate','role_id','image','remember_token','created_at','updated_at','address','state_of_origin_id','lga_id','employment_status_id','superadmin','bank_id','account_num','locale','location_id','staff_category_id','position_id'];
    protected $dates=['hiredate'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    public function department()
    {
        return $this->belongsTo('App\Department');
    }
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }
    public function subsidiary()
    {
        return $this->belongsTo('App\Subsidiary');
    }
    //Nok is the next of kin
    public function nok()
    {
        return $this->hasOne('App\Nok');
    }
    public function job()
    {
        return $this->belongsTo('App\Job');
    }
    public function dependants()
    {
        return $this->hasMany('App\Dependant','user_id');
    }
    public function employmentHistories()
    {
        return $this->hasMany('App\EmploymentHistory');
    }
    public function promotionHistories()
    {
        return $this->hasMany('App\PromotionHistory');
    }
    public function educationHistories()
    {
        return $this->hasMany('App\EducationHistory','emp_id');
    }
    public function skills()
    {
        return $this->hasMany('App\Skill','user_id');
    }
    public function profHistories()
    {
        return $this->hasMany('App\ProfHistory');
    }
    public function socialMediaAccounts()
    {
        return $this->belongsToMany('App\SocialMediaAccount','user_social_media_account','user_id','social_media_account_id');
    }
    public function managers()
    {
        return $this->belongsToMany('App\User','employee_manager','employee_id','manager_id')->withTimestamps();
    }
    public function employees()
    {
        return $this->belongsToMany('App\User','employee_manager','manager_id','employee_id')->withTimestamps();
    }
    public function employmentStatus()
    {
        return $this->belongsTo('App\EmploymentStatus');
    }
    public function grades()
    {
        return $this->hasManyThrough('App\Grade','App\PromotionHistory');
    }
    public function performanceseason(){
         $checkseason= \App\PerformanceSeason::select('season')->value('season');
             return $checkseason;
    }
    public function quarterName($num){
        switch ($num) {
            case 1:
               return 'First';
                break;
                case 2:
               return 'Second';
                break;
                case 3:
               return 'Third';
                break;
                case 4:
               return 'Fourth';
                break;
            
            default:
                # code...
                break;
        }

        // $formatter = new \NumberFormatter('en_US', \NumberFormatter::SPELLOUT);
        // $formatter->setTextAttribute(\NumberFormatter::DEFAULT_RULESET,"%spellout-ordinal");
        // return ucfirst($formatter->format($num));
    }
  public function progressreport(){
        return $this->hasMany('App\ProgressReport','emp_id');
    }

public function getquarter(){
    
    //getquarter
    $review=\App\fiscal::where('id',1)->first();
    return 12/$review->end_month;
    
  }
    public function getEmploymentStatusAttribute(){

        return $this->employment_status_id==1 ? 'Locked' : 'Open';
    }

    public function goal(){
        return $this->hasMany('App\Goal','user_id')->withDefault();
    }

     public function getProbationStatusAttribute(){
          if(!is_null($this->hiredate) && $this->hiredate->diffInDays()<=180){
            return '<span class="tag tag-warning">On-Probation</span>';
          }
          elseif(!is_null($this->hiredate) && $this->hiredate->diffInDays()>180 && $this->confirmed==1){
            return '<span class="tag tag-success">Confirmed</span>';
          }
          else{
            return 'N/A';
          }
        }

    public function position()
    {
        return $this->belongsTo('App\Position','position_id');
    }
    public function location()
    {
        return $this->belongsTo('App\Location','location_id');
    }
    public function category()
    {
        return $this->belongsTo('App\StaffCategory','staff_category_id');
    }
    public function employee_type()
    {
        return $this->belongsTo('App\EmployeeType','employee_type_id');
    }
    public function costcenter()
    {
        return $this->belongsTo('App\CostCenter','costcenter_id');
    }
    public function attendances()
    {
         return $this->hasMany('App\Attendance','emp_num','emp_num');
    }
    public function attendancedetails()
    {
         return $this->hasManyThrough('App\AttendanceDetail','App\Attendance','emp_num','emp_num');
    }
    public function timesheets()
    {
        return $this->hasManyThrough('App\Timesheet','App\TimesheetDetail','user_id');
    }
    public function timesheetdetails()
    {
        return $this->hasMany('App\TimesheetDetail','user_id');
    }
    public function shifts()
    {
         return $this->belongsToMany('App\Shift','user_shift_schedule','user_id','shift_id');
    }
    public function shift_schedules()
    {
         return $this->belongsToMany('App\ShiftSchedule','user_shift_schedule','user_id','shift_schedule_id');
    }
    public function usershiftschedules()
    {
        return $this->hasMany('App\UserShiftSchedule');
    }
    public function initiatedShiftSwaps()
    {
        return $this->hasMany('App\UserShiftSchedule','owner_id');
    }
    public function suggestedShiftSwaps()
    {
        return $this->hasMany('App\UserShiftSchedule','swapper_id');
    }
    public function SalaryComponents()
    {
        return $this->belongsToMany('App\SalaryComponent','salary_component_exemptions','user_id','salary_component_id');
    }
    public function specificSalaryComponents(){
         return $this->hasMany('App\SpecificSalaryComponent','emp_id');
    }
    public function leave_requests()
    {
        return $this->hasMany('App\LeaveRequest','user_id');
    }
    public function user_groups()
    {
        return $this->belongsToMany('App\UserGroup','user_group_user','user_id','user_group_id');
    }
    public function loan_requests()
    {
        return $this->hasMany('App\LoanRequest','user_id');
    }
    public function payroll_details()
    {
         return $this->hasMany('App\PayrollDetail','user_id');
    }

}