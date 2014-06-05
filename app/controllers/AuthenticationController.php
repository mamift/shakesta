<?php

class AuthenticationController extends \BaseController {
	// for an already existing username
	public static function check_username($username) 
	{
		$existing_user = User::where('username','=', $username)->first();
		
		if (isset($existing_user)) {
			if ($existing_user->username === $username)
				return true;
			else 
				return false;
		} else
			return false;
	}

	// for an already existing email
	public static function check_email($email) 
	{
		if ($email == "" || $email === '' || !isset($email)) return false;
		// var_dump($email); exit();
		$existing_user = User::where('email','=', $email)->first();
		
		if (isset($existing_user)) {
			if ($existing_user->email === $email)
				return true;
			else 
				return false;
		} else
			return false;
	}

	/**
	 * Display login page.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('login');
	}

	/**
	 * Attempt to authenticate.
	 *
	 * @return Response
	 */
	public function authenticate()
	{
		$input = Input::all();
		$validation_rules = [
			'username' => 'required',
			'password' => 'required|alphaNum|min:3'
		];

		$validator = Validator::make($input, $validation_rules);

		if ($validator->fails()) {
			return Redirect::to('user-login')
				->withErrors($validator)
				->withInput(Input::except('password'));

		} else {
			// $user = new User;
			$user = ['username' => Input::get('username'), 'password' => Input::get('password'), 'status' => 'enabled'];
			// $user = ['username' => Input::get('username'), 'password' => Input::get('password')];
			
			$user_mi = User::where('username','=', Input::get('username'))->get();
			$user_is_enabled = ($user_mi->first()->status === 'enabled');

			// var_dump($user_is_enabled); exit();
			
			$authenticated = null;

			if (isset($input['remember_token']) && ($input['remember_token'] == 'on' || $input['remember_token'] == "ON")) {
				$authenticated = Auth::attempt($user, true);
			} else {
				$authenticated = Auth::attempt($user, false);
			}

			if ($authenticated) {
				// if ($user_is_enabled) {
				return Redirect::to('/user-login');
				// } 


			} else {
				$flash_message = ($user_is_enabled) ? 'Authentication failed! Try again.' : 'Authentication failed! Account is disabled';
				return Redirect::to('user-login')
					->with('flash_error', $flash_message)
					->withInput(Input::except('password'));
			}
		}
	}

	/**
	 * Show the form for self-registering a new user
	 *
	 * @return Response
	 */
	public function register()
	{
		if (!Auth::check()) {
			$retailers = UsersController::get_retailers_list();
			unset($retailers['null']); // don't allow self-admin registration
			$retailers['(other: enter your own)'] = '(other: enter your own)';

			return View::make('registration.register', ['retailers' => $retailers]);
			
		} else {
			return Redirect::to('/user-login');

		}
	}

	/**
	 * Store new user information, but disable the user
	 *
	 * @return Response
	 */
	public function self_signup_store() 
	{
		$input = Input::all();

		$input['status'] = 'disabled'; // always disable a new user; admins must approve

		$self_sign_rules = [
			'username' => 'required|unique:user,username',
			'email' => 'required|unique:user,email',
			'password' => 'required|min:6|confirmed',
			'password_confirmation' => 'required|min:6',
			'suggested_retailer_name' => 'min:1|unique:retailer,title'
		];

		$validator = Validator::make($input, $self_sign_rules);

		$username = Input::get('username');
		$email = Input::get('email');
		$suggested_retailer = Input::get('suggested_retailer_name');
		$retailer = Input::get('retailer_id');

		if (isset($suggested_retailer) && strlen($suggested_retailer) == 0) {
			return Redirect::back()->with('suggested_retailer_name', 'You need to actually enter something here if you\'re gonna specify your own retailer, fool!')->withInput()->withErrors($validator);
		}

		if ($retailer != '(other: enter your own)' && isset($suggested_retailer)) {
			// go with the retailer_id value
			unset($input['suggested_retailer_name']);

		}

		// var_dump($input); exit();
		if (isset($suggested_retailer) && $retailer == '(other: enter your own)') {
			// if no retailer_id is set, then place this in the user notes
			$input['notes'] = 'This user wants to represent a client not in the database, and that client is: "' . $suggested_retailer . '". When enabling this user, you might want to create a new Client for this retailer if it doesn\'t already exist.';
			unset($input['retailer_id']); // we don't want sql errors
		}

		// I AM A MORON: apparently this validation is already built-into Laravel! see the above rules
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

		} else {
			return View::make('registration.confirmation');
		}
	}

	/**
	 * Logout.
	 *
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();
		return Redirect::to('/user-login');
	}

}