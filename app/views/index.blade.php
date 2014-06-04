@extends('layout')
	
@section('content')
	@if (!Auth::check()) {{-- Not logged in --}}
		<p class="margin-centered">This site is restricted. You must already have a an active user account to login.</p>		

		<p class="margin-centered">
			Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.
		</p>

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