@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>
	<div class="">
		<a href="{{ URL::route('deals.index') }}">Back to deals</a>
	</div>
	<div>
		{{ Form::model($deal, ['method' => 'GET', 'route' => ['deals.index']] ) }}
			<table class="tabulus tabulus-form">
				<thead>
					<tr>
						<th colspan="2">
							<h3>View Deal &#35;{{ $deal->deal_id }}</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ Form::label('deal_id', 'ID') }} <br/>(product must already exist)</td>
						<td>
							{{ $deal->deal_id }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('_product', 'For Product: ') }}</td>
						<td>
							{{ Form::select('_product', ['PRODUCT_NAME'], 'PRODUCT_NAME', ['disabled' => 'disabled']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('price_discount', 'Price Discount') }} </td>
						<td>
							{{ $deal->price_discount }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('terms','Terms:') }}</td>
						<td>
							{{ $deal->terms }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('begins', 'Begins') }}</td>
						<td>{{ $deal->begins_datetime }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('expires', 'Expires') }}</td>
						<td>{{ $deal->expires_datetime }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('category', 'Category') }}</td>
						<td>{{ $deal->category }}</td>
					</tr>
					<tr>
						<td>Created </td>
						<td>{{ date("l jS F Y h:i:s A", strtotime($deal->created_at)) }}</td>
					</tr>
					<tr>
						<td>Last updated</td>
						<td>{{ date("l jS F Y h:i:s A", strtotime($deal->updated_at)) }} </td>
					</tr>
				</tbody>
				<tfoot>
					<tr class="">
						<td colspan="2">
							{{ Form::submit('Back') }}
							<button type="button" onClick="window.location='{{ URL::route('deals.edit', $deal->deal_id) }}'">Edit deal</button>
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>

@stop