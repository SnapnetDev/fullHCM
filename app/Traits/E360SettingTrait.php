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
trait E360SettingTrait
{
	public function processGet($route,Request $request){
		switch ($route) {
			
			case 'get_measurement_period':
				# code...
				return $this->getMeasurementPeriod($request);
				break;
			case 'download_template':
				# code...
				return $this->downloadTemplate($request);
				break;
			case 'get_det_details':
				# code...
				return $this->getDETDetails($request);
				break;
			case 'delete_det_detail':
				# code...
				return $this->deleteDETDetail($request);
				break;
			case 'get_det':
				# code...
				return $this->getDET($request);
				break;
			case 'template':
				# code...
				return $this->template($request);
				break;
			case 'get_question':
				# code...
				return $this->getQuestion($request);
				break;
			case 'get_question_options':
				# code...
				return $this->getDETQuestionOptions($request);
				break;
			case 'delete_question':
				# code...
				return $this->deleteQuestion($request);
				break;
			case 'delete_question_option':
				# code...
				return $this->deleteQuestionOption($request);
				break;
			
			
			default:
				# code...
				break;
		}
		 
	}


	public function processPost(Request $request){
		// try{
		switch ($request->type) {
			case 'editweight':
				# code...
				return $this->saveWeight($request);
				break;
			case 'measurementperiod':
				# code...
				return $this->saveMeasurementPeriod($request);
				break;
			case 'save_det_detail':
				# code...
				return $this->saveDETDetail($request);
				break;
			case 'save_question':
				# code...
				return $this->saveQuestion($request);
				break;
			case 'save_question_option':
				# code...
				return $this->saveQuestionOption($request);
				break;
			case 'import_template':
				# code...
				return $this->importQuestions($request);
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

	public function getMeasurementPeriod(Request $request)
	{
		return $measurementperiod= E360MeasurementPeriod::find($request->mp_id);
	}
	public function saveMeasurementPeriod(Request $request)
	{
		$month=date('m',strtotime('01-'.$request->to));
		$year=date('Y',strtotime('01-'.$request->to));
		$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
		E360MeasurementPeriod::updateOrCreate(['id'=>$request->mp_id],['from'=>date('Y-m-d',strtotime('01-'.$request->from)),'to'=>date('Y-m-d',strtotime($days.'-'.$request->to))]);
		return 'success';
	}
	public function getDet(Request $request)
	{
		
		$department=Department::find($request->department);
		$mp=E360MeasurementPeriod::find($request->mp);
		$operation='evaluate';
		
						$det=E360Det::where(['department_id'=>$department->id,'measurement_period_id'=>$request->mp])->first();
					if($det){
						
						
						return view('e360.view_department_template',compact('det'));

					}else{
						
						
							$det=E360Det::create(['measurement_period_id'=>$request->mp,'department_id'=>$department->id]);
							
						
						return view('e360.view_department_template',compact('det'));

					}	
		
	}

	public function saveQuestion(Request $request)
	{
					
			
			 $det_question=E360DetQuestion::updateOrCreate(['id'=>$request->question_id],['e360_det_id'=>$request->det_id,'question'=>$request->question]);
			
			 
			return $det_question;
			
	
	}
	public function getQuestion(Request $request)
	{
		return $question=e360DetQuestion::find($request->question_id);
	}

	public function getDETQuestionOptions(Request $request)
	{
		return $options=e360DetQuestionOption::where(['e360_det_question_id'=>$request->question_id])->get();
		
	}

	public function deleteQuestion(Request $request)
	{
		$det_question=e360DetQuestion::find($request->id);
		$det_question->delete();
		
	}

	public function deleteQuestionOption(Request $request)
	{
		$option=e360DetQuestionOption::find($request->id);
		$option->delete();
		
	}

	public function saveQuestionOption(Request $request)
	{
					
			
			 $det_question_option=E360DetQuestionOption::updateOrCreate(['id'=>$request->id],['e360_det_question_id'=>$request->e360_det_question_id,'content'=>$request->content,'score'=>$request->score]);
			
			 
			return $det_question_option;
			
	
	}

	public function template(Request $request)
	{
		$company_id=companyId();
        $measurement_periods=E360MeasurementPeriod::all();
        
        $departments=Department::where('company_id',$company_id)->get();
     
       
        return view('e360.template',compact('measurement_periods','departments'));
	}

	public function downloadTemplate(Request $request)
	{
		 
              
               // return $payroll->payroll_details->count();
               $view='e360.partials.downloadtemplate';
                // return view('compensation.d365payroll',compact('payroll','allowances','deductions','income_tax','salary','date','has_been_run'));
                 return     \Excel::create("questionnaire", function($excel) use ($view) {

            $excel->sheet("export", function($sheet) use ($view) {
                $sheet->loadView("$view")
                ->setOrientation('landscape');
            });

        })->export('xlsx');
	}

	public function importQuestions(Request $request)
	{
		$document = $request->file('template');
		// $company=Company::find($request->company_id);
		 //$document->getRealPath();
		// return $document->getClientOriginalName();
		// $document->getClientOriginalExtension();
		// $document->getSize();
		// $document->getMimeType();
		
		
		 if($request->hasFile('template')){
            Excel::load($request->file('template')->getRealPath(), function ($reader) use($request) {
            	
            	foreach ($reader->toArray() as $key => $row) {
            		if ($row['question']) {
            			$question=E360DetQuestion::create(['e360_det_id'=>$request->det_id,'question'=>$row['question']]);
            			if ($row['option1']) {
            			E360DetQuestionOption::create(['e360_det_question_id'=>$question->id,'content'=>$row['option1'],'score'=>$row['score1']]);
            			
            			}
            			if ($row['option2']) {
            			E360DetQuestionOption::create(['e360_det_question_id'=>$question->id,'content'=>$row['option2'],'score'=>$row['score2']]);
            			
            			}
            			if ($row['option3']) {
            			E360DetQuestionOption::create(['e360_det_question_id'=>$question->id,'content'=>$row['option3'],'score'=>$row['score3']]);
            			
            			}
            			if ($row['option4']) {
            			E360DetQuestionOption::create(['e360_det_question_id'=>$question->id,'content'=>$row['option4'],'score'=>$row['score4']]);
            			
            			}
            			if ($row['option5']) {
            			E360DetQuestionOption::create(['e360_det_question_id'=>$question->id,'content'=>$row['option5'],'score'=>$row['score5']]);
            			
            			}
            		}
            		 
            		 }
            		
            });
            
            
          $request->session()->flash('success', 'Import was successful!');

        return 'success';
        }
        

	}
}