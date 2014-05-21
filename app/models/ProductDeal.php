<?php

class ProductDeal extends \Eloquent {
	// validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// hidden
	protected $hidden = ['id','created_at','updated_at'];

	protected $table = 'product_deals';
	protected $primaryKey = 'id';

	public $timestamps = true;
	public $incrementing = true;

	// these fields are mass-assignable
	protected $fillable = ['price_discount','terms','expires_time','begins_time','category'];

	// these fields aren't
	protected $guarded = ['id'];

	// custom attributes
	protected $appends = [];
}