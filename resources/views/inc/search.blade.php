@if( Auth::guest() ? 1 : ( Auth::user()->company ? 0 : 1 ) )

	<div class="search">
						
		<h3>Заказ запчастей</h3>

		<p>Заполните форму и получите 
			персональные предложения от актуальных компаний</p>

		<div id="search" class="search_button"
		href="{{ Auth::guest() ? '#sign-up-popup' : 
				( Auth::user()->is_ready() ? '#search-popup' : '#fill-up-profile-popup' ) }}">
			Отправить запрос
		</div>

	</div>

	@include('popups.search')

@endif