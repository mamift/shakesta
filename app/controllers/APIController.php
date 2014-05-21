<?php

class APIController extends \BaseController {

	/**
	 * Display a listing of the resource. Returns data from the 'product_deals' database view.
	 *
	 * @return Response
	 */
	public function index()
	{
		$deals = ProductDeal::all();

		return Response::json($deals->toArray(), 200);
	}

	/**
	 * Returns only data from the 'deal' table.
	 * 
	 * @return Response
	 */
	public function dealsindex()
	{
		$deals = Deal::all();

		return Response::json($deals->toArray(), 200);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * $fillable = ['price_discount','terms','expires_time','begins_time','category','product_id'];
	 * test with: 
	 * (fail test 1) curl -i --user admin:gizmoe99 -d 'price_discount=0.5&terms=blah blah' localhost:8000/api/v1.1/productdeals
	 * (fail test 2) curl -i --user admin:gizmoe99 -d 'price_discount=0.5&terms=blah blah&expires_time=2014-05-31 05:12:00&begins_time=2014-05-01 00:00:01&category=Home goods&product_id=99' localhost:8000/api/v1.1/productdeals
	 * (success test) curl -i --user admin:gizmoe99 -d 'price_discount=0.5&terms=blah blah&expires_time=2014-05-31 05:12:00&begins_time=2014-05-01 00:00:01&category=Home goods&product_id=5' localhost:8000/api/v1.1/productdeals
	 * @return Response
	 */
	public function store()
	{
		$deal = new ProductDeal;

		$input = Input::all();
		$null_validated = true;
		$product_validated = true;
		$status = false; // false means OK! that we don't have a situation

		$validator = Validator::make($input, ProductDeal::$rules);
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
				$status = !$deal->save();
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
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$deal = ProductDeal::find($id);

		$status = !isset($deal);
		$response = array('status' => $status, 'message' => null, 'deal' => null);

		if ($status) {
			$response['message'] = 'cannot find record';
		} else {
			$response['message'] = 'record was found';
			$response['deal'] = $deal;
		}

		return Response::json($response, 200);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//not needed
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$deal = ProductDeal::find($id);
 
		if (Request::get('deal')) {
			$deal->deal = Request::get('deal');
		}

		if (Request::get('description')) {
			$deal->description = Request::get('description');
		}

		if (isset($deal)) 
			$status = !$deal->save();

		$response = array('status' => $status, 'message' => null);

		if ($status) {
			$response['message'] = 'cannot update record';
		} else {
			$response['message'] = 'record was updated';
		}

		return Response::json($response, 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$deal = ProductDeal::find($id);

		$status = !isset($deal);
		$response = array('status' => $status, 'message' => null);

		if ($status) {
			$response['message'] = 'cannot delete record';
		} else {
			$response['message'] = 'record was deleted';
			$deal->delete();
		}

		return Response::json($response, 200);
	}

}