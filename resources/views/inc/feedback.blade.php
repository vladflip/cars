<div class="feedback">

	<h3 class="feedback_h3">Ваше мнение - важно</h3>
	<p class="feedback_p">
		Вы можете оставить отзыв об эксплуатации Вашего автомобиля
	</p>

	<div id="feedback" class="feedback_button"
	href="{{ Auth::guest() ? '#sign-up-popup' : 
			Auth::user()->is_ready() ? '#feedback-popup' : '#fill-up-profile-popup' }}" >
		
		Написать отзыв
	</div>

</div>

@include('popups.feedback')