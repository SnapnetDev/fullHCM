<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\UserProfile;

class UserProfileController extends Controller
{
	use UserProfile;
	public function index(Request $request)
    {
    	 $user=User::find($user_id);
       $locations=Location::all();
       $staff_categories=StaffCategory::all();
       $positions=Position::all();
       return view('empmgt.partials.details',['user'=>$user,'locations'=>$locations,'staff_categories'=>$staff_categories,'positions'=>$positions]);
    }
   
   public function store(Request $request)
    {
        //
     
        return $this->processPost($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        //
        return $this->processGet($id,$request);
    }

}
