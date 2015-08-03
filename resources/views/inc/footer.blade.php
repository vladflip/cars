<div class="footer">
	
	<div class="container">

		<div class="footer_row">
			
			<div>

				<ul class="footer_list">
					<li>Информация</li>
					@foreach($pages as $page)
						<li>
							<a href="{{ URL::to('/') . '/page/' . $page->url }}">{{ $page->title }}</a>
						</li>
					@endforeach
				</ul>
				
				<ul class="footer_list">
					<li>Каталог</li>
					<li>Компании</li>
					<li>Запчасти</li>
					<li>Услуги</li>
					<li>Поиск</li>
				</ul>
				
				<ul class="footer_list">
					<li>Клуб</li>
					<li>Новости</li>
					<li>Общение</li>
					<li>Клубные карты</li>
				</ul>

			</div>

			@if(Auth::guest())
			
				<div class="footer_sign-up-block">

					<h5>
						Зарегистрируйся и найди любые запчасти бесплатно
					</h5>

					<div id="footer-sign-up" href="#sign-up-popup" class="footer_sign-up-button">
						Регистрация
					</div>

				</div>

			@endif

		</div>

		<div class="footer_row">
			
			<div>
				
				<h5 class="footer_rights">2015 Komtrans club. Все права защищены.</h5>

			</div>
			
			<div>
				
				<div class="footer_logo"></div>

			</div>

		</div>

	</div>

</div>