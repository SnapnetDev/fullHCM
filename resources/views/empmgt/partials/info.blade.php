<header class="slidePanel-header overlay" style="background-image: url('{{asset('global/photos/placeholder.png')}}')">
  <div class="overlay-panel overlay-background vertical-align">
    <div class="slidePanel-actions">
      <div class="btn-group btn-group-flat">
        <button type="button" class="btn btn-pure btn-inverse icon md-folder" aria-hidden="true"></button>
        <button type="button" class="btn btn-pure btn-inverse icon md-delete" aria-hidden="true"></button>
        <button type="button" class="btn btn-pure btn-inverse slidePanel-close icon md-close"
          aria-hidden="true"></button>
      </div>
    </div>
    <div class="vertical-align-middle">
      <a class="avatar" href="javascript:void(0)">
        <img src="{{ $user->image!=''?asset('storage/avatar'.$user->image):($user->sex=='M'?asset('global/portraits/male-user.png'):asset('global/portraits/female-user.png'))}}" alt="...">
      </a>
      <h3 class="name">{{$user->name}}</h3>
      <h4 class="name">({{$user->role->name}})</h4>
      <div class="tags">
        <a type="button" target="_blank" href="{{ url('user_attendance/'.$user->id) }}" class="btn btn-inverse"><i class="icon fa fa-calendar"></i>Attendance</a>
        <a type="button" target="_blank" href="{{ url('performances/employee?id='.$user->id) }}"  class="btn btn-inverse"><i class="icon fa fa-bar-chart"></i>Performance</a>
        <a type="button" target="_blank" class="btn btn-inverse" href="{{ url('user_shift_schedules/'.$user->id) }}"><i class="icon fa fa-calendar-o"></i>Shift Schedule</a>
      </div>
    </div>
    <a href="{{ route('users.edit',['id'=>$user->id]) }}"  class="edit btn btn-success btn-floating" >
      <i class="icon md-eye animation-scale-up" aria-hidden="true"></i>
    </a>
  </div>
</header>
<div class="slidePanel-inner">
  <table class="user-info">
    <tbody>
      <tr>
        <td class="info-label">Gender:</td>
        <td>
          <span> {{$user->sex=='M'?'Male':($user->sex=='F'?'Female':'')}}</span>
          <div class="form-group form-material floating">
            <input type="email" class="form-control empty" name="inputFloatingEmail" value="mazhesee@gmail.com">
          </div>
        </td>
       </tr>
        <tr>
        <td class="info-label">Email:</td>
        <td>
          <span>{{$user->email}}</span>
          <div class="form-group form-material floating">
            <input type="email" class="form-control empty" name="inputFloatingEmail" value="mazhesee@gmail.com">
          </div>
        </td>
      </tr>
      <tr>
        <td class="info-label">Phone:</td>
        <td>
          <span>{{$user->phone}}</span>
          <div class="form-group form-material floating">
            <input type="text" class="form-control empty" name="inputFloatingPhone" value="{{$user->phone}}">
          </div>
        </td>
      </tr>
      <tr>
        <td class="info-label">Address:</td>
        <td>
          <span>{{$user->address}}</span>
          <div class="form-group form-material floating">
            <input type="text" class="form-control empty" name="inputFloatingAddress" value="Fuzhou">
          </div>
        </td>
      </tr>
      <tr>
        <td class="info-label">Position:</td>
        <td>
          <span> @if(count($user->jobs)>0)
              {{$user->jobs()->latest()->first()->title}}
              @endif</span>
          <div class="form-group form-material floating">
            <input type="text" class="form-control empty" name="inputFloatingBirthday" value="1990/2/15">
          </div>
        </td>
      </tr>
      <tr>
        <td class="info-label">With Us Since:</td>
        <td>
          <span>{{\Carbon\Carbon::parse($user->hiredate)->diffForHumans()}}</span>
          <div class="form-group form-material floating">
            <input type="text" class="form-control empty" name="inputFloatingURL" value="http://amazingSurge.com">
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>