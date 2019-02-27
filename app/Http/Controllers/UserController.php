<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Filters\UserFilter;
use App\Company;
use App\Job;
use App\Department;
use App\Location;
use App\StaffCategory;
use App\Position;
use Validator;
use App\Role;
use App\Qualification;
use App\UserGroup;
use App\Competency;
use App\Bank;
use App\Grade;


class UserController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $auth=Auth::user();
        $company_id=companyId();
        if (count($request->all())==0) {
            if ($company_id>0) {
                if (Auth::user()->role->manages=='all') {
                     $users=User::where('company_id','=',$company_id)->paginate(10);
                }elseif(Auth::User()->role->manages=="dr"){
                     $users=Auth::User()->employees()->paginate(10);
                }
               

            }else{
                $users=User::paginate(10);
            }
            $ncompany=Company::find($company_id);
            $staff_categories=StaffCategory::all();
             $grades=Grade::all();
        $companies=Company::all();
        $branches=$companies->first()->branches;
        $departments=$companies->first()->departments;
        $qualifications=Qualification::all();
        if (Auth::user()->role->manages=='all') {
                      $usersforcount=User::where('company_id','=',$company_id)->get();
                }elseif(Auth::User()->role->manages=="dr"){
                     $usersforcount=Auth::User()->employees()->get();
                }
        $roles=Role::all();
        $competencies=Competency::all();
        $user_groups=UserGroup::all();
        $managers=User::whereHas('role',function ($query)  {
                $query->where('manages','dr');
                $query->orWhere('manages','all');
            })->get();
        return view('empmgt.list',['users'=>$users,'usersforcount'=>$usersforcount,'companies'=>$companies,'branches'=>$branches,'departments'=>$departments,'roles'=>$roles,'user_groups'=>$user_groups,'managers'=>$managers,'qualifications'=>$qualifications,'competencies'=>$competencies,'ncompany'=>$ncompany,'grades'=>$grades,'staff_categories'=>$staff_categories]);

            }else{
            $users=UserFilter::apply($request);
             $companies=Company::all();
             $ncompany=Company::find($company_id);
             $staff_categories=StaffCategory::all();
              $grades=Grade::all();
        $branches=$companies->first()->branches;
        $departments=$companies->first()->departments;
         if (Auth::user()->role->manages=='all') {
                      $usersforcount=User::where('company_id','=',$company_id)->get();
                }elseif(Auth::User()->role->manages=="dr"){
                     $usersforcount=Auth::User()->employees()->get();
                }
        $roles=Role::all();
        $competencies=Competency::all();
        $user_groups=UserGroup::all();

        $managers=User::whereHas('role',function ($query)  {
                $query->where('manages','dr');
                $query->orWhere('manages','all');
            })->get();

        if ($request->excel==true) {
            $view='empmgt.list-excel';
                // return view('compensation.d365payroll',compact('payroll','allowances','deductions','income_tax','salary','date','has_been_run'));
                 return     \Excel::create("export", function($excel) use ($users,$view) {

            $excel->sheet("export", function($sheet) use ($users,$view) {
                $sheet->loadView("$view",compact('users'))
                ->setOrientation('landscape');
            });

        })->export('xlsx');
            # code...
        }
        if ($request->excelall==true) {
            $view='empmgt.list-excel';
            $users=User::where('company_id','=',$company_id)->get();
                // return view('compensation.d365payroll',compact('payroll','allowances','deductions','income_tax','salary','date','has_been_run'));
                 return     \Excel::create("export", function($excel) use ($users,$view) {

            $excel->sheet("export", function($sheet) use ($users,$view) {
                $sheet->loadView("$view",compact('users'))
                ->setOrientation('landscape');
            });

        })->export('xlsx');
            # code...
        }
            return view('empmgt.list',['users'=>$users,'usersforcount'=>$usersforcount,'companies'=>$companies,'branches'=>$branches,'departments'=>$departments,'roles'=>$roles,'user_groups'=>$user_groups,'managers'=>$managers,'competencies'=>$competencies,'ncompany'=>$ncompany,'grades'=>$grades,'staff_categories'=>$staff_categories]);

      }
        
    }
    public function getCompanyDepartmentsBranches($company_id){
        $company=Company::find($company_id);
        return ['departments'=>$company->departments,'branches'=>$company->branches];
    }
     public function getDepartmentJobroles($department_id){
        $department=Department::find($department_id);
        return ['jobroles'=>$department->jobs];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function assignRole(Request $request)
    {
        // return $request->users;
        $users_count=count($request->users);
        $role_id=$request->role_id;
           
        for ($i=0; $i < $users_count; $i++) { 
           $user=User::find($request->users[$i]);
           $user->role_id=$role_id;
           $user->save();
        }
        return 'success';
    }
    public function alterStatus(Request $request)
    {
        // return $request->users;
        $users_count=count($request->users);
        $status=$request->status;
           
        for ($i=0; $i < $users_count; $i++) { 
           $user=User::find($request->users[$i]);
           $user->status=$status;
           $user->save();
        }
        return 'success';
    }
    public function assignManager(Request $request)
    {
        // return $request->users;
        $users_count=count($request->users);
        $manager_id=$request->manager_id;
        $manager=User::find($manager_id);
           
        for ($i=0; $i < $users_count; $i++) {
        $user=User::find($request->users[$i]); 
        $has_manager=$user->managers->contains('id',$manager_id);
        $user->line_manager_id=$manager_id;
        $user->save();
           // $has_manager=User::find($request->users[$i])->whereHas('managers',function ($query) use($manager_id)  {
           //      $query->where('users.id',$manager_id);
           //  })->get();
           if (!$has_manager && $manager_id!=$request->users[$i]) {
               $user->managers()->attach($manager_id);
               $user->line_manager_id=$manager_id;
        $user->save();
           }
        }
        return 'success';
    }
    public function assignGroup(Request $request)
    {
        // return $request->users;
        $users_count=count($request->users);
        $group_id=$request->group_id;
        $group=UserGroup::find($group_id);
           
        for ($i=0; $i < $users_count; $i++) {
        $user=User::find($request->users[$i]); 
        $has_group=$user->user_groups->contains('id',$group_id);
           // $has_manager=User::find($request->users[$i])->whereHas('managers',function ($query) use($manager_id)  {
           //      $query->where('users.id',$manager_id);
           //  })->get();
           if (!$has_group) {
               $user->user_groups()->attach($group_id);
           }
        }
        return 'success';
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          
       $validator = Validator::make($request->all(), ['name'=>'required|min:3','emp_num'=>['required',
            Rule::unique('users')->ignore($request->user_id)
        ],'phone'=>['required',
            Rule::unique('users')->ignore($request->user_id)
        ]]);

       if ($validator->fails()) {
            return response()->json([
                    $validator->errors()
                    ],401);
        }
        //build LGA
        // $lga=\App\LocalGovernment::find($request->lga);
        // if (!$lga and $request->lga!='') {
        //     $lga=\App\LocalGovernment::create(['name'=>$request->lga,'state_id'=>$request->state]);
        // }
        //end build LGA
        $user=User::find($request->user_id);
        $user->update(['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'emp_num'=>$request->emp_num,'sex'=>$request->sex,'address'=>$request->address,'marital_status'=>$request->marital_status,'dob'=>date('Y-m-d',strtotime($request->dob)),'branch_id'=>$request->branch_id,'company_id'=>$request->company_id,'bank_id'=>$request->bank_id,'bank_account_no'=>$request->bank_account_no,'country_id'=>$request->country,'state_id'=>$request->state,'lga_id'=>$request->lga]);
       
            $nok=\App\Nok::updateOrCreate(['id'=>$request->nok_id],['name'=>$request->nok_name,'phone'=>$request->nok_phone,'address'=>$request->nok_address,'relationship'=>$request->nok_relationship,'user_id'=>$request->user_id]);
       
          if ($request->file('avatar')) {
                    $path = $request->file('avatar')->store('public/avatar');
                    if (Str::contains($path, 'public/avatar')) {
                       $filepath= Str::replaceFirst('public/avatar', '', $path);
                    } else {
                        $filepath= $path;
                    }
                    $user->image = $filepath;
                    $user->save();
                }
        
       return 'success';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //

    }
    public function search(Request $request)
    {
     
                
        if($request->q==""){
            return "";
        }
       else{
        $name=\App\User::where('name','LIKE','%'.$request->q.'%')
                        ->select('id as id','name as text')
                        ->get();
            }
        
        
        return $name;
    
     
    }
    public function modal($user_id)
    {
       $user=User::find($user_id);
       return view('empmgt.partials.info',['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
       $user=User::find($user_id);
       $countries=\App\Country::all();
       $qualifications=Qualification::all();
       $competencies=Competency::all();
        $companies=Company::all();
        $banks=Bank::all();
        $company=Company::find(session('company_id'));
        $grades=Grade::all();
        if(!$company){
          $company=Company::first();
        }
        $departments=$company->departments;
        $jobroles=$company->departments()->first()->jobs;
       $staff_categories=StaffCategory::all();
       // return $user->skills()->where('skills.id',1)->first()->pivot->competency;
       return view('empmgt.profile',['user'=>$user,'qualifications'=>$qualifications,'countries'=>$countries,'competencies'=>$competencies,'companies'=>$companies,'banks'=>$banks,'company'=>$company,'grades'=>$grades,'departments'=>$departments,'jobs'=>$jobroles,'staff_categories'=>$staff_categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
    public function saveNew(Request $request)
    {
        $validator = Validator::make($request->all(), ['name'=>'required|min:3','emp_num'=>['required',
            Rule::unique('users')->ignore($request->user_id)
        ],'phone'=>['required',
            Rule::unique('users')->ignore($request->user_id)
        ]]);

       if ($validator->fails()) {
            return response()->json([
                    $validator->errors()
                    ],401);
        }

        $user=User::create(['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'emp_num'=>$request->emp_num,'sex'=>$request->sex,'hiredate'=>date('Y-m-d',strtotime($request->started)),'dob'=>date('Y-m-d',strtotime($request->dob)),'branch_id'=>$request->branch_id,'company_id'=>$request->company_id,'job_id'=>$request->job_id,'department_id'=>$request->department_id,'grade_id'=>$request->grade_id,'role_id'=>$request->role_id]);
        $user->promotionHistories()->create([
                                'old_grade_id' => $request->grade_id,'grade_id'=>$request->grade_id,'approved_on'=>date('Y-m-d'),'approved_by'=>Auth::user()->id
                            ]);
            
            $user->save();

        $user->jobs()->attach($request->job_id, ['started' => date('Y-m-d',strtotime($request->started))]);
        
        $user->save();

         return 'success';
    }
}
