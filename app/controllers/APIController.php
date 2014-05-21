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

		return Response::json($deals);
	}

	/**
	 * Returns only data from the 'deal' table.
	 * 
	 * @return Response
	 */
	public function dealsindex()
	{
		$deals = Deal::all();

		return Response::json($deals);
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
	 *
	 * @return Response
	 */
	public function store()
	{
		$deal = new ProductDeal;
		$deal->deal = Request::get('deal');
		$deal->description = Request::get('description');
		$deal->user_id = Auth::user()->id;

		// validation and filtering done here

		$deal->save();

		return Response::json(array
		(
			'error' => false,
			// 'deals' => $deal->toArray()),
			'message' => 'deal created'),
			200
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}