<div class="found">

	<hr>

	<h3>Найденные организации</h3>

	@if(isset($spec_id))
		<div class="company-preview-list" id="catalog-companies"
		data-make="{{ $make_id }}"
		data-spec="{{ $spec_id }}"
		>
	@else
		<div class="company-preview-list" id="catalog-companies"
		data-make="{{ $make_id }}"
		>
	@endif

		@for($i=0; $i < count($companies); $i++)

			@if($i<5)

				<div class="company-preview">
					<div class="company-preview_logo"
					style="background-image: url({{ URL::to('/') . '/' . $companies[$i]['logo'] }})"></div>
					<div class="company-preview_info">
						<h3 class="company-preview_name">{{ $companies[$i]['name'] }}</h3>
						<h5 class="company-preview_address">{{ $companies[$i]['address'] }}</h5>
						<h5 class="company-preview_excerpt">
							{{ substr($companies[$i]['about'], 
								0, strpos($companies[$i]['about'], '.')+1) }}
						</h5>
					</div>
					<div class="company-preview_more">
						<span>Подробнее</span>
						<svg fill="#000000" xmlns="http://www.w3.org/2000/svg">
							<path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
							<path d="M0 0h24v24H0V0z" fill="none"></path>
							<path d="M12 10h-2v2H9v-2H7V9h2V7h1v2h2v1z"></path>
						</svg>
				
					</div>
					<div class="company-preview_data"
						data-phone="{{ $companies[$i]['phone'] }}"
						data-about="{{ $companies[$i]['about'] }}"
					>
						@foreach($companies[$i]['tags'] as $tag)

							<div data-tag="{{ $tag }}"></div>

						@endforeach
					</div>
				</div>

			@endif

		@endfor

	</div>

	@if(count($companies)>5)
		<div id="show-more-found-companies" class="found_more">
			Показать еще
		</div>
	@endif

</div>