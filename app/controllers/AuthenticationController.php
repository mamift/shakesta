<?php

class AuthenticationController extends \BaseController {

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
			$user = ['username' => Input::get('username'), 'password' => Input::get('password')];
			$authenticated = false;

			if (isset($input['remember_token']) && ($input['remember_token'] == 'on' || $input['remember_token'] == "ON")) {
				$authenticated = Auth::attempt($user, true);
			} else {
				$authenticated = Auth::attempt($user, false);
			}

			if ($authenticated) {
				return Redirect::to('/user-login');
			} else {
				return Redirect::to('user-login')
					->with('flash_error', 'Authentication failed! Try again.')
					->withInput(Input::except('password'));
			}
		}
	}

	/**
	 * Show the user profile page for the current user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show_user($user)
	{
		//
	}

	/**
	 * Logout.
	 *
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();
		return Redirect::to('/');
	}

}