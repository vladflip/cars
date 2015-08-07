<script id="admin-makes-template" type="text/x-handlebars-template">

	<div class="popup_field">
								
		<div class="popup_label">Имя</div>

		<input type="text" class="popup_input make-title" value="{{title}}">

	</div>

	<div class="popup_field">
								
		<div class="popup_label">Url</div>

		<input type="text" class="popup_input make-url" value="{{url}}">

	</div>

	<div class="popup_field">
								
		<div class="popup_label">Модели</div>

		<table id="admin-models" class="table-striped table table-hover">

			<thead>
				<tr style="position:relative">
					<th style="width:30px">№</th>
					<th>Имя</th>
					<th>Url</th>
				</tr>
			</thead>

			{{#each models}}

				<tr class="model"
				data-id="{{id}}"
				data-title="{{title}}"
				data-url="{{url}}">
					<td>{{id}}</td>
					<td>{{title}}</td>
					<td>{{url}}</td>
				</tr>

			{{/each}}

		</table>

	</div>

	<div id="admin-edit-button" class="popup_button">
		Принять изменения
	</div>

</script>