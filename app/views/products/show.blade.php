@extends('layout')

@section('content')

	<h2>
		<a href="{{ URL::route('products.index') }}">&lt; Go to products</a>
	</h2>
	<div>
		{{ Form::open(['method' => 'GET', 'route' => 'products.index']) }}
			<table class="table table-hover table-striped table-condensed">
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
							{{ $all_retailers[$product->retailer_id] }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('retail_price','Retail Price:') }}</td>
						<td>
							{{ $product->retail_price }}
						</td>
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
							{{ Form::submit('Back', ['class' => 'btn btn-primary']) }}
							<button type="button" onClick="window.location='{{ URL::route('products.edit', $product->product_id) }}'" class="btn btn-warning">Edit product</button>
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>
@stop