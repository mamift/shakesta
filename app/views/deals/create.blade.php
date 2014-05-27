@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>
	<div class="">
		<a href="{{ URL::route('deals.index') }}">Back to deals</a>
	</div>
	<div>
		{{ Form::open(['route' => 'deals.store']) }}
			<table class="tabulus tabulus-form">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Create new Deal</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ Form::label('deal_id', 'ID') }}</td>
						<td>
							{{ Form::input('text', 'deal_id', $new_id, ['readonly' => 'readonly']) }}
						</td>
					</tr>
					<tr>
						<td>
							{{ Form::label('product_id', 'For Product: ') }} 
						</td>
						<td>
							{{ Form::select('product_id', $all_products) }}
							@if (Auth::user()->is_admin)
							<br />
							<a href="{{ URL::route('products.create') }}">
							(Click here to create new product)
							</a>
							@endif
							@if ($errors->first('product_id'))
								<span class="error">{{ $title_message = $errors->first('product_id') }}</span>
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('price_discount', 'Price Discount') }} </td>
						<td>
							{{ Form::input('number', 'price_discount', null, ['step' => '0.01']) }} 
							Enter as decimal (e.g 0.5 for 50 &percnt;)
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('terms','Terms:') }}</td>
						<td>
							{{ Form::textarea('terms') }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('begins', 'Begins') }}</td>
						<td>{{ Form::input('text', 'begins_time', '0000-00-00 00:00:00') }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('expires', 'Expires') }}</td>
						<td>{{ Form::input('text', 'expires_time', '0000-00-00 00:00:00') }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('category', 'Category') }}</td>
						<td>{{ Form::input('text', 'category') }}</td>
					</tr>
					<tr>
						<td>Created </td>
						<td>{{ Form::input('time', 'created_at', null, ['readonly' => 'readonly']) }}</td>
					</tr>
					<tr>
						<td>Last updated</td>
						<td>{{ Form::input('time', 'updated_at', null, ['readonly' => 'readonly']) }}</td>
					</tr>
				</tbody>
				<tfoot>
					<tr class="">
						<td colspan="2">
							{{ Form::submit('Save') }}
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>
@stop