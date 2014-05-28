<?php

/** 
* This model uses the 'products_deals' database view, which includes information about the 
* product that the deal currently uses.
*/
class ProductDeal extends Deal {

	protected $table = 'product_deals';
	protected $primaryKey = 'id';

	protected $guarded = ['id','product_title','product_description','original_price','image_url'];

	// this model inherits from the 'product_deals' table which is has an 'id' column, instead of 'deal_id'
	public function getIdAttribute() {
		return $this->attributes['id'];
	}
}