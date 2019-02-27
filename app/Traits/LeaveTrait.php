<?php
namespace App\Traits;
use App\Notifications\ApproveLeaveRequest;
use App\Notifications\LeaveRequestApproved;
use App\Notifications\LeaveRequestPassedStage;
use App\Notifications\LeaveRequestRejected;
use App\Leave;
use App\LeaveRequest;
use App\LeaveApproval;
use App\LeavePolicy;
use App\Holiday;
use App\Setting;
use App\Workflow;
use App\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;

use Auth;
 
/**
 *
 */
trait LeaveTrait
{

	public function processGet($route,Request $request)
	{
	switch ($route) {
		case 'myrequests':
		return $this->myRequests($request);
		break;
		case 'get_request':
		return $this->getRequest($request);
		break;
		case 'view_requests':
		return $this->viewRequests($request);
		break;
		case 'delete_request':
		return $this->deleteRequest($request);
		break;
		case 'show_approval':
		return $this->showApproval($request);
		break;
		case 'getdetails':
		return $this->getDetails($request);
		break;
		case 'approvals':
		return $this->approvals($request);
		break;
		
		default:
			# code...
			break;
	}
	}
	public function processPost(Request $request)
	{
		switch ($request->type) {
			case 'save_request':
				return $this->saveRequest($request);
				break;
				case 'save_approval':
				return $this->saveApproval($request);
				break;
			
			default:
				# code...
				break;
		}
	}
	public function viewRequests(Request $request)
	{
		# code...
	}

	public function myRequests(Request $request)
	{
		
		$company_id=companyId();
		$lp=LeavePolicy::where('company_id',$company_id)->first();
		if (Auth::user()->grade) {
			if (Auth::user()->grade->leave_length>0) {
				$leavebank=Auth::user()->grade->leave_length;
			}else{
				$leavebank=$lp->default_length;
			}
			
		}else{
				$leavebank=$lp->default_length;
		}
		// $leavebank=Auth::user()->promotionHistories()->latest()->first()->grade->leave_length;
		$leave_includes_weekend=$lp->includes_weekend;
		$leave_includes_holiday=$lp->includes_holiday;
		$holidays=Holiday::whereYear('date',date('Y-m-d'))->get();
		$pending_leave_requests=Auth::user()->leave_requests()->where('status',0)->whereYear('start_date', date('Y'))->get();
		$leave_requests=Auth::user()->leave_requests()->whereYear('start_date', date('Y'))->get();
		
		$leaves=Leave::all();
		
		
		$used_leaves=Auth::user()->leave_requests()->where('status',1)->whereYear('start_date', date('Y'))->get();
		if ($used_leaves) {
			$used_days=0;
			foreach ($used_leaves as $used_leave) {
				$startdate = \Carbon\Carbon::parse( $used_leave->start_date);
				
				$used_days+= $startdate->diffInDays($used_leave->end_date);
				if ($leave_includes_weekend==0) {
			
					 $weekends = 0;
					    $fromDate = $used_leave->start_date;
					    $toDate = $used_leave->end_date;
					    while (date("Y-m-d", $fromDate) != date("Y-m-d", $toDate)) {
					        $day = date("w", $fromDate);
					        if ($day == 0 || $day == 6) {
					            $weekends ++;
					        }
					        $fromDate = strtotime(date("Y-m-d", $fromDate) . "+1 day");
					    }
						    $used_days=$used_days -  $weekends;
					} elseif ($leave_includes_holiday==0) {

						$fromDate = $used_leave->start_date;
						    $toDate = $used_leave->end_date;
					$hols=Holiday::whereBetween('date', [$fromDate, $toDate])->count();
					$used_days=$used_days - $hols;

				}
			}
			$leavebank=$leavebank-$used_days;
		}
		
		// return ['leavebank'=>$leavebank,'holidays'=>$hols];
		return view('leave.myrequests',compact('leavebank','holidays','leave_requests','pending_leave_requests','leaves'));
	}
	public function saveRequest(Request $request)
	{
		// $leave_workflow_id=Setting::where('name','leave_workflow')->first()->value;
		
		$company_id=companyId();
		$leave_workflow_id=LeavePolicy::where('company_id',$company_id)->first()->workflow_id;
		$leave_request=LeaveRequest::create(['leave_id'=>$request->leave_id,'user_id'=>Auth::user()->id,'start_date'=>date('Y-m-d',strtotime($request->start_date)),'end_date'=>date('Y-m-d',strtotime($request->end_date)),'reason'=>$request->reason,'workflow_id'=>$leave_workflow_id,'paystatus'=>$request->paystatus,'status'=>0,'priority'=>$request->priority,'company_id'=>$company_id]);
		  $stage=Workflow::find($leave_request->workflow_id)->stages->first();
		  if($stage->type==1){
		  	$leave_request->leave_approvals()->create([
			    'leave_request_id' => $request->id,'stage_id'=>$stage->id,'comments'=>'','status'=>0,'approver_id'=>$stage->user_id
			]);
			if ($stage->user) {
				$stage->user->notify(new ApproveLeaveRequest($leave_request));
			}
			
		  }elseif($stage->type==2){
		  	$leave_request->leave_approvals()->create([
			    'leave_request_id' => $request->id,'stage_id'=>$stage->id,'comments'=>'','status'=>0,'approver_id'=>0
			]);
		  	if ($stage->role->manages=='dr') {
		  		if ($leave_request->user->managers) {
			  		foreach($leave_request->user->managers as $manager){
			  			$manager->notify(new ApproveLeaveRequest($leave_request));
			  		}
		  		}
		  	}elseif($stage->role->manage=='all'){
		  		foreach($stage->role->users as $user){
		  			$user->notify(new ApproveLeaveRequest($leave_request));
		  		}
		  	}elseif($stage->role->manage=='none'){
		  		foreach($stage->role->users as $user){
		  			$user->notify(new ApproveLeaveRequest($leave_request));
		  		}
		  	}
		  }elseif ($stage->type==3) {
		  	if ($stage->group) {
		  		foreach($stage->group->users as $user){
		  		$user->notify(new ApproveLeaveRequest($leave_request));
		  		}
		  	}
		  	
		  }
		
		if ($request->file('absence_doc')) {
                    $path = $request->file('absence_doc')->store('public');
                    if (Str::contains($path, 'public/')) {
                       $filepath= Str::replaceFirst('public/', '', $path);
                    } else {
                        $filepath= $path;
                    }
                    $leave_request->absence_doc = $filepath;
                    $leave_request->save();
                }
   	
        
        return 'success';
	}
	public function updateRequest(Request $request)
	{
		$leave_workflow_id=Setting::where('name','leave_workflow')->first()->value;
		$approved_leave_request_exist=LeaveRequest::find($request->leave_request_id)->approvals()->where(function ($query) {
                $query->where('status',1);
                     
            })
            ->get();
            if (!$approved_leave_request_exist) {
            	$request=LeaveRequest::find($request->leave_request_id)->update(['leave_id'=>$request->leave_id,'user_id'=>$request->user_id,'start_date'=>date('Y-m-d',strtotime($request->start_date)),'end_date'=>date('Y-m-d',strtotime($request->end_date)),'reason'=>$request->reason,'workflow_id'=>$leave_work,'status'=>$request->status]);
            }
		
		
   
        
        return 'success';
	}

	public function deleteRequest(Request $request)
	  {
	   $lr=LeaveRequest::find($request->leave_request_id);
	   if ($lr) {
	    
	     $lr->delete();
	      return 'success';
	   }
	  }

	  public function showApproval(Request $request)
	  {
	  	$leave_request=LeaveRequest::find($request->leave_request_id);

       return view('leave.approval',['leave_request'=>$leave_request]);
	  }

	  public function approvals(Request $request)
	  {
	  	$user=Auth::user();
	  	
			 $user_approvals=$this->userApprovals($user);
			   $dr_approvals=$this->getDRLeaveApprovals($user);
			   $role_approvals=$this->roleApprovals($user);
			   $group_approvals=$this->groupApprovals($user);
			
			 return view('leave.approvals',compact('user_approvals','role_approvals','group_approvals','dr_approvals'));
	  }

	  public function userApprovals(User $user)
	  {
	  	return $las = LeaveApproval::whereHas('stage.user',function($query) use($user){
				$query->where('users.id',$user->id);

			})

			 ->where('status',0)->orderBy('id','desc')->get();

	  }
	   public function getDRLeaveApprovals(User $user)
	  {
	  	return Auth::user()->getDRLeaveApprovals();
	  // 	return $las = LeaveApproval::whereHas('stage.role.users',function($query) use($user){
			// 	$query->where('users.id',$user->id);
			// })

			//  ->where('status',0)->orderBy('id','desc')->get();

	  }
	  public function roleApprovals(User $user)
	  {
	  	return $las = LeaveApproval::whereHas('stage.role',function($query) use($user){
	  		$query->where('manages','!=','dr')
				->where('roles.id',$user->role_id);
			})->where('status',0)->orderBy('id','desc')->get();
	  }
	   public function groupApprovals(User $user)
	  {
	  	return $las = LeaveApproval::whereHas('stage.group.users',function($query) use($user){
				$query->where('users.id',$user->id);
			})

			 ->where('status',0)->orderBy('id','desc')->get();

	  }

	  public function saveApproval(Request $request)
    {
      $leave_approval=LeaveApproval::find($request->leave_approval_id);
      $leave_approval->comments=$request->comment;
      if ($request->approval==1) {
          $leave_approval->status=1;
          $leave_approval->approver_id=Auth::user()->id;
          $leave_approval->save();
          // $logmsg=$leave_approval->document->filename.' was approved in the '.$leave_approval->stage->name.' in the '.$leave_approval->stage->workflow->name;
          // $this->saveLog('info','App\Review',$leave_approval->id,'leave_approvals',$logmsg,Auth::user()->id);
             $newposition=$leave_approval->stage->position+1;
      $nextstage=Stage::where(['workflow_id'=>$leave_approval->stage->workflow->id,'position'=>$newposition])->first();
      // return $review->stage->position+1;
      // return $nextstage;

      if ($nextstage) {

        $newleave_approval=new LeaveApproval();
        $newleave_approval->stage_id=$nextstage->id;
        $newleave_approval->leave_request_id=$leave_approval->leave_request->id;
        $newleave_approval->status=0;
        $newleave_approval->save();
        // $logmsg='New review process started for '.$newleave_approval->document->filename.' in the '.$newleave_approval->stage->workflow->name;
        // $this->saveLog('info','App\Review',$leave_approval->id,'reviews',$logmsg,Auth::user()->id);
        if($nextstage->type==1){
		  	
			$nextstage->user->notify(new ApproveLeaveRequest($leave_approval->leave_request));
		  }elseif($nextstage->type==2){
		  	if ($nextstage->role->manages=='dr') {
		  		foreach($leave_approval->leave_request->user->managers as $manager){
		  			$manager->notify(new ApproveLeaveRequest($leave_approval->leave_request));
		  		}
		  	}elseif($nextstage->role->manage=='all'){
		  		foreach($nextstage->role->users as $user){
		  			$user->notify(new ApproveLeaveRequest($leave_approval->leave_request));
		  		}
		  	}elseif($nextstage->role->manage=='none'){
		  		foreach($nextstage->role->users as $user){
		  			$user->notify(new ApproveLeaveRequest($leave_approval->leave_request));
		  		}
		  	}
		  }elseif ($nextstage->type==3) {
		  	foreach($nextstage->group->users as $user){
		  		$user->notify(new ApproveLeaveRequest($leave_approval->leave_request));
		  	}
		  }
        
        $leave_approval->leave_request->user->notify(new LeaveRequestPassedStage($leave_approval,$leave_approval->stage,$newleave_approval->stage));
      }else{
        $leave_approval->leave_request->status=1;
        $leave_approval->leave_request->save();

        $leave_approval->stage->user->notify(new LeaveRequestApproved($leave_approval->stage,$leave_approval));
      }


      }elseif($request->approval==2){
          $leave_approval->status=2;
           $leave_approval->comments=$request->comment;
           $leave_approval->approver_id=Auth::user()->id;
          $leave_approval->save();
          // $logmsg=$leave_approval->document->filename.' was rejected in the '.$leave_approval->stage->name.' in the '.$leave_approval->stage->workflow->name;
          // $this->saveLog('info','App\Review',$leave_approval->id,'leave_approvals',$logmsg,Auth::user()->id);
          $leave_approval->leave_request->user->notify(new LeaveRequestRejected($leave_approval->leave_request,$leave_approval->stage));
          // return redirect()->route('documents.mypendingleave_approvals')->with(['success'=>'Document Reviewed Successfully']);
      }

      return 'success';
   


      // return redirect()->route('documents.mypendingreviews')->with(['success'=>'Leave Request Approved Successfully']);
    }
    public function getDetails(Request $request)
    {
    	$leave_request=LeaveRequest::where('id',$request->leave_request_id)->get()->first();
		return view('leave.partials.leaveDetails',compact('leave_request'));
    }

}