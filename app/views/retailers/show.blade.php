@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>
	<div class="">
		<a href="{{ URL::route('retailers.index') }}">Back to retailers</a>
	</div>
	<div>
		{{ Form::open(['method' => 'PATCH', 'route' => 'retailers.index']) }}
			<table class="tabulus tabulus-form">
				<thead>
					<tr>
						<th colspan="2">
							<h3>View retailer: {{ $retailer->title }} </h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ Form::label('retailer_id', 'ID') }}</td>
						<td>
							{{ $retailer->id }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('title','Title:') }}</td>
						<td>
							{{ $retailer->title }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('description','Description:') }}</td>
						<td>
							{{ $retailer->description }}
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
					<tr class="">
						<td colspan="2">
							{{ Form::submit('Back') }}
							<button type="button" onClick="window.location='{{ URL::route('retailers.edit', $retailer->id) }}'">Edit retailer</button>
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>
@stop