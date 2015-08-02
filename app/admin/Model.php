<?php

Admin::model(App\CarModel::class)->title('Модели')
->as('models')
->with('make')
->columns(function ()
{

	Column::string('id', '№');

	Column::string('make.title', 'Марка');
	Column::string('title', 'Модель');

})->form(function ()
{

	FormItem::text('make.title', 'Марка');

	FormItem::text('title', 'Модель');

});