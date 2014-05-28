<?php

class Deal extends Eloquent {
	
	// validation rules here
	public static $rules = [
		'product_id' => 'required',
		'price_discount' => 'required|numeric|min:0.01|max:0.99'
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

	public function product() {
		return $this->belongsTo('Product','product_id');
	}
}