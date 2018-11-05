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


class UserController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (count($request->all())==0) {
            $users=User::where('superadmin','!=',1)->paginate(10);
        $companies=Company::all();
        $branches=$companies->first()->branches;
        $departments=$companies->first()->departments;
        $qualifications=Qualification::all();
        $usersforcount=User::where('superadmin','!=',1)->get();
        $roles=Role::all();
        $managers=User::whereHas('role',function ($query)  {
                $query->where('manages','dr');
            })->get();
        return view('empmgt.list',['users'=>$users,'usersforcount'=>$usersforcount,'companies'=>$companies,'branches'=>$branches,'departments'=>$departments,'roles'=>$roles,'managers'=>$managers,'qualifications'=>$qualifications]);

            }else{
            $users=UserFilter::apply($request);
             $companies=Company::all();
        $branches=$companies->first()->branches;
        $departments=$companies->first()->departments;
        $usersforcount=User::where('superadmin','!=',1)->get();
        $roles=Role::all();
        $managers=User::whereHas('role',function ($query)  {
                $query->where('manages','dr');
            })->get();
            return view('empmgt.list',['users'=>$users,'usersforcount'=>$usersforcount,'companies'=>$companies,'branches'=>$branches,'departments'=>$departments,'roles'=>$roles,'managers'=>$managers]);

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
        $user=User::where('id', $request->user_id)->update(['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'emp_num'=>$request->emp_num,'sex'=>$request->sex,'marital_status'=>$request->marital_status,'dob'=>date('Y-m-d',strtotime($request->dob)),'branch_id'=>$request->branch_id,'location_id'=>$request->location_id,'job_id'=>$request->job_id]);
          if ($request->file('avatar')) {
                    $path = $request->file('avatar')->store('public');
                    if (Str::contains($path, 'public/')) {
                       $filepath= Str::replaceFirst('public/', '', $path);
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
       return view('empmgt.profile',['user'=>$user,'qualifications'=>$qualifications,'countries'=>$countries]);
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
