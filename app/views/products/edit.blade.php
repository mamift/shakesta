@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>
	<div class="">
		<a href="{{ URL::route('products.index') }}">Back to products</a>
	</div>
	<div>
		{{ Form::model($product, ['method' => 'PATCH', 'route' => ['products.update', $product->product_id]]) }}
			<table class="tabulus tabulus-form">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Edit a product</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ Form::label('product_id', 'ID') }}</td>
						<td>
							{{ Form::input('text', 'product_id', 'AUTO_INCREMENT', ['readonly' => 'readonly']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('title','Title:') }}</td>
						<td>
							{{ Form::text('title') }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('description','Description:') }}</td>
						<td>
							{{ Form::textarea('description', null, ['cols' => '40', 'rows' => '10']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('_retailer_id', 'For Retailer: ') }} <br/>(retailer must already exist)</td>
						<td>
							{{ Form::select('_retailer_id', ['RETAILER_ID'], 'RETAILER_ID', ['disabled' => 'disabled']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('retail_price','Retail Price:') }}</td>
						<td>
							{{ Form::input('number', 'retail_price') }}
						</td>
					</tr>
					<tr>
						<td colspan="2" class="image-td-span">
							<img src="/images/hive-logo.png" />
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('image', 'Image') }}</td>
						<td>{{ Form::file('image') }}</td>
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
							{{ Form::submit('Save') }}
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>
@stop