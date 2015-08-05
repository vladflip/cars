<?php namespace App\Columns;

use SleepingOwl\Admin\Columns\Interfaces\ColumnInterface;

class SovietColumn implements ColumnInterface {

	// public function __construct($name) {
	// 	$this->name = $name;
	// }

	public function renderHeader() {
		return '<th style="width: 10px">Советская</th>';
	}

	public function render($instance, $totalCount) {

		$content = '';

		if($instance->soviet)
			$content = 'Да';
		else
			$content = 'Нет';

		return "<td> $content </td>";

	}

	public function getName() {
		return 'soviet';
	}

	public function isHidden() {
		// return false to display this column
		// return true to hide this column (used for column appendants)
		return false;
	}

}