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
				

			</div>

			@if(Auth::guest())
			
				<div class="footer_sign-up-block">

					<h5>
						Поиск товаров и услуг для грузового автотранспорта доступен только зарегистрированным членам клуба
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