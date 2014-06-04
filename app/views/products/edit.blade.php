@extends('layout')

@section('content')

	<h2>
		<a href="{{ URL::route('products.index') }}">&lt; Go to products</a>
	</h2>
	<div id="edit-form">
		{{ Form::model($product, ['method' => 'PATCH', 'route' => ['products.update', $product->product_id], 'files' => 'true', 'role' => 'form', 'class' => 'form-inline']) }}
			<table class="table table-hover table-striped table-condensed">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Edit a product</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr style="visibility:hidden; display:none">
						<td>{{ Form::label('product_id', 'ID') }}</td>
						<td>
							{{ Form::input('text', 'product_id', $product->product_id, ['readonly' => 'readonly', 'class' => 'form-control input-sm']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('title','Title:') }}</td>
						<td>
							{{ Form::text('title', null, ['class' => 'form-control input-sm']) }}
							@if ($errors->first('title'))
								<span class="error">{{ $title_message = $errors->first('title') }}</span>
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('description','Description:') }}</td>
						<td>
							{{ Form::textarea('description', null, ['cols' => '40', 'rows' => '10', 'class' => 'form-control input-sm']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('retailer_id', 'For Client: ') }} <br/>(must already exist)</td>
						<td>
							{{ Form::select('retailer_id', $all_retailers, $product->retailer_id, ['disabled' => 'disabled', 'class' => 'form-control input-sm']) }}
							<br/>
							<a href="{{ URL::route('retailers.create') }}"> (Click here to create new client)</a>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('retail_price','Retail Price:') }}</td>
						<td>&dollar; {{ Form::input('number', 'retail_price', null, ['step' => '0.01', 'class' => 'form-control input-sm']) }}</td>
					</tr>
					<tr>
						@if ($product->image_url)
						<td colspan="2" class="image-td-span-bordered">
							<img src="{{ $product->image_url or '/images/hive-logo.png' }}" />
						</td>
						@else
						<td colspan="2" class="image-td-span">
							<img src="/images/hive-logo.png" />
							<br/>(no image set)
						</td>
						@endif
					</tr>
					<tr>
						<td>{{ Form::label('image_file', 'Image') }}</td>
						<td>
							@if (!$product->image_url)NOTE: This will replace the existing image file @endif
							{{ Form::file('image_file', ['class' => 'form-control input-sm']) }}
							<br />
							
							<span class="error">
								{{{ Session::get('file_exception_message') }}}
							</span>
							
						</td>
					</tr>
					<!-- <tr>
						<td>Created </td>
						<td>{{ Form::input('time', 'created_at', null, ['readonly' => 'readonly']) }}</td>
					</tr>
					<tr>
						<td>Last updated</td>
						<td>{{ Form::input('time', 'updated_at', null, ['readonly' => 'readonly']) }}</td>
					</tr> -->
				</tbody>
				<tfoot>
					<tr class="">
						<td colspan="2">
							{{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>

	<div id="deals-for-product">
		<h2>
			Campaigns current for this product
		</h2>	
		<table class="table  table-hover table-striped table-condensed">
		<thead>	
			<tr>
				<td colspan="8"><a href="{{ URL::route('deals.create') }}" class="btn btn-primary btn-xs">Create a new campaign</a></td>
			</tr>
			<tr>
				<!-- <th>ID</th> -->
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
		@foreach ($deals as $deal)
			<tr>
				<td>
					Original: &dollar;{{ $product->retail_price }} <br />
					Discount: {{ $deal->price_discount * 100 }} &percnt; <br/>
					Deal price: &dollar;{{ $deal->original_price - ($deal->original_price * $deal->price_discount) }}
				</td>
				<td>{{ $deal->terms }}</td>
				<td><a href="{{ URL::route('deals.show', $deal->id) }}">{{ $deal->begins_datetime }}</a></td>
				<td><a href="{{ URL::route('deals.show', $deal->id) }}">{{ $deal->expires_datetime }}</a></td>
				<td>{{ $deal->expiry_time }}</td>
				<td>{{ $deal->category }}</td>
				<td><a href="{{ URL::route('deals.edit', $deal->id) }}">Edit</a></td>
				<td>{{ Form::open(['route' => ['deals.destroy', $deal->id], 'onSubmit' => 'return confirm_delete();']) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) }}
					{{ Form::close() }}</td>
			</tr>
		@endforeach
		@else
		<tr>
    		<td colspan="8" style="text-align: center;">No Campaigns here!</td>
    	</tr>
		@endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="8"><a href="{{ URL::route('deals.create') }}" class="btn btn-primary btn-xs">Create a new Campaign</a></td>
			</tr>
		</tfoot>
		</table>
	</div>
	
@stop