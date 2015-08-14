<?php

Admin::model(App\Company::class)->title('Компании')
->as('companies')
->with(['makes.models', 'user', 'models'])
->denyCreating()
->columns(function ()
{
	
	Column::status();

	Column::string('id', '№');
	Column::string('name', 'Название');

	Column::string('user.name', 'Пользователь');

	Column::lists('makes.title', 'Марки');
	Column::lists('models.title', 'Модели');

})->form(function ()
{

	FormItem::select('status', 'Статус')
	->list([1 => 'Подтвержден', 2 => 'Отклонен']);

	FormItem::text('name', 'Name');

});