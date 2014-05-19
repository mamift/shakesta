<?php

class Url extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// fillable fields
	protected $fillable = [];

	// hidden
	protected $hidden = ['created_at_datetime', 'updated_at_datetime', 'url_id'];

	protected $table = 'url';

	protected $primaryKey = 'url_id';

	protected $appends = array('created_at_datetime','updated_at_datetime','id');

	public function getCreatedAtDatetimeAttribute() {
		return date("l jS F Y h:i:s A", strtotime($this->attributes['created_at']));
	}

	public function getUpdatedAtDatetimeAttribute() {
		return date("l jS F Y h:i:s A", strtotime($this->attributes['updated_at']));	
	}

	public function getIdAttribute() {
		return $this->attributes['url_id'];
	}
}