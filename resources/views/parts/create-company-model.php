<script id="create-company-model-template" type="text/x-handlebars-template">
	
	<select name="" class="popup_select create-company_select">

		<option value="all" selected>Все модели</option>

		{{#each models}}
			<option value="{{id}}" class="popup_option">
				{{title}}
			</option>	
		{{/each}}

	</select>

</script>
