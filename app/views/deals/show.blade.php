@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>

		<table class="tabulus tabulus-form">
			<thead>
				<tr>
					<th colspan="2">View category</th>
				</tr>
			</thead>
			<tbody>
				<tr class="category-table-id-detail">
					<td>ID</td>
					<td>
						<input type="number" size="1" name="id" value="" readonly />
						<input type="number" name="table" value="" readonly hidden />
					</td>
				</tr>
				<tr class="category-table-name-detail">
					<td>Name</td>
					<td><div id="name"></div></td>
				</tr>
				<tr class="category-table-name-description">
					<td>Description</td>
					<td><div id="description"></div></td>
				</tr>
				<tr class="record-row">
					<td colspan="2">
						<a href="">View all items under this category</a>
					</td>
				</tr>
			</tbody>
		</table>

@stop