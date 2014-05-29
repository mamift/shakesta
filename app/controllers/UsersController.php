<?php

class UsersController extends \BaseController {

	private static function hash_value_on_input_field(&$input, $field) {
		if (!isset($input[$field])) {
			throw new Exception("Field '" . $field . "' is not set on input variable!");

		} else {
			$field_to_hash = $input[$field];
			$hashed_value = Hash::make($input[$field]);

			//quick check
			if (!Hash::check($field_to_hash, $hashed_value)) {
				return false; // return false on failure

			} else {
				$input[$field] = $hashed_value;
				return true;
			}
		}
	}

	private static function get_retailers_list() {
		$all_retailers = DB::table('retailer')->lists('title','retailer_id');

		$retailers = array();
		
		foreach($all_retailers as $key => $val) {
			$retailers[$key] = "" . $key . ": " . $val;
		}

		return $retailers;
	}

	private static function generate_apikey(&$input) {
		if (isset($input['generate_apikey'])) {
			$input['apikey'] = uniqid('key', true);
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

		// use this option to create another admin user; admin users can be used for API interfacing
		$retailers["NULL"] = "none (create an admin user)";

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
			if (UsersController::hash_value_on_input_field($input, 'password') == false) {
				return Redirect::back()->withInput()->except('password');
			}

			//generate api key
			UsersController::generate_apikey($input);
		}

		// mysql won't accept 'NULL' into retailer_id if it's blank
		if (isset($input['retailer_id']) && $input['retailer_id'] == 'NULL') {
			unset($input['retailer_id']);
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

		$update_user_validation_rules = [
			'username' => 'required', 
			'new_password' => 'min:6|confirmed', 
			'new_password_confirmation' => 'min:6'
		];

		$validator = Validator::make($input, $update_user_validation_rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();

		} else {
			if (isset($input['new_password']) && isset($input['new_password_confirmation'])) {
				// check both new_password and new_password_confirm
				$sta1 = UsersController::hash_value_on_input_field($input, 'new_password');
				$sta2 = UsersController::hash_value_on_input_field($input, 'new_password_confirmation');
				
				if ($sta1 == false || $sta2 == false) {
					return Redirect::back()->withInput()->except('new_password','new_password_confirmation');
				} else {
					$input['password'] = Hash::make($input['new_password']);
				}
			}

			//generate api key
			UsersController::generate_apikey($input);
		}

		if (isset($input['retailer_id']) && $input['retailer_id'] == 'NULL') {
			unset($input['retailer_id']);
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