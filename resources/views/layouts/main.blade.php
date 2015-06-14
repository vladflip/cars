<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Komtrans</title>
	<link rel="stylesheet" href="{{ URL::to('/') }}/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:500,700italic,300,700,500italic,300italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{ URL::to('/') }}/css/vendor/popup.css">
</head>
<body>
	
	@include('inc.header')


	@include('inc.menu')
	

	@yield('body')

	
	@include('inc.footer')

	<script src="{{ URL::to('/') }}/js/vendor/jquery.js"></script>
	<script src="{{ URL::to('/') }}/js/vendor/jquery-ui.js"></script>
	<script src="{{ URL::to('/') }}/js/vendor/selectbox.js"></script>
	<script src="{{ URL::to('/') }}/js/vendor/underscore.js"></script>
	<script src="{{ URL::to('/') }}/js/vendor/backbone.js"></script>
	<script src="{{ URL::to('/') }}/js/vendor/popup.js"></script>
	<script src="{{ URL::to('/') }}/js/script.js"></script>
</body>
</html>