@extends('layout')

@section('content')
	<script type="text/javascript">
		function confirm_delete() {
			return confirm("Are you sure about deleting this?");
		}
	</script>
	<h1>All Retailers</h1>
	<table class="table table-bordered table-hover table-striped table-condensed">
		<thead>	
			<tr>
				<td colspan="4"><a href="{{ URL::route('retailers.create') }}">Create a new retailer</a></td>
			</tr>
			<tr>
				<!-- <th>ID</th> -->
				<th>Title</th>
				<th>Description</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
	@if (count($retailers) > 0)
    @foreach($retailers as $retailer)
			<tr>
				<!-- <td>{{ $retailer->id }}</td> -->
				<td><a href="{{ URL::route('retailers.show', $retailer->id) }}">{{ $retailer->title }}</a></td>
				<td>{{ $retailer->description }} </td>
				<td><a href="{{ URL::route('retailers.edit', $retailer->id) }}">Edit</a></td>
				<td>
					{{ Form::open(['route' => ['retailers.destroy', $retailer->id], 'onSubmit' => 'return confirm_delete();']) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete') }}
					{{ Form::close() }}
				</td>
			</tr>
    @endforeach
    @else
    	<tr>
    		<td colspan="4" style="text-align: center;">No retailers here!</td>
    	</tr>
    @endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4"><a href="{{ URL::route('retailers.create') }}">Create a new retailer</a></td>
			</tr>
		</tfoot>
	</table>
	@if (Session::get('delete_error'))
		<p class="error">
			{{ Session::get('delete_error') }} <br/>
			Delete all associated users, then try deleting this retailer.
		</p>
	@endif
@stop