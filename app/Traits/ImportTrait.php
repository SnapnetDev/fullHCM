<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Auth;
use Excel;
use DB;
use App\User;
use App\Branch;
use App\Company;
use App\Department;
use App\Job;
use App\Grade;


trait ImportTrait {
	public $allowed=['xls','xlsx','csv'];
	public function processGet($route,Request $request){
		switch ($route) {
			case 'employees':
				# code...
				return $this->viewEmployeesImport($request);
				break;
			case 'departments':
				# code...
				return $this->viewDepartmentsImport($request);
				break;
			case 'branches':
				# code...
				return $this->viewBranchesImport($request);
				break;
			case 'jobroles':
				# code...
				return $this->viewJobrolesImport($request);
				break;
			case 'grades':
				# code...
				return $this->viewGradesImport($request);
				break;
			
			default:
				# code...
				break;
		}
		 
	}


	public function processPost(Request $request){
		// try{
		switch ($request->type) {
			case 'employees':
				# code...
				return $this->importEmployees($request);
				break;
			case 'departments':
				# code...
				return $this->importDepartments($request);
				break;
			case 'branches':
				# code...
				return $this->importBranches($request);
				break;
			case 'jobroles':
				# code...
				return $this->importJobroles($request);
				break;
			case 'grades':
				# code...
				return $this->importUserRoles($request);
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

	public function viewEmployeesImport(Request $request)
	{
		$companies=Company::all();
         return view('import.employees',compact('companies'));
	}
	public function viewDepartmentsImport(Request $request)
	{
		$companies=Company::all();
         return view('import.departments',compact('companies'));
	}
	public function viewBranchesImport(Request $request)
	{
		$companies=Company::all();
         return view('import.branches',compact('companies'));
	}
	public function viewJobrolesImport(Request $request)
	{
		$companies=Company::all();
         return view('import.jobroles',compact('companies'));
	}
	public function viewGradesImport(Request $request)
	{
		$companies=Company::all();
         return view('import.grades',compact('companies'));
	}

	public function importEmployees(Request $request)
	{
		$document = $request->file('template');
		 //$document->getRealPath();
		// return $document->getClientOriginalName();
		// $document->getClientOriginalExtension();
		// $document->getSize();
		// $document->getMimeType();
		
		
                	$company=Company::find($request->company_id);

		 if($request->hasFile('template')){
            Excel::load($request->file('template')->getRealPath(), function ($reader) use ($company) {
            	$array=$reader->toArray();
                foreach ($reader->toArray() as $key => $row) {
                	$branch=Branch::where('name', 'like', '%'.$row['branch'].'%')->where('company_id',$company->id)->first();
                	$old_user=User::where('emp_num',$row['staff_id'])->first();
                	$dob=\Carbon\Carbon::parse($row['date_of_birth'])->toDateTimeString();
                	// $dob=\Carbon\Carbon::createFromFormat('d H:i:s.u', '2019-02-01 03:45:27.612584')
                		$hiredate=\Carbon\Carbon::parse($row['hiredate'])->toDateTimeString();
                	if (!$old_user) {

                		$user=User::create(['name'=>$row['first_name'].' '.$row['last_name'],'email'=>$row['email'],'phone'=>$row['phone'],'emp_num'=>$row['staff_id'],'sex'=>$row['gender'],'address'=>$row['address'],'marital_status'=>$row['marital_status'],'dob'=>date('Y-m-d',strtotime($dob)),'branch_id'=>($branch ?$branch->id : ''),'company_id'=>$company->id,'hiredate'=>date('Y-m-d',strtotime($hiredate)),'role_id'=>4]);
				       if ($row['next_of_kin']!='' && $row['relationship']!='') {
				       
				            $nok=\App\Nok::create(['name'=>$row['next_of_kin'],'address'=>$row['address_of_next_of_kin'],'relationship'=>strtolower($row['relationship']),'user_id'=>$user->id]);
				       }
				        $grade=Grade::where('level',$row['grade'])->first();
				       if ($grade) {
				      
				       $user->promotionHistories()->create(['approved_by'=>Auth::user()->id,'approved_on'=>date('Y-m-d'),'old_grade_id'=>$grade->id,'grade_id'=>$grade->id]);
				       }
                	}else{
                		$old_user->update(['name'=>$row['first_name'].' '.$row['last_name'],'email'=>$row['email'],'phone'=>$row['phone'],'emp_num'=>$row['staff_id'],'sex'=>$row['gender'],'address'=>$row['address'],'marital_status'=>$row['marital_status'],'dob'=>date('Y-m-d',strtotime($dob)),'hiredate'=>date('Y-m-d',strtotime($hiredate))]);

                		if ($row['next_of_kin']!='' && $row['relationship']!='') {

                			\App\Nok::updateOrCreate(
											    ['user_id' => $old_user->id],
											   ['name'=>$row['next_of_kin'],'address'=>$row['address_of_next_of_kin'],'relationship'=>strtolower($row['relationship']),'user_id'=>$old_user->id]
											);
				       
				            
				       }
				       $grade=Grade::where('level',$row['grade'])->first();
				       if ($grade) {
				       
				       $hist=$old_user->promotionHistories()->first();

				       if ($hist) {
				       	$hist->update(['approved_by'=>Auth::user()->id,'approved_on'=>date('Y-m-d'),'old_grade_id'=>$grade->id,'grade_id'=>$grade->id]);
				       	$old_user->grade_id=$grade->id;
				       	$old_user->save();
				       }else{
				       	$old_user->promotionHistories()->create(['approved_by'=>Auth::user()->id,'approved_on'=>date('Y-m-d'),'old_grade_id'=>$grade->id,'grade_id'=>$grade->id]);
				       	$old_user->grade_id=$grade->id;
				       	$old_user->save();
				       }
				       
				       
				       }
                	}
                	
                    // $data['name'] = $row['name'];
                    // $data['email'] = $row['email'];
                    // $data['staff_id'] = $row['staffid'];

                    // if(!empty($data)) {
                    //     DB::table('test')->insert($data);
                    // }
                }
            });
        //     $path = $request->file('template')->getRealPath();
        // return $data = Excel::load($path)->get();
            // return $array;
               
          $request->session()->flash('success', 'Import was successful!');

        return back();
        }
        

	}
	public function importDepartments(Request $request)
	{
		$document = $request->file('template');
		$company=Company::find($request->company_id);
		 //$document->getRealPath();
		// return $document->getClientOriginalName();
		// $document->getClientOriginalExtension();
		// $document->getSize();
		// $document->getMimeType();
		

		 if($request->hasFile('template')){
            Excel::load($request->file('template')->getRealPath(), function ($reader) use($company) {
            	
            	foreach ($reader->toArray() as $key => $row) {
            		 $dept=Department::where('name',$row['department_name'])->first();
            		 if (!$dept) {
            		 	Department::create(['name'=>$row['department_name'],'company_id'=>$company->id]);
						 }
            		 }
            		
            });
            
              
          $request->session()->flash('success', 'Import was successful!');

        return back();
        }
        

	}

	public function importBranches(Request $request)
	{
		$document = $request->file('template');
		$company=Company::find($request->company_id);
		 //$document->getRealPath();
		// return $document->getClientOriginalName();
		// $document->getClientOriginalExtension();
		// $document->getSize();
		// $document->getMimeType();
	

		 if($request->hasFile('template')){
            Excel::load($request->file('template')->getRealPath(), function ($reader) use($company) {
            	
            	foreach ($reader->toArray() as $key => $row) {
            		$
            		$branch=Branch::where('name',$row['branch_name'])->first();
            		 if (!$branch) {
            		Branch::create(['name'=>$row['branch_name'],'company_id'=>$company->id,'address'=>$row['branch_address'],'email'=>$row['branch_email']]);
						 }
						}
            });
            
               
          $request->session()->flash('success', 'Import was successful!');

        return back();
        }
        

	}

	public function importJobroles(Request $request)
	{
		$document = $request->file('template');
		$company=Company::find($request->company_id);
		 //$document->getRealPath();
		// return $document->getClientOriginalName();
		// $document->getClientOriginalExtension();
		// $document->getSize();
		// $document->getMimeType();
		

		 if($request->hasFile('template')){
            Excel::load($request->file('template')->getRealPath(), function ($reader) use($company) {
            	
            	foreach ($reader->toArray() as $key => $row) {
            		$department=Department::where(['name'=>$row['department_name'],'company_id'=>$company->id])->first();
            		if ($department) {
            			$job=Job::where(['title'=>$row['title'],'department_id'=>$department->id])->first();
            			if (!$job) {
            				$qualification=\App\Qualification::find($row['qua_id']);
            				Job::create(['title'=>$row['title'],'department_id'=>$department->id,'description'=>$row['description'],'qualification_id'=>$qualification->id]);
            			}elseif($job){
            				$reports_to=$company->jobs()->where(['title'=>$row['reports_to']])->first();
            				if ($reports_to) {
            					$job->update(['description'=>$row['description'],'parent_id'=>$reports_to->id]);
            				}

            			}
            			
            		}
            		
						 }
            });
            
          $request->session()->flash('success', 'Import was successful!');

        return back();
        }

	}

	public function importUserRoles(Request $request)
	{
		$document = $request->file('template');
		$company=Company::find($request->company_id);
		 //$document->getRealPath();
		// return $document->getClientOriginalName();
		// $document->getClientOriginalExtension();
		// $document->getSize();
		// $document->getMimeType();
		

		 if($request->hasFile('template')){
            Excel::load($request->file('template')->getRealPath(), function ($reader) use($company) {
           
            	foreach ($reader->toArray() as $key => $row) {
            		 // $hiredate=\Carbon\Carbon::createFromFormat('d/m/Y', $row['hiredate'])->toDateTimeString();	
            		if ($row['jobid']) {
            			$job=\App\Job::find($row['jobid']);
            			$user=\App\User::where(['emp_num'=>$row['staff_id']])->first();
            			$user->jobs()->attach($job->id);
            			$user->job_id=$job->id;
            			$user->department_id=$job->department->id;
            			$user->save();
            		}
            		
            		
						 }
            });
            
          $request->session()->flash('success', 'Import was successful!');

        return back();
        }

	}

	public function importGrades(Request $request)
	{
		// $document = $request->file('template');
		$company=Company::find($request->company_id);
		 //$document->getRealPath();
		// return $document->getClientOriginalName();
		// $document->getClientOriginalExtension();
		// $document->getSize();
		// $document->getMimeType();
		

		 if($request->hasFile('template')){
            Excel::load($request->file('template')->getRealPath(), function ($reader) use($company) {
            	
            	foreach ($reader->toArray() as $key => $row) {
            		Grade::create(['level'=>$row['level'],'leave_length'=>$row['leave_length'],'basic_pay'=>$row['monthly_gross']]);
						 }
            });
            
          $request->session()->flash('success', 'Import was successful!');

        return back();
        }

	}
 


}