<?php

Admin::model(App\Feedback::class)->title('Отзывы')
->as('feedbacks')
->with(['make', 'model', 'user', 'likes', 'dislikes'])
->denyCreating()
->columns(function ()
{

	Column::string('id', 'id');
	Column::string('header', 'Заголовок');

	Column::string('user.name', 'Пользователь');

	Column::string('make.title', 'Марка');
	Column::string('model.title', 'Модель');

	Column::count('likes', 'Лайки');
	Column::count('dislikes', 'Дизлайки');

})->form(function ()
{

	FormItem::text('name', 'Name');

});