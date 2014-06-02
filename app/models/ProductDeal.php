<?php

/** 
* This model uses the 'products_deals' database view, which includes information about the 
* product that the deal currently uses.
*/
class ProductDeal extends Deal {

	protected $table = 'product_deals';
	protected $primaryKey = 'id';

	protected $guarded = ['id','product_title','product_description','original_price'];

	// this model inherits from the 'product_deals' table which is has an 'id' column, instead of 'deal_id'
	public function getIdAttribute() {
		return $this->attributes['id'];
	}

	// original_price
	public function getOriginalPriceAttribute() {
		return (float) $this->attributes['original_price'];
	}

	public function getImageUrlAttribute() {
		// return 'http:://' . $_SERVER['HTTP_HOST'] . '/images/products/' . $this->attributes['image_url'];
		if (isset($this->attributes['image_url']))
			return '/images/products/' . $this->attributes['image_url'];
		else 
			return null;
	}
}