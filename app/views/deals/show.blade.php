@extends('layout')

@section('content')

	<h2>
		<a href="{{ URL::route('deals.index') }}">&lt; Go to All Campaigns</a>
	</h2>
	<div>
		{{ Form::model($deal, ['method' => 'GET', 'route' => ['deals.index']] ) }}
			<table class="table table-hover table-striped table-condensed">
				<thead>
					<tr>
						<th colspan="2">
							<h3>View Campaign &#35;{{ $deal->deal_id }}</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ Form::label('deal_id', 'ID') }}</td>
						<td>
							{{ $deal->deal_id }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('product', 'For Product: ') }}</td>
						<td>
							<a href="{{ URL::route('products.show', $product['id']) }}">
								{{ $product['title'] }}
							</a>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('product', 'Client (or retailer): ') }}</td>
						<td>
							{{ ProductDealsRetailers::find($deal->deal_id)->retailer }}
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
							{{ Form::submit('Back', ['class' => 'btn btn-primary']) }}
							<button type="button" onClick="window.location='{{ URL::route('deals.edit', $deal->deal_id) }}'" class="btn btn-warning">Edit campaign</button>
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>

@stop