@extends('layout')

@section('content')
	<script type="text/javascript">
		$(document).ready(function() {
			var fired_once = false;
			if ($("#retailer_id option:selected").val() == 'null') {
				$("#retailer_id").change(function() {
					if (!fired_once) {
						alert('This will demote this user to a retailer! Only an administrator can change this back!');
						fired_once = true;
					}
				});
			}
		});
	</script>
	<h2>
		<a href="{{ URL::route('users.index') }}">&lt; Back to users</a>
	</h2>
	<div>
		{{ Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user->id]]) }}
			<table class="table table-bordered table-hover table-striped table-condensed">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Edit user</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ Form::label('user_id', 'ID') }}</td>
						<td>
							{{ Form::input('text', 'user_id', $user->id, ['readonly' => 'readonly']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('username','Username:') }}</td>
						<td>
							{{ Form::text('username') }}
							<span class="error">{{{ $username_message = $errors->first('username') }}}</span>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('email','E-mail:') }}</td>
						<td>
							{{ Form::text('email') }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('retailer_id','Retailer:') }}</td>
						<td>
							{{-- The admin user cannot demote himself (neither can any other admin user) --}}
							@if (Auth::user()->is_admin && $user->username == 'admin')
							{{ Form::select('retailer_id', $retailers, 'null', ['disabled' => 'disabled']) }}
							{{-- The admin user can turn admin users into retail users --}}
							@elseif (Auth::user()->is_admin && $user->is_admin && $user->username != 'admin') 
							{{ Form::select('retailer_id', $retailers, 'null') }}
							@else
							{{ Form::select('retailer_id', $retailers, $user->retailer_id) }}
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('new_password','New passowrd:') }}</td>
						<td>
							{{ Form::password('new_password', ['placeholder' => 'Min 6 chars']) }} 
							<span class="error">{{{ $password_message1 = $errors->first('new_password') }}}</span>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('new_password_confirm','New passowrd (confirm):') }}</td>
						<td>
							{{ Form::password('new_password_confirmation', ['placeholder' => 'Min 6 chars']) }} 
							<span class="error">{{{ $password_message2 = $errors->first('new_password_confirmation') }}}</span>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('generate_or_delete_apikey','Generate new api key?') }}</td>
						<td>
							{{ Form::checkbox('generate_or_delete_apikey', 'generate_apikey', false) }}
							
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('status','Enable user?') }}</td>
						{{-- Can't disable the admin user--}}
						@if (Auth::user()->is_admin && $user->username === 'admin')
						<td>{{ Form::select('status', ['enabled' => 'enabled','disabled' => 'disabled'], $user->status, ['disabled' => 'disabled']) }}</td>	
						@else
						<td>{{ Form::select('status', ['enabled' => 'enabled','disabled' => 'disabled'], $user->status) }}</td>
						@endif
					</tr>
					@if ($user->apikey)
					<tr>
						<td colspan="2" style="text-align: center;">
						Existing API key is&colon; <span class="error">{{ $user->apikey }} </span>
						</td>
					</tr>
					<!-- <tr>
						<td>{{ Form::label('generate_or_delete_apikey','Delete API key?') }}</td>
						<td>
							{{ Form::radio('generate_or_delete_apikey', 'delete_apikey', false) }}
						</td>
					</tr> -->
					@endif
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