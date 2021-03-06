@extends('layout')

@section('content')
	<h2>
		<a href="{{ URL::route('deals.index') }}">&lt; Go to Campaigns</a>
	</h2>
	<div>
		{{ Form::model($deal, ['method' => 'PATCH', 'route' => ['deals.update', $deal->deal_id], 'role' => 'form', 'class' => 'form-inline']) }}
			<table class="table table-hover table-striped table-condensed">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Edit Campaign &#35;{{ $deal->deal_id }}</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<!-- <tr>
						<td>{{ Form::label('deal_id', 'ID') }}</td>
						<td>
							{{ Form::input('text', 'deal_id', $deal->id, ['readonly' => 'readonly']) }}
						</td>
					</tr> -->
					<tr>
						<td>{{ Form::label('product_id', 'For Product: ') }}</td>
						<td>
							{{ Form::select('product_id', [$deal->product->id => $deal->product->id . ": " .$deal->product->title], $deal->product->id, ['class' => 'form-control input-sm']) }}
							<br />
							<a href="{{ URL::route('products.create') }}">
							(Click here to create new product)
							</a>
							@if ($errors)
								<span class="error">{{ $errors->first('product_id') }}</span>
							@endif
						</td>
					</tr>
					<tr>
						<td>
							{{ Form::label('title', 'Campaign Title: ') }} 
						</td>
						<td>
							{{ Form::text('title', null, ['placeholder' => 'Enter a title', 'class' => 'form-control input-sm']) }}
							<span class="error">{{ $errors->first('title') }}</span>
						</td>
					</tr>
					<tr>
						<td>
							{{ Form::label('price_discount', 'Price Discount') }} <br/>
							(enter as decimal&colon; e.g. 0.5 &equals; 50&percnt;)
						</td>
						<td>
							{{ Form::input('number', 'price_discount', null, ['step' => '0.01', 'placeholder' => 'Decimal: 0.5 = 50%', 'class' => 'form-control input-sm']) }}
							@if ($errors)
								<span class="error">{{ $errors->first('price_discount') }}</span>
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('terms','Terms:') }}</td>
						<td>
							{{ Form::textarea('terms', null, ['class' => 'form-control input-sm']) }}
							@if ($errors)
								<span class="error">{{ $errors->first('terms') }}</span>
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('begins', 'Begins') }}</td>
						<td>
							{{ Form::input('text', 'begins_time', $deal->begins_time, ['class' => 'datetime_field form-control input-sm']) }}
							@if ($errors)
								<span class="error">{{ $errors->first('begins_time') }}</span>
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('expires', 'Expires') }}</td>
						<td>
							{{ Form::input('text', 'expires_time', $deal->expires_time, ['class' => 'datetime_field form-control input-sm']) }}
							@if ($errors)
								<span class="error">{{ $errors->first('expires_time') }}</span>
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('category', 'Category') }}</td>
						<td>
							{{ Form::select('category', $categories, $deal->category, ['id' => 'enter-categories-select', 'class' => 'form-control input-sm']) }}
							@if ($errors)
								<span class="error">{{ $errors->first('category') }}</span>
							@endif
						</td>
					</tr>
					@if (Session::get('category_already_exists'))
					<tr id="enter-your-own-category-row">
						<td>{{ Form::label('other_new_category', 'Enter your own category') }}</td>
						<td>
							{{ Form::text('other_new_category', '', ['id' => 'other_new_category','enabled' => 'enabled']) }}
							<span class="error">{{ Session::get('category_already_exists') }}</span>
						</td>
					</tr>
					@else
					<tr id="enter-your-own-category-row" style="display:none;">
						<td>{{ Form::label('other_new_category', 'Enter your own category') }}</td>
						<td>
							{{ Form::text('other_new_category', '', ['id' => 'other_new_category','disabled' => 'disabled']) }}
							<span class="error">{{ Session::get('category_already_exists') }}</span>
						</td>
					</tr>
					@endif
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