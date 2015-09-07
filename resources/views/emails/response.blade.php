<p>
	По вашему запросу от {{ $request['created_at'] }} пришел ответ от компании {{ $company['name'] }}, <br>
	прочесть который возможно по <a href="{{ route('room', ['id' => $room['id']]) }}">этой ссылке</a>. <br>
	<br>
	Состав вашего заказа: <br>
	<strong>Тип:</strong> {{ $request['new'] ? 'новая' : '' }} {{ $request['old'] ? ', бу' : '' }} <br>
	<strong>Машина:</strong> {{ $request['type']['title'] }} -> {{ $request['make']['title'] }} -> {{ $request['model']['title'] }} <br>
	<strong>Год выпуска:</strong> {{ $request['year'] }} <br>
	<strong>Сообщение:</strong> {{ $request['text'] }}
</p>