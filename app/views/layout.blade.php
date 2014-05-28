<!DOCTYPE html>
<html>
<head> 
	<link rel="stylesheet" href="/style.css" />
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
	<link rel="stylesheet" href="/css/5grid/core-desktop.css" />
	<link rel="stylesheet" href="/css/5grid/core-1200px.css" />
	<link rel="stylesheet" href="/css/5grid/core-noscript.css" />
	<link rel="stylesheet" href="/css/style.css" />
	<link rel="stylesheet" href="/css/style-desktop.css" />
	<link rel="stylesheet" type="text/css" href="/jquery.datetimepicker.css"/ >

	<script type="text/javascript" src="/jquery-2.1.0.min.js"></script>
	
</head>

<body>


	<div class="container">
		<div class="logo">
			<img src="/images/shakesta.gif"/>
		</div>
		
		<div class="nav">
			<ul>	
				<li><a href="/">Home</a></li>
				<li>
					<a href="/user-login">
					@if (Auth::check())	
						User page
					@else
						Login
					@endif
					</a>
				</li>

			@if (Auth::check())

				@if (Auth::user()->user_type === 'admin')

				<li><a href="/users">Manage Users</a></li>
				<li><a href="/deals">Manage Deals</a></li>
				<li><a href="/products">Manage Products</a></li>
				<li><a href="/retailers">Manage Retailers</a></li>
				<!-- <li><a href="/shops">Manage Shop Locations</a></li> -->

				@elseif (Auth::user()->user_type === 'retailer')

				<li><a href="/deals">View My Deals</a>
					<ul>
						<li><a href="/deals/create">Create Deal</a></li>
					</ul>
				</li>
				

				<li><a href="/products">View My Products</a>
					<ul>
						<li><a href="/products/create">Create Product</a></li>
					</ul>
				</li>
				@endif
				
				<li><a href="/user-logout">Logout</a></li>

			@endif

				<li><a href="/contact-us">Contact Us</a></li>
			</ul>
		</div>
		
		<div class="content">
			@yield('content')
		</div>

	<div class="footer">		
		<img src="/images/hive-logo.png"/>
		<br>
		<ul class="social">
			<li style="margin-left:25px; margin-bottom:30px;"class="facebook"><a href="#">Facebook</a></li>
			<li style="margin-left:25px; margin-bottom:30px;"class="linkedin"><a href="#">LinkedIn</a></li>
		</ul>
	</div>

	</div>	
		
</body>

<script type="text/javascript" src="/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/shakesta.js"></script>
</html>