@extends('layouts.master')
@section('stylesheets')
  <link href="{{ asset('global/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
      <link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
      <link href="{{ asset('global/vendor/select2/select2.min.css') }}" rel="stylesheet" />
      <link rel="stylesheet" href="{{ asset('assets/examples/css/pages/user.css') }}">
  

@endsection
@section('content')
 <div class="page">
  <div class="page-header">
      <h1 class="page-title">Employees Directory</h1>
      <div class="page-header-actions">
    <div class="row no-space w-250 hidden-sm-down">

      <div class="col-sm-6 col-xs-12">
        <div class="counter">
          <span class="counter-number font-weight-medium">{{date("M j, Y")}}</span>

        </div>
      </div>
      <div class="col-sm-6 col-xs-12">
        <div class="counter">
          <span class="counter-number font-weight-medium" id="time">{{date('h:i s a')}}</span>

        </div>
      </div>
    </div>
  </div>
    </div>
    <div class="page-content">
      <!-- Panel -->
      <div class="panel">
        <div class="panel-body">
          <form class="page-search-form" role="search">
            <div class="input-search input-search-dark">
              <i class="input-search-icon md-search" aria-hidden="true"></i>
              <input type="text" class="form-control" id="inputSearch" name="search" placeholder="Search Employees">
              <button type="button" class="input-search-close icon md-close" aria-label="Close"></button>
            </div>
          </form>
          <div class="nav-tabs-horizontal nav-tabs-animate" data-plugin="tabs">
            
          
           
                <ul class="list-group">
                  @foreach($users as $user)
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-away">
                          <img src="{{ file_exists(public_path('uploads/avatar'.$user->image))?asset('uploads/avatar'.$user->image):($user->sex=='M'?asset('global/portraits/male-user.png'):asset('global/portraits/female-user.png'))}}" alt="...">
                          
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          {{$user->name}}
                         
                        </h4>
                        <p>
                          <i class="icon icon-color md-phone" aria-hidden="true" title="phone"></i>                        {{$user->phone}}
                        </p>
                        <p>
                          <i class="icon icon-color md-email" aria-hidden="true" title="email address"></i>                          {{$user->email}}
                        </p>
                        <p>
                          <i class="icon icon-color md-case" aria-hidden="true" title="job title"></i>                          {{$user->job->title}}
                        </p>
                        <p>
                          <i class="icon icon-color md-badge-check" aria-hidden="true" title="grade"></i>                         {{$user->grade->level}}
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)" title="Message on Skype for business">
                            <i class="icon icon-color md-skype" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)" title="Send an Email">
                            <i class="icon icon-color md-email" aria-hidden="true"></i>
                          </a>
                          
                        </div>
                      </div>
                      
                    </div>
                  </li>
                  <hr>
                  @endforeach
                </ul>
                <nav>
                  <ul data-plugin="paginator" data-total="50" data-skin="pagination-no-border"></ul>
                </nav>
              
          </div>
        </div>
      </div>
      <!-- End Panel -->
    </div>
  </div>

@section('scripts')

<script src="{{asset('global/vendor/select2/select2.min.js')}}"></script>
<script src="{{asset('global/vendor/bootstrap-table/bootstrap-table.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('global/vendor/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
  <script type="text/javascript">
  $(document).ready(function() {
   
} );
  </script>
@endsection