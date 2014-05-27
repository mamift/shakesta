<?php

class UsersController extends \BaseController {

	private static function get_retailers_list() {
		$all_retailers = DB::table('retailer')->lists('title','retailer_id');

		$retailers = array();
		
		foreach($all_retailers as $key => $val) {
			$retailers[$key] = "" . $key . ": " . $val;
		}

		return $retailers;
	}

	/**
	 * Display a listing of users
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();

		return View::make('users.index', ['users' => $users]);
	}

	/**
	 * Show the form for creating a new user
	 *
	 * @return Response
	 */
	public function create()
	{
		$retailers = UsersController::get_retailers_list();
		$latest_user = User::orderBy('user_id','DESC')->get()->first();
		$new_id = $latest_user->user_id + 1;

		// use this option to create another admin user; admin users can be used for API interfacing
		$retailers[""] = "none (create an admin user)";

		return View::make('users.create', ['retailers' => $retailers, 'new_id' => $new_id]);
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), User::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		User::create($data);

		return Redirect::route('users.index');
	}

	/**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::findOrFail($id);

		return View::make('users.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);
		$retailers = UsersController::get_retailers_list();

		return View::make('users.edit', ['user' => $user, 'retailers' => $retailers]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::findOrFail($id);

		$validator = Validator::make($data = Input::all(), User::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$user->update($data);

		return Redirect::route('users.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		User::destroy($id);

		return Redirect::route('users.index');
	}

}