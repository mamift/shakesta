@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>
	<h2>
		<a href="{{ URL::route('products.index') }}">&lt; Go to products</a>
	</h2>
	<div>
		{{ Form::open(['route' => 'products.store', 'files' => 'true']) }}
			<table class="tabulus tabulus-form">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Create new product</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<!-- <td>{{ Form::label('product_id', 'ID') }}</td>
						<td>
							{{-- Form::input('text', 'product_id', $new_id, ['readonly' => 'readonly']) --}}
						</td> -->
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
							{{ Form::textarea('description') }}
						</td>
					</tr>
					<tr>
						<td>
							{{ Form::label('retailer_id', 'For Retailer: ') }} <br/>
						</td>
						<td>
							@if (Auth::user()->is_admin)
							{{ Form::select('retailer_id', $all_retailers) }}
							<a href="{{ URL::route('retailers.create') }}">
							(Click here to create new retailer)
							</a>
							@else 
							{{ Form::select('retailer_id', [$retailer_id => $all_retailers[$retailer_id]], $retailer_id) }}
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('retail_price','Retail Price:') }}</td>
						<td>{{ Form::input('number', 'retail_price', '0.0', ['step' => '0.01']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('image_file', 'Image') }}</td>
						<td>{{ Form::file('image_file') }}</td>
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