<?php

Admin::model(App\Make::class)->title('Марки')
->as('makes')
->with('models')
->columns(function ()
{

	Column::string('id', '№');

	Column::string('title', 'Марка');
	Column::lists('models.title', 'Модели');

	Column::string('name', 'Url');

	Column::soviet();

})->form(function ()
{

	FormItem::text('title', 'Марка');

	FormItem::select('soviet', 'Советская')
	->list([0 => 'Нет', 1 => 'Да']);

	FormItem::text('name', 'Url')->unique()->validationRule('url');

});