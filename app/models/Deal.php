<?php

// Schema note: you must grab a deal for a product.

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
}