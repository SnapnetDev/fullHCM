<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Traits\Micellenous;
use App\User;

trait Performance {
	use Micellenous;

	public function processGet($route,Request $request){
		switch ($route) {
			case 'employee':
				# code...
				return $this->employee($request);
				break;
				case 'list':
				# code...
				return $this->index($request);
				break;
			case 'toggleSeason':
				# code...
				return $this->toggleSeason($request);
				break;
			default:
				return $this->index($request);
				break;
		}
		 
	}


	public function processPost(Request $request){
		try{
		switch ($request->type) {
			case 'saveComment':
				# code...
			     return $this->saveComment($request);
				break;
			case 'addStretch':
				# code...
				return $this->addStretch($request);
				break;
			case 'addProgressReport':
				# code...
				return $this->addProgressReport($request);
				break;
			case 'saveReportComment':
				# code...
				return $this->saveReportComment($request);
				break;
			case 'addKpi':
				# code...
				return $this->addKpi($request);
				break;
			default:
				# code...
				break;
		}
	}
	catch(\Exception $ex){

		return response()->json(['status'=>'error','message'=>$ex->getMessage()]);
	}

	}
	

	private function addKpi(Request $request){

			 $kpi=\App\kpi::updateOrCreate(['id'=>$request->formid],
			 	[
			 	 'deliverable'=>$request->deliverables,
			 	 'targetweight'=>$request->targetamount,
			 	 'targetamount'=>$request->targetweight,
			 	 'status'=>0,
			 	 'from'=>date('Y-m-d',strtotime($request->from)),
			 	 'to'=>date('Y-m-d',strtotime($request->to)),
			 	 'comment'=>$request->comment,
			 	 'created_by'=>$request->user()->id,
			 	 'created_at'=>date('Y-m-d H:i:s'),
			 	 'assigned_to'=>$request->assigned_to
			 	]);

			 return response()->json(['status'=>'success','message'=>'Operation Successfull']);

	}

	private function saveReportComment(Request $request){

			$lmrepcomment=\App\progressreport::where('id',$request->reportid)->update(['reportcomment'=>$request->comment]);
		//Notify Employee that he has been commented
			return response()->json(['status'=>'success','message'=>'Operation Successfull']);
	}

    private function toggleSeason(Request $request){
    	if($request->user()->performanceseason()==1){
    		$performance=0;
    		$msg='Stopped';
    	}
    	else{
    		$performance=1;
    		$msg="Started";
    	}
    	$toggle=\App\PerformanceSeason::where('id',1)->update(['season'=>$performance]);
    	//Notify All Stackholders
    	return response()->json(['status'=>'success','message'=>"Performance Season $msg"]);

    }
 private function convdate($date){

 		return date('Y-m-d',strtotime($date));

 }

    private function addProgressReport(Request $request){

      $savereport=\App\progressreport::create([
      			'report'=>$request->progressreport,
      			'from'=>self::convdate($request->reportfroms),
      			'to'=>self::convdate($request->reporttos),
      			'achievedamount'=>$request->achievedamount,
      			'reportcomment'=>$request->commentrep,
      			'status'=>$request->status,
      			'emp_id'=>$request->emp_id,
      			'kpiid'=>$request->kpiid
      		]);
      //send notification
     return response()->json(['status'=>'success','message'=>'Report successfully added']);
    }

	private function saveComment(Request $request){
		// session(['FY'=>date('Y')]);
		 $data=['goal_id'=>$request->goalid,'emp_id'=>$request->empid,'quarter'=>$request->quarter];
		 $rate= $request->has('rating') ? $request->rating : 0;
		 if($request->user()->id==$request->empid){
		 	$rateColumn='lm_rate';
		 	$comment='emp_comment';
		 }
		 else{
		 	$rateColumn=$this->resolveRate();
		 	$comment=$this->resolveCommentRow();
		 }
 		 $data2=[$rateColumn=>$rate,$comment=>$request->comment];

		$updateRatingComment=\App\Rating::where($data)->whereYear('created_at',session('FY'))->update($data2);
		 $data=array_merge($data,$data2);
		if(!$updateRatingComment){
			$createRating=\App\Rating::create($data);
		}
		// dd($data)
		return response()->json(['status'=>'success','message'=>'Comment Successfully Added']);
	}

	private function addStretch(Request $request){
		$goalCatid=$request->has('goalType') ? $request->goalType : 1;

			$data=['objective'=>$request->objective,
					 'commitment'=>$request->commitment, 
					 'user_id'=>$request->user()->id,
					 'assigned_to'=>$request->emp_id,
					  'goal_cat_id'=>$goalCatid,
					  'quarter'=>$this->predictQuarter()
					];
		
			$saveStrech=\App\Goal::updateOrcreate(['id'=>$request->id],$data);
		return response()->json(['status'=>'success','message'=>'Strech Goal Successfully Applied']);


	}

	private function predictQuarter(){
		$getQuarter=\Auth::user()->getquarter();
		return 1;
	}




	private function resolveRate(){
		switch (\Auth::user()->role) {
			case 3:
				# code...
				return 'admin_rate';
				break;
			case 2:
				# code...
				return 'lm_rate';
				break;

			default:
				# code...
				break;
		}
	}
	private function resolveCommentRow(){
			switch (\Auth::user()->role) {
			case 3:
				# code...
				return 'admin_comment';
				break;
			case 2:
				# code...
				return 'lm_comment';
				break;

			default:
				# code...
				return 'emp_comment';
				break;
		}
	
	}
	private function  employee(Request $request){

		$employee=\App\User::where('id',$request->id)->first();
    	$fiscal= $this->fiscalYear(); 
    	$pilots= $this->pilotGoals();
    	$quarter=$request->has('quarter') ? $request->quarter: 1;
    	$date=$request->has('date') ? $request->date: date('Y');
     	$yearquarter=(object) ['quarter'=>$quarter,'year'=>$date];

     	$lmGoals= $this->goals(1,$request->id,$quarter,$date);

     	$idps= $this->goals(3,$request->id,$quarter,$date);
  	
     	$carasps= $this->goals(4,$request->id,$quarter,$date);
 	 	$kpis= $this->getkpis($request);
		return view('performance.employee',compact('employee','fiscal','lmGoals','pilots','yearquarter','carasps','idps','kpis')); 
	}


	   public function getkpis(Request $request) {
              
               $kpis=\App\kpi::whereYear('created_at',date('Y')) 
               					->where(function($query) use ($request){
               					$query->where('created_by',$request->id)
               						   ->orwhere('assigned_to',0)
               						   ->orwhereHas('kpiassignedto',function($query) use ($request){
               								$query->where('user_id',$request->id);
               					});
               		});
               					
               	if($request->has('start') || $request->has('end')){
               		$kpis=$kpis->whereRaw("DATE(created_at) BETWEEN $request->start and $request->end");
               	}
               	  $kpis=$kpis->paginate(10);
               					  

            return $kpis;
 
          }

}