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

	private static function get_categories()
	{
		$deal_categories = DB::table('category')->lists('name');
		$categories = array();

		foreach ($deal_categories as $key => $val)  {
			$categories[$val] = $val;
		}

		// var_dump($categories); exit();

		// only admins can add their own category when making a new deal
		if (Auth::user()->is_admin)
			$categories['(other: enter your own)'] = '(other: enter your own)';

		return $categories;
	}

	private static function process_input(&$input) 
	{
		// $other_new_category = 
		// var_dump($other_new_category); exit();

		if (isset($input['other_new_category'])) { // when a user has entered their own category
			$preexisting_categories = DB::table('category')->lists('name');
			// var_dump($preexisting_categories); 
			$exists = in_array($other_new_category, $preexisting_categories);
			// var_dump($exists); exit();

			if ($exists) {
				return Redirect::back()->with('category_already_exists', "Category already exists, yo!")->withInput();
				
			} else {
				Category::create(['name' => $other_new_category]);
			}

			$input['category'] = $other_new_category;
		}
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
		$categories = DealsController::get_categories();

		unset($categories['(other: enter your own)']); // we specifically don't want this here
		$view_data = ['deals' => $deals, 'categories' => $categories];

		if (Auth::user()->user_type === 'admin') {
			return View::make('deals.index-admin', $view_data);
		} else {
			return View::make('deals.index', $view_data);
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

		$categories = DealsController::get_categories();

		// var_dump($categories); exit();

		if (Auth::user()->is_admin) {
			return View::make('deals.create', ['all_products' => $all_products, 'categories' => $categories]);
		} else {
			return View::make('deals.create', ['all_products' => $all_products, 'categories' => $categories])->with('all_products', $all_products);
		}
	}

	/**
	 * Store a newly created deal in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validator = Validator::make($input, Deal::$create_rules);
		var_dump($input);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			DealsController::process_input($input);
		}


		Deal::create($input);

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

		$retailer = Retailer::findOrFail($deal->product->retailer_id);

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
		$categories = DealsController::get_categories();

		return View::make('deals.edit', ['categories' => $categories])->with('deal', $deal);
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
		$input = Input::all();

		// var_dump($input); exit();

		$validator = Validator::make($input, Deal::$update_rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			DealsController::process_input($input);

		}

		$deal->update($input);

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

	/** deal categories **/

	public function store_category() {
		$name = Input::get('name');

		$input = ['name' => $name];

		if (!isset($name) || $name == '' || strlen($name) < 1) {
			return Redirect::back()->with('created_category','Nothing was not created. You need to provide a value, fool!');
		}

		$validatus = Validator::make($input, Category::$rules);
		if ($validatus->fails()) {
			return Response::json('error: category was not created', 200);

		} 
		
		Category::create($input);

		return Redirect::back()->with('created_category', 'Category "' . $name . '" was created!');
	}

	public function update_category() {
		$category_to_update = Input::get('cat_to_update');
		$updated_category_name = Input::get('updated_cat_name');

		if (!isset($updated_category_name) || $updated_category_name == '' || strlen($updated_category_name) < 1) {
			return Redirect::back()->with('updated_category','"' . $category_to_update . '" was not updated. You need to provide a value, fool!');
		}

		$input = ['name' => $updated_category_name];

		Category::findOrFail($category_to_update)->update($input);

		return Redirect::back()->with('updated_category','"' . $category_to_update . '" was updated to' . ' "' . $updated_category_name . '"');
	}

	public function destroy_category() {
		$category = Input::get('cat_to_delete');

		Category::destroy($category);

		return Redirect::back()->with('deleted_category', 'Category "' .$category . '" was deleted!');
	}

}