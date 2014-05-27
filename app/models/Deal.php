<?php

class Deal extends Eloquent {
	
	// validation rules here
	public static $rules = [
		'product_id' => 'required'
	];

	// hidden
	protected $hidden = ['deal_id','created_at','updated_at'];

	protected $table = 'deal';
	protected $primaryKey = 'deal_id';

	public $timestamps = true;
	public $incrementing = true;

	// these fields are mass-assignable
	protected $fillable = ['price_discount','terms','expires_time','begins_time','category','product_id'];

	// these fields aren't
	protected $guarded = ['deal_id'];

	protected $appends = ['id','begins_datetime','expires_datetime'];

	public function getIdAttribute() {
		return $this->attributes['deal_id'];
	}

	public function getBeginsDatetimeAttribute() {
		return date("l jS F Y h:i:s A", strtotime($this->attributes['begins_time']));
	}

	public function getExpiresDatetimeAttribute() {
		return date("l jS F Y h:i:s A", strtotime($this->attributes['expires_time']));	
	}

	public function product() {
		return $this->belongsTo('Product','product_id');
	}
}