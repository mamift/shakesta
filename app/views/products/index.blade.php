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
				<th>Title</th>
				<th>Description</th>
				<th>R.ID</th>
				<th>Retail Price</th>
				<th>Image</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
	@if (count($products) > 0)
    @foreach($products as $product)
			<tr>
				<td>{{ $product->product_id }}</td>
				<td><a href="{{ URL::route('products.show', $product->product_id) }}">{{ $product->title }}</a></td>
				<td>{{ $product->description }} </td>
				<td>{{ $product->retail_id }}</td>
				<td>{{ $product->retail_price }}</td>
				<td>{{{ $product->image or 'None' }}}</td>
				<td><a href="{{ URL::route('products.edit', $product->product_id) }}">Edit</a></td>
				<td>
					{{ Form::open(['route' => ['products.destroy', $product->product_id], 'onSubmit' => 'return confirm_delete();']) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete') }}
					{{ Form::close() }}
				</td>
			</tr>
    @endforeach
    @else
    	<tr>
    		<td colspan="8" style="text-align: center;">No products here!</td>
    	</tr>
    @endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="8"><a href="{{ URL::route('products.create') }}">Create a new product</a></td>
			</tr>
		</tfoot>
	</table>
@stop