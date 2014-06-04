<?php

class UsersController extends \BaseController {

	public static function get_retailers_list() {
		$all_retailers = DB::table('retailer')->lists('title','retailer_id');

		$retailers = array();
		
		foreach($all_retailers as $key => $val) {
			$retailers[$key] = "" . $key . ": " . $val;
		}

		// use this option to create another admin user; admin users can manage other users
		$retailers['null'] = "none (an admin user)";

		return $retailers;
	}

	public static function process_input(&$input) {

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

		// sent by the users.create form; hidden form element
		if (isset($input['enabled'])) {
			$enabled = $input['enabled'];

			if ($enabled == true || $enabled == 'true') {
				$input['status'] = 'enabled';

			} else {
				$input['status'] = 'disabled';
			}
		}

		UsersController::generate_or_delete_apikey($input);
	}

	public static function store_new_password(&$input) {
		// storing a password for a new user
		
		$password = $input['password'];

		if (strlen($password) < 6) return;

		$input['password'] = Hash::make($password);

		// var_dump($input['password']); exit();
	}

	public static function reset_password(&$input) {
		$np_set = strlen(isset($input['new_password']));
		// password reset
		$new_password = $input['new_password'];
		$new_password_confirmation = $input['new_password_confirmation'];
		
		// var_dump($np_set); exit();

		if (strlen($new_password) < 6) return;
		if (strlen($new_password_confirmation) < 6) return;
		

		// check both new_password and new_password_confirm
		$the_same = ($new_password === $new_password_confirmation);
		
		if ($the_same == false) {
			return Redirect::back()->withInput()->except('new_password','new_password_confirmation');
		} else {
			$input['password'] = Hash::make($new_password);
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
		$users = User::where('status','=','enabled')->get();
		$disabled_users = User::where('status','=','disabled')->get();

		return View::make('users.index', ['users' => $users, 'disabled_users' => $disabled_users]);
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

		if (Auth::user()->is_admin) { 
			// $retailers['(create new retailer)'] = '(create new retailer)';
			return View::make('users.create', ['retailers' => $retailers]);
			
		} else
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

		$username = Input::get('username');
		$email = Input::get('email');

		// check for pre-existing username and e-mail
		// if (AuthenticationController::check_username($username)) {
			// return Redirect::back()->with('username_message', "Username already taken!")->withInput();
		// } 

		// if (AuthenticationController::check_email($email)) {
			// return Redirect::back()->with('email_message', "Email already taken!")->withInput();
		// }

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();

		} else {
			UsersController::process_input($input);
			UsersController::store_new_password($input);
		}

		User::create($input);

		if (Auth::check()) {
			return Redirect::route('users.index');

		} else { // this should only occur with self-service user registration
			return View::make('users.confirmation');
		}
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
		$retailer = Retailer::find($user->retailer_id);

		return View::make('users.show', ['user' => $user, 'retailer' => $retailer]);
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
			'username' => 'min:1',
			'email' => 'min:1', 
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