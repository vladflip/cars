<?php

Admin::model(App\Request::class)->title('Заказы')
->as('requests')
->with(['make', 'model', 'user'])
->columns(function ()
{

	Column::string('id', 'id');

	Column::string('user.name', 'Пользователь');

	Column::string('make.title', 'Марка');
	Column::string('model.title', 'Модель');

})->form(function ()
{

	FormItem::text('name', 'Name');

});