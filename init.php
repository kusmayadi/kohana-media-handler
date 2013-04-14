<?php defined('SYSPATH') or die('No direct script access.');

Route::set('image', 'img(/<width>x<height>(/<file>))', array('width' => '[0-9]+', 'height' => '[0-9]+', 'file' => '[a-zA-Z0-9\/.]+'))
	->defaults(array(
		'controller' => 'image',
		'action' => 'index'
));
