<?php namespace App;

use \SleepingOwl\Models\SleepingOwlModel as Model;

class Page extends Model {

	protected $table = 'pages';

	protected $fillable = ['title', 'url', 'content', 'in_header'];

}