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
	<style>
		
	</style>
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
			<li><a href="/user-login">Login</a></li>
			<li><a href="/deals">View My Deals</a></li>
			<li><a href="/user-createdeal">Create Deal</a></li>
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
</html>