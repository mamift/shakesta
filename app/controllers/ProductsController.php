<?php

class ProductsController extends \BaseController {

	private static function get_products()  {
		$user_type = Auth::user()->user_type;
		$products = array();

		if ($user_type === "admin") {
			//show all products
			$products = Product::all();
		} else {
			$retailer_id = User::find(Auth::user()->user_id)->retailer->id;
			// show only products that belongs to the user
			$products = Product::where('retailer_id','=', $retailer_id)->get();
		}

		return $products;
	}

	private static function get_all_retailers_list() {
		$all_retailer_titles = DB::table('retailer')->lists('title','retailer_id');
		$all_retailers = array();

		// this loop just adds the primary key to the retailer title.
		foreach ($all_retailer_titles as $key => $val) {
			$all_retailers[$key] = "" . $key . ": " . $val;
		}

		return $all_retailers;
	}

	/**
	 * Display a listing of products
	 *
	 * @return Response
	 */
	public function index()
	{	
		$products = ProductsController::get_products();
		return View::make('products.index', compact('products'));
	}

	/**
	 * Show the form for creating a new product
	 *
	 * @return Response
	 */
	public function create()
	{
		// $latest_product = DB::table('product')->orderBy('product_id','desc')->first();
		// $new_id = $latest_product->product_id + 1;

		$all_retailers = ProductsController::get_all_retailers_list();

		if (Auth::user()->is_admin) {
			return View::make('products.create', ['all_retailers' => $all_retailers]);
		} else {
			return View::make('products.create', ['retailer_id' => Auth::user()->retailer_id])
												->with('all_retailers', $all_retailers);
		}
	}

	/**
	 * Store a newly created product in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Product::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Product::create($data);

		return Redirect::route('products.index');
	}

	/**
	 * Display the specified product.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$product = Product::findOrFail($id);
		
		$all_retailers = ProductsController::get_all_retailers_list();

		return View::make('products.show', compact('product'))->with('all_retailers', $all_retailers);
	}

	/**
	 * Show the form for editing the specified product.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$product = Product::findOrFail($id);
		
		$all_retailers = ProductsController::get_all_retailers_list();

		return View::make('products.edit', ['product' => $product])->with('all_retailers', $all_retailers);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$product = Product::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Product::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$product->update($data);

		return Redirect::route('products.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Product::destroy($id);

		return Redirect::route('products.index');
	}

}