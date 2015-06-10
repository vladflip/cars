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

		return view('parts.feed.make')
			->with('models', $models)
			->with('make', $m)
			->with('feeds', $feeds);

	}

}
