<div class="sent-requests" id="user-requests">
	
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
				<div class="requests_body requests_body--yellow">
					{{ $request->text }}
					<p class="requests_additional">
						Тип: {{ $request->new ? 'новая' : '' }} {{ $request->old ? ', бу' : '' }} <br>
						Машина: {{ $request->type->title }} -> {{ $request->make->title }} -> {{ $request->model->title }} <br>
						Год выпуска: {{ $request->year }}
					</p>
				</div>
			</div>

			<div class="requests_time">
				{{ 
					$request->created_at->day . '.' . 
					$request->created_at->month . '.'.
					$request->created_at->year
				}}
			</div>

		</div>

		@if($room->response)
			<div class="response">
				
				<div class="response_time">
					{{ 
						$room->response->created_at->day . '.' . 
						$room->response->created_at->month . '.'.
						$room->response->created_at->year
					}}
				</div>

				<div class="response_info">
					
					<div class="requests_logo-name">
						
						<div class="requests_logo">
							<img src="{{ URL::to('/') . '/' . $room->response->company->logo }}" alt="">
						</div>

						<div class="requests_name">
							{{ $room->response->company->name }}
						</div>

					</div>

				</div>

				<div class="response_body requests_body--grey">
					{{ $room->response->text }}
					<p class="requests_additional">
						Адрес: {{ $room->response->company->address }} <br>
						Телефон: {{ $room->response->company->phone }}
					</p>
				</div>

			</div>
		@endif

	</div>

</div>