<?php

class Product extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'title' => 'required'
		// 'image_file' => 'required|image'
	];

	// hidden
	protected $hidden = ['product_id','image'];

	protected $table = 'product';
	protected $primaryKey = 'product_id';

	public $timestamps = true;
	public $incrementing = true;

	// Don't forget to fill this array
	protected $fillable = ['title','description','retailer_id','retail_price','image','image_url'];

	// these fields aren't
	protected $guarded = ['product_id'];

	protected $appends = array('created_at_datetime','updated_at_datetime','id');

	public function getCreatedAtDatetimeAttribute() {
		return date("l jS F Y h:i:s A", strtotime($this->attributes['created_at']));
	}

	public function getUpdatedAtDatetimeAttribute() {
		return date("l jS F Y h:i:s A", strtotime($this->attributes['updated_at']));	
	}

	public function getIdAttribute() {
		return $this->attributes['product_id'];
	}

	public function getImageUrlAttribute() {
		// return 'http:://' . $_SERVER['HTTP_HOST'] . '/images/products/' . $this->attributes['image_url'];
		if (isset($this->attributes['image_url']))
			return '/images/products/' . $this->attributes['image_url'];
		else 
			return null;
	}

	public function retailer() {
		return $this->belongsTo('Retailer','retailer_id');
	}
}