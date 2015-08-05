<?php

Admin::model(App\CarModel::class)->title('Модели')
->as('models')
->with('make')
->columns(function ()
{

	Column::string('id', '№');

	Column::string('title', 'Модель');

	Column::string('make.title', 'Марка');

	Column::string('name', 'Url');


})->form(function ()
{

	FormItem::text('make.title', 'Марка');

	FormItem::text('title', 'Модель');

	FormItem::text('name', 'Url');

});