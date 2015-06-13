<?php namespace App\Http\Controllers;

class FeedbackController extends Controller {

	public function index() {

		$data = \App\Type::with(['makes' => function($q){
			$q->has('feedbacks');
			$q->with('feedbacks');
		}])->get();

		return view('parts.feed.main')
			->with('makes', $data);

	}

	public function make($type, $make) {

		$t = \App\Type::whereName($type)->first();

		if(!$t) {
			abort(404);
		}

		$m = \App\Make::whereName($make)->first();

		if(!$m) {
			abort(404);
		}

		$models = \App\CarModel::where('make_id', '=', $m->id)
		->has('feedbacks')
		->with('feedbacks')
		->get();

		$feeds = \App\Feedback::where('make_id', '=', $m->id)
		->with('user')
		->with('likes')
		->with('dislikes')
		->get();

		$bread = ['make' => $m, 'type' => $t];

		return view('parts.feed.make')
			->with('models', $models)
			->with('make', $m)
			->with('type', $t)
			->with('feeds', $feeds)
			->with('bread', $bread);

	}

	public function model($type, $make, $model) {

		$t = \App\Type::whereName($type)->first();

		if(!$t) {
			abort(404);
		}

		$ma = \App\Make::whereName($make)->first();

		if(!$ma) {
			abort(404);
		}

		$mo = \App\CarModel::whereName($model)->first();

		if(!$mo) {
			abort(404);
		}

		$feeds = \App\Feedback::where('model_id', '=', $mo->id)
		->with('user')
		->with('likes')
		->with('dislikes')
		->get();

		$bread = ['model' => $mo, 'make' => $ma, 'type' => $t];

		return view('parts.feed.model')
			->with('model', $mo)
			->with('feeds', $feeds)
			->with('bread', $bread);

	}

	public function mention($id) {

		$f = \App\Feedback::select('id')->find($id);

		if(!$f)
			abort(404);

		$mention = \App\Feedback::with('user')
			->with('likes')
			->with('dislikes')
			->with('comments')
			->with('type')
			->with('model')
			->with('make')
			->find($id);

		$bread = [
			'model' => $mention->model, 
			'make' => $mention->make, 
			'type' => $mention->type, 
			'mention' => true];

		return view('pages.mention')
			->with('mention', $mention)
			->with('bread', $bread);


	}

}
