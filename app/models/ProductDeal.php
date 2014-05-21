<?php

class ProductDeal extends \Eloquent {
	// validation rules here
	public static $rules = [
		// 'title' => 'required'
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
	protected $appends = [];
}