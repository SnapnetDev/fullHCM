<?php
namespace App\Traits;

use App\Payroll;
use App\Bank;
use App\CompanyAccountDetail;
use App\PayslipDetail;
use App\PayrollPolicy;
<<<<<<< HEAD
use App\TmsaPolicy;
=======
>>>>>>> 756669c79ba12453137381addef2325f0d752945
use App\LoanPolicy;
use App\SalaryComponent;
use App\TmsaComponent;
use App\TmsaSchedule;
use App\SpecificSalaryComponent;
use App\Workflow;
use App\LatenessPolicy;
use App\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Auth;
use Excel;
use Illuminate\Validation\Rule;
use Validator;
/**
 *
 */
trait PayrollSetting
{
	public function processGet($route,Request $request)
	{
		switch ($route) {
			case 'account':
				# code...
				return $this->accountSettings($request);
				break;
			case 'payslip':
			# code...
			return $this->payslipDetailSettings($request);
			break;
      case 'payroll_policy':
      # code...
      return $this->payrollPolicySettings($request);
      break;
<<<<<<< HEAD
       case 'tmsa_policy':
      # code...
      return $this->tmsaPolicySettings($request);
      break;
=======
>>>>>>> 756669c79ba12453137381addef2325f0d752945
      case 'loan_policy':
      # code...
      return $this->loanPolicySettings($request);
      break;
      case 'salary_components':
      # code...
      return $this->salaryComponents($request);
      break;
      case 'salary_component':
      # code...
      return $this->salaryComponent($request);
      break;
      case 'specific_salary_components':
      # code...
      return $this->specificSalaryComponents($request);
      break;
      case 'downloadssctemplate':
        return $this->downloadSSTemplate($request);
        break;
      case 'specific_salary_component':
      # code...
      return $this->specificSalaryComponent($request);
      break;
       case 'change_salary_component_status':
      # code...
      return $this->changeSalaryComponentStatus($request);
      break;
       case 'delete_salary_component':
      # code...
      return $this->deleteSalaryComponent($request);
      break;
       case 'change_specific_salary_component_status':
      # code...
      return $this->changeSpecificSalaryComponentStatus($request);
      break;
      case 'change_salary_component_taxable':
      # code...
      return $this->changeSalaryComponentTaxable($request);
      break;
<<<<<<< HEAD
       case 'change_specific_salary_component_taxable':
      # code...
      return $this->changeSpecificSalaryComponentTaxable($request);
      break;
=======
>>>>>>> 756669c79ba12453137381addef2325f0d752945
       case 'delete_specific_salary_component':
      # code...
      return $this->deleteSpecificSalaryComponent($request);
      break;
      case 'lateness_policy':
      # code...
      return $this->latenessPolicy($request);
      break;
      case 'change_lateness_policy_status':
      # code...
      return $this->changeLatenessPolicyStatus($request);
      break;
       case 'delete_lateness_policy':
      # code...
      return $this->deleteLatenessPolicy($request);
      break;
       case 'switch_lateness_policy':
      # code...
      return $this->switchLatenessPolicy($request);
      break;
       case 'tmsa_components':
      # code...
      return $this->tmsaComponents($request);
      break;
      case 'tmsa_component':
      # code...
      return $this->tmsaComponent($request);
      break;
      case 'change_tmsa_component_status':
      # code...
      return $this->changeTmsaComponentStatus($request);
      break;
       case 'delete_tmsa_component':
      # code...
      return $this->deleteTmsaComponent($request);
      break;
      case 'change_tmsa_component_taxable':
      # code...
      return $this->changeTmsaComponentTaxable($request);
      break;
			
			default:
				# code...
				break;
		}
	}
	public function processPost(Request $request)
	{
		
		switch ($request->type) {
			case 'account':
				# code...

				return $this->updateAccountSettings($request);
				break;
			case 'payslip':
			# code...
			return $this->updatePayslipDetailSettings($request);
			break;
       case 'payroll_policy':
      # code...
      return $this->savePayrollPolicySettings($request);
      break;
<<<<<<< HEAD
       case 'tmsa_policy':
      # code...
      return $this->saveTmsaPolicySettings($request);
      break;
=======
>>>>>>> 756669c79ba12453137381addef2325f0d752945
      case 'loan_policy':
      # code...
      return $this->saveLoanPolicySettings($request);
      break;
       case 'salary_component':
      # code...
      return $this->saveSalaryComponent($request);
      break;
       case 'tmsa_component':
      # code...
      return $this->saveTmsaComponent($request);
      break;
       case 'specific_salary_component':
      # code...
      return $this->saveSpecificSalaryComponent($request);
      break;
      case 'import_specific_salary_components':
      # code...
      return $this->importSpecificSalaryComponent($request);
      break;
      case 'lateness_policy':
      # code...
      return $this->saveLatenessPolicy($request);
      break;
			
			default:
				# code...
				break;
		}
	}
  public function accountSettings(Request $request)
  {
  		$banks=Bank::orderBy('bank_name','ASC')->get();
  		$cad=CompanyAccountDetail::first();
    return view('payrollsettings.account',compact('banks','cad'));
  }
  public function updateAccountSettings(Request $request)
  {
  		// return $request->all();
  		$cad=CompanyAccountDetail::first();
  		if ($cad) {
  			$cad->update(['accountNum'=>$request->accountNum,'first_name'=>$request->first_name,'last_name'=>$request->last_name,'bank_id'=>$request->bank_id]);
  		}else{
  			CompanyAccountDetail::create(['accountNum'=>$request->accountNum,'first_name'=>$request->first_name,'last_name'=>$request->last_name,'bank_id'=>$request->bank_id]);
  		}
    return 'success';
  }
  public function payslipDetailSettings(Request $request)
  {
    $company_id=companyId();
  		$payslip_detail=PayslipDetail::where('company_id',$company_id)->first();
  		if (!$payslip_detail) {
  			$payslip_detail=PayslipDetail::create(['watermark_text'=>'','company_id'=>$company_id]);
  		}
  		return view('payrollsettings.payslip_detail',compact('payslip_detail'));
  }
  public function updatePayslipDetailSettings(Request $request)
  {	
    $company_id=companyId();
  		$payslip_detail=PayslipDetail::first();
  		if ($payslip_detail) {
  			$payslip_detail->update(['watermark_text'=>$request->watermark_text]);
  			if ($request->file('logo')) {
                    $path = $request->file('logo')->store('public');
                    if (Str::contains($path, 'public/')) {
                       $filepath= Str::replaceFirst('public/', '', $path);
                    } else {
                        $filepath= $path;
                    }
                     $payslip_detail->logo = $filepath;
                    $payslip_detail->save();
                }
  		}else{
  			PayslipDetail::create(['watermark_text'=>$request->watermark_text,'company_id'=>$company_id]);
  			if ($request->file('logo')) {
                    $path = $request->file('logo')->store('public');
                    if (Str::contains($path, 'public/')) {
                       $filepath= Str::replaceFirst('public/', '', $path);
                    } else {
                        $filepath= $path;
                    }
                   $payslip_detail->logo = $filepath;
                    $payslip_detail->save();
                }
  		}
  		 return 'success';

   
  }

  public function specificSalaryComponent(Request $request)
  {
   $ssc=SpecificSalaryComponent::find($request->specific_salary_component_id);
   return $ssc;
  }
  public function specificSalaryComponents(Request $request)
  {
   $sscs=SpecificSalaryComponent::all();
   return view('payrollsettings.specific_salary_component',compact('sscs'));
  }
  public function saveSpecificSalaryComponent(Request $request)
  {
     $company_id=companyId();
   $sc=SpecificSalaryComponent::updateOrCreate(['id'=>$request->specific_salary_component_id],['name'=>$request->name,'amount'=>$request->amount,'gl_code'=>$request->gl_code,'project_code'=>$request->project_code,'type'=>$request->ssctype,'comment'=>$request->comment,'emp_id'=>$request->user_id,'duration'=>$request->duration,'grants'=>$request->grant,'status'=>0,'starts'=>$request->starts,'ends'=>$request->ends,'company_id'=>$company_id]);
   
    return 'success';
  }
  public function deleteSpecificSalaryComponent(Request $request)
  {
   $sc=SpecificSalaryComponent::find($request->specific_salary_component_id);
   if ($sc) {
   
     $sc->delete();
      return 'success';
   }
  }
  public function salaryComponent(Request $request)
  {

   $sc=SalaryComponent::where('id',$request->salary_component_id)->with('exemptions')->first();
   return $sc;
  }
  public function salaryComponents(Request $request)
  {
   $scs=SalaryComponent::with('exemptions')->get();
   return view('payrollsettings.salary_component',compact('scs'));
  }
  public function saveSalaryComponent(Request $request)
  {
    $company_id=companyId();

    $validator=Validator::make($request->all(), [
    'constant' => [
        'required',
        Rule::unique('salary_components')->where(function ($query) use($company_id,$request) {
    return $query->where('company_id', $company_id)
    ->where('id','!=',$request->salary_component_id);
})
          ],
      ]);
    if ($validator->fails()) {
            return response()->json([
                    $validator->errors()
                    ],401);
        }
   
    $sc=SalaryComponent::updateOrCreate(['id'=>$request->salary_component_id],['name'=>$request->name,'gl_code'=>$request->gl_code,'project_code'=>$request->project_code,'type'=>$request->sctype,'comment'=>$request->comment,'constant'=>$request->constant,'formula'=>$request->formula,'company_id'=>$company_id,'taxable'=>$request->taxable]);
    $no_of_exemptions=count($request->input('exemptions'));
    if($no_of_exemptions>0){
      $sc->exemptions()->detach();
              for ($i=0; $i <$no_of_exemptions ; $i++) {
                if ($request->exemptions[$i]!=0) {
                  $sc->exemptions()->attach($request->exemptions[$i],['created_at' => date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                }
            
            }
        }
        return 'success';
  }
  public function deleteSalaryComponent(Request $request)
  {
   $sc=SalaryComponent::find($request->salary_component_id);
   if ($sc) {
    $sc->exemptions()->detach();
     $sc->delete();
      return 'success';
   }
  }
  public function changeSalaryComponentStatus(Request $request)
  {
   $sc=SalaryComponent::find($request->salary_component_id);
   if ($sc->status==1) {
     $sc->update(['status'=>0]);
      return 2;
   }elseif($sc->status==0){
    $sc->update(['status'=>1]);
    return 1;
   }
   
  
  }
  public function changeSpecificSalaryComponentStatus(Request $request)
  {
   $sc=SpecificSalaryComponent::find($request->specific_salary_component_id);
   if ($sc->status==1) {
     $sc->update(['status'=>0]);
      return 2;
   }elseif($sc->status==0){
    $sc->update(['status'=>1]);
    return 1;
   }
 }

   public function changeSalaryComponentTaxable(Request $request)
  {
   $sc=SalaryComponent::find($request->salary_component_id);
   if ($sc->taxable==1) {
     $sc->update(['taxable'=>0]);
      return 2;
   }elseif($sc->taxable==0){
    $sc->update(['taxable'=>1]);
    return 1;
   }
   
  
  }
  public function changeSpecificSalaryComponentTaxable(Request $request)
  {
   $ssc=SpecificSalaryComponent::find($request->specific_salary_component_id);
   if ($ssc->taxable==1) {
     $ssc->update(['taxable'=>0]);
      return 2;
   }elseif($ssc->taxable==0){
    $ssc->update(['taxable'=>1]);
    return 1;
   }
   
  
  }
  public function importSpecificSalaryComponent(Request $request)
  {
    $document = $request->file('template');
    $company_id=companyId();
    $company=Company::find($company_id);
     //$document->getRealPath();
    // return $document->getClientOriginalName();
    // $document->getClientOriginalExtension();
    // $document->getSize();
    // $document->getMimeType();
    

     if($request->hasFile('template')){
            Excel::load($request->file('template')->getRealPath(), function ($reader) use($company) {
           
              foreach ($reader->toArray() as $key => $row) {
                 // $hiredate=\Carbon\Carbon::createFromFormat('d/m/Y', $row['hiredate'])->toDateTimeString();  
                if ($row['staff_id']) {
                  $user=\App\User::where(['emp_num'=>$row['staff_id']])->first();
                 $user->specific_salary_components()->create(['name'=>$row['component_name'],'gl_code'=>$row['gl_code'],'project_code'=>$row['project_code'],'type'=>$row['type'],'comment'=>$row['comment'],'duration'=>$row['duration'],'grants'=>0,'status'=>0,'company_id'=>$company->id,'amount'=>$row['amount'],'taxable'=>$row['taxable']]);
                }
                
                
             }
            });
            
          $request->session()->flash('success', 'Import was successful!');

        return back();
        }

  }
  public function payrollPolicySettings(Request $request)
  {
      $company_id=companyId();
      $pp=PayrollPolicy::where('company_id',$company_id)->first();
       $workflows=Workflow::all();
       // $setting=Setting::where(['name'=>'use_lateness','company_id'=>$company_id])->first();
       // if (!$setting) {
       //  $setting=Setting::create(['name'=>'use_lateness','company_id'=>$company_id]);
       // }
       $latenesspolicies=LatenessPolicy::where('company_id',$company_id)->get();
      if (!$pp) {
        $pp=PayrollPolicy::create(['basic_pay_percentage'=>$request->basic_pay_percentage,'payroll_runs'=>$request->when,'user_id'=>Auth::user()->id,'company_id'=>$company_id]);
      }
    return view('payrollsettings.payroll_policy',compact('pp','workflows','latenesspolicies'));
  }
  public function savePayrollPolicySettings(Request $request)
  {
      // return $request->all();
    $company_id=companyId();
      $pp=PayrollPolicy::where('company_id',$company_id)->first();

      if ($pp) {
        $pp->update(['basic_pay_percentage'=>$request->basic_pay_percentage,'payroll_runs'=>$request->when,'user_id'=>Auth::user()->id,'workflow_id'=>$request->workflow_id]);
      }else{
        PayrollPolicy::create(['basic_pay_percentage'=>$request->basic_pay_percentage,'payroll_runs'=>$request->payroll_runs,'user_id'=>Auth::user()->id,'workflow_id'=>$request->workflow_id,'company_id'=>$company_id]);
      }
    return 'success';
  }
<<<<<<< HEAD
  public function tmsaPolicySettings(Request $request)
  {
      $company_id=companyId();
      $tp=TmsaPolicy::where('company_id',$company_id)->first();
       $workflows=Workflow::all();
      
       
      if (!$tp) {
        $tp=TmsaPolicy::create(['onshore_day_rate'=>$request->onshore_day_rate,'offshore_day_rate'=>$request->offshore_day_rate,'out_of_station'=>$request->out_of_station,'company_id'=>$company_id]);
      }
    return view('payrollsettings.tmsa_policy',compact('tp','workflows'));
  }
  public function saveTmsaPolicySettings(Request $request)
  {
      // return $request->all();
    $company_id=companyId();
      $tp=TmsaPolicy::where('company_id',$company_id)->first();

      if ($tp) {
        $tp->update(['onshore_day_rate'=>$request->onshore_day_rate,'offshore_day_rate'=>$request->offshore_day_rate,'out_of_station'=>$request->out_of_station,'workflow_id'=>$request->workflow_id]);
      }else{
        TmsaPolicy::create(['onshore_day_rate'=>$request->onshore_day_rate,'offshore_day_rate'=>$request->offshore_day_rate,'out_of_station'=>$request->out_of_station,'workflow_id'=>$request->workflow_id]);
      }
    return 'success';
  }
=======
>>>>>>> 756669c79ba12453137381addef2325f0d752945
   public function loanPolicySettings(Request $request)
  {
      $company_id=companyId();
      $lp=LoanPolicy::where('company_id',$company_id)->first();
       $workflows=Workflow::all();
       
       
      if (!$lp) {
        $lp=LoanPolicy::create(['annual_interest'=>0,'maximum_allowed'=>0,'user_id'=>Auth::user()->id,'company_id'=>$company_id,'workflow_id'=>0]);
      }
    return view('payrollsettings.loan_policy',compact('lp','workflows'));
  }
  public function saveLoanPolicySettings(Request $request)
  {
      // return $request->all();
    $company_id=companyId();
       $lp=LoanPolicy::where('company_id',$company_id)->first();

      if ($lp) {
        $lp->update(['annual_interest'=>$request->annual_interest,'maximum_allowed'=>$request->maximum_allowed,'user_id'=>Auth::user()->id,'workflow_id'=>$request->workflow_id]);
      }else{
        LoanPolicy::create(['annual_interest'=>$request->annual_interest,'maximum_allowed'=>$request->maximum_allowed,'user_id'=>Auth::user()->id,'workflow_id'=>$request->workflow_id,'company_id'=>$company_id]);
      }
    return 'success';
  }

  public function latenessPolicy(Request $request)
  {

   $lp=LatenessPolicy::find($request->lateness_policy_id);
   return $lp;
  }
  
public function saveLatenessPolicy(Request $request)
  {
    $company_id=companyId();
    $lp=LatenessPolicy::updateOrCreate(['id'=>$request->lateness_policy_id],['policy_name'=>$request->policy_name,'late_minute'=>$request->late_minute,'deduction_type'=>$request->deduction_type,'deduction'=>$request->deduction,'company_id'=>$company_id]);
   
        
        return 'success';
  }
  public function deleteLatenessPolicy(Request $request)
  {
   $lp=LatenessPolicy::find($request->lateness_policy_id);
   if ($lp) {
    
     $lp->delete();
      return 'success';
   }
  }

  public function changeLatenessPolicyStatus(Request $request)
  {
    //this function enables user to enable and disable lateness policy
   $lp=LatenessPolicy::find($request->lateness_policy_id);
   if ($lp->status==1) {
     $lp->update(['status'=>0]);
      return 2;
   }elseif($lp->status==0){
    $lp->update(['status'=>1]);
    return 1;
   }
   
  
  }
  public function switchLatenessPolicy(Request $request)
  {
    $company_id=companyId();
    $pp=PayrollPolicy::where('company_id',$company_id)->first();
    if ($pp->use_lateness==1) {
     $pp->update(['use_lateness'=>0]);
      return 2;
    }elseif($pp->use_lateness==0){
      $pp->update(['use_lateness'=>1]);
       return 1;
    }
  }

  public function tmsaComponent(Request $request)
  {

   $tc=TmsaComponent::where('id',$request->tmsa_component_id)->with('exemptions')->first();
   return $tc;
  }
  public function tmsaComponents(Request $request)
  {
   $tcs=TmsaComponent::with('exemptions')->get();
   return view('payrollsettings.tmsa_component',compact('tcs'));
  }
  public function saveTmsaComponent(Request $request)
  {
    $company_id=companyId();

    $validator=Validator::make($request->all(), [
    'constant' => [
        'required',
        Rule::unique('tmsa_components')->where(function ($query) use($company_id,$request) {
    return $query->where('company_id', $company_id)
    ->where('id','!=',$request->tmsa_component_id);
})
          ],
      ]);
    if ($validator->fails()) {
            return response()->json([
                    $validator->errors()
                    ],401);
        }
   
    $tc=TmsaComponent::updateOrCreate(['id'=>$request->tmsa_component_id],['name'=>$request->name,'type'=>$request->tctype,'constant'=>$request->constant,'company_id'=>$company_id,'taxable'=>$request->taxable,'amount'=>$request->amount,'status'=>0,'comment'=>$request->comment,'gl_code'=>$request->gl_code,'project_code'=>$request->project_code]);
    $no_of_exemptions=count($request->input('exemptions'));
    if($no_of_exemptions>0){
      $tc->exemptions()->detach();
              for ($i=0; $i <$no_of_exemptions ; $i++) {
                if ($request->exemptions[$i]!=0) {
                  $tc->exemptions()->attach($request->exemptions[$i],['created_at' => date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                }
            
            }
        }
        return 'success';
  }
  public function deleteTmsaComponent(Request $request)
  {
   $tc=TmsaComponent::find($request->tmsa_component_id);
   if ($tc) {
    $tc->exemptions()->detach();
     $tc->delete();
      return 'success';
   }
  }
  public function changeTmsaComponentStatus(Request $request)
  {
   $tc=TmsaComponent::find($request->tmsa_component_id);
   if ($tc->status==1) {
     $tc->update(['status'=>0]);
      return 2;
   }elseif($tc->status==0){
    $tc->update(['status'=>1]);
    return 1;
   }
   
  
  }
 public function changeTmsaComponentTaxable(Request $request)
  {
   $tc=TmsaComponent::find($request->tmsa_component_id);
   if ($tc->taxable==1) {
     $tc->update(['taxable'=>0]);
      return 2;
   }elseif($tc->taxable==0){
    $tc->update(['taxable'=>1]);
    return 1;
   }
   
  
  }

  private function downloadSSTemplate(Request $request){

                           $template=['staff id','component name','type','amount','comment','duration','taxable','gl_code','project_code'];
                          

                           return $this->exportexcel('template',['template'=>$template]);

              }

  private function exportexcel($worksheetname,$data)
  {
    return \Excel::create($worksheetname, function($excel) use ($data)
    {
      foreach($data as $sheetname=>$realdata)
      {
        $excel->sheet($sheetname, function($sheet) use ($realdata,$sheetname)
        {
            
                  $sheet->fromArray($realdata);
                 

           
        });
      }
    })->download('xlsx');
  }

  // public function importTemplate(Request $request)
  // {
  //   $document = $request->file('template');
  //   $company_id=companyId();
  //   $det=BscDet::find($request->det_id);
    

  //    if($request->hasFile('template')){

  //     $datas=\Excel::load($request->file('template')->getrealPath(), function($reader) { 
  //                                        $reader->noHeading()->skipRows(1);
  //                          })->get();
      
  //                          foreach ($datas[0] as $data) {
  //                           // dd($data[0]);
  //                           if ($data[0]) {
  //                       $user=User::where('emp_num',$data[0])->first();
  //                        $det_detail=BscDetDetail::create(['bsc_det_id'=>$det->id,'bsc_metric_id'=>$metric->id,'business_goal'=>$data[1],'measure'=>$data[2],'lower'=>$data[3],'mid'=>$data[4],'upper'=>$data[5],'weighting'=>$data[6]*100]);
                        
                        
  //                     }
                                                             
  //                          }


  //       return 'success';
  //       }

  // }
}
