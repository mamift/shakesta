@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>
	<div>
		<a href="{{ URL::route('products.index') }}">Back to products</a>
	</div>
	<div>
		{{ Form::open(['method' => 'GET', 'route' => 'products.index']) }}
			<table class="tabulus tabulus-form">
				<thead>
					<tr>
						<th colspan="2">
							<h3>View a product</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ Form::label('product_id', 'ID') }}</td>
						<td>
							{{ $product->product_id }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('title','Title:') }}</td>
						<td>
							{{ $product->title }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('description','Description:') }}</td>
						<td>
							{{ $product->description }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('_retailer_id', 'Retailer: ') }} <br/></td>
						<td>
							{{ $product->retailer_id }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('retail_price','Retail Price:') }}</td>
						<td>
							{{ $product->retail_price }}
						</td>
					</tr>
					<tr>
						<td colspan="2" class="image-td-span">
							<img src="/images/hive-logo.png" />
							<br/>(no image set)
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
					<tr>
						<td colspan="2">
							{{ Form::submit('Back') }}
							<button type="button" onClick="window.location='{{ URL::route('products.edit', $product->product_id) }}'">Edit product</button>
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>
@stop