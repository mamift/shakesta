<?php

/** 
* This model uses the 'products_deals_retailers' database view, which includes information about the 
* product the deal currently applies to and the retailer of that product.
*/
class ProductDealsRetailers extends ProductDeal {

	protected $table = 'product_deals_retailers';
	protected $primaryKey = 'id';

	protected $guarded = ['id','product_title','product_description','original_price','retailer_id','retailer'];
}