@extends('layout')

@section('content')
	<script type="text/javascript">
		function confirm_delete() {
			return confirm("Are you sure about deleting this?");
		}
	</script>
	<h1>Current Deals listed for {{ $retailer = User::find(Auth::user()->user_id)->retailer->title; }}</h1>
	<table>
		<thead>	
			<tr>
				<td colspan="9"><a href="{{ URL::route('deals.create') }}">Create a new deal</a></td>
			</tr>
			<tr>
				<!-- <th>ID</th> -->
				<th>Product</th>
				<th>Price + Discount</th>
				<th>Terms</th>
				<th>Begins</th>
				<th>Expires</th>
				<th>Ends in</th>
				<th>Category</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
	@if (count($deals) > 0)
    @foreach($deals as $deal)
			<tr>
				<!-- <td><a href="{{ URL::route('deals.show', $deal->id) }}">{{ $deal->id }}</a></td> -->
				<td>
					<a href="{{ URL::route('products.show', $deal->product_id) }}">
						{{ $deal->product_id . ": " . $deal->product_title }}
					</a>
				</td>
				<td>
					Original: &dollar;{{ $deal->original_price }} <br />
					Discount: {{ $deal->price_discount * 100 }} &percnt; <br/>
					Deal price: &dollar;{{ $deal->original_price - ($deal->original_price * $deal->price_discount) }}
				</td>
				<td>{{ $deal->terms }}</td>
				<td><a href="{{ URL::route('deals.show', $deal->id) }}">{{ $deal->begins_datetime }}</a></td>
				<td><a href="{{ URL::route('deals.show', $deal->id) }}">{{ $deal->expires_datetime }}</a></td>
				<td>{{ $deal->expiry_time }}</td>
				<td>{{ $deal->category }}</td>
				<td><a href="{{ URL::route('deals.edit', $deal->id) }}">Edit</a></td>
				<td>
					{{ Form::open(['route' => ['deals.destroy', $deal->id], 'onSubmit' => 'return confirm_delete();']) }}
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