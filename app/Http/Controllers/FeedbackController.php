<?php namespace App\Http\Controllers;

class FeedbackController extends Controller {

	public function index() {

		$data = \App\Type::with(['makes' => function($q){
			$q->has('feedbacks');
		}])->get();

		return view('parts.feed.main')
			->with('types', $data);

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

	public function create() {

		$input = (object)\Input::all();

		$feedback = new \App\Feedback([

			'header' => $input->header,
			'content' => $input->content

		]);

		$feedback->type_id = $input->type;

		if(\App\Make::isInType($input->make, $input->type))
			$feedback->make_id = $input->make;
		else
			return 'fuck';

		$feedback->user_id = \Auth::id();

		if(\App\CarModel::isInMake($input->model, $input->make))
			$feedback->model_id = $input->model;
		else
			return 'fuck';

		$feedback->save();

		if(isset($input->images)){

			foreach ($input->images as $src) {

				$name = md5(\Hash::make($src . \Auth::id()));

				$dirname = 'img/user' . \Auth::id();

				$fullname = $dirname . '/' . $name . 'jpg';

				if( ! file_exists($dirname) ){
					mkdir($dirname, 0777, true);
				}
				
				\Image::make($src)->save($fullname, 100);

					$photo = new \App\Photo(['src' => $fullname]);

					$photo->feedback_id = $feedback->id;

					$photo->save();

				$feedback->photos()->save($photo);

			}

		} else {
			$feedback->logo = URL::to('/') . '/feedback.png';
		}

		return $feedback;

	}

}
