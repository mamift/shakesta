@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>
	<h2 class="">
		<a href="{{ URL::route('retailers.index') }}">&lt; Go to retailers</a>
	</h2>
	<div>
		{{ Form::model($retailer, ['method' => 'PATCH', 'route' => ['retailers.update', $retailer->id]]) }}
			<table class="tabulus tabulus-form">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Create new retailer</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ Form::label('retailer_id', 'ID') }}</td>
						<td>
							{{ Form::input('text', 'retailer_id', $retailer->id, ['readonly' => 'readonly']) }}
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
							{{ Form::textarea('description') }}
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
							{{ Form::submit('Save') }}
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>
@stop