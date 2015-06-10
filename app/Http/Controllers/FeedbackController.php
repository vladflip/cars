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

	public function make() {

		return view('parts.feed.make');

	}

}
