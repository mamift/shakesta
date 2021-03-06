@extends('layout')

@section('content')
	<h2 class="">
		<a href="{{ URL::route('users.index') }}">&lt; Back to users</a>
	</h2>
	<div>
		{{ Form::model($user, ['method' => 'GET', 'route' => ['users.index', $user->id]]) }}
			<table class="table table-hover table-striped table-condensed">
				<thead>
					<tr>
						<th colspan="2">
							<h3>User no. {{ $user->id }}</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ Form::label('user_id', 'ID') }}</td>
						<td>
							{{ $user->id }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('username','Username:') }}</td>
						<td>
							{{ $user->username }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('email','E-mail:') }}</td>
						<td>
							{{ $user->email or "no e-mail address provided" }}
						</td>
					</tr>
					@if ($retailer)
					<tr>
						<td>{{ Form::label('retailer','Client:') }}</td>
						<td>
							<a href="{{ URL::route('retailers.show', $retailer->id) }}">{{ $retailer->title }}</a>
						</td>
					</tr>
					@endif
					<tr>
						<td>{{ Form::label('enabled','Status') }}</td>
						@if ($user->is_enabled)
						<td>{{ $user->status }}</td>
						@else 
						<td><span class="error">{{ $user->status }}</span></td>
						@endif
					</tr>
					@if ($user->apikey)
					<tr>
						<td>{{ Form::label('apikey','API Key:') }}</td>
						<td>
							{{ $user->apikey }} <br />
							<span class="error">API Url: www.shakesta.com/api/v1.1/</span>
						</td>
					</tr>
					@endif
					@if ($user->notes && $user->status === 'disabled')
					<tr>
						<td>{{ Form::label('notes','User notes:') }}</td>
						<td>
							{{ $user->notes }} <br />
						</td>
					</tr>
					@endif
				</tbody>
				<tfoot>
					<tr class="">
						<td colspan="2">
							{{ Form::submit('Back', ['class' => 'btn btn-primary']) }}
							<button type="button" onClick="window.location='{{ URL::route('users.edit', $user->user_id) }}'" class="btn btn-warning">Edit user</button>
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>
@stop