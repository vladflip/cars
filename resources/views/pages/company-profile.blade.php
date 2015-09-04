@extends('layouts.main')

@section('body')

	<div class="profile">
		
		<div class="container">
			
			<div class="profile_left">

				@include('parts.company-profile-info')

			</div>

			<div class="profile_right">
				
				@include('inc.search')

				@include('inc.feedback')

			</div>

		</div>

	</div>

	@include('popups.edit-profile', [
		'id' => 'edit-company-profile-popup', 
		'button_id' => 'edit-company-profile-button'
	])

	@include('popups.edit-profile', [
		'id' => 'edit-user-profile-popup', 
		'button_id' => 'edit-user-profile-button'
	])

	@include('templates.popup-field-template')

	@include('templates.avatar-template')

	@include('popups.settings')

@stop