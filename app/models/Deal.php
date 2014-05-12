<?php

class Deal extends Eloquent {
	
	// validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// hidden
	protected $hidden = ['deal_id'];

	protected $table = 'deal';
	protected $primaryKey = 'deal_id';

	public $timestamps = true;
	public $incrementing = true;

	// these fields are mass-assignable
	protected $fillable = ['price_discount','terms','expires_time','begins_time','category'];

	// these fields aren't
	protected $guarded = ['deal_id'];

	protected $appends = array('begins_datetime','exprires_datetime','created_at_datetime','updated_at_datetime','id');

	public function getBeginsDatetimeAttribute() {
		return date("l jS F Y h:i:s A", strtotime($this->attributes['begins_time']));
	}

	public function getExpiresDatetimeAttribute() {
		return date("l jS F Y h:i:s A", strtotime($this->attributes['expires_time']));
	}

	public function getCreatedAtDatetimeAttribute() {
		return date("l jS F Y h:i:s A", strtotime($this->attributes['created_at']));
	}

	public function getUpdatedAtDatetimeAttribute() {
		return date("l jS F Y h:i:s A", strtotime($this->attributes['updated_at']));	
	}

	public function getIdAttribute() {
		return $this->attributes['deal_id'];
	}

}