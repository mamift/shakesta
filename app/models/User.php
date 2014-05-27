<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password','remember_token','created_at','updated_at'];

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public static $rules = [
		'username' => 'required'
	];

	// fields that are mass assignable
	protected $fillable = ['username','password','email'];

	protected $primaryKey = 'user_id';

	public $timestamps = true;
	public $incrementing = true;

	// these fields aren't
	protected $guarded = ['user_id','retailer_id'];

	protected $appends = ['created_at_datetime','updated_at_datetime','id','user_type'];

	public function getCreatedAtDatetimeAttribute() {
		return date("l jS F Y h:i:s A", strtotime($this->attributes['created_at']));
	}

	public function getUpdatedAtDatetimeAttribute() {
		return date("l jS F Y h:i:s A", strtotime($this->attributes['updated_at']));	
	}

	public function getIdAttribute() {
		return $this->attributes['user_id'];
	}

	// if a retailer_id is set in the user table, then this user record belongs to a regular 'retailer', otherwise it's an admin user
	public function getUserTypeAttribute() {
		$retailer_id_set = (isset($this->attributes['retailer_id']) || $this->attributes['retailer_id'] > 0);

		return ($retailer_id_set ? 'retailer' : 'admin');
	}

	// user has one retailer
	public function retailer() {	
		return $this->belongsTo('Retailer','retailer_id');
	}
}
