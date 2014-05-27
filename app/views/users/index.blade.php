@extends('layout')

@section('content')
	<script type="text/javascript">
		function confirm_delete() {
			return confirm("Are you sure about deleting this?");
		}
	</script>
	<h1>All Users</h1>
	<table>
		<thead>	
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>E-mail</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
	@if (count($users) > 0)
    @foreach($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td><a href="{{ URL::route('users.show', $user->id) }}">{{ $user->username }}</a></td>
				<td>{{ $user->email }} </td>
				<td><a href="{{ URL::route('users.edit', $user->id) }}">Edit</a></td>
				<td>
					{{-- You can't delete the admin user --}}
					@if (Auth::user()->user_type === 'admin' and $user->username !== 'admin')
					{{ Form::open(['route' => ['users.destroy', $user->id], 'onSubmit' => 'return confirm_delete();']) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete') }}
					{{ Form::close() }}
					@endif
				</td>
			</tr>
    @endforeach
    @else
    	<tr>
    		<td colspan="5" style="text-align: center;">No users here!</td>
    	</tr>
    @endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="5"><a href="{{ URL::route('users.create') }}">Create a new user</a></td>
			</tr>
		</tfoot>
	</table>
@stop