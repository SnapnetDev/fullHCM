      @if(count($pilots)>0)
      @foreach($pilots as $pilot)
      
      @php  $rating=$pilot->getObjectDetail('admin_rate',$yearquarter)  @endphp
      @php  $rating2=$pilot->getObjectDetail('lm_rate',$yearquarter)  @endphp 

      <div class="panel-group panel-group-simple m-b-0" id="exampleAccordion{{$pilot->id}}" aria-multiselectable="true" role="tablist">
        <div class="panel">
          <div class="panel-heading" id="exampleHeadingThree" role="tab">
            <a style="color: #1e88e5;" class="panel-title collapsed" data-parent="#exampleAccordion{{$pilot->id}}" data-toggle="collapse" href="#exampleCollapseThree{{$pilot->id}}" aria-controls="exampleCollapseThree{{$pilot->id}}" aria-expanded="false">
             <b> {{$pilot->commitment}} </b>
           </a>
         </div>
         <div class="panel-collapse collapse" id="exampleCollapseThree{{$pilot->id}}" aria-labelledby="exampleHeadingThree" role="tabpanel" aria-expanded="false">
          <div class="panel-body">
           <div class="col-md-12 col-xs-12">
            <h4 style="color: #ccc;">Objective(s)</h4>
            <p>
              {{$pilot->objective}}
            </p>
          </div>
          <!-- PANEL BODY -->
          <table class="table table-striped"> 
            
            <tr>
             <td>HR Rating</td>
             <td id="hrrating">{{$rating}}</td>
             <td >@if(round($rating)==0 && $employee->performanceseason()==1 && in_array(Auth::user()->role,[3]))<div class="hrrating"></div> @endif</td>
           </tr>

           <tr>
             <td>HR Comment</td>
             <td>{{$pilot->getObjectDetail('admin_comment',$yearquarter)}}</td>
             <td>@if(round($rating)==0 && $employee->performanceseason()==1 && in_array(Auth::user()->role,[3]))
              <button class="btn btn-sm btn-primary" onclick="comment({{$pilot->id}},{{$employee->id}})">Comment</button>
              @endif <td>
              </tr>

              <tr>
               <td>Line Manager's Rating</td>
               <td id="lmrating">{{$pilot->getObjectDetail('lm_rate',$yearquarter)}}</td>
               <td>@if(round($rating2)==0 && $employee->performanceseason()==1 && in_array(Auth::user()->role,[2])) <div class="lmrating"></div> @endif  <td>
               </tr>

               <tr>
                 <td>Line Manager's Comment</td>
                 <td>{{$pilot->getObjectDetail('lm_comment',$yearquarter)}}</td>
                 <td>
                  @if(round($rating2)==0 && $employee->performanceseason()==1 && in_array(Auth::user()->role,[2]))
                  <button onclick="comment({{$pilot->id}},{{$employee->id}})" class="btn btn-sm btn-primary">Comment</button>
                  @endif
                  <td>
                  </tr>
                  
                  <tr>
                   <td>Employee Comment</td>
                   <td>{{$pilot->getObjectDetail('emp_comment',$yearquarter)}}</td>
                   <td> 
                @if(round($rating2)==0 && $employee->performanceseason()==1 && in_array(Auth::user()->role,[1]))
                  <button onclick="comment({{$pilot->id}},{{$employee->id}},1)" class="btn btn-sm btn-primary">Comment</button>
                  @endif
                    <td>
                   </tr>
                   
                 </table>
                 <!-- PANEL BODY -->
               </div>
             </div>
           </div>
         </div>
         <hr>
         @endforeach
         @endif