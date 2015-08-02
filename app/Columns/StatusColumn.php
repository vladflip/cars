<?php namespace App\Columns;

use SleepingOwl\Admin\Columns\Interfaces\ColumnInterface;

class StatusColumn implements ColumnInterface {

	public function renderHeader() {
		return '<th style="width: 100px">Статус</th>';
	}

	public function render($instance, $totalCount) {

		$content = '';
		$color = '';

		if($instance->status == 0){
			$content = 'На проверке';
			$color = '#c9302c';
		} else if($instance->status == 1) {
			$content = 'Подтвержден';
			$color = 'green';
		} else {
			$content = 'Отклонен';
		}

		return "<td style='color: $color'>" . $content . '</td>';
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