<div class="footer">
	
	<div class="container">

		
		<div class="footer_menu">

			<ul class="footer_list">
				<li>
					<a href="/">Главная</a>
				</li>
				<li>
					<a href="/catalog">Каталог</a>
				</li>
				<li>
					<a href="/feedback">Отзывы</a>
				</li>
				<li>
					<a href="/page/pravila">Правила</a>
				</li>
				<li>
					<a href="/contacts">Контакты</a>
				</li>
				
			</ul>
			

		</div>

		@if(Auth::guest())
		
			<div class="footer_sign-up-block">

				<h5>
					Поиск товаров и услуг для грузового автотранспорта доступен только авторизованным членам клуба.
				</h5>

				<div id="footer-sign-up" href="#sign-up-popup" class="footer_sign-up-button">
					Регистрация
				</div>

			</div>

		@endif


		
		<div class="footer_copyright">
			
			<div class="footer_copyright--text">
				
				<h5 class="footer_rights">&copy; 2015г. клуб "Комтранс". Все права защищены. <a href="/page/pravila">Правила пользования сайтом</a>.</h5>

			</div>
			
			<div class="footer_copyright--logo">
				
				<div class="footer_logo"></div>

			</div>
		</div>



	</div>

</div>