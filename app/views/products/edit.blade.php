@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>
	<h2>
		<a href="{{ URL::route('products.index') }}">&lt; Go to products</a>
	</h2>
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
							{{ Form::input('text', 'product_id', $product->product_id, ['readonly' => 'readonly']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('title','Title:') }}</td>
						<td>
							{{ Form::text('title') }}
							@if ($errors->first('title'))
								<span class="error">{{ $title_message = $errors->first('title') }}</span>
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('description','Description:') }}</td>
						<td>
							{{ Form::textarea('description', null, ['cols' => '40', 'rows' => '10']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('retailer_id', 'For Retailer: ') }} <br/>(retailer must already exist)</td>
						<td>
							{{ Form::select('retailer_id', $all_retailers, $product->retailer_id, ['disabled' => 'disabled']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('retail_price','Retail Price:') }}</td>
						<td>
							&dollar; {{ Form::input('number', 'retail_price', null, ['step' => '0.01']) }}
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
					{{-- var_dump($all_retailers); --}}
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