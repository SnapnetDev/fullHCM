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
use App\Location;
use App\StaffCategory;
use App\Position;
use Validator;
use App\Role;
use App\Qualification;
use App\UserGroup;
use App\Competency;
use App\Bank;


class UserController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $company_id=companyId();
        if (count($request->all())==0) {
            if ($company_id>0) {
                $users=User::where('company_id','!=',1)->paginate(10);
            }else{
                $users=User::paginate(10);
            }
            
        $companies=Company::all();
        $branches=$companies->first()->branches;
        $departments=$companies->first()->departments;
        $qualifications=Qualification::all();
        $usersforcount=User::where('superadmin','!=',1)->get();
        $roles=Role::all();
        $competencies=Competency::all();
        $user_groups=UserGroup::all();
        $managers=User::whereHas('role',function ($query)  {
                $query->where('manages','dr');
                $query->orWhere('manages','all');
            })->get();
        return view('empmgt.list',['users'=>$users,'usersforcount'=>$usersforcount,'companies'=>$companies,'branches'=>$branches,'departments'=>$departments,'roles'=>$roles,'user_groups'=>$user_groups,'managers'=>$managers,'qualifications'=>$qualifications,'competencies'=>$competencies]);

            }else{
            $users=UserFilter::apply($request);
             $companies=Company::all();
        $branches=$companies->first()->branches;
        $departments=$companies->first()->departments;
        $usersforcount=User::where('superadmin','!=',1)->get();
        $roles=Role::all();
        $competencies=Competency::all();
        $user_groups=UserGroup::all();

        $managers=User::whereHas('role',function ($query)  {
                $query->where('manages','dr');
            })->get();
            return view('empmgt.list',['users'=>$users,'usersforcount'=>$usersforcount,'companies'=>$companies,'branches'=>$branches,'departments'=>$departments,'roles'=>$roles,'user_groups'=>$user_groups,'managers'=>$managers,'competencies'=>$competencies]);

      }
        
    }
    public function getCompanyDepartmentsBranches($company_id){
        $company=Company::find($company_id);
        return ['departments'=>$company->departments,'branches'=>$company->branches];
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
    public function assignManager(Request $request)
    {
        // return $request->users;
        $users_count=count($request->users);
        $manager_id=$request->manager_id;
        $manager=User::find($manager_id);
           
        for ($i=0; $i < $users_count; $i++) {
        $user=User::find($request->users[$i]); 
        $has_manager=$user->managers->contains('id',$manager_id);
           // $has_manager=User::find($request->users[$i])->whereHas('managers',function ($query) use($manager_id)  {
           //      $query->where('users.id',$manager_id);
           //  })->get();
           if (!$has_manager && $manager_id!=$request->users[$i]) {
               $user->managers()->attach($manager_id);
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
          
       $validator = Validator::make($request->all(), ['name'=>'required|min:3','email' => [
            'required',
            Rule::unique('users')->ignore($request->user_id)
        ],'emp_num'=>['required',
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
        $lga=\App\LocalGovernment::find($request->lga);
        if (!$lga) {
            $lga=\App\LocalGovernment::create(['name'=>$request->lga,'state_id'=>$request->state]);
        }
        //end build LGA
        $user=User::find($request->user_id);
        $user->update(['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'emp_num'=>$request->emp_num,'sex'=>$request->sex,'address'=>$request->address,'marital_status'=>$request->marital_status,'dob'=>date('Y-m-d',strtotime($request->dob)),'branch_id'=>$request->branch_id,'company_id'=>$request->company_id,'bank_id'=>$request->bank_id,'bank_account_no'=>$request->bank_account_no,'country_id'=>$request->country,'state_id'=>$request->state,'lga_id'=>$lga->id]);
       
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
        if(!$company){
          $company=Company::first();
        }
       // return $user->skills()->where('skills.id',1)->first()->pivot->competency;
       return view('empmgt.profile',['user'=>$user,'qualifications'=>$qualifications,'countries'=>$countries,'competencies'=>$competencies,'companies'=>$companies,'banks'=>$banks,'company'=>$company]);
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
}
