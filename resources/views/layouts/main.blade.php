<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Komtrans</title>
	<link rel="stylesheet" href="{{ URL::to('/') }}/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:500,700italic,300,700,500italic,300italic' rel='stylesheet' type='text/css'>
</head>
<body>
	
	@include('inc.header')


	@include('inc.menu')
	

	@yield('body')

	
	@include('inc.footer')

	<div class="popup" id="popup"></div>

	<script>
		var s = document.getElementById('search');
		var pop = document.getElementById('popup');

		s.onclick = function(){
			pop.style.display = 'block';
		}
		pop.onclick = function(){
			pop.style.display = 'none';
		}
	</script>

</body>
</html>