@extends('layouts.main')

@section('body')

	<div class="profile">
		
		<div class="container">
			
			<div class="profile_left">

				@if($user->confirmed)

					@include('parts.user-profile-info')

				@else

					<div class="profile_verify">

						Поздравляем, Вы зарегистрировались в клубе "Комтранс"!
						Для того чтобы воспользоваться бесплатными функциями сайта, Вам необходимо подтвердить 
						свою почту (
							<a href="http://{{ $user->email_provider() }}">{{ $user->email }}</a>
						) путем активации письма.
						<br>
						<br>
						Если письмо не пришло, либо ссылка в нем не работает, то нажмите <a href="{{ route('user-repeat-message') }}">сюда</a> чтобы повторить отправку письма.

					</div>

				@endif

			</div>

			<div class="profile_right">
				
				@include('inc.search')

				@include('inc.feedback')

			</div>

		</div>

	</div>

	@include('popups.create-company')

	@include('popups.edit-profile', [
		'id' => 'edit-user-profile-popup', 
		'button_id' => 'edit-user-profile-button'
	])

	@include('templates.popup-field-template')

	@include('templates.avatar-template')

	@include('popups.settings')

@stop