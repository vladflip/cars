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
						<p class="requests_additional">
							Тип: {{ $request->new ? 'новая' : '' }} {{ $request->old ? ', бу' : '' }} <br>
							Машина: {{ $request->type->title }} -> {{ $request->make->title }} -> {{ $request->model->title }} <br>
							Год выпуска: {{ $request->year }}
						</p>
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

					</div>

					<div class="response_body requests_body--grey">
						{{ $response->text }}
						<p class="requests_additional">
							Адрес: {{ $response->company->address }} <br>
							Телефон: {{ $response->company->phone }}
						</p>
					</div>

				</div>

			@endforeach

		</div>

	@endforeach

</div>