<div class="received-requests" id="company-requests">

	@foreach($requests as $request)

		<?php
			if( $request->canceled_by_user == 1  && ! count($request->responses) )
				continue;
		?>
	
		<div class="requests_item" data-id="{{ $request->id }}">
			
			<div class="requests_request">
				
				<div class="requests_logo-name">

					<div class="requests_logo"
					style="background-image:url({{ URL::to('/') . '/' . ($request->user->ava ? $request->user->ava : 'img/noavatar.png') }})">
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

			@if(count($request->responses))

				<div class="response">
						
					<div class="requests_logo-name requests_logo-name--company">
						
						<div class="requests_logo">
							<img src="{{ URL::to('/') . '/' . $user->company->logo }}" alt="">
						</div>

						<div class="requests_name">
							{{ $user->company->name }}
						</div>

					</div>

					<div class="response_body requests_body--grey">
						{{ $request->responses[0]->text }}
					</div>

				</div>

			@elseif( $request->pivot->canceled_by_company )

				<div class="response">
						
					<div class="requests_logo-name requests_logo-name--company">
						
						<div class="requests_logo">
							<img src="{{ URL::to('/') . '/' . $user->company->logo }}" alt="">
						</div>

						<div class="requests_name">
							{{ $user->company->name }}
						</div>

					</div>

					<div class="response_body requests_body--grey">
						Отклонено.
					</div>

				</div>

			@else

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
							<div class="response_cancel">Отклонить</div>
							<div class="response_answer">Ответить</div>
						</div>
					</div>

				</div>

			@endif

		</div>

	@endforeach

</div>