<?php

class UrlController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// $urls = Url::where('user_id', Auth::user()->id)->get();
		$urls = Url::all();

		return Response::json(array(
			'error' => false,
			'urls' => $urls->toArray()),
			200
		);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//not needed
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
	    $url = new Url;
		$url->url = Request::get('url');
		$url->description = Request::get('description');
		$url->user_id = Auth::user()->id;

		// validation and filtering done here

		$url->save();

		return Response::json(array
		(
			'error' => false,
			// 'urls' => $url->toArray()),
			'message' => 'url created'),
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
		// Make sure current user owns the requested resource
		// $url = Url::where('user_id', Auth::user()->id)
		// 	->where('url_id', $id)
		// 	->take(1)
		// 	->get();

		$url = Url::where('url_id', $id)->get();

		return Response::json(array(
			'error' => false,
			'urls' => $url->toArray()),
			200
		);
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
	 * test with: curl -i -X PUT --user admin:gizmoe99 -d 'url=http://www.google.com.u' localhost:8000/api/v1/url/2
	 */
	public function update($id)
	{
		$url = Url::findOrFail($id);
 
		if (Request::get('url')) {
			$url->url = Request::get('url');
		}

		if (Request::get('description')) {
			$url->description = Request::get('description');
		}

		$url->save();

		return Response::json(array(
			'error' => false,
			'message' => 'url updated'),
			200
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// test: curl -i -X DELETE --user admin:gizmoe99 localhost:8000/api/v1/url/1
		// $url = Url::where('user_id', Auth::user()->id)->find($id);
		$url = Url::where('url_id', $id);

		$url->delete();

		return Response::json(array(
			'error' => false,
			'message' => 'url deleted'),
			200
		);
	}
}