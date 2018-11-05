<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Department;
use App\Qualification;
use App\Grade;
use App\User;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\PermissionCategory;

class EmployeeSettingController extends Controller
{

	public function index()
	{
		$grades=Grade::all();
		$qualifications=Qualification::all();
		$roles=Role::all();
		return view('settings.employeesettings.index',compact('grades','qualifications','roles'));
	}
	public function saveGrade(Request $request)
	{
		Grade::updateOrCreate(['id'=>$request->grade_id],['level'=>$request->level,'basic_pay'=>$request->basic_pay,'leave_length'=>$request->leave_length]);
		return  response()->json('success',200);
	}
	public function getGrade($grade_id)
	{
		$grade=Grade::find($grade_id);
		return  response()->json($grade,200);
	}
	public function deleteGrade($grade_id)
	{
		$grade=Grade::find($grade_id);
		if ($grade) {
			$grade->delete();
		}else{
			return  response()->json(['failed'],200);
		}
		return  response()->json(['success'],200);
	}

	public function saveQualification(Request $request)
	{
		Qualification::updateOrCreate(['id'=>$request->qualification_id],['name'=>$request->name]);
		return  response()->json('success',200);
	}
	public function getQualification($qualification_id)
	{
		$qualification=Qualification::find($qualification_id);
		return  response()->json($qualification,200);
	}
	public function deleteQualification($qualification_id)
	{
		$qualification=Qualification::find($qualification_id);
		if ($qualification) {
			$qualification->delete();
		}else{
			return  response()->json(['failed'],200);
		}
		return  response()->json(['success'],200);
	}
	
	

}