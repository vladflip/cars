<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model as Model;

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		DB::disableQueryLog();

		$this->call('TypeSeeder');

		$this->call('MakeCarModelSeeder');

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

class TypeSeeder extends Seeder {

	public function run() {

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
			<g id="#7e7e7eff">
			<path fill="#7e7e7e" opacity="1" d="M42.79 1.64C43.36-0.22 45.56 0.31 46.98 0.47 49.44 0.82 51.64 2.11 53.52 3.69 50.82 3.87 48.11 3.81 45.41 3.8 45.33 11.38 45.23 18.98 45.41 26.56 45.78 26.77 46.53 27.18 46.9 27.38 47.11 19.92 46.94 12.46 47 5 53.11 4.89 59.31 5.11 65.19 6.93 66.54 7.37 67.93 8 68.81 9.18 69.36 12.62 68.13 17.15 71.43 19.53 73.78 20.35 76.52 19.89 78.66 21.31 79.26 24.29 79.35 27.58 78.42 30.49 77.78 32.22 75.78 31.96 74.32 32.12 73.47 29.42 72.12 26.29 68.95 25.83 65.14 24.9 61.92 28.15 61.45 31.73 52.04 31.96 42.62 31.86 33.2 31.96 33.23 29.28 31.58 26.69 28.91 26.01 26.34 24.97 23.85 26.55 21.94 28.13 21.96 29.41 21.98 30.69 21.99 31.97 21.35 31.94 20.09 31.87 19.45 31.83 19.14 27.82 14.99 24.48 11.03 26.1 8.42 26.81 7.49 29.51 6.61 31.76 5.51 31.73 4.41 31.69 3.32 31.67 2.85 31.29 1.93 30.53 1.47 30.15 1.39 27.86 1.35 25.58 1.3 23.3 14.27 23.24 27.24 23.23 40.21 23.26 40.49 16.05 40.05 8.45 42.79 1.64M53.99 7.87C54.29 11.34 54.59 14.8 54.88 18.27 59.38 18.64 63.9 18.79 68.41 18.64 67.77 15.64 67.48 12.15 64.88 10.1 61.86 7.55 57.7 7.64 53.99 7.87Z"/>
			<path fill="#7e7e7e" opacity="1" d="M11.53 27.59C14.94 25.99 19.01 30.09 17.45 33.5 16.35 36.44 12.1 37.54 9.91 35.11 7.41 32.99 8.53 28.59 11.53 27.59Z"/>
			<path fill="#7e7e7e" opacity="1" d="M25.57 27.57C28.99 26.02 33.02 30.13 31.44 33.52 30.32 36.47 26.04 37.54 23.88 35.08 21.4 32.94 22.57 28.54 25.57 27.57Z"/>
			<path fill="#7e7e7e" opacity="1" d="M66.48 27.46C70.33 26.01 74.15 31.3 71.5 34.48 69.77 37.22 65.38 37 63.8 34.24 62.08 31.82 63.72 28.2 66.48 27.46Z"/>
			</g>
			</svg>',

			'<svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" viewBox="0 0 80 40" version="1.1">
			<g id="#7e7e7eff">
			<path fill="#7e7e7e" opacity="1" d="M6.88 10.97C7.85 8.5 10.24 6.72 12.95 7.04 28.95 7.11 44.96 6.89 60.94 7.17 69.45 8.94 73.57 18.25 74.25 26.13 74.52 30.29 70.03 31.99 66.59 32.06 65.88 29.24 64.14 26.24 60.93 25.95 57.14 25.35 54.4 28.76 53.63 32.1 47.55 32.16 41.47 32.18 35.39 32.24 34.53 28.92 31.94 25.39 28.07 25.93 24.43 26.25 22.74 29.91 22.04 33.04 20.15 30.31 19.02 25.98 14.96 25.93 11.02 25.49 8.66 29.24 7.96 32.61 6.4 31.46 4.11 30.38 4.46 28.04 4.46 22.3 4.57 16.31 6.88 10.97M11.12 9.24C7.87 11.48 8.03 16 7.22 19.46 20.95 19.56 34.68 19.49 48.41 19.5 48.78 16.03 49.22 12.56 49.67 9.1 36.82 9.19 23.96 8.88 11.12 9.24M52.32 9.12C51.88 12.66 51.44 16.2 51.05 19.74 58.04 21.34 65.03 22.91 72.02 24.51 70.65 19.68 69.4 14.09 64.84 11.21 61.28 8.36 56.54 9.13 52.32 9.12Z"/>
			<path fill="#7e7e7e" opacity="1" d="M11.14 29.07C13.38 26.33 17.34 27.74 19.16 30.21 19.47 32.99 18.3 36.44 15.06 36.66 11.1 37.35 8.15 31.9 11.14 29.07Z"/>
			<path fill="#7e7e7e" opacity="1" d="M28.41 27.55C32 27.08 34.81 31.7 32.61 34.6 30.89 37.46 26.23 37.31 24.72 34.33 22.95 31.6 25.26 27.68 28.41 27.55Z"/>
			<path fill="#7e7e7e" opacity="1" d="M59.43 27.6C62.61 26.95 65.74 30.46 64.57 33.53 63.62 36.76 58.96 37.8 56.79 35.19 54.2 32.81 55.98 27.95 59.43 27.6Z"/>
			</g>
			</svg>',

			'<svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" viewBox="0 0 80 40" version="1.1">
			<g id="#7e7e7eff">
			<path fill="#7e7e7e" opacity="1" d="M5.59 15.93C5.57 12.68 8.76 10 11.95 10.22 22.3 10.15 32.65 10.22 43 10.19 43 15.77 43 21.35 43 26.93 35.34 26.43 27.39 28.13 19.98 25.65 15.36 27.39 10.42 26.92 5.58 26.92 5.66 23.26 5.51 19.59 5.59 15.93Z"/>
			<path fill="#7e7e7e" opacity="1" d="M44 10.21C46.91 10.27 50.08 9.67 52.77 11.11 56.17 12.97 58.96 15.73 62.31 17.66 66.29 20.14 70.84 21.45 75.29 22.82 75.42 24.18 75.58 25.53 75.79 26.88 70.83 27.02 65.82 27.25 61.06 25.69 55.6 27.82 49.69 26.63 44 26.93 44 21.36 44 15.78 44 10.21M48.45 12.08C48.44 14.78 48.46 17.49 48.45 20.19 53.4 20.18 58.34 20.15 63.29 20.26 59.55 18.28 56.04 15.92 52.69 13.35 51.51 12.31 49.9 12.32 48.45 12.08Z"/>
			<path fill="#7e7e7e" opacity="1" d="M18.49 27.51C22.13 26 26.08 30.66 24.01 33.99 22.56 36.92 18.15 37.32 16.27 34.61 14.23 32.29 15.63 28.36 18.49 27.51Z"/>
			<path fill="#7e7e7e" opacity="1" d="M59.51 27.65C62.73 26.02 66.78 29.49 65.81 32.91 65.14 36 60.93 37.63 58.49 35.47 55.62 33.62 56.4 28.77 59.51 27.65Z"/>
			<path fill="#7e7e7e" opacity="1" d="M5.23 28.63C8.39 28.59 11.55 28.46 14.72 28.52 14.44 29.31 13.9 30.9 13.62 31.7 10.6 31.49 5.73 33.06 5.23 28.63Z"/>
			<path fill="#7e7e7e" opacity="1" d="M25.06 28.5C35.43 28.57 45.81 28.55 56.19 28.51 55.69 29.62 55.19 30.74 54.71 31.85 45.24 31.79 35.78 31.98 26.32 31.91 26 31.06 25.37 29.35 25.06 28.5Z"/>
			<path fill="#7e7e7e" opacity="1" d="M66.53 28.53C69.47 28.51 72.41 28.51 75.35 28.62 73.43 30.97 70.48 31.7 67.6 31.83 67.33 31 66.8 29.35 66.53 28.53Z"/>
			</g>
			</svg>',

			'<svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" viewBox="0 0 80 40" version="1.1">
			<g id="#7e7e7eff">
			<path fill="#7e7e7e" opacity="1" d="M1.7 20.74C27.36 20.74 53.01 20.72 78.67 20.76 78.65 22.8 78.63 24.85 78.63 26.89 74.34 26.79 69.9 27.56 65.79 25.99 63.16 25.12 60.72 27.25 58.06 26.95 51.01 26.9 43.96 26.97 36.92 26.92 34.31 26.95 31.81 24.92 29.23 26.18 24.91 27.65 20.21 27.08 15.95 25.7 11.34 27.21 6.51 27.03 1.72 26.92 1.72 24.86 1.71 22.8 1.7 20.74Z"/>
			<path fill="#7e7e7e" opacity="1" d="M14.44 27.49C16.9 26.56 19.96 28.41 20.28 31.02 21.48 35.06 15.69 38.32 12.79 35.28 9.96 33.17 11.16 28.39 14.44 27.49Z"/>
			<path fill="#7e7e7e" opacity="1" d="M29.49 27.65C32.69 26.01 36.72 29.48 35.79 32.89 35.08 36.26 30.28 37.76 27.97 35.04 25.62 32.99 26.63 28.68 29.49 27.65Z"/>
			<path fill="#7e7e7e" opacity="1" d="M62.54 27.67C65.75 25.99 69.86 29.45 68.88 32.9 68.19 36.3 63.34 37.73 61.05 35.01 58.71 32.97 59.72 28.73 62.54 27.67Z"/>
			<path fill="#7e7e7e" opacity="1" d="M69.6 28.56C72.59 28.5 75.6 28.42 78.58 28.76 76.39 30.73 73.64 31.74 70.72 31.88 70.44 31.05 69.88 29.39 69.6 28.56Z"/>
			<path fill="#7e7e7e" opacity="1" d="M1.39 28.59C4.44 28.51 7.5 28.54 10.55 28.51 10.32 29.3 9.85 30.88 9.62 31.67 6.6 31.52 1.86 33 1.39 28.59Z"/>
			<path fill="#7e7e7e" opacity="1" d="M36.53 28.52C44.09 28.54 51.64 28.56 59.2 28.51 58.78 29.64 58.3 30.75 57.77 31.83 51.03 31.86 44.3 31.96 37.56 31.9 37.3 31.06 36.78 29.36 36.53 28.52Z"/>
			</g>
			<g id="#767676ef">
			<path fill="#767676" opacity="0.94" d="M20.85 28.5C22.63 28.5 24.4 28.49 26.17 28.49 25.68 29.66 25.2 30.83 24.73 32.01 24.12 32.01 22.9 32.01 22.28 32.01 21.86 30.82 21.38 29.65 20.85 28.5Z"/>
			</g>
			</svg>'
		];

		for ($i=1; $i < 5; $i++) { 

			\App\Type::create([

				'name' => $types2[$i-1],
				'title' => $types[$i-1],
				'icon' => $icons[$i-1]

			]);

		}

	}

}

class MakeCarModelSeeder extends Seeder {

	public function run() {

		$arr = Config::get('makemodel');

		$i = 1;

		foreach ($arr as $key => $makes) {
			
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