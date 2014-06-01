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

			return View::make('registration.register', ['retailers' => $retailers]);
			
		} else {
			return Redirect::to('/user-login');

		}
	}

	/**
	 * Store the new user information
	 *
	 * @return Response
	 */
	public function self_signup_store() 
	{
		$input = Input::all();
		$self_sign_rules = [
			'username' => 'required',
			'password' => 'required|min:6|confirmed',
			'password_confirmation' => 'required|min:6'
		];

		$validator = Validator::make($input, $self_sign_rules);

		$username = Input::get('username');
		$email = Input::get('email');

		// check for pre-existing username and e-mail
		if (AuthenticationController::check_username($username)) {
			return Redirect::back()->with('username_message', "Username already taken!")->withInput();
		} 

		if (AuthenticationController::check_email($email)) {
			return Redirect::back()->with('email_message', "Email already taken!")->withInput();
		}

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