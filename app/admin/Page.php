<?php

Admin::model(App\Page::class)->title('Страницы')
->as('pages')
->columns(function ()
{

	Column::string('id', '№');
	Column::string('title', 'Заголовок');
	Column::string('url', 'Url');
	Column::in_menu();

	Column::content();

})->form(function ()
{

	FormItem::text('title', 'Заголовок')->required();

	FormItem::textAddon('url', 'Url')->unique()->addon('komtrans-club.ru/page/')->placement('before');

	FormItem::select('in_header', 'В меню')->list( [0 => 'Нет', 1 => 'Да'] );

	FormItem::ckeditor('content', 'Содержание')->required();


});