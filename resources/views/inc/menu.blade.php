<div class="menu">
	
	<div class="m_c container">
		
		<div class="{{ Request::is('/') ? 'active' : '' }}">
			<a href="{{ route('home') }}">Главная</a>
		</div>
		<div class="{{ Request::is('about') ? 'active' : '' }}">
			<a href="#">О клубе</a>
		</div>
		<div class="{{ Request::is('catalog') ? 'active' : '' }}">
			<a href="{{ route('catalog') }}">Каталог</a>
		</div>
		<div class="{{ Request::is('feedback') ? 'active' : '' }}">
			<a href="#">Отзывы</a>
		</div>
		<div class="{{ Request::is('contacts') ? 'active' : '' }}">
			<a href="#">Контакты</a>
		</div>

	</div>

</div>