<?php

class ProductDeal extends \Deal {
	// validation rules here
	public static $rules = [
		'price_discount'  	=> 'required',
		'terms' 		 	=> 'required',
		'expires_time' 	 	=> 'required',
		'begins_time' 	 	=> 'required',
		'category' 		 	=> 'required',
		'product_id' 	 	=> 'required'
	];

	// hidden
	protected $hidden = ['created_at','updated_at'];

	protected $table = 'product_deals';
	protected $primaryKey = 'id';

	public $timestamps = true;
	public $incrementing = true;

	// these fields are mass-assignable
	protected $fillable = ['price_discount','terms','expires_time','begins_time','category','product_id'];

	// these fields aren't
	protected $guarded = ['id','product_title','product_description','original_price','image_url'];

	// custom attributes
	protected $appends = ['begins_date_time','expires_date_time','expiry_time'];

	public function getBeginsDatetimeAttribute() {
		$empty_datetime = new DateTime('0000-00-00 00:00:00');
		$datetime = new DateTime($this->attributes['begins_time']);
		if ($empty_datetime == $datetime) {
			return "(not set)";
		} else {
			//l jS F Y h:i:s A for seconds
			return date("l jS F Y h:i A", strtotime($this->attributes['begins_time']));
		}
	}

	public function getExpiresDatetimeAttribute() {
		$empty_datetime = new DateTime('0000-00-00 00:00:00');
		$datetime = new DateTime($this->attributes['expires_time']);
		if ($empty_datetime == $datetime) {
			return "(not set)";
		} else {
			//l jS F Y h:i:s A for seconds
			return date("l jS F Y h:i A", strtotime($this->attributes['expires_time']));
		}
	}

	public function getExpiryTimeAttribute() {
		$now_datetime = new DateTime('now');
		$datetime = new DateTime($this->attributes['expires_time']);

		return $now_datetime->diff($datetime)->format('%R%d days, %h hours, %s secs');
	}
}