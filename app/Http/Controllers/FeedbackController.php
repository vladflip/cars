<?php namespace App\Http\Controllers;

class FeedbackController extends Controller {

	public function index() {

		$data = \App\Type::with(['makes' => function($q){
			$q->has('feedbacks');
		}])->get();

		return view('parts.feed.main')
			->with('types', $data);

	}

	public function by_make($type, $make) {

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
		->orderBy('created_at', 'desc')
		// ->orderByRaw('(likes_count - dislikes_count) * -1')
		->get();

		$bread = ['make' => $m, 'type' => $t];

		return view('parts.feed.make')
			->with('models', $models)
			->with('make', $m)
			->with('type', $t)
			->with('feeds', $feeds)
			->with('bread', $bread);

	}

	public function by_model($type, $make, $model) {

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
		->orderBy('created_at', 'DESC')
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

		$opts = [
			['1'],
			['2'],
			['21','12'],
			['22', '13', '31'],
			['23', '32', '14', '41'],
			['33', '42', '51', '15', '24'],
			['25', '34', '52', '43'],
			['35', '53'],
			['45', '54'],
			['55']
		];

		$mention = \App\Feedback::with('user')
			->with('likes')
			->with('dislikes')
			->with('comments')
			->with('type')
			->with('model')
			->with('make')
			->with('photos')
			->find($id);

		$option = 0;

		if(count($mention->photos)>0){
			$row = count($mention->photos)-1;
			$col = count($opts[$row]);
			$randOption = rand(0, $col-1);

			$option = $opts[$row][$randOption];
		}

		$bread = [
			'model' => $mention->model, 
			'make' => $mention->make, 
			'type' => $mention->type, 
			'mention' => true];

		return view('pages.mention')
			->with('mention', $mention)
			->with('option', $option)
			->with('bread', $bread);


	}

	public function create() {

		$input = (object)\Input::all();

		$content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $input->content);

		$content = preg_replace('/<img[^>]+\>/i', '', $content);

		$feedback = new \App\Feedback([

			'header' => $input->header,
			'content' => $content

		]);

		$feedback->type_id = $input->type;

		if(\App\Make::isInType($input->make, $input->type))
			$feedback->make_id = $input->make;
		else
			return 'hello lamer';

		$feedback->user_id = \Auth::id();

		if(\App\CarModel::isInMake($input->model, $input->make))
			$feedback->model_id = $input->model;
		else
			return 'hello lamer';

		$feedback->save();

		if(isset($input->images)){

			if( count($input->images) > 10 )
				return 'hello lamer';

			foreach ($input->images as $src) {

				$name = md5(\Hash::make($src . \Auth::id()));

				$dirname = 'img/user' . \Auth::id() . '/feedbacks';

				$fullname = $dirname . '/' . $name . '.jpg';

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
			$feedback->logo = \URL::to('/') . '/img/feedback.png';
		}

		if(isset($input->pluses)){

			foreach ($input->pluses as $text) {

				if(strlen($text) == 0) {
					return 'hello lamer';
				}
				
				$plus = new \App\Plus(['text' => $text]);

				$plus->feedback_id = $feedback->id;

				$plus->save();

			}

		}

		if(isset($input->minuses)){

			foreach ($input->minuses as $text) {

				if(strlen($text) == 0) {
					return 'hello lamer';
				}
				
				$minus = new \App\Minus(['text' => $text]);

				$minus->feedback_id = $feedback->id;

				$minus->save();

			}

		}

		$feedback->save();

		return 'ok';

	}

	public function vote() {

		$id = \Input::get('id');

		$type = \Input::get('type');

		$feedback = \App\Feedback::find($id);

		$hasLike = $feedback->likes->contains( \Auth::id() );

		$hasDislike = $feedback->dislikes->contains( \Auth::id() );

		if( $type == 'likes' ) {

			if( $hasLike ) {

				$feedback->detach_like( \Auth::id() );

			} else {

				$feedback->attach_like( \Auth::id() );

				if( $feedback->dislikes->contains( \Auth::id() ) )
					$feedback->detach_dislike( \Auth::id() );

			}
				
		} else if( $type == 'dislikes' ) {

			if( $hasDislike ) {

				$feedback->detach_dislike( \Auth::id() );

			} else {

				$feedback->attach_dislike( \Auth::id() );

				if( $feedback->likes->contains( \Auth::id() ) )
					$feedback->detach_like( \Auth::id() );

			}

		}

	}

}
