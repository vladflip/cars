<?php

Admin::model(App\User::class)->title('Пользователи')
->as('users')
->with('company.models')
->columns(function ()
{
	// Describing columns for table view
	Column::string('id', 'id');
	Column::string('name', 'Имя');
	Column::string('email', 'Email');
})->form(function ()
{
	// Describing elements in create and editing forms
	FormItem::text('name', 'Name');
	FormItem::text('email', 'Email');
});