@extends('layout')

@section('content')
	<script type="text/javascript">
		
	</script>
	<h1>All Campaigns</h1>
	<table class="table table-hover table-striped table-condensed" id="index-of-deals-table">
		<thead>	
			<tr>
				<td colspan="11"><a href="{{ URL::route('deals.create') }}" class="btn btn-primary btn-xs">Create a new Campaign</a></td>
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
				<td><a href="{{ URL::route('deals.edit', $deal->id) }}" class="btn btn-warning btn-xs">Edit</a></td>
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
    		<td colspan="11" style="text-align: center;">No campaigns here!</td>
    	</tr>
    @endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="11"><a href="{{ URL::route('deals.create') }}" class="btn btn-primary btn-xs">Create a new Campaign</a></td>
			</tr>
		</tfoot>
	</table>

	<a id="categories"></a>
	<h1>Campaign Categories</h1>

	<p class="error">{{ Session::get('deleted_category') }}</p>
	<p class="error">{{ Session::get('created_category') }}</p>
	<p class="error">{{ Session::get('updated_category') }}</p>

	<!-- Edit Modal -->
	<div class="modal fade" id="update-category-modal" tabindex="-1" role="dialog" aria-labelledby="update-category-modalLabel" aria-hidden="true">
    {{ Form::open(['url' => '/api/v1.2/categories/apikey=' . Auth::user()->apikey . '/update', 'method' => 'POST', 'role' => 'form', 'class' => 'form-inline']) }}
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="update-category-modalLabel">Update Category</h4>
	      </div>
	      <div class="modal-body">
				<div class="form-group">
					{{ Form::label('cat_to_update', 'Category to update') }}
					{{ Form::select('cat_to_update', $categories, 0, ['class' => 'form-control input-sm']) }}
				</div>
				<p></p>
				<div class="form-group">
					{{ Form::label('updated_cat_name', 'New category name') }}
					{{ Form::text('updated_cat_name', '',['class' => 'form-control input-sm']) }}
				</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			{{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
	      </div>
	    </div>
	  </div>
	{{ Form::close() }}
	</div>

	<!-- Create Modal -->
	<div class="modal fade" id="create-category-modal" tabindex="-2" role="dialog" aria-labelledby="create-category-modalLabel" aria-hidden="true">
	{{ Form::open(['url' => '/api/v1.2/categories/apikey=' . Auth::user()->apikey . '/create', 'method' => 'POST', 'role' => 'form', 'class' => 'form-inline']) }}
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="create-category-modalLabel">Create new Catetgory</h4>
	      </div>
	      <div class="modal-body">
				{{ Form::label('name', 'Category Name') }}
				{{ Form::text('name', '', ['class' => 'form-control input-sm']) }}
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			{{ Form::submit('Create', ['class' => 'btn btn-primary']) }}
	      </div>
	    </div>
	  </div>
	{{ Form::close() }}
	</div>

	<table class="table table-hover table-striped table-condensed">
		<thead>	
			<tr>
				<td colspan="3">
					<a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#create-category-modal">Create a new Category</a>
				</td>
			</tr>
			<tr>
				<td>Name</td>
				<td>Edit</td>
				<td>Delete</td>
			</tr>
		</thead>
		<tbody>
			@if (count($categories) > 0)
			@foreach ($categories as $cat)
			<tr>
				<td>{{ $cat }}</td>
				<td>
					<a href="#" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#update-category-modal" onclick="change_select_category_to_update('{{$cat}}');">Edit</a>
				</td>
				<td>
				{{ Form::open(['url' => '/api/v1.2/categories/apikey=' . Auth::user()->apikey . '/destroy', 'method' => 'POST', 'role' => 'form', 'class' => 'form-inline', 'onSubmit' => 'return confirm_delete();']) }}
					{{ Form::label('cat_to_delete', 'Category to delete', ['hidden' => 'true']) }}
					{{ Form::select('cat_to_delete', $categories, null, ['class' => 'form-control input-sm hidden']) }}
					{{ Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) }}
				{{ Form::close() }}
				</td>
			</tr>
			@endforeach
			@else
			<tr>
				<td colspan="3">No categories set</td>
			</tr>
			@endif

			<tr id="new-category-form-row" class="hidden-form">
				<td colspan="3">
					
				</td>
			</tr>

			<tr id="edit-category-form-row" class="hidden-form">
				<td colspan="3">

				</td>
			</tr>

			<tr id="delete-category-form-row" class="hidden-form">
				<td colspan="3">
					
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3"><a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#create-category-modal">Create a new Category</a></td>
			</tr>
		</tfoot>
	</table>
@stop