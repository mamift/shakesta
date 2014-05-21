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
	 * @return Response
	 */
	public function store()
	{
		$deal = new ProductDeal;

		$input = Input::all();

		(isset($input['price_discount'])) 	? $deal->price_discount 	= $input['price_discount'] 	: null;
		(isset($input['terms'])) 			? $deal->terms 				= $input['terms'] 			: null;
		(isset($input['expires_time'])) 	? $deal->expires_time 		= $input['expires_time'] 	: null;
		(isset($input['begins_time'])) 		? $deal->begins_time 		= $input['begins_time'] 	: null;
		(isset($input['category'])) 		? $deal->category 			= $input['category'] 		: null;
		(isset($input['product_id'])) 		? $deal->product_id 		= $input['product_id'] 		: null;
 
		$status = !$deal->save();

		$response = array('status' => $status, 'message' => null, 'deal' => null);

		if ($status) {
			$response['message'] = 'cannot create record';
		} else {
			$response['message'] = 'record was created';
			$response['deal'] = $input;
			// $response['deal'] = $input['price_discount'];
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