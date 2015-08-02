<td style="padding:1px">
	<div>Текст:</div>
	<p>{{ $text }}</p>

	<div>Тип:</div>
	<b>{{ $type }}</b>

	<br>

	<div>Марка:</div>
	<b>{{ $make }}</b>

	<br>

	<div>Модель:</div>
	<b>{{ $model }}</b>

	<br>

	@if($new)
		<div>Новая</div>
	@endif

	@if($old)
		<div>Б\у</div>
	@endif

	<div>Год:</div>
	<b>{{ $year }}</b>

</td>