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

		// $this->call('RequestSeeder');

		// $this->call('ResponseSeeder');
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
					'email' => (rand(1, 10)) . $f->email,
					'password' => Hash::make($f->password),
					'name' => $f->name(),
					// 'about' => $f->paragraph(5),
					// 'address' => 'fuck',
					// 'phone' => '2340293',
					
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

		$icons = [
			'<svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" viewBox="0 0 80 40" version="1.1">
			  <g id="#d9d9d9ff">
			    <path fill="#d9d9d9" opacity="1" d="M36.78 2.66C37.35 0.78 39.53 1.3 40.97 1.47 43.34 1.92 45.77 2.84 47.26 4.85 44.64 4.87 42.03 4.79 39.41 4.78 39.31 12.38 39.29 19.99 39.38 27.59 39.76 27.77 40.53 28.15 40.91 28.34 41.1 21.01 40.95 13.69 41 6.36 44.44 6.51 47.94 5.96 51.32 6.63 55.08 8.26 57.55 11.71 60.6 14.3 64.07 17.51 68.24 19.85 72.64 21.51 76.41 22.58 77.34 28 74.68 30.62 73.07 32.34 70.6 32.48 68.43 32.92 67.37 30.37 66.07 27.28 62.96 26.83 59.19 25.9 55.82 29.14 55.49 32.76 44.47 32.92 33.45 32.95 22.43 32.88 22.23 28.84 18 25.5 14.07 27.09 11.47 27.78 10.45 30.44 9.65 32.73 7.54 32.71 5.43 32.68 3.32 32.68 2.86 32.3 1.93 31.54 1.47 31.16 1.4 28.87 1.35 26.59 1.29 24.3 12.27 24.2 23.24 24.28 34.22 24.26 34.48 17.05 34.06 9.48 36.78 2.66M48.88 8.91C48.86 12.37 48.87 15.82 48.86 19.28 53.74 19.27 58.62 19.26 63.51 19.35 59.61 16.65 56.16 13.41 52.73 10.15 51.75 9.04 50.19 9.2 48.88 8.91Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M14.55 28.58C17.96 27 22 31.1 20.45 34.5 19.35 37.44 15.11 38.55 12.93 36.12 10.39 34.01 11.53 29.57 14.55 28.58Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M60.44 28.48C64 27.13 67.7 31.52 65.93 34.83 64.66 37.49 60.86 38.39 58.69 36.27 55.87 34.13 57.13 29.33 60.44 28.48Z"/>
			  </g>
			</svg>',

			'<svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" viewBox="0 0 80 40" version="1.1">
			  <g id="#d9d9d9ff">
			    <path fill="#d9d9d9" opacity="1" d="M7.11 13.9C7.94 11.22 9.74 8.02 12.95 8.08 29.29 8.05 45.66 7.94 62 8.16 70.46 10.01 74.54 19.23 75.26 27.09 75.53 31.26 71.01 33.09 67.51 33.02 66.98 29.83 64.5 26.69 60.99 26.91 57.57 26.93 55.35 30.05 54.66 33.1 48.56 33.16 42.45 33.18 36.35 33.24 35.59 30.19 33.45 26.94 29.96 26.91 26.55 26.64 24.21 29.65 23.46 32.65 23.15 32.91 22.52 33.43 22.21 33.69 21.47 30.62 19.65 27.1 16.07 26.93 12.13 26.45 9.58 30.15 9 33.59 7.75 32.58 5.7 31.92 5.53 30.06 5.31 24.65 5.56 19.12 7.11 13.9M12.07 10.22C8.91 12.56 8.99 16.97 8.24 20.45 21.97 20.56 35.7 20.51 49.43 20.48 49.75 17.01 50.23 13.56 50.67 10.11 37.81 10.17 24.93 9.92 12.07 10.22M53.34 10.12C52.84 13.66 52.46 17.21 52.06 20.76 59.05 22.33 66.03 23.9 73.01 25.52 71.67 20.45 70.19 14.6 65.25 11.82 61.77 9.34 57.33 10.2 53.34 10.12Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M60.46 28.6C63.93 27.87 67.17 32.14 65.25 35.24 63.91 37.96 59.8 38.56 57.81 36.21 55.18 33.84 56.98 28.92 60.46 28.6Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M12.12 30.1C14.31 27.34 18.4 28.66 20.11 31.25 20.55 34.08 19.23 37.5 15.97 37.68 12.04 38.27 9.2 32.9 12.12 30.1Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M27.47 29.13C29.92 27.67 33.68 29.06 34.14 32 35.61 35.85 30.31 39.36 27.17 36.9 24.31 35.17 24.58 30.68 27.47 29.13Z"/>
			  </g>
			</svg>',

			'<svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" viewBox="0 0 80 40" version="1.1">
			  <g id="#d9d9d9ff">
			    <path fill="#d9d9d9" opacity="1" d="M6.64 13.01C7.16 10.06 9.71 6.99 12.97 7.31 24.99 7.3 37.02 7.35 49.04 7.29 52.6 7.28 55.02 10.41 57.45 12.59 60.98 16.35 65.36 19.19 70.19 20.97 72.64 21.74 73.97 24.14 73.8 26.65 69.92 26.51 65.85 27.43 62.12 26 59.71 24.82 57.44 27.03 54.99 26.77 44.65 26.68 34.31 26.77 23.97 26.73 22.15 26.61 20.44 25.16 18.59 25.79 14.76 27.38 10.58 26.57 6.56 26.7 6.68 22.14 6.46 17.57 6.64 13.01M48.75 10.37C48.63 13.15 48.8 15.93 48.68 18.72 53.08 18.9 57.49 18.78 61.9 18.86 58.52 16.62 55.59 13.82 52.65 11.05 51.58 10.2 49.8 8.68 48.75 10.37Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M16.07 29.08C17.42 26.33 22.66 26.36 23.11 29.8 23.56 29.24 24.02 28.68 24.47 28.13 34.81 28.37 45.17 28.41 55.5 28.11 55.97 28.67 56.43 29.24 56.9 29.81 57.28 26.28 62.72 26.36 64.01 29.19 66.23 32.22 62.15 36.74 58.93 35.13 56.46 34.01 56.33 31.02 55.2 28.89L54.51 31.14C44.73 31.33 34.94 31.25 25.16 31.25L24.92 28.77C23.65 30.96 23.54 34.03 20.97 35.23 17.67 36.61 13.76 32.08 16.07 29.08Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M6.11 28.56C9.03 28.15 11.98 28.26 14.92 28.31 14.47 29.29 14.01 30.27 13.52 31.23 11.65 31.2 9.79 31.16 7.93 31.17 7.47 30.52 6.56 29.21 6.11 28.56Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M65.09 28.33C67.75 28.24 70.41 28.18 73.07 28.44 71.33 29.99 69.06 31.15 66.72 31.17 65.82 30.47 65.57 29.31 65.09 28.33Z"/>
			  </g>
			</svg>',

			'<svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" viewBox="0 0 80 40" version="1.1">
			  <g id="#d9d9d9ff">
			    <path fill="#d9d9d9" opacity="1" d="M1.71 27.92C1.72 25.86 1.71 23.8 1.7 21.74 27.02 21.74 52.34 21.73 77.67 21.74 77.64 23.8 77.63 25.85 77.63 27.9 73.34 27.73 68.88 28.61 64.78 26.98 62.15 26.06 59.72 28.32 57.04 27.95 49.04 27.5 40.81 29 33.04 26.69 27.56 28.51 21.43 28.54 15.96 26.67 11.36 28.26 6.51 27.99 1.71 27.92Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M14.59 28.44C18.48 27.05 22.28 32.42 19.5 35.57 17.73 38.25 13.44 37.95 11.87 35.23 10.15 32.8 11.8 29.15 14.59 28.44Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M32.41 28.35C35.86 27.5 39.28 31.75 37.39 34.9 36.11 37.61 32.04 38.39 30.01 36.07 27.3 33.76 28.97 28.84 32.41 28.35Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M61.5 28.69C64.73 26.95 68.91 30.48 67.87 33.95 67.13 37.33 62.3 38.72 60.03 36 57.74 33.95 58.71 29.75 61.5 28.69Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M1.43 29.58C4.47 29.53 7.51 29.54 10.55 29.51 10.32 30.3 9.85 31.88 9.62 32.66 6.64 32.5 1.78 34.04 1.43 29.58Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M20.89 29.5C23.31 29.54 25.74 29.56 28.16 29.5 27.67 30.65 27.19 31.8 26.71 32.95 25.23 32.93 23.75 32.93 22.27 32.92 21.93 32.07 21.23 30.36 20.89 29.5Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M38.52 29.52C45.08 29.55 51.64 29.55 58.2 29.51 57.75 30.62 57.3 31.73 56.83 32.84 51.08 32.77 45.33 32.93 39.58 32.92 39.31 32.07 38.78 30.37 38.52 29.52Z"/>
			    <path fill="#d9d9d9" opacity="1" d="M68.61 29.53C71.56 29.53 74.51 29.5 77.46 29.61 75.53 31.95 72.57 32.71 69.67 32.83 69.41 32 68.88 30.35 68.61 29.53Z"/>
			  </g>
			</svg>'
		];

		foreach ($arr as $key => $makes) {

			\App\Type::create([

					'name' => $types2[$i-1],
					'title' => $types[$i-1],
					'icon' => $icons[$i-1]

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
				'logo' => 'img/company_logo.png',
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

			$feed->attach_like($i+1);

			$feed->attach_dislike($i+1);

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