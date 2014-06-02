<?php

class Deal extends Eloquent {
	
	// validation rules here
	public static $create_rules = [
		'product_id' 		=> 'required|numeric',
		'price_discount' 	=> 'required|numeric|min:0.01|max:0.99',
		'terms' 		 	=> 'required',
		'begins_time' 	 	=> 'required|date|date_format:"Y-m-d H:i:s"',
		'expires_time' 	 	=> 'required|date|date_format:"Y-m-d H:i:s"|after:begins_time',
		'category' 		 	=> 'required',
	];

	// hidden
	protected $hidden = ['deal_id','created_at','updated_at','begins_time','expires_time'];

	protected $table = 'deal';
	protected $primaryKey = 'deal_id';

	public $timestamps = true;
	public $incrementing = true;

	// these fields are mass-assignable
	protected $fillable = ['price_discount','terms','expires_time','begins_time','category','product_id'];

	// these fields aren't
	protected $guarded = ['deal_id'];

	protected $appends = ['id','begins_datetime','expires_datetime','expiry_time','is_expired','discount_price'];

	/** overriding default accesors & mutators **/

	// price_discount
	public function getPriceDiscountAttribute() {
		return (float) $this->attributes['price_discount'];
	}

	/** custom attributes **/

	public function getIdAttribute() {
		return $this->attributes['deal_id'];
	}

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

	public function getIsExpiredAttribute() {
		$now_datetime = new DateTime('now');
		$datetime = new DateTime($this->attributes['expires_time']);

		$is_expired = $now_datetime->diff($datetime)->format('%R%s') <= 0 ? true : false;

		return $is_expired;
	}

	public function getDiscountPriceAttribute() {
		$original_price = $this->attributes['original_price'];
		$price_discount = $this->attributes['price_discount'];

		return $original_price - ($original_price * $price_discount);
	}

	public function product() {
		return $this->belongsTo('Product','product_id');
	}
}