@php
	$first=$payroll->payroll_details()->first();
	$first_details=unserialize
@endphp
<table >
	<thead>
		<tr>
			<th></th>
			<th>Employee Number</th>
			<th>Employee Name</th>
			<th>Grade</th>
			<th>Gross pay</th>
			
		</tr>
	</thead>
	<tbody>
		@php
			$sn=1;
		@endphp
		@foreach ($payroll->payroll_details as $detail)
			<tr>
				<td>{{$sn}}</td>
			<td>{{$detail->user->emp_num}}</td>
			<td>{{$detail->user->name}}</td>
			<td>{{$detail->user->promotionHistories()->latest()->first()->grade->level}}</td>
			<td>{{$detail->user->promotionHistories()->latest()->first()->grade->basic_pay}}</td>
			@php
			$pdetails=unserialize($detail->details);
			// $num=count($days);
			@endphp
				<td></td>
			</tr>
			@php
				$sn++;
			@endphp
			@endforeach
		
	</tbody>
</table>