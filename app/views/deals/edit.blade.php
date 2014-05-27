@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>
	<div class="">
		<a href="{{ URL::route('deals.index') }}">Back to deals</a>
	</div>
	<div>
		{{ Form::model($deal, ['method' => 'PATCH', 'route' => ['deals.update', $deal->deal_id]] ) }}
			<table class="tabulus tabulus-form">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Edit Deal &#35;{{ $deal->deal_id }}</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ Form::label('deal_id', 'ID') }}</td>
						<td>
							{{ Form::input('text', 'deal_id', $deal->id, ['readonly' => 'readonly']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('product_id', 'For Product: ') }}</td>
						<td>
							{{ Form::select('product_id', [$deal->product->id => $deal->product->id . ": " .$deal->product->title], $deal->product->id) }}
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
						<td>{{ Form::input('text', 'begins_time', $deal->begins_time) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('expires', 'Expires') }}</td>
						<td>{{ Form::input('text', 'expires_time', $deal->expires_time) }}</td>
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