<div class="menu">
	
	<div class="container">
		
		<div class="menu_item">
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
			
			@foreach($pages as $page)

				<div class="menu_btn {{ Request::is($page->url) ? 'active' : '' }}">
					<a href="{{ URL::to('/') . '/page/' . $page->url }}">{{ $page->title }}</a>
				</div>

			@endforeach

		</div>

		@if(Auth::check())
			{!! Form::open(['method' => 'GET', 'route' => 'user-logout', 'id' => 'user-logout-form']) !!}
				<div id="user-logout-button" class="menu_sign-up">
					Выход
				</div>
			{!! Form::close() !!}
		@else
			<div id="sign-up" href="#sign-up-popup" class="menu_sign-up">
				Регистрация
			</div>
		@endif

	</div>

	@include('popups.sign-up')

</div>