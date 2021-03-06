@extends('layout')

@section('content')

	<h2 class="">
		<a href="{{ URL::route('retailers.index') }}">&lt; Go to Clients</a>
	</h2>
	<div>
		{{ Form::open(['route' => 'retailers.store', 'role' => 'form', 'class' => 'form-inline']) }}
			<table class="table table-hover table-striped table-condensed">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Create new client</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<!-- <td>{{ Form::label('retailer_id', 'ID') }}</td>
						<td>
							{{-- Form::input('text', 'retailer_id', $new_id, ['readonly' => 'readonly']) --}}
						</td> -->
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