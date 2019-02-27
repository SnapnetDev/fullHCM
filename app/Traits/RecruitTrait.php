<?php
namespace App\Traits;
use Illuminate\Http\Request;
use App\JobListing;
use App\Applicant;
use App\User;
use App\JobApplication;
use App\Company;
use App\Department;
use Auth;

trait RecruitTrait
{
	public function processGet($route,Request $request){
		switch ($route) {
			
				case 'joblistings':
				# code...
				return $this->jobListings($request);
				break;
				case 'view_job_listing':
				# code...
				return $this->viewJobListing($request);
				break;
				case 'delete_job_listing':
				# code...
				return $this->deleteJobListing($request);
				break;
				case 'change_listing_status':
				# code...
				return $this->changeJobListingStatus($request);
				break;
				case 'get_job_listing_info':
				# code...
				return $this->getJobListingInfo($request);
				break;
				case 'myjobs':
				# code...
				return $this->empJobListings($request);
				break;
				case 'jobsapplied':
				# code...
				return $this->empAppJobListings($request);
				break;
				case 'favjobs':
				# code...
				return $this->empFavJobListings($request);
				break;
				case 'emp_job_fav':
				# code...
				return $this->empJobListingFavorite($request);
				break;
				case 'emp_job_apply':
				# code...
				return $this->empJobListingApplication($request);
				break;
			default:
				return $this->index($request);
				break;
		}
		 
	}


	public function processPost(Request $request){
		try{
		switch ($request->type) {
			case 'save_listing':
				# code...
			     return $this->saveJobListing($request);
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

	public function saveJobListing(Request $request)
	{
		return $listing=JobListing::updateOrCreate(['id'=>$request->job_listing_id],['job_id'=>$request->job_id,'salary_from'=>$request->salary_from,'salary_to'=>$request->salary_to,'expires'=>date('Y-m-d',strtotime($request->expires)),'level'=>$request->level,'experience_from'=>$request->experience_from,'experience_to'=>$request->experience_to,'requirements'=>$request->requirements,'type'=>$request->jtype]);
		return 'success';

	}

	// public function jobListings(Request $request)
	// {
	// 	$listings=JobListing::all();

	// }

	public function viewJobListing(Request $request)
	{
		$joblisting=JobListing::find($request->listing_id);
		$company_id=companyId();
        $company=Company::find($company_id);
        $departments=$company->departments;
         $jobs=$company->departments()->first()->jobs;
		
				return view('recruit.view',compact('joblisting','company','departments','jobs'));

	}
	public function empViewJobListing(Request $request)
	{
		$joblisting=JobListing::find($request->listing_id);
		if ($joblisting->status==1) {
			$company_id=companyId();
        $company=Company::find($company_id);
        $departments=$company->departments;
         $jobs=$company->departments()->first()->jobs;
		
				return view('recruit.user_view',compact('joblisting','company','departments','jobs'));
		}else{
			return redirect()->back()->with('This job cannot be viewed as it has been unlisted');
		}
		

	}
	 public function empJobListings()
    {
        $company_id=companyId();
        $company=Company::find($company_id);
        $departments=$company->departments;
         $jobs=$company->departments()->first()->jobs;
         $joblistings=JobListing::where(['status'=>1])->get();

        return view('recruit.user_listing',compact('company','departments','jobs','joblistings'));
    }
     public function empFavJobListings()
    {
        $company_id=companyId();
        $company=Company::find($company_id);
        $departments=$company->departments;
         $jobs=$company->departments()->first()->jobs;
          $joblistings=JobListing::where(['status'=>1])->get();

        return view('recruit.user_fav_listing',compact('company','departments','jobs','joblistings'));
    }
     public function empAppJobListings()
    {
        $company_id=companyId();
        $company=Company::find($company_id);
        $departments=$company->departments;
         $jobs=$company->departments()->first()->jobs;
         $joblistings=JobListing::where(['status'=>1])->get();

        return view('recruit.user_application_listing',compact('company','departments','jobs','joblistings'));
    }
	
	public function getJobListingInfo(Request $request)
	{
		return $joblisting=JobListing::find($request->listing_id);


	}
	public function deleteJobListing(Request $request)
	{
		$listing=JobListing::find($request->listing_id);
	   if ($listing) {
	     $listing->delete();
	      return 'success';
	   }
	}
	public function changeJobListingStatus(Request $request)
	  {
	   $listing=JobListing::find($request->listing_id);
	   if ($listing->status==1) {
	     $listing->update(['status'=>0]);
	      return 2;
	   }elseif($listing->status==0){
	    $listing->update(['status'=>1]);
	    return 1;
	   }
	 }

	 public function empJobListingApplication(Request $request)
	  {
	    $listing=JobListing::find($request->listing_id);
	   $user=Auth::user();
	   if ($user->applications->contains('job_listing_id', $listing->id)) {
	   	$user->applications()->where('job_listing_id', $listing->id)->first()->delete();
	   	return 2;
	   }else{
	   	$user->applications()->create(['job_listing_id'=>$listing->id]);
	   return 1;
	   }
	  
	 }
	 public function empJobListingFavorite(Request $request)
	  {
	   $listing=JobListing::find($request->listing_id);
	   $user=Auth::user();
	   if ($user->favorites->contains('job_listing_id', $listing->id)) {
	   	$user->favorites()->where('job_listing_id', $listing->id)->first()->delete();
	   	return 2;
	   }else{
	   	$user->favorites()->create(['job_listing_id'=>$listing->id]);
	   return 1;
	   }
	   
	 }
}