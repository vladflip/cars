<link rel="stylesheet" href="{{ URL::to('/') }}/css/admin.css">
<link rel="stylesheet" href="{{ URL::to('/') }}/css/vendor/popup.css">

<h1 class="admin_header">Марки и модели</h1>

<hr>

<div id="new-make" style="width:200px" class="btn btn-primary navbar-btn">
	<i class="fa fa-plus"></i>
	Новая марка-модель
</div>

<table id="admin-makes" class="table-striped table table-hover">

	<thead>
		<tr>
			<th style="width:30px">№</th>
			<th>Марка</th>
			<th>Url</th>
			<th>Модели</th>
			<th style="width:90px"></th>
		</tr>
	</thead>
	
	@foreach($makes as $make)

		<tr class="make"
			data-id="{{ $make->id }}"
			data-title="{{ $make->title }}"
			data-url="{{ $make->name }}">
			<td>{{ $make->id }}</td>
			<td>{{ $make->title }}</td>
			<td>{{ $make->name }}</td>
			<td>
				<table class="table-striped table">
					
					@foreach($make->models as $model)

						<tr class="model"
						data-id="{{ $model->id }}"
						data-title="{{ $model->title }}"
						data-url="{{ $model->name }}"
						data-type-id="{{ $model->type->id }}"
						data-type-title="{{ $model->type->title }}">
							<td>{{ $model->title }}</td>
						</tr>

					@endforeach
				</table>
			</td>
			<td>
				<div class="btn btn-default btn-sm edit-make">
					<i class="fa fa-pencil"></i>
				</div>
				<div class="btn btn-danger btn-sm delete-make">
					<i class="fa fa-times"></i>
				</div>
			</td>
		</tr>

	@endforeach

</table>

<div id="types">
	
	@foreach($types as $type)

		<div data-id="{{ $type->id }}"
			data-title="{{ $type->title }}"></div>

	@endforeach

</div>

<div id="csrf" data-csrf="{{ csrf_token() }}" data-home="{{ route('home') }}"></div>

<div id="admin-popup" style="width:800px" class="mfp-hide popup"></div>

@include('templates.admin-makes')


<script src="{{ URL::to('/') }}/js/vendor/jquery-ui.js"></script>
<script src="{{ URL::to('/') }}/js/vendor/handlebars.js"></script>
<script src="{{ URL::to('/') }}/js/vendor/underscore.js"></script>
<script src="{{ URL::to('/') }}/js/vendor/bootbox.min.js"></script>
<script src="{{ URL::to('/') }}/js/vendor/backbone.js"></script>
<script src="{{ URL::to('/') }}/js/vendor/selectbox.js"></script>
<script src="{{ URL::to('/') }}/js/vendor/popup.js"></script>
<script src="{{ URL::to('/') }}/js/admin.js"></script>