@php
	$pdetails=unserialize($detail->details);
	// $num=count($days);
@endphp
<h4>{{$detail->user->name}}</h4>
<div class="table-responsive">
<table class="table table-striped ">
	
	<tbody>
		<tr>
			
			<th>Basic Pay</th>
			<td style="text-align: right">&#8358;{{$detail->basic_pay}}</td>
			
		</tr>
	</tbody>
	
</table>
<h4>Allowances</h4>
<table class="table table-striped ">
	
	<tbody>
		@foreach($pdetails['allowances'] as $key=>$allowance)
		<tr>
			
			<th>{{$pdetails['component_names'][$key]}}</th>
			<td style="text-align: right">&#8358;{{round($allowance,2)}}</td>
			
		</tr>
		@endforeach
	</tbody>
	
</table>

<h4>Deductions</h4>
<table class="table table-striped ">
	
	<tbody>
		@foreach($pdetails['deductions'] as $key=>$deduction)
		<tr>
			
			<th>{{$pdetails['component_names'][$key]}}</th>
			<td style="text-align: right">-&#8358;{{$deduction}}</td>
			
		</tr>
		@endforeach
		<tr>
			<th>Income Tax</th>
			<td style="text-align: right">&#8358;{{$detail->paye}}</td>
		</tr>
	</tbody>
	
</table>
<hr>
<h4><span class="">Net Salary</span><span class="pull-right">&#8358;{{($detail->basic_pay+$detail->allowances)-($detail->deductions+$detail->paye)}}</span></h4>
</div>