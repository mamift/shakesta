@extends('layout')

@section('content')
	<table>
		<thead>	
			<tr>
				<th>User ID</th>
				<th>Password</th>
				<th>Retail ID</th>
				<th>E-mail address</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
	@if (count($users) > 0)
    @foreach($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>{{ $user->password }} </td>
				<td>{{ $user->retail_id }}</td>
				<td>{{ $user->email }}</td>
				<td><a href="{{ URL::route('users.edit', $user->id) }}">Edit</a></td>
				<td>
					{{ Form::open(['route' => ['users.destroy', $user->id]]) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete') }}
					{{ Form::close() }}
				</td>
			</tr>
    @endforeach
    @else
    	<tr>
    		<td colspan="6" style="text-align: center;">No users here!</td>
    	</tr>
    @endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6"><a href="{{ URL::route('users.create') }}">Create a new user</a></td>
			</tr>
		</tfoot>
	</table>
@stop