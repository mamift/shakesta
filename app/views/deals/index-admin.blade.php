@extends('layout')

@section('content')
	<script type="text/javascript">
		function confirm_delete() {
			return confirm("Are you sure about deleting this?");
		}
	</script>
	<h1>All Deals</h1>
	<table class="table table-bordered table-hover table-striped table-condensed" id="index-of-deals-table">
		<thead>	
			<tr>
				<td colspan="11"><a href="{{ URL::route('deals.create') }}">Create a new deal</a></td>
			</tr>
			<tr>
				<!-- <th>ID</th> -->
				<th>Product</th>
				<th>Discount</th>
				<th>Original Price</th>
				<th>Retailer</th>
				<th>Terms</th>
				<th>Begins</th>
				<th>Expires</th>
				<th>Ends in</th>
				<th>Category</a></th>
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
				<td>{{ $deal->price_discount * 100 }} &percnt; </td>
				<td>{{ $deal->original_price }} </td>
				<td>
					<a href="{{ URL::route('retailers.show', $deal->retailer_id) }}">
						{{ $deal->retailer_id . ": " . $deal->retailer }}
					</a>
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
						{{ Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) }}
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

	<h1>Deals Categories</h1>
	<form id="new-category-form">

	</form>

	<table class="table table-bordered table-hover table-striped table-condensed">
		<thead>	
			<tr>
				<td colspan="3"><a href="" class="btn btn-primary">Create a new Category</a></td>
			</tr>
			<tr>
				<td>Name</td>
				<td>Edit</td>
				<td>Delete</td>
			</tr>
		</thead>
		<tbody>
			@if (count($categories) > 0)
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			@else
			<tr>
				<td colspan="3">No categories set</td>
			</tr>
			@endif

			<tr id="new-category-form-row">
				<td colspan="3">
					{{ Form::open(['url' => '/api/v1.2/categories/apikey=' . Auth::user()->apikey . '/create', 'method' => 'POST', 'role' => 'form', 'class' => 'form-inline']) }}
						{{ Form::label('name', 'Category Name') }}
						{{ Form::text('name', '', ['class' => 'form-control']) }}
						{{ Form::submit('Create', ['class' => 'btn btn-primary']) }}
					{{ Form::close() }}
				</td>
			</tr>

			<tr id="edit-category-form-row">
				<td colspan="3">
					{{ Form::open(['url' => '/api/v1.2/categories/apikey=' . Auth::user()->apikey . '/update', 'method' => 'POST', 'role' => 'form', 'class' => 'form-inline']) }}
						<div class="form-group">
							{{ Form::label('cat_to_update', 'Category to update') }}
							{{ Form::select('cat_to_update', $categories, 0, ['class' => 'form-control']) }}
						</div>
						<p></p>
						<div class="form-group">
							{{ Form::label('updated_cat_name', 'New category name') }}
							{{ Form::text('updated_cat_name', '',['class' => 'form-control']) }}
							{{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
						</div>
					{{ Form::close() }}
				</td>
			</tr>

			<tr id="delete-category-form-row">
				<td colspan="3">
					{{ Form::open(['url' => '/api/v1.2/categories/apikey=' . Auth::user()->apikey . '/destroy', 'method' => 'POST', 'role' => 'form', 'class' => 'form-inline']) }}
						{{ Form::label('cat_to_delete', 'Category to delete') }}
						{{ Form::select('cat_to_delete', $categories, null, ['class' => 'form-control']) }}
						{{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
					{{ Form::close() }}
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3"><a href="" class="btn btn-primary">Create a new Category</a></td>
			</tr>
		</tfoot>
	</table>
@stop