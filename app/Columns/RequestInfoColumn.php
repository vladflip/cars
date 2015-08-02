<?php namespace App\Columns;

use SleepingOwl\Admin\Columns\Interfaces\ColumnInterface;

class RequestInfoColumn implements ColumnInterface {

	// public function __construct($name) {
	// 	$this->name = $name;
	// }

	public function renderHeader() {
		return '<th style="width: 100px">Тело заказа</th>';
	}

	public function render($instance, $totalCount) {

		return view('admin.request-info')
			->with([
				'type' => $instance->type->title,
				'text' => $instance->text,
				'make' => $instance->make->title,
				'model' => $instance->model->title,
				'old' => $instance->old,
				'new' => $instance->new,
				'year' => $instance->year
			]);

	}

	public function getName() {
		return 'status';
	}

	public function isHidden() {
		// return false to display this column
		// return true to hide this column (used for column appendants)
		return false;
	}

}