<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CommentController extends Controller {

	public function create() {

		$feedback = \Input::get('feedback');
		$content = \Input::get('comment');

		if( ! \App\Feedback::find($feedback) )
			return 'hello lamer';

		$comment = new \App\Comment;

		$comment->user_id = \Auth::id();

		$comment->feedback_id = $feedback;

		$comment->text = $content;

		$comment->save();

		return $comment;

	}

}
