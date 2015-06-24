<script id="found-template" type="text/x-handlebars-template">

	<hr>

	<h3>Найденные организации</h3>

	<div class="company-preview-list">

		{{#each companies}}
			<div class="company-preview">
				<div class="company-preview_logo"
					style="background-image: {{logo}}"
				></div>
				<div class="company-preview_info">
					<h3>{{name}}</h3>
					<h5>{{address}}</h5>
					<h5>{{excerpt}}</h5>
				</div>
				<div class="company-preview_more">Подробнее</div>
			</div>
		{{/each}}

	</div>

	<div class="found_more">
		Показать еще
	</div>

</script>