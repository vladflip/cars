<?php namespace App\Columns;

use SleepingOwl\Admin\Columns\Interfaces\ColumnInterface;

class PageContentColumn implements ColumnInterface {

	// public function __construct($name) {
	// 	$this->name = $name;
	// }

	public function renderHeader() {
		return '<th style="width: 10px">Содержание</th>';
	}

	public function render($instance, $totalCount) {

		return "<td> $instance->content </td>";

	}

	public function getName() {
		return 'content';
	}

	public function isHidden() {
		// return false to display this column
		// return true to hide this column (used for column appendants)
		return false;
	}

}