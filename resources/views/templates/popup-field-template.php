<script id="popup-field-template" type="text/x-handlebars-template">
							
	<div class="popup_label">{{label}}</div>

	{{#if input}}
		<input type="text" class="popup_input" 
		value="{{value}}">
	{{else}}
		<textarea cols="30" rows="7" class="popup_textarea">{{value}}</textarea>
	{{/if}}

</script>