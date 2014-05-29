<?php

class UsersController extends \BaseController {

	private static function get_retailers_list() {
		$all_retailers = DB::table('retailer')->lists('title','retailer_id');

		$retailers = array();
		
		foreach($all_retailers as $key => $val) {
			$retailers[$key] = "" . $key . ": " . $val;
		}

		// use this option to create another admin user; admin users can manage other users
		$retailers['null'] = "none (an admin user)";

		return $retailers;
	}

	private static function process_input(&$input) {
		// storing/updating retailer_id
		if (isset($input['retailer_id'])) {
			$retailer_id = $input['retailer_id'];
			// mysql whines if you provide 'null' in quotes 
			if ($retailer_id == 'NULL' || $retailer_id == 'null') {
				$input['retailer_id'] = null;
				// unset($input['retailer_id']);

				// var_dump($input); exit();
			}
		}

		UsersController::generate_or_delete_apikey($input);
	}

	private static function store_new_password(&$input) {
		// storing a password for a new user
		if (isset($input['password'])) {
			$password = $input['password'];

			$field_to_hash = $password;
			$hashed_password = Hash::make($password);

			$input['password'] = $hashed_password;
		}
	}

	private static function reset_password(&$input) {
		// password reset
		if (isset($input['new_password']) && isset($input['new_password_confirmation'])) {
			$new_password = $input['new_password'];
			$new_password_confirmation = $input['new_password_confirmation'];

			// check both new_password and new_password_confirm
			$the_same = ($new_password === $new_password_confirmation);
			
			if ($the_same == false) {
				return Redirect::back()->withInput()->except('new_password','new_password_confirmation');
			} else {
				$input['password'] = Hash::make($new_password);
			}
		} 
	}

	private static function generate_or_delete_apikey(&$input) {
		if (isset($input['generate_or_delete_apikey'])) {
			// generate api key if input['generate_apikey'] is set
			if ($input['generate_or_delete_apikey'] === 'generate_apikey') {
				$input['apikey'] = uniqid('key', true);
				
			} else {
			// delete api key if input['delete_apikey'] is set
				$input['apikey'] = null;
			}
		}
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
		// $latest_user = User::orderBy('user_id','DESC')->get()->first();
		// $new_id = $latest_user->user_id + 1;

		return View::make('users.create', ['retailers' => $retailers]);
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function store()
	{	
		$input = Input::all();
		$validator = Validator::make($input, User::$create_rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();

		} else {
			UsersController::process_input($input);
			UsersController::store_new_password($input);
		}

		User::create($input);

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

		// dont allow changing user types from retailer to admin unless current logged in user is admin
		if ($user->user_type === 'retailer' && Auth::user()->username !== 'admin') {
			unset($retailers['null']);
		} 

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
		$input = Input::all();

		// var_dump($input); exit();

		$update_user_validation_rules = [
			'username' => 'required', 
			'new_password' => 'min:6|confirmed', 
			'new_password_confirmation' => 'min:6'
		];

		$validator = Validator::make($input, $update_user_validation_rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();

		} else {
			UsersController::process_input($input);
			UsersController::reset_password($input);
		}

		$user->update($input);

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