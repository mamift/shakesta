<?php

class Url extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// fillable fields
	protected $fillable = [];

	// hidden
	protected $hidden = [];

	protected $table = 'url';
}