<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model as Model;

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		DB::disableQueryLog();

		$this->call('TypesMakeCarModelSeeder');

		$this->call('UserSeeder');

		$this->call('SpecSeeder');
		
		$this->call('CompanySeeder');

		$this->call('FeedbackSeeder');

		$this->call('CommentSeeder');

		$this->call('MinusSeeder');

		$this->call('PlusSeeder');

		$this->call('PhotoSeeder');

		$this->call('RequestSeeder');

		$this->call('ResponseSeeder');
	}

}

class FF {
	public static function get() {
		return Faker\Factory::create();
	}
}

class UserSeeder extends Seeder {

	public function run() {

		$f = FF::get();

		$count = \App\Make::count();

		for($i=0; $i < $count; $i++){

			App\User::create([
					'email' => $f->email,
					'password' => Hash::make($f->password),
					'name' => $f->name(),
					'about' => $f->paragraph(5),
					'address' => 'fuck',
					'phone' => '2340293',
					
					'confirmed' => 1
				]);

		}

		App\User::create([
			'email' => 'admin@mail.ru',
			'password' => Hash::make('admin'),
			'name' => 'admin',

			'confirmed' => 1
		]);

	}

}

class SpecSeeder extends Seeder {

	public function run() {

		$f = FF::get();

		$arr = [
			'Магазины запчастей', 'Разборки (б/у)',
			'Тех. центры', 'Автосервисы',
			'Мойки грузовые', 'Установка оборудования',
			'Шины и диски'
		];

		$arr2 = [
			'shops', 'oldparts', 'tech', 'services',
			'washes', 'partsetup', 'wheels'
		];

		for($i=0; $i < count($arr); $i++){

			App\Spec::create([
				'title' => $arr[$i],
				'name' => $arr2[$i]
			]);

		}

	}

}

class TypesMakeCarModelSeeder extends Seeder {

	public function run() {

		$arr = Config::get('makemodel');

		$i = 1;

		$types = [
			'Грузовики', 'Автобусы', 
			'Малый коммерческий траспорт', 'Прицепы'
		];

		$types2 = [
			'trucks', 'bus',
			'light-trucks', 'trailers'
		];

		foreach ($arr as $key => $makes) {

			\App\Type::create([

					'name' => $types2[$i-1],
					'title' => $types[$i-1],
					'icon' => "img/icon{$i}.jpg",
					'icon_active' => "img/icon{$i}-active.jpg"

				]);
			
			foreach ($makes as $k => $make) {
				
				$ma = (object)$make;

				if($ins = \App\Make::exists($ma->name)){

					$newmake = $ins;

				} else {

					$newmake = \App\Make::create([

						'name' => urlencode(strtolower($ma->name)),
						'title' => $ma->title,
						'soviet' => $ma->soviet

					]);

				}

				$newmake->types()->attach($i);

				foreach ($ma->models as $model) {

					$mo = (object)$model;

					$newmodel = new \App\CarModel([

						'name' => urlencode(strtolower($mo->name)),
						'title' => $mo->title,
						'type_id' => $i

					]);

					$newmodel->make()->associate($newmake);

					$newmodel->save();

				}


			}


			$i++;

		}

	}

}

class CompanySeeder extends Seeder {

	public function run() {

		$f = FF::get();

		$count = \App\Make::count();

		for($i=0; $i < $count; $i++){

			$model = \App\CarModel::getModelByMake($i+1);

			$c = \App\Company::create([
				'user_id' => $i+1,
				'name' => $f->company,
				'about' => $f->paragraph(5),
				'phone' => $f->phoneNumber,
				'address' => $f->address,
				'spec_id' => rand(1, 7),
				'logo' => 'http://lorempixel.com/100/100/business/',
				'type_id' => $model->type_id
			]);

			$c->models()->attach($model->id);

			$c->makes()->attach($i+1);

		}

	}

}

class FeedbackSeeder extends Seeder {

	public function run() {

		$f = FF::get();

		for($i=0; $i < 30; $i++){

			$id = $this->getModel($i+1);

			$feed = App\Feedback::create([

				'header' => $f->sentence(rand(3, 8)),
				'content' => $f->paragraph(5),
				'logo' => 'http://lorempixel.com/65/65/transport',

				'user_id' => $i+1,
				'type_id' => rand(1, 4),
				'make_id' => $i+1,
				'model_id' => $id
			]);

			$feed->likes()->attach($i+1);

			$feed->dislikes()->attach($i+1);

		}

	}

	public function getModel($id) {

		$m = \App\Make::with('models')->find($id);

		return rand($m->models[0]->id, count($m->models) + $m->models[0]->id - 1);

	}

}

class CommentSeeder extends Seeder {

	public function run() {

		$f = FF::get();

		for($i=0; $i < 10; $i++){

			App\Comment::create([
				'text' => $f->paragraph(5),

				'user_id' => $i+1,
				'feedback_id' => $i+1,
				'parent_id' => $i+1
			]);

		}

	}

}

class MinusSeeder extends Seeder {

	public function run() {

		$f = FF::get();

		for($i=0; $i < 10; $i++){

			App\Minus::create([

				'text' => $f->sentence(rand(4, 10)),
				'feedback_id' => $i+1
				
			]);

		}

	}

}

class PlusSeeder extends Seeder {

	public function run() {

		$f = FF::get();

		for($i=0; $i < 10; $i++){

			App\Plus::create([

				'text' => $f->sentence(rand(4, 10)),
				'feedback_id' => $i+1

			]);

		}

	}

}

class PhotoSeeder extends Seeder {

	public function run() {

		$f = FF::get();

		for($i=0; $i < 30; $i++){

			App\Photo::create([

				'src' => 'http://lorempixel.com/400/200/transport',
				'feedback_id' => $i+1

			]);

		}

	}

}

class RequestSeeder extends Seeder {

	public function run() {

		$f = FF::get();

		for($i=0; $i < 10; $i++){

			App\Request::create([

				'opened' => 0,
				'new' => 1,
				'year' => '1993',
				'text' => $f->paragraph(10),
				'old' => 1,
				
				'user_id' => $i+1,
				'type_id' => rand(1, 4),
				'make_id' => $i+1,
				'model_id' => $i+1

			]);

		}

	}

}

class ResponseSeeder extends Seeder {

	public function run() {

		$f = FF::get();

		for($i=0; $i < 10; $i++){

			App\Response::create([

				'text' => $f->paragraph(10),
				
				'request_id' => $i+1,
				'company_id' => $i+1

			]);

		}

	}

}