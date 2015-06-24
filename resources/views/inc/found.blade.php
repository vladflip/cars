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
					style="background-image: url({{ $companies[$i]['logo'] }})"></div>
					<div class="company-preview_info">
						<h3 class="company-preview_name">{{ $companies[$i]['name'] }}</h3>
						<h5 class="company-preview_address">{{ $companies[$i]['address'] }}</h5>
						<h5 class="company-preview_excerpt">
							{{ substr($companies[$i]['description'], 
								0, strpos($companies[$i]['description'], '.')+1) }}
						</h5>
					</div>
					<div class="company-preview_more">Подробнее</div>
					<div class="company-preview_data"
						data-phone="{{ $companies[$i]['phone'] }}"
						data-description="{{ $companies[$i]['description'] }}"
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