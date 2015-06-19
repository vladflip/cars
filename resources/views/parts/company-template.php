<script id="company-template" type="text/x-handlebars-template">

	<div className="company-popup">

		<div class="company-preview">
			<div class="company-preview_logo"
				style="background-image: url({{logo}})"
			></div>
			<div class="company-preview_info">
				<h3>{{name}}</h3>
				<h5>{{address}}</h5>
				<h5>{{excerpt}}</h5>
			</div>
		</div>

		<h4 class="company-popup_spec">Специализация</h4>

		<div class="company-popup_tags">
			{{#each tags}}
				<div class="company-popup_tag">{{this}}</div>
			{{/each}}

		</div>

		<h4 class="company-popup_desc">Описание</h4>

		<p class="company-popup_description">
			{{description}}
		</p>

	</div>

</script>