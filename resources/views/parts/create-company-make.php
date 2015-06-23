<script id="create-company-make-template" type="text/x-handlebars-template">
	
	<select name="" class="popup_select create-company_select">

		{{#each makes}}
			<option value="{{id}}" class="popup_option">
				{{title}}
			</option>	
		{{/each}}

	</select>

	<div class="popup_redx popup_redx--left"></div>

</script>
