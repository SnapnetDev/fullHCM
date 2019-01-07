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

	public function importEmployees(Request $request)
	{
		$document = $request->file('template');
		 //$document->getRealPath();
		// return $document->getClientOriginalName();
		// $document->getClientOriginalExtension();
		// $document->getSize();
		// $document->getMimeType();
		
		$branch=Branch::where('name', 'like', '%'.$row['branch'].'%')->get();
                	$company=Company::find($request->company_id);

		 if($request->hasFile('template')){
            Excel::load($request->file('template')->getRealPath(), function ($reader) use ($branch,$company) {
            	$array=$reader->toArray();
                foreach ($reader->toArray() as $key => $row) {
                	

                	$user=User::create(['name'=>$row['first_name'].' '.$row['last_name'],'email'=>$row['email'],'phone'=>$row['email'],'emp_num'=>$row['staff_id'],'sex'=>$row['gender'],'address'=>$row['address'],'marital_status'=>$row['address'],'dob'=>date('Y-m-d',strtotime($row['date_of_birth'])),'branch_id'=>$branch->id,'company_id'=>$company->id]);
       
            $nok=\App\Nok::create(['name'=>$row['next_of_kin'],'address'=>$row['address_of_next_of_kin'],'relationship'=>strtolower($row['relationship']),'user_id'=>$user->id]);
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
            		Department::create(['name'=>$row['name'],'company_id'=>$company_id]);
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
            		Branch::create(['name'=>$row['branch_name'],'company_id'=>$company->id,'address'=>$row['branch_address'],'email'=>$row['branch_email']]);
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
		$department=Department::where('department', 'like', '%'.$row['department'].'%')->get();

		 if($request->hasFile('template')){
            Excel::load($request->file('template')->getRealPath(), function ($reader) use($company,$department) {
            	
            	foreach ($reader->toArray() as $key => $row) {
            		Job::create(['name'=>$row['name'],'department_id'=>$department->id,'description'=>$row['description'],'personnel'=>1]);
						 }
            });
            
          $request->session()->flash('success', 'Import was successful!');

        return back();
        }

	}
 


}