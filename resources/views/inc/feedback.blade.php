<div class="feedback">

	<h3 class="feedback_h3">Нам важно мнение</h3>
	<p class="feedback_p">
		Вы можете поделиться своим мнением с другими участниками клуба
	</p>

	<div id="feedback" class="feedback_button"
	href="{{ Auth::guest() ? '#sign-up-popup' : '#feedback-popup' }}" >
		
		Написать отзыв
	</div>

</div>

@include('popups.feedback')