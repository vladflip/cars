<div class="sent-requests" id="user-requests">

	@foreach($user->requests as $request)
	
		<div class="requests_item" data-id="{{ $request->id }}">
			
			<div class="requests_request">
				
				<div class="requests_logo-name">

					<div class="requests_logo"
					style="background-image:url({{ URL::to('/') . '/' . ($user->ava ? $user->ava : 'img/noavatar.png') }})">
					</div>

					<div class="requests_name">
						{{ $user->name }}
					</div>

				</div>

				<div>
					<div class="requests_body 
					{{ $request->canceled_by_user ? 'requests_body--grey' : 'requests_body--yellow' }}">
						{{ $request->text }}
					</div>

					@if( ! $request->canceled_by_user )
						<div class="response_buttons">
							<div class="response_cancel">Закрыть</div>
						</div>
					@endif
				</div>

				<div class="requests_time">
					{{ 
						$request->created_at->day . '.' . 
						$request->created_at->month . '.'.
						$request->created_at->year
					}}
				</div>

			</div>

			@foreach($request->responses as $response)

				<div class="response">
					
					<div class="response_time">
						{{ 
							$response->created_at->day . '.' . 
							$response->created_at->month . '.'.
							$response->created_at->year
						}}
					</div>

					<div class="response_info">
						
						<div class="requests_logo-name">
							
							<div class="requests_logo">
								<img src="{{ URL::to('/') . '/' . $response->company->logo }}" alt="">
							</div>

							<div class="requests_name">
								{{ $response->company->name }}
							</div>

						</div>

						<div class="sent-requests_response-contacts">
							{{ $response->company->address }} <br>
							{{ $response->company->phone }}
						</div>

					</div>

					<div class="response_body requests_body--grey">
						{{ $response->text }}
					</div>

				</div>

			@endforeach

		</div>

	@endforeach

</div>