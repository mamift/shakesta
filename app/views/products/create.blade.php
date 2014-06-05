@extends('layout')

@section('content')

	<h2>
		<a href="{{ URL::route('products.index') }}">&lt; Go to products</a>
	</h2>
	<div>
		{{ Form::open(['route' => 'products.store', 'files' => 'true', 'class' => 'form-inline', 'role' => 'form']) }}
			<table class="table table-hover table-striped table-condensed">
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
							{{ Form::text('title', null, ['class' => 'form-control input-sm', 'size' => 30]) }}
							@if ($errors->first('title'))
								<span class="error">{{ $title_message = $errors->first('title') }}</span>
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('description','Description:') }}</td>
						<td>
							{{ Form::textarea('description', null, ['class' => 'form-control input-sm']) }}
						</td>
					</tr>
					<tr>
						<td>
							{{ Form::label('retailer_id', 'For Client: ') }} <br/>
						</td>
						<td>
							@if (Auth::user()->is_admin)
							{{ Form::select('retailer_id', $all_retailers, null, ['class' => 'form-control input-sm']) }}
							<br/>
							<a href="{{ URL::route('retailers.create') }}"> (Click here to create new client)</a>
							@else 
							{{ Form::select('retailer_id', [$retailer_id => $all_retailers[$retailer_id]], $retailer_id) }}
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('retail_price','Retail Price:') }}</td>
						<td>{{ Form::input('number', 'retail_price', '0.0', ['step' => '0.01', 'class' => 'form-control input-sm']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('image_file', 'Image') }}</td>
						<td>{{ Form::file('image_file', ['class' => 'form-control input-sm']) }}</td>
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
@stop