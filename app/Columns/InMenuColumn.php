<?php namespace App\Columns;

use SleepingOwl\Admin\Columns\Interfaces\ColumnInterface;

class InMenuColumn implements ColumnInterface {

	// public function __construct($name) {
	// 	$this->name = $name;
	// }

	public function renderHeader() {
		return '<th style="width: 10px">В меню</th>';
	}

	public function render($instance, $totalCount) {

		$content = '';
		$color = '#c9302c';

		if($instance->in_header){
			$content = 'Да';
			$color = 'green';
		}
		else
			$content = 'Нет';

		return "<td style='color:$color'> $content </td>";

	}

	public function getName() {
		return 'in_menu';
	}

	public function isHidden() {
		// return false to display this column
		// return true to hide this column (used for column appendants)
		return false;
	}

}