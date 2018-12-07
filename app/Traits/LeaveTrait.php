<?php
namespace App\Traits;
use App\Notifications\ApproveLeaveRequest;
use App\Notifications\LeaveRequestApproved;
use App\Notifications\LeaveRequestPassedStage;
use App\Notifications\LeaveRequestRejected;
use App\Leave;
use App\LeaveRequest;
use App\LeaveApproval;
use App\Holiday;
use App\Setting;
use App\Workflow;
use App\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
		return $this->viewRequest($request);
		break;
		case 'delete_request':
		return $this->deleteRequest($request);
		break;
		case 'show_approval':
		return $this->showApproval($request);
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

	public function myRequests(Request $request)
	{
		$leavebank=Auth::user()->promotionHistories()->latest()->first()->grade->leave_length;
		$leave_includes_weekend=Setting::where('name','leave_includes_weekend')->first()->value;
		$leave_includes_holiday=Setting::where('name','leave_includes_holiday')->first()->value;
		$holidays=Holiday::whereYear('date',date('Y-m-d'))->get();
		$pending_leave_requests=Auth::user()->leave_requests()->where('status',0)->whereYear('start_date', date('Y'))->get();
		$leave_requests=Auth::user()->leave_requests()->whereYear('start_date', date('Y'))->get();
		
		$leaves=Leave::all();
		
		
		$used_leaves=Auth::user()->leave_requests()->where('status',1)->whereYear('start_date', date('Y'))->get();
		if ($used_leaves) {
			$used_days=0;
			foreach ($used_leaves as $used_leave) {
				$datediff = $used_leave->start_date - $usd_leave->end_date;
				$used_days+= round($datediff / (60 * 60 * 24));
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
					$used_days=$used_days - $holidays;

				}
			}
			$leavebank=$leavebank-$used_days;
		}
		
		// return ['leavebank'=>$leavebank,'holidays'=>$hols];
		return view('leave.myrequests',compact('leavebank','holidays','leave_requests','pending_leave_requests','leaves'));
	}
	public function saveRequest(Request $request)
	{
		$leave_workflow_id=Setting::where('name','leave_workflow')->first()->value;
		$leave_request=LeaveRequest::create(['leave_id'=>$request->leave_id,'user_id'=>Auth::user()->id,'start_date'=>date('Y-m-d',strtotime($request->start_date)),'end_date'=>date('Y-m-d',strtotime($request->end_date)),'reason'=>$request->reason,'workflow_id'=>$leave_workflow_id,'paystatus'=>$request->paystatus,'status'=>0,'priority'=>$request->priority]);
		  $stage=Workflow::find($leave_request->workflow_id)->stages->first();
		  if($stage->type==1){
		  	$leave_request->leave_approvals()->create([
			    'leave_request_id' => $request->id,'stage_id'=>$stage->id,'comments'=>'','status'=>0,'approver_id'=>$stage->user_id
			]);
			$stage->user->notify(new ApproveLeaveRequest($leave_request));
		  }elseif($stage->type==2){
		  	if ($stage->role->manages=='dr') {
		  		foreach($leave_request->user->managers as $manager){
		  			$manager->notify(new ApproveLeaveRequest($leave_request));
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
		  	foreach($stage->group->users as $user){
		  		$user->notify(new ApproveLeaveRequest($leave_request));
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
      // return view('documents.review',['document'=>$document]);
	  }

	  public function approvals()
	  {
	  	$user=Auth::user();
	  	$leave_approvals = (new LeaveApproval)->newQuery();

			$leave_approvals->whereHas('stage.user',function($query) use($user){
				$query->where('users.id',$user->id);

			});
			$leave_approvals->whereHas('stage.role.users',function($query) use($user){
				$query->where('users.id',$user->id);
			});
			$leave_approvals->whereHas('stage.group.users',function($query) use($user){
				$query->where('users.id',$user->id);
			});

			$leave_approvals->where('status',0)->get();
	  }

	  public function saveApproval(Request $request)
    {
      $leave_approval=LeaveApproval::find($leave_approval_id);
      $leave_approval->comment=$request->comment;
      if ($request->action=="approve") {
          $leave_approval->status=1;
          $leave_approval->save();
          // $logmsg=$leave_approval->document->filename.' was approved in the '.$leave_approval->stage->name.' in the '.$leave_approval->stage->workflow->name;
          // $this->saveLog('info','App\Review',$leave_approval->id,'leave_approvals',$logmsg,Auth::user()->id);
      }elseif($request->action=="reject"){
          $leave_approval->status=2;
          $leave_approval->save();
          // $logmsg=$leave_approval->document->filename.' was rejected in the '.$leave_approval->stage->name.' in the '.$leave_approval->stage->workflow->name;
          // $this->saveLog('info','App\Review',$leave_approval->id,'leave_approvals',$logmsg,Auth::user()->id);
          $leave_approval->document->user->notify(new LeaveRequestRejected($leave_approval->leave_request,$leave_approval->stage));
          // return redirect()->route('documents.mypendingleave_approvals')->with(['success'=>'Document Reviewed Successfully']);
      }

      //create new review if another stage exist
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
        $logmsg='New review process started for '.$newleave_approval->document->filename.' in the '.$newleave_approval->stage->workflow->name;
        $this->saveLog('info','App\Review',$leave_approval->id,'reviews',$logmsg,Auth::user()->id);
        $newleave_approval->stage->user->notify(new ApproveLeaveRequest($leave_approval->leave_request));
        $approval_request->document->user->notify(new LeaveRequestPassedStage($leave_approval,$leave_approval->stage,$newleave_approval->stage));
      }else{
        $leave_approval->leave_request->status=1;
        $leave_approval->leave_request->save();
        $leave_approval->stage->user->notify(new LeaveRequestApproved($leave_approval->stage,$leave_approval));
      }


      // return redirect()->route('documents.mypendingreviews')->with(['success'=>'Leave Request Approved Successfully']);
    }

}