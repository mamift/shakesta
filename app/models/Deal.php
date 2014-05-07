<?php

// Schema note: you must grab a deal for a product.

class Deal extends Eloquent {
	
	// validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	protected $table = 'deal';
	protected $primaryKey = 'deal_id';

	protected $timestamps = true;
	protected $incrementing = true;

	// these fields are mass-assignable
	protected $fillable = ['price_discount','terms','expires_time','begins_time','category'];
}