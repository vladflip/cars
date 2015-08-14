<?php

Admin::model(App\Company::class)->title('Компании')
->as('companies')
->with(['makes.models', 'user', 'models'])
->denyCreating()
->columns(function ()
{

	Column::string('id', '№');
	Column::string('name', 'Имя');

	Column::string('user.name', 'Пользователь');

	Column::lists('makes.title', 'Марки');
	Column::lists('models.title', 'Модели');

})->form(function ()
{

	FormItem::text('name', 'Name');

});