@extends('layout')

@section('content')
	<script type="text/javascript">
		function confirm_delete() {
			return confirm("Are you sure about deleting this?");
		}
	</script>
	<h1>All Deals for All Products and Retailers</h1>
	<table>
		<thead>	
			<tr>
				<th>ID</th>
				<th>Product</th>
				<th>Discount</th>
				<th>Original Price</th>
				<th>Retailer</th>
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
				<td><a href="{{ URL::route('deals.show', $deal->id) }}">{{ $deal->id }}</a></td>
				<td>
					<a href="{{ URL::route('products.show', $deal->product_id) }}">
						{{ $deal->product_id . ": " . $deal->product_title }}
					</a>
				</td>
				<td>{{ $deal->price_discount * 100 }} &percnt; </td>
				<td>{{ $deal->original_price }} </td>
				<td>
					<a href="{{ URL::route('retailers.show', $deal->retailer_id) }}">
						{{ $deal->retailer_id . ": " . $deal->retailer }}
					</a>
				</td>
				<td>{{ $deal->terms }}</td>
				<td>{{ $deal->begins_datetime }}</td>
				<td>{{ $deal->expires_datetime }}</td>
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
    		<td colspan="11" style="text-align: center;">No deals here!</td>
    	</tr>
    @endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="11"><a href="{{ URL::route('deals.create') }}">Create a new deal</a></td>
			</tr>
		</tfoot>
	</table>
@stop