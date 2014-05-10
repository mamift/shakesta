@extends('layout')

@section('content')
	<script type="text/javascript">
		function confirm_delete() {
			return confirm("Are you sure about deleting this?");
		}
	</script>
	<table>
		<thead>	
			<tr>
				<th>ID</th>
				<th>P. ID</th>
				<th>Price Discount %</th>
				<th>Terms</th>
				<th>Begins</th>
				<th>Expires</th>
				<th>Category</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
	@if (count($deals) > 0)
    @foreach($deals as $deal)
			<tr>
				<td>{{ $deal->deal_id }}</td>
				<td>{{ $deal->product_id }}</td>
				<td>{{ $deal->price_discount }} </td>
				<td>{{ $deal->terms }}</td>
				<td>{{ $deal->begins_time }}</td>
				<td>{{ $deal->expires_time }}</td>
				<td>{{ $deal->category }}</td>
				<td><a href="{{ URL::route('deals.edit', $deal->deal_id) }}">Edit</a></td>
				<td>
					{{ Form::open(['route' => ['deals.destroy', $deal->deal_id], 'onSubmit' => 'return confirm_delete();']) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete') }}
					{{ Form::close() }}
				</td>
			</tr>
    @endforeach
    @else
    	<tr>
    		<td colspan="9" style="text-align: center;">No deals here!</td>
    	</tr>
    @endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="9"><a href="{{ URL::route('deals.create') }}">Create a new deal</a></td>
			</tr>
		</tfoot>
	</table>
@stop