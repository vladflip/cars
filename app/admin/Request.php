<?php

Admin::model(App\Request::class)->title('Заказы')
->as('requests')
->with(['make', 'model', 'user'])
->columns(function ()
{

	Column::status();

	Column::string('id', '№');

	Column::string('user.name', 'Пользователь');

	Column::info();
	Column::string('created_at', 'Дата создания');

})->form(function ()
{

	FormItem::select('status', 'Статус')
	->list([1 => 'Подтвержден', 2 => 'Отклонен']);



});