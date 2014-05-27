<?php

class DealsController extends \BaseController {
	
	private static function get_deals() {
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

	/**
	 * Display a listing of deals
	 *
	 * @return Response
	 */
	public function index()
	{	
		$deals = DealsController::get_deals();

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
		return View::make('deals.create');
	}

	/**
	 * Store a newly created deal in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Deal::$rules);

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

		$validator = Validator::make($data = Input::all(), Deal::$rules);

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