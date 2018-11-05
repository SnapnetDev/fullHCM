<?php
namespace App\Traits;
use App\User;
use App\Qualification;
use App\EducationHistory;
use App\EmploymentHistory;
use App\Skill;
use App\Dependant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


trait UserProfile{
public function processGet($route,Request $request)
{
	switch ($route) {
			case 'profile':
			return $this->profile($request);
			break;
			case 'academic_history':
			return $this->academic_history($request);
			break;
			case 'delete_academic_history':
			return $this->delete_academic_history($request);
			break;
			case 'dependant':
			return $this->dependant($request);
			break;
			case 'delete_dependant':
			return $this->delete_dependant($request);
			break;
			case 'skill':
			return $this->skill($request);
			break;
			case 'delete_skill':
			return $this->delete_skill($request);
			break;
			case 'work_experience':
			return $this->work_experience($request);
			break;
			case 'delete_work_experience':
			return $this->delete_work_experience($request);
			break;
			case 'states':
			return $this->states($request);
			break;
			case 'lgas':
			return $this->lgas($request);
			break;
		
		default:
			# code...
			break;
	}
}
public function processPost(Request $request)
{
	switch ($request->type) {
		case 'academic_history':
			return $this->save_academic_history($request);
			break;
			case 'dependant':
			return $this->save_dependant($request);
			break;
			case 'skill':
			return $this->save_skill($request);
			break;
			case 'work_experience':
			return $this->save_work_experience($request);
			break;
			case 'promotion_history':
			# code...
			break;
		
		default:
			# code...
			break;
	}
}

public function profile(Request $request)
{
	$user=User::find($request->user_id);
	 // return view('empmgt.partials.details',['user'=>$user]);
	return $request->user_id;
}
public function academic_history(Request $request)
{
	$ah=EducationHistory::find($request->academic_history_id);
	return $ah;
}
public function delete_academic_history(Request $request)
{
	$ah=EducationHistory::find($request->academic_history_id);
	if ($ah) {
		$ah->delete();
		return 'success';
	}
	return 'failed';
}
public function save_academic_history(Request $request)
{
	try{
		$ah = EducationHistory::updateOrCreate(['id'=>$request->academic_history_id],['title'=>$request->title,'qualification_id'=>$request->qualification_id,'institution'=>$request->institution,'year'=>$request->year,'course'=>$request->course,'grade'=>$request->grade,'emp_id'=>$request->user_id]);
		return 'success';

	}catch(\Exception $ex){
		return $ex->getMessage();
	}

	
}
public function dependant(Request $request)
{
	$dependant=Dependant::find($request->dependant_id);
	return $dependant;
}
public function delete_dependant(Request $request)
{
	$dependant=Dependant::find($request->dependant_id);
	if ($dependant) {
		$dependant->delete();
		return 'success';
	}
	return 'failed';
}
public function save_dependant(Request $request)
{
	try{
		$dependant = Dependant::updateOrCreate(['id'=>$request->dependant_id],['name'=>$request->name,'dob'=>$request->dob,'email'=>$request->email,'phone'=>$request->phone,'relationship'=>$request->relationship,'user_id'=>$request->user_id]);
		return 'success';

	}catch(\Exception $ex){
		return $ex->getMessage();
	}
}
public function skill(Request $request)
{
	$skill=Skill::find($request->skill_id);
	return $skill;
}
public function delete_skill(Request $request)
{
	$skill=Skill::find($request->skill_id);
	if ($skill) {
		$skill->delete();
		return 'success';
	}
	return 'failed';
}
public function save_skill(Request $request)
{
	try{
		$skill = Skill::updateOrCreate(['id'=>$request->skill_id],['name'=>$request->name,'experience'=>$request->experience,'rating'=>$request->rating,'remark'=>$request->remark,'user_id'=>$request->user_id]);
		return 'success';

	}catch(\Exception $ex){
		return $ex->getMessage();
	}
}
public function work_experience(Request $request)
{
	$work_experience=EmploymentHistory::find($request->work_experience_id);
	return $work_experience;
}
public function delete_work_experience(Request $request)
{
	$work_experience=EmploymentHistory::find($request->work_experience_id);
	if ($work_experience) {
		$work_experience->delete();
		return 'success';
	}
	return 'failed';
}
public function save_work_experience(Request $request)
{
	try{
		$work_experience = EmploymentHistory::updateOrCreate(['id'=>$request->work_experience_id],['organization'=>$request->organization,'position'=>$request->position,'start_date'=>$request->start_date,'end_date'=>$request->end_date,'user_id'=>$request->user_id]);
		return 'success';

	}catch(\Exception $ex){
		return $ex->getMessage();
	}
}

public function states(Request $request)
{
	$country=\App\Country::find($request->country_id);
	return $country->states;
}
public function lgas(Request $request)
{
	
	$state=\App\State::find($request->state_id);
	return $state->lgas;
}

}