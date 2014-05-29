<?php

class DealsController extends \BaseController {
	
	private static function get_deals_list() {
		$user_type = Auth::user()->user_type;
		$deals = array();

		if ($user_type === "admin") {
			//show all deals
			$deals = ProductDealsRetailers::all();
		} else {
			$retailer_id = User::find(Auth::user()->user_id)->retailer->id;
			// show only deals that belongs to the user
			$deals = ProductDealsRetailers::where('retailer_id','=', $retailer_id)->get();
		}

		return $deals;
	}

	private static function get_products_list() {
		$is_admin = Auth::user()->is_admin;
		$all_product_titles = DB::table('product_retailers')->lists('title','product_id');
		$all_product_retailers = DB::table('product_retailers')->lists('retailer','product_id');
		$all_products = array();

		// only retrieve products that belong to the current user (retailer)
		if (!$is_admin) {
			$retailer_id = User::find(Auth::user()->user_id)->retailer->retailer_id;
			$all_product_titles = DB::table('product')->where('retailer_id','=', $retailer_id)->lists('title','product_id');
		}

		// this loop just adds the primary key to the product title.
		foreach ($all_product_titles as $key => $val) {
			if ($is_admin) $all_products[$key] = "Retailer: " . $all_product_retailers[$key] . ", Product: " . $key . ", " . $val; 
			else $all_products[$key] = "" . $key . ": " . $val;
		}

		// var_dump($all_products);
		// exit();

		$all_products["NULL"] = "(choose one)";

		return $all_products;
	}

	// same as index(), except items are sorted by category
	public function index_deals_by_category() {
		$deals = DealsController::get_deals_list();
		//sort
		$deals->sortBy(function($deal) { return $deal->category; });

		if (Auth::user()->user_type === 'admin') {
			return View::make('deals.index-admin', ['deals' => $deals]);
		} else {
			return View::make('deals.index', ['deals' => $deals]);
		}
	}

	/**
	 * Display a listing of deals
	 *
	 * @return Response
	 */
	public function index()
	{	
		$deals = DealsController::get_deals_list();

		if (Auth::user()->user_type === 'admin') {
			return View::make('deals.index-admin', ['deals' => $deals]);
		} else {
			return View::make('deals.index', ['deals' => $deals]);
		}
	}

	/**
	 * Show the form for creating a new deal
	 *
	 * @return Response
	 */
	public function create()
	{
		// $latest_deal = DB::table('deal')->orderBy('deal_id','desc')->first();
		// $new_id = $latest_deal->deal_id + 1;

		$all_products = DealsController::get_products_list();

		if (Auth::user()->is_admin) {
			return View::make('deals.create', ['all_products' => $all_products]);
		} else {
			return View::make('deals.create', ['retailer_id' => Auth::user()->retailer_id])
												->with('all_products', $all_products);
		}
	}

	/**
	 * Store a newly created deal in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Deal::$create_rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Deal::create($data);

		return Redirect::route('deals.index');
	}

	/**
	 * Display the specified deal.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$deal = Deal::findOrFail($id);
		$product = [
			'id' => $deal->product->product_id, 
			'title' => $deal->product->product_id . ": " . $deal->product->title
		];

		$retailer = Retailer::findOrFail(1);

		return View::make('deals.show', ['deal' => $deal, 'product' => $product, 'retailer' => $retailer]);
	}

	/**
	 * Show the form for editing the specified deal.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$deal = Deal::find($id);

		return View::make('deals.edit')->with('deal', $deal);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$deal = Deal::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Deal::$create_rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$deal->update($data);

		return Redirect::route('deals.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Deal::destroy($id);

		return Redirect::route('deals.index');
	}

}