<div class="received-requests">

	@foreach($requests as $request)
	
		<div class="requests_item">
			
			<div class="requests_request">
				
				<div class="requests_logo-name">

					<div class="requests_logo">
						<img src="{{ URL::to('/') . '/' . $request->user->ava }}" alt="">
					</div>

					<div class="requests_name">
						{{ $request->user->name }}
					</div>

				</div>

				<div class="requests_body requests_body--yellow">
					{{ $request->text }}
				</div>

				<div class="requests_time">
					{{ 
						$request->created_at->day . '.' . 
						$request->created_at->month . '.'.
						$request->created_at->year
					}}
				</div>

			</div>

			<div class="response">
					
				<div class="requests_logo-name requests_logo-name--company">
					
					<div class="requests_logo">
						<img src="{{ URL::to('/') . '/' . $user->company->logo }}" alt="">
					</div>

					<div class="requests_name">
						{{ $user->company->name }}
					</div>

				</div>

				<div>
					<div class="response_body requests_body--grey">
						<textarea placeholder="Ответить" class="response_textarea" name="" id="" cols="30" rows="5"></textarea>
					</div>
					
					<div class="response_buttons">
						<div class="response_decline">Отклонить</div>
						<div class="response_answer">Ответить</div>
					</div>
				</div>

			</div>

		</div>

	@endforeach

</div>