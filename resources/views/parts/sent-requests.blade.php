<div class="sent-requests">

	@foreach($user->requests as $request)
	
		<div class="requests_item">
			
			<div class="requests_request">
				
				<div class="requests_logo-name">

					<div class="requests_logo">
						<img src="{{ URL::to('/') . '/' . $user->ava }}" alt="">
					</div>

					<div class="requests_name">
						{{ $user->name }}
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

			@foreach($request->responses as $response)

				<div class="sent-requests_response">
					
					<div class="sent-requests_response-time">
						{{ 
							$response->created_at->day . '.' . 
							$response->created_at->month . '.'.
							$response->created_at->year
						}}
					</div>

					<div class="sent-requests_response-info">
						
						<div class="requests_logo-name">
							
							<div class="requests_logo">
								<img src="img/com_logo.jpg" alt="">
							</div>

							<div class="requests_name">
								ООО Трансавтосервис
							</div>

						</div>

						<div class="sent-requests_response-contacts">
							г. Москва, ул. Улица д21 <br>
							843 089 98 4, 34 98432 7893
						</div>

					</div>

					<div class="sent-requests_response-body requests_body--grey">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore est esse nesciunt optio illo tempora sapiente aspernatur recusandae. Totam, iste.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore harum porro doloribus provident, deleniti ducimus minus, repellendus.
					</div>

				</div>

			@endforeach

		</div>

	@endforeach

</div>