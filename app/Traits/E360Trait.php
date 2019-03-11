<?php
namespace App\Traits;
use App\E360Det;
use App\E360DetQuestion;
use App\E360DetQuestionOption;
use App\E360Evaluation;
use App\E360EvaluationDetail;
use App\E360MeasurementPeriod;
use App\Department;
use Illuminate\Http\Request;
use Excel;
use App\User;
use Auth;
trait E360Trait
{
	public function processGet($route,Request $request){
		switch ($route) {
			
			
			case 'get_evaluation':
				# code...
				return $this->getEvaluation($request);
				break;
			case 'get_evaluation_report':
				# code...
				return $this->getEvaluationReport($request);
				break;
			case 'department_employees':
				# code...
				return $this->getDepartmentEmployees($request);
				break;
			case 'department_report_employees':
				# code...
				return $this->getDepartmentReportEmployees($request);
				break;
			case 'select_department':
				# code...
				return $this->selectDepartment($request);
				break;
			case 'select_report_department':
				# code...
				return $this->selectReportDepartment($request);
				break;
			
			
			
			default:
				# code...
				break;
		}
		 
	}


	public function processPost(Request $request){
		// try{
		switch ($request->type) {
			case 'save_evaluation':
				# code...
				return $this->saveEvaluation($request);
				break;
			

			default:
				# code...
				break;
		}
		// }
		// catch(\Exception $ex){
		// 	return response()->json(['status'=>'error','message'=>$ex->getMessage()]);
		// }
	}
	public function selectDepartment(Request $request)
	{
		$company_id=companyId();
        $measurement_periods=E360MeasurementPeriod::all();
        
        $departments=Department::where('company_id',$company_id)->get();
     
       
        return view('e360.select_departments',compact('measurement_periods','departments'));
	}
	public function selectReportDepartment(Request $request)
	{
		$company_id=companyId();
        $measurement_periods=E360MeasurementPeriod::all();
        
        $departments=Department::where('company_id',$company_id)->get();
     
       
        return view('e360.select_report_departments',compact('measurement_periods','departments'));
	}
	public function getDepartmentReportEmployees(Request $request)
	{
		
		$department=Department::find($request->department);
		$mp=E360MeasurementPeriod::find($request->mp);
		$operation='evaluate';
		
						$det=E360Det::where(['department_id'=>$department->id,'measurement_period_id'=>$request->mp])->first();
					if($det){
						
						
						return view('e360.department_users_report',compact('det'));

					}else{
						
						return redirect()->back()->with('error', 'Department Review Questions have not been uploaded!');
							
							
						
						

					}	
		
	}
	public function getDepartmentEmployees(Request $request)
	{
		
		$department=Department::find($request->department);
		$mp=E360MeasurementPeriod::find($request->mp);
		$operation='evaluate';
		
						$det=E360Det::where(['department_id'=>$department->id,'measurement_period_id'=>$request->mp])->first();
					if($det){
						
						
						return view('e360.department_users',compact('det'));

					}else{
						
						return redirect()->back()->with('error', 'Department Review Questions have not been uploaded!');
							
							
						
						

					}	
		
	}

	public function getEvaluation(Request $request)
	{
		
		$det=E360Det::find($request->det);
		$employee=User::find($request->employee);
		$reviewer=User::find(Auth::user()->id);
		$operation='evaluate';
		
						$evaluation=E360Evaluation::where(['e360_det_id'=>$det->id,'user_id'=>$employee->id,'evaluator_id'=>$reviewer->id])->first();

					if($evaluation){
						
						
						return view('e360.review',compact('evaluation','det'));

					}else{
						
						
							$evaluation=E360Evaluation::create(['e360_det_id'=>$det->id,'user_id'=>$employee->id,'evaluator_id'=>$reviewer->id]);
							
						return view('e360.review',compact('evaluation','det'));

					}	
		
	}
	public function getEvaluationReport(Request $request)
	{
		
		$det=E360Det::find($request->det);
		$employee=User::find($request->employee);
		$operation='evaluate';
		
						$evaluation=E360Evaluation::where(['e360_det_id'=>$det->id,'user_id'=>$employee->id])->first();

					if($evaluation){
						
						$evaluations=E360Evaluation::where(['e360_det_id'=>$det->id,'user_id'=>$employee->id])->get();
						return view('e360.review_report',compact('employee','det','evaluations'));

					}else{
						
						
						return redirect()->back()->with('error', 'Employee has not been reviewed!');
					}	
		
	}
	public function saveEvaluation(Request $request)
	{
		$det=E360Det::find($request->det_id);
		$evaluation=E360Evaluation::find($request->evaluation_id);
		foreach ($det->questions as $question) {
			$det_question=E360EvaluationDetail::updateOrCreate(['e360_det_question_id'=>$request->question_id,'e360_evaluation_id'=>$request->evaluation_id,'e360_det_question_option_id'=>$request->result['question_'.$question->id]],['e360_evaluation_id'=>$request->evaluation_id,'e360_det_question_id'=>$question->id,'e360_det_question_option_id'=>$request->result['question_'.$question->id]]);
		}
					
			
			
			 
			return 'success';
			
	
	}

}