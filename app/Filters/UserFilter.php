<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserFilter
{
    public static function apply(Request $filters)
    {
        $user = (new User)->newQuery();

        // Search for a user based on their email.
        if ($filters->filled('employee')) {
          $q=$filters->input('employee');
            $user->where(function ($query) use($q) {
                $query->where('email','like' ,'%' . $q . '%')
                      ->orWhere('name','like' ,'%' . $q . '%')
                      ->orWhere('emp_num','like' ,'%' . $q . '%');
            });
        }
       // if ($filters->filled('company')&&$filters->input('company')!=0) {

       //      $user->where('company_id','=' ,$filters->input('company'));
       //  }
       //  if ($filters->filled('department')&&$filters->input('department')!=0) {
       //      $user->where('department_id','=' ,$filters->input('department'));
       //  }
       //  if ($filters->filled('branch')&&$filters->input('branch')!=0) {
       //      $user->where('branch_id','=' ,$filters->input('branch'));
       //  }
          // Search for a user based on their role.
        
          if ($filters->filled('role')&&$filters->input('role')!=0) {
            $user->where('role_id','=' ,$filters->input('role'));
          }
         
        // Search for a user based on their creation date.
       


        // Get the results and return them.
          if ($filters->filled('pagi')&&$filters->input('pagi')=='all') {
            return $user->get();
          } elseif($filters->filled('pagi')&&($filters->input('pagi')==10||$filters->input('pagi')==15||$filters->input('pagi')==25||$filters->input('pagi')==50)){
           return $user->paginate($filters->input('pagi'));
          }
          
        return $user->paginate(10);

        }


    }
