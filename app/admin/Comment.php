<?php

Admin::model(App\Comment::class)->title('Комментарии')
->as('comments')
->with(['feedback', 'user'])
->columns(function ()
{

	Column::string('id', '№');

	Column::string('text', 'Текст');

	Column::string('feedback.header', 'Отзыв');

	Column::string('user.name', 'Пользователь');


})->form(function ()
{

	FormItem::textarea('text', 'Текст');

});