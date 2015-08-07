<script id="admin-makes-template" type="text/x-handlebars-template">

	<div class="popup_field">
								
		<div class="popup_label">Имя</div>

		<input id="create-company-address" type="text" class="popup_input" value="{{title}}">

	</div>

	<div class="popup_field">
								
		<div class="popup_label">Url</div>

		<input id="create-company-address" type="text" class="popup_input" value="{{url}}">

	</div>

	<div class="popup_field">
								
		<div class="popup_label">Модели</div>

		<table id="admin-makes" class="table-striped table table-hover">

			<thead>
				<tr>
					<th style="width:30px">№</th>
					<th>Имя</th>
					<th>Url</th>
				</tr>
			</thead>

			{{#each models}}

				<tr>
					<td>{{id}}</td>
					<td>{{title}}</td>
					<td>{{url}}</td>
				</tr>

			{{/each}}

		</table>

	</div>

	<div id="edit-button" class="popup_button">
		Принять изменения
	</div>

</script>