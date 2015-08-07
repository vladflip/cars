<link rel="stylesheet" href="{{ URL::to('/') }}/css/style.css">
<link rel="stylesheet" href="{{ URL::to('/') }}/css/vendor/popup.css">

<table id="admin-makes" class="table-striped table table-hover">

	<thead>
		<tr>
			<th style="width:30px">№</th>
			<th>Марка</th>
			<th>Url</th>
			<th>Модели</th>
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
						data-url="{{ $model->name }}">
							<td>{{ $model->title }}</td>
						</tr>

					@endforeach
				</table>
			</td>
		</tr>

	@endforeach

</table>

<div id="csrf" data-csrf="{{ csrf_token() }}" data-home="{{ route('home') }}"></div>

<div id="admin-popup" style="width:800px" class="mfp-hide popup"></div>

@include('templates.admin-makes')


<script src="{{ URL::to('/') }}/js/vendor/jquery-ui.js"></script>
<script src="{{ URL::to('/') }}/js/vendor/handlebars.js"></script>
<script src="{{ URL::to('/') }}/js/vendor/underscore.js"></script>
<script src="{{ URL::to('/') }}/js/vendor/backbone.js"></script>
<script src="{{ URL::to('/') }}/js/vendor/selectbox.js"></script>
<script src="{{ URL::to('/') }}/js/vendor/popup.js"></script>
<script src="{{ URL::to('/') }}/js/admin.js"></script>