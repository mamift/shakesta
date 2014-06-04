@extends('layout')
	
@section('content')
	@if (!Auth::check()) {{-- Not logged in --}}
		<p class="margin-centered">This site is restricted. You must already have a an active user account to login.</p>		

		<p class="margin-centered">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.</p>

		<p class="margin-centered">Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus.</p>

		<p class="margin-centered">Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi.</p>

		<p class="margin-centered">Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc</p>

		<p class="margin-centered center-aligned no-bg">
			<a href="/user-signup" class="btn btn-primary">
				Register new account
			</a>
		</p>
	@else
		<img src="images/sale-1.png"/>
		<img style="margin-left:20px" src="images/sale-2.png"/>
		<br>
		<br>
		<img src="images/sale-3.png"/>
		<img style="margin-left:20px" src="images/sale-4.png"/>
		<br>
		<br>
		<img src="images/sale-5.png"/>
		<img style="margin-left:20px" src="images/sale-6.png"/>
	@endif
</div>
@stop