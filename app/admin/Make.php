<?php

Admin::model(App\Make::class)->title('Марки')
->as('makes')
->with('models')
->columns(function ()
{

	Column::string('id', 'id');

	Column::string('title', 'Марка');
	Column::lists('models.title', 'Модели');

})->form(function ()
{

	FormItem::text('title', 'Марка');

});