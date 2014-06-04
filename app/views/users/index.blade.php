@extends('layout')

@section('content')
<div id="enabled-users">
	<h1>Users</h1>
	<p>Any users without a retailer set are administrator users, and can manager other users except the admin user.</p>
	<table class="table table-hover table-striped table-condensed">
		<thead>	
			<tr>
				<td colspan="7"><a href="{{ URL::route('users.create') }}" class="btn btn-primary btn-xs">Create a new user</a></td>
			</tr>
			<tr>
				<!-- <th>ID</th> -->
				<th>Username</th>
				<th>E-mail</th>
				<th>For retailer</th>
				<th>Has API Key?</th>
				<th>Status</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
	@if (count($users) > 0)
    @foreach($users as $user)
			<tr>
				<!-- <td>{{ $user->id }}</td> -->
				<td><a href="{{ URL::route('users.show', $user->id) }}">{{ $user->username }}</a></td>
				<td>{{ $user->email }} </td>
				<td>
					@if ($user->user_type === 'admin')
						------
					@else
					<a href="{{ URL::route('retailers.show', $user->retailer->retailer_id )}}">
						{{{ $user->retailer->title or "----" }}}
					</a>
					@endif
				</td>
				<td>{{ isset($user->apikey) ? 'Yes' : 'No' }}</td>
				<td>{{ $user->status }}</td>
				<td><a href="{{ URL::route('users.edit', $user->id) }}" class="btn btn-warning btn-xs">Edit</a></td>
				<td>
					{{-- You can't delete the admin user --}}
					@if (Auth::user()->user_type === 'admin' and $user->username !== 'admin')
					{{ Form::open(['route' => ['users.destroy', $user->id], 'onSubmit' => 'return confirm_delete();']) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) }}
					{{ Form::close() }}
					@endif
				</td>
			</tr>
    @endforeach
    @else
    	<tr>
    		<td colspan="7" style="text-align: center;">No users here!</td>
    	</tr>
    @endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="7"><a href="{{ URL::route('users.create') }}" class="btn btn-primary btn-xs">Create a new user</a></td>
			</tr>
		</tfoot>
	</table>
</div>

<div id="disabled-users">
	<h1>Disabled Users</h1>
	<p>These are users who have signed up via the self-registration form on the homepage. See the user's notes for details on which client they wish to represent if they have no retailer set.</p>
	<table class="table table-hover table-striped table-condensed">
		<thead>	
			<tr>
				<!-- <th>ID</th> -->
				<th>Username</th>
				<th>E-mail</th>
				<th>For retailer</th>
				<th>Has API Key?</th>
				<th>Status</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
	@if (count($disabled_users) > 0)
    @foreach($disabled_users as $duser)
			<tr>
				<!-- <td>{{ $duser->id }}</td> -->
				<td><a href="{{ URL::route('users.show', $duser->id) }}">{{ $duser->username }}</a></td>
				<td>{{ $duser->email }} </td>
				<td>
					@if ($duser->user_type === 'admin')
						------
					@else
					<a href="{{ URL::route('retailers.show', $duser->retailer->retailer_id )}}">
						{{{ $duser->retailer->title or "----" }}}
					</a>
					@endif
				</td>
				<td>{{ isset($duser->apikey) ? 'Yes' : 'No' }}</td>
				<td>{{ $duser->status }}</td>
				<td><a href="{{ URL::route('users.edit', $duser->id) }}" class="btn btn-warning btn-xs">Edit</a></td>
				<td>
					{{-- You can't delete the admin user --}}
					@if (Auth::user()->user_type === 'admin' and $duser->username !== 'admin')
					{{ Form::open(['route' => ['users.destroy', $duser->id], 'onSubmit' => 'return confirm_delete();']) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) }}
					{{ Form::close() }}
					@endif
				</td>
			</tr>
    @endforeach
    @else
    	<tr>
    		<td colspan="7" style="text-align: center;">No users here!</td>
    	</tr>
    @endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="7"><a href="{{ URL::route('users.create') }}" class="btn btn-primary btn-xs">Create a new user</a></td>
			</tr>
		</tfoot>
	</table>
</div>
@stop