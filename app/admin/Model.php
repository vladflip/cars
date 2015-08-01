<?php

Admin::model(App\CarModel::class)->title('Модели')
->as('models')
->with('make')
->columns(function ()
{

	Column::string('id', 'id');

	Column::string('make.name', 'Марка');
	Column::string('title', 'Модель');

})->form(function ()
{

	FormItem::text('make.title', 'Марка');

	FormItem::text('title', 'Модель');

});