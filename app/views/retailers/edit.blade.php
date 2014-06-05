@extends('layout')

@section('content')

	<h2 class="">
		<a href="{{ URL::route('retailers.index') }}">&lt; Go to clients</a>
	</h2>
	<div>
		{{ Form::model($retailer, ['method' => 'PATCH', 'route' => ['retailers.update', $retailer->id], 'role' => 'form', 'class' => 'form-inline']) }}
			<table class="table table-hover table-striped table-condensed">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Edit client</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr style="visibility:hidden;display:none;">
						<td>{{ Form::label('retailer_id', 'ID') }}</td>
						<td>
							{{ Form::input('text', 'retailer_id', $retailer->id, ['readonly' => 'readonly', 'class' => 'form-control input-sm']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('title','Title:') }}</td>
						<td>
							{{ Form::text('title', null, ['class' => 'form-control input-sm']) }}
							<span class="error">{{ $errors->first('title') }}</span>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('description','Description:') }}</td>
						<td>
							{{ Form::textarea('description', null, ['class' => 'form-control input-sm']) }}
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
							{{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>
@stop