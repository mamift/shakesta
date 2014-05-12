<?php

class RetailersController extends \BaseController {

	/**
	 * Display a listing of retailers
	 *
	 * @return Response
	 */
	public function index()
	{
		$retailers = Retailer::all();

		return View::make('retailers.index')->with('retailers', $retailers);
	}

	/**
	 * Show the form for creating a new retailer
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('retailers.create');
	}

	/**
	 * Store a newly created retailer in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Retailer::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Retailer::create($data);

		return Redirect::route('retailers.index');
	}

	/**
	 * Display the specified retailer.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$retailer = Retailer::findOrFail($id);

		return View::make('retailers.show', compact('retailer'));
	}

	/**
	 * Show the form for editing the specified retailer.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$retailer = Retailer::find($id);

		return View::make('retailers.edit', compact('retailer'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$retailer = Retailer::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Retailer::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$retailer->update($data);

		return Redirect::route('retailers.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Retailer::destroy($id);

		return Redirect::route('retailers.index');
	}

}