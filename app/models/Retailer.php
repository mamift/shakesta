<?php

class Retailer extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['title','description'];

	// hidden
	protected $hidden = ['retailer_id'];

	protected $table = 'retailer';
	protected $primaryKey = 'retailer_id';

	public $timestamps = true;
	public $incrementing = true;

	// these fields aren't
	protected $guarded = ['retailer_id'];

	protected $appends = array('created_at_datetime','updated_at_datetime','id');

	public function getCreatedAtDatetimeAttribute() {
		return date("l jS F Y h:i:s A", strtotime($this->attributes['created_at']));
	}

	public function getUpdatedAtDatetimeAttribute() {
		return date("l jS F Y h:i:s A", strtotime($this->attributes['updated_at']));	
	}

	public function getIdAttribute() {
		return $this->attributes['retailer_id'];
	}
}