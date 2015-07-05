<div class="menu">
	
	<div class="container">
		
		<div class="menu_btn {{ Request::is('/') ? 'active' : '' }}">
			<a href="{{ route('home') }}">Главная</a>
		</div>
		{{-- <div class="menu_btn {{ Request::is('about') ? 'active' : '' }}">
			<a href="#">О клубе</a>
		</div> --}}
		<div class="menu_btn {{ $catalog }}">

			<a href="{{ route('catalog') }}">Каталог</a>

		</div>
		<div class="menu_btn {{ $feedback }}">
			<a href="{{ route('feedback') }}">Отзывы</a>
		</div>
		<div class="menu_btn {{ Request::is('contacts') ? 'active' : '' }}">
			<a href="#">Контакты</a>
		</div>

	</div>

</div>