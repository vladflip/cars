<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model as Model;

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		$this->call('UserSeeder');

		$this->call('SpecSeeder');
		
		$this->call('TypeSeeder');

		$this->call('MakeCarModelSeeder');
		
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

		for($i=0; $i < 30; $i++){

			App\User::create([
					'email' => $f->email,
					'password' => Hash::make($f->password),
					'name' => $f->name(),

					'is_admin' => 0,
					'confirmed' => 1
				]);

		}

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
				'name' => $arr2[$i],
				'icon' => $f->imageUrl(),
				'desc' => $f->paragraph(2)
			]);

		}

	}

}

class TypeSeeder extends Seeder {

	public function run() {

		Model::unguard();

		$f = FF::get();

		$arr = [
			'Грузовики', 'Автобусы', 
			'Малый коммерческий траспорт', 'Прицепы'
		];

		$arr2 = [
			'trucks', 'buses',
			'small', 'trailers'
		];

		for($i=0; $i < count($arr); $i++){

			$im = $i+1;

			App\Type::create([
				'name' => $arr2[$i],
				'title' => $arr[$i],
				'icon' => "img/icon{$im}.jpg",
				'icon_active' => "img/icon{$im}-active.jpg",
				'desc' => $f->paragraph(2)
			]);

		}

	}

}

class MakeCarModelSeeder extends Seeder {

	public function run() {

		$makes = Config::get('makemodel');

		$f = FF::get();

		$id = 1;

		foreach ($makes as $k => $v) {

			foreach ($v as $key => $value) {

				if(is_array($value)){

					foreach ($value as $ke => $val) {

						foreach ($val as $k2 => $v2) {

							if($k2 == 'title')
								continue;

							$m = App\CarModel::create([
								'name' => urlencode(strtolower($v2)),
								'title' => $v2,
								'icon' => $f->imageUrl(),
								'desc' => $f->paragraph(2),
								'make_id' => $id
							]);

							if($id%10 == 0)
								error_log($id);
						}

					}

				} else {

					if($key == 'value')
						continue;

					$m = App\Make::create([
						'title' => $value,
						'name' => urlencode(strtolower($value)),
						'icon' => $f->imageUrl(),
						'desc' => $f->paragraph(2)
					]);

					$m->types()->attach(1);

					$m->types()->attach(2);

				}

			}

			$id++;
		}

	}

}

class CompanySeeder extends Seeder {

	public function run() {

		Model::unguard();

		$f = FF::get();

		for($i=0; $i < 30; $i++){

			$c = App\Company::create([
				'user_id' => $i+1,
				'name' => $f->company,
				'description' => $f->paragraph(5),
				'phone' => $f->phoneNumber,
				'address' => $f->address,
				'spec_id' => rand(1, 7),
				'type_id' => rand(1, 4)
			]);

			$c->makes()->attach($i+1);

			$c->makes()->attach($i+2);

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