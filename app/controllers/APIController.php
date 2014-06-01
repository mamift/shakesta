<?php

class APIController extends \BaseController {
	private static function current_deals() 
	{
		$unexpired_filter = function($deal) {
			return !$deal->is_expired;
		};

		$deals = ProductDealsRetailers::where('expires_time','>', (new DateTime())); 

		return $deals;
	}

	private static function expired_deals() 
	{
		$expired_filter = function($deal) {
			return $deal->is_expired;
		};

		$deals = ProductDealsRetailers::where('expires_time','<', (new DateTime()));

		return $deals;
	}

	/**
	 * Returns all records from the 'product_deals' database view.
	 *
	 * @return JSON Response
	 */
	public function index()
	{
		$deals = APIController::current_deals()->paginate(10);
		// to get page 2, shakesta.com/api/v1.1/deals/?page=2
		return Response::json($deals->toArray(), 200);
	}

	/**
	 * Returns only data from the 'deal' table; (so no product information provided)
	 * 
	 * @return JSON Response
	 */
	public function index_all_deals()
	{
		$deals = ProductDealsRetailers::all();

		return Response::json($deals->toArray(), 200);
	}

	/**
	 * Returns deals that have not expired (i.e. expired_datetime is before current date/time)
	 *
	 * @return JSON Response
	 */
	public function index_current_deals()
	{	
		$deals = APIController::current_deals()->get();

		return Response::json($deals->toArray(), 200);
	}

	/**
	 * Returns deals that have expired (i.e. expired_datetime is after current date/time)
	 *
	 * @return JSON Response
	 */
	public function index_expired_deals()
	{
		$deals = APIController::expired_deals()->get();

		return Response::json($deals->toArray(), 200);
	}

	/**
	 * Returns records from the 'product_deals' database view where deals only begun today (i.e. expired_datetime is before current date/time)
	 *
	 * @return JSON Response
	 */
	public function index_todays_deals()
	{	
		$today_filter = function($deal) {
			$todays_time = new DateTime("today");
			$tomorrows_time = new DateTime("tomorrow");
			$begins_time = new DateTime($deal->begins_time);

			// var_dump($begins_time); exit();

			return ($begins_time > $todays_time) && ($begins_time < $tomorrows_time);
		};

		$deals = ProductDealsRetailers::all()->filter($today_filter);

		return Response::json($deals->toArray(), 200);
	}

	/**
	 * Returns records from the 'product_deals' database view where deals only begun at the beginning of this week (from Monday of the current week) (i.e. begun_datetime is after the date of this week's Monday)
	 *
	 * @return JSON Response
	 */
	public function index_thisweeks_deals()
	{
		$week_filter = function($deal) {
			$week_time = new DateTime("this week");
			$begins_time = new DateTime($deal->begins_time);

			// var_dump($begins_time); exit();

			return ($begins_time > $week_time) && !($deal->is_expired);
		};

		$deals = ProductDealsRetailers::all()->filter($week_filter);

		return Response::json($deals->toArray(), 200);
	}

	/**
	 * unused
	 * 
	 */
	public function search($text) 
	{
		// unused
	}

	/**
	 * Display JSON representation of a deal from the product_deals database view.
	 *
	 * @param  int  $id
	 * @return JSON Response of a deal
	 */
	public function show()
	{
		if (func_num_args() > 1) { // received via GET
			$id = func_get_arg(1); // id should be second one

		} else if (func_num_args() == 1) { //received via POST
			$id = func_get_arg(0); // id should be the first
		}

		$deal = ProductDealsRetailers::find($id);

		$status = !isset($deal);
		$response = ['status' => $status, 'message' => null, 'deal' => null];

		if ($status) {
			$response['message'] = 'cannot find record';
		} else {
			$response['message'] = 'record was found';
			$response['deal'] = $deal->toArray();
		}

		return Response::json($response, 200);
	}

	/**
	 * Show a list of deal categories (distinct).
	 * 
	 */
	public function index_deal_categories() 
	{
		$deal_categories = DB::table('deal')->distinct()->lists('category');
		$response = ['total' => count($deal_categories), 'data' => $deal_categories];
		return Response::json($response, 200);
	}

	/**
	 * Show deals by a category
	 * 
	 */
	public function deals_by_category()
	{
		if (func_num_args() > 1) { // received via GET
			$category = func_get_arg(1); // category should be the second one, api key is the first

		} else if (func_num_args() == 1) { //received via POST
			$category = func_get_arg(0);
		}

		$deals = ProductDealsRetailers::where('category','=', $category)->paginate(10);
		$count = $deals->count();
		$response = ['total' => $count, 'data' => $deals->toArray()];

		// return Response::json($response, 200);
		return Response::json($deals, 200);
	}

	/**
	 * Used to create a new record in the 'product_deals' database view. Cannot be used to create a new product, only deals. Must specify all fields in the deals table, including product_id so a product must already exist. 
	 * $fillable = ['price_discount','terms','expires_time','begins_time','category','product_id'];
	 * test with: 
	 * (fail test 1) curl -i --user admin:gizmoe99 -d 'price_discount=0.5&terms=blah blah' localhost:8000/api/v1.1/productdeals
	 * (fail test 2) curl -i --user admin:gizmoe99 -d 'price_discount=0.5&terms=blah blah&expires_time=2014-05-31 05:12:00&begins_time=2014-05-01 00:00:01&category=Home goods&product_id=99' localhost:8000/api/v1.1/productdeals
	 * (success test) curl -i --user admin:gizmoe99 -d 'price_discount=0.5&terms=blah blah&expires_time=2014-05-31 05:12:00&begins_time=2014-05-01 00:00:01&category=Home goods&product_id=5' localhost:8000/api/v1.1/productdeals
	 * @return JSON Response indicating if the record was successfully created.
	 */
	private static function store_new_deal()
	{
		$deal = new ProductDeal;

		$input = Input::all();
		$null_validated = true;
		$product_validated = true;
		$status = false; // false means OK! that we don't have a situation

		$validator = Validator::make($input, Deal::$create_rules);
		$validated = $validator->passes();

		foreach($input as $key => $val) 
		{
			// if any keys have a null value, then validation has failed
			if (!isset($input[$key]) || $input[$key] == null) { $null_validated = false; break; }

			// check that each of these fields are set
			if (!isset($input['price_discount']))	{ $null_validated = false; break; }
			if (!isset($input['terms']))			{ $null_validated = false; break; }
			if (!isset($input['expires_time']))		{ $null_validated = false; break; }
			if (!isset($input['begins_time']))		{ $null_validated = false; break; }
			if (!isset($input['category']))			{ $null_validated = false; break; }
			if (!isset($input['product_id']))		{ $null_validated = false; break; }
		}
 	
 		if ($null_validated) {
	 		$deal->price_discount 	= $input['price_discount'];
			$deal->terms 			= $input['terms'];
			$deal->expires_time 	= $input['expires_time'];
			$deal->begins_time 		= $input['begins_time'];
			$deal->category 		= $input['category'];
			$deal->product_id 		= $input['product_id'];

			// must check for a product
			$product = Product::find($input['product_id']);
			if (!isset($product)) $product_validated = false;

			if ($product_validated)
				$status = !$deal->save(); // save the deal
			else 
				$status = false; // for now, when product validation fails, set this as false (to mean that everything's fine); we'll use the $product_validated variable to check later. we just don't want to call $deal->save when there no valid product_id. Laravel will throw its own exception and return HTML.

 		} else {
			$status = true; // we have a situation
 		}

		$response = array('status' => $status, 'message' => null, 'deal' => null);

		$response['deal'] = [
			'input provided was' => $input, 
			'product_id ok?' => $product_validated,
			'validation passed?' => $validated,
			'validation messages' => array($validator->messages()->all())
		];

		// if we have a situation...
		if ($status) {
			$response['message'] = "cannot create record; check that a value exists for 'price_discount', 'terms', 'expires_time', 'begins_time', 'category', 'product_id' ";
		// if we cannot find a valid product (based on 'product_id')
		} else if (!$product_validated) {
			$response['message'] = "cannot create record; product_id supplied is invalid (must already exist; use web interface to enter new products)";
		} else {
			$response['message'] = 'record was created';
		}

		return Response::json($response, 200);
	}

	/**
	 * Update a record by deal ID in the 'products_deal' database view. Can only be used to update deal information and not products information. Use the web interface for that.
	 * test cases:
	 * (success) curl -i -X PUT --user admin:gizmoe99 -d 'expires_time=2014-05-31 05:12:00&begins_time=2014-05-01 00:00:01' localhost:8000/api/v1.1/deals/5
	 * (fail) curl -i -X PUT --user admin:gizmoe99 -d 'expires_time=2014-05-31 05:12:00&begins_time=2014-05-01 00:00:01' localhost:8000/api/v1.1/deals/99
	 *
	 * @param  int  $id
	 * @return JSON Response indicating whether the specified record was updated or not.
	 */
	private static function update($id)
	{
		$deal = ProductDeal::find($id);
		$input = Input::all();
 
		if (isset($deal) && isset($input)) {
			if (isset($input['price_discount'])) $deal->price_discount 	= $input['price_discount'];
			if (isset($input['terms']))			 $deal->terms 			= $input['terms'];
			if (isset($input['expires_time']))	 $deal->expires_time 	= $input['expires_time'];
			if (isset($input['begins_time']))	 $deal->begins_time 	= $input['begins_time'];
			if (isset($input['category']))		 $deal->category 		= $input['category'];
			if (isset($input['product_id']))	 $deal->product_id 		= $input['product_id'];

			// save the deal
			$status = !$deal->save();
		} else {
			$status = true; // we have a situations
		}

		$response = ['status' => $status, 'message' => null, 'deal' => null];

		if ($status) {
			$response['message'] = 'cannot update record; check id number url';
			$response['deal'] = [
				'input provided was' => $input, 
			];

		} else {
			$response['message'] = 'record was updated';
			$response['deal'] = ['input provided was' => $input];
 		}

		return Response::json($response, 200);
	}

	/**
	 * Remove a record from the database by ID number.
	 *
	 * @param  int  $id
	 * @return JSON Response containing a message indicating if the record was successfully deleted or not.
	 */
	private static function destroy($id)
	{
		$deal = ProductDeal::find($id);

		$status = !isset($deal);
		$response = ['status' => $status, 'message' => null];

		if ($status) {
			$response['message'] = 'cannot delete record';
		} else {
			$deal->delete();
			$response['message'] = 'record was deleted';
		}

		return Response::json($response, 200);
	}

}