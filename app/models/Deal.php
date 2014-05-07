<?php

// Schema note: you must grab a deal for a product.

class Deal extends Eloquent {
	protected $table = 'deal';
	protected $primaryKey = 'deal_id';

	protected $timestamps = true;
	protected $incrementing = true;

	protected $fillable = array('price_discount','terms','expires_time','begins_time','category');
}