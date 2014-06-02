@extends('layout')

@section('content')
	<script type="text/javascript">
		function confirm_delete() {
			return confirm("Are you sure about deleting this?");
		}
	</script>
	@if (Auth::user()->user_type == 'retailer')
	<h1>Current products for {{ Auth::user()->retailer->title }}</h1>
	@else
	<h1>All Products</h1>
	@endif

	@if (Session::get('delete_error'))
	<p class="error">
		{{ Session::get('delete_error') }} <br/>
		Delete all associated deals, then try deleting this product.
	</p>
	@endif
	
	<table class="table table-bordered table-hover table-striped table-condensed">
		<thead>	
			<tr>
				<td colspan="7"><a href="{{ URL::route('products.create') }}">Create a new product</a></td>
			</tr>
			<tr>
				<!-- <th>ID</th> -->
				<th>Title</th>
				<th>Description</th>
				<th>Retailer</th>
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
				<!-- <td>{{ $product->product_id }}</td> -->
				<td><a href="{{ URL::route('products.show', $product->product_id) }}">{{ $product->title }}</a></td>
				<td>{{ $product->description }} </td>
				<td>{{ $product->retailer->title }}</td>
				<td>&dollar;{{ $product->retail_price }}</td>
				<td>
					@if ($product->image_url) Yes @else None set  @endif</td>
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
    		<td colspan="7" style="text-align: center;">No products here!</td>
    	</tr>
    @endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="7"><a href="{{ URL::route('products.create') }}">Create a new product</a></td>
			</tr>
		</tfoot>
	</table>
@stop