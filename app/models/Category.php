<?php

class Category extends \Eloquent {
	public static $rules = ['name' => 'required|max:255|alphaNum'];

	protected $fillable = ['name']; // this is the only field on the table
	protected $guarded = null;

	protected $table = 'category';
	protected $primaryKey = 'name';

	public $timestamps = false;
	public $incrementing = false;

}