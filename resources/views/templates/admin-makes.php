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

		<div id="new-model" style="width:130px" class="btn btn-primary navbar-btn">
			<i class="fa fa-plus"></i>
			Новая модель
		</div>

		<table id="admin-models" class="table-striped table table-hover">

			<thead>
				<tr style="position:relative">
					<th style="width:30px">№</th>
					<th>Имя</th>
					<th>Url</th>
					<th style="width:200px">Тип</th>
					<th style="width:90px"></th>
				</tr>
			</thead>

			{{#each models}}

				<tr class="model"
				data-id="{{id}}"
				data-title="{{title}}"
				data-url="{{url}}"
				data-type-id="{{type_id}}"
				data-type-title="{{type_title}}">
					<td>{{id}}</td>
					<td>{{title}}</td>
					<td>{{url}}</td>
					<td>{{type_title}}</td>
					<td>
						<div class="btn btn-default btn-sm edit-model">
							<i class="fa fa-pencil"></i>
						</div>
						<div class="btn btn-danger btn-sm btn-delete delete-model">
							<i class="fa fa-times"></i>
						</div>
					</td>
				</tr>

			{{/each}}

		</table>

	</div>

	<div id="admin-edit-button" class="popup_button">
		Принять изменения
	</div>

</script>

