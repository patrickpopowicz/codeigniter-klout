<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Klout API v8 library for CodeIgniter
 *
 * @license Creative Commons Attribution 3.0 <http://creativecommons.org/licenses/by/3.0/>
 * @version 1.0
 * @author Patrick Popowicz <http://patrickpopowicz.com>
 * @copyright Copyright (c) 2011, Patrick Popowicz <http://patrickpopowicz.com>
 */
class Klout {

	protected $_ci;
	protected $_klout_apikey	= '';
	protected $_klout_format	= '';
	protected $_klout_api 		= '';
	protected $_klout_routes	= array();
	protected $_target			= '';
	protected $_response;

	// ------------------------------------------------------------------------

	/**
	 * Construct
	 *
	 * Setup klout lib
	 *
	 * @param	array
	 * @return 	void
	 */
	function __construct($params = array())
	{
		$this->_ci =& get_instance();
		$this->_ci->config->load('klout');

		log_message('debug', 'Klout Class Initialized');
		$this->_initialize($params);
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize preferences
	 *
	 * @param	array
	 * @return	void
	 */
	public function _initialize($params = array())
	{
		$this->_response = '';
		foreach ($params as $key => $val)
		{
			$this->{'_'.$key} = (isset($this->{'_'.$key}) ? $val : $this->_ci->config->item($key));
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Manually Set Config
	 *
	 * Pass an array of config vars to override previous setup
	 *
	 * @param	array
	 * @return 	void
	 */
	public function set_config($config = array())
	{
		if ( ! empty($config))
		{
			$this->_initialize($config);
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Handle method call based on attempted route
	 *
	 * @param string $route API method being used
	 * @param mixed $params user string
	 * @return bool
	 * @author Patrick Popowicz
	 */
	public function __call($route, $params)
	{
		// Validate route against supported endpoints
		return (array_key_exists($route, $this->_klout_routes)) ? $this->_execute($route, $params[0]) : FALSE;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Builds a full profile for one user based on the main endpoints
	 *
	 * @param string $params user string
	 * @return mixed
	 * @author Patrick Popowicz
	 */
	public function profile($params)
	{
		// Preliminary checks and variable settings
		if (empty($params)) { return FALSE; }
		$this->_klout_format = 'json';
		
		// Pull out just the user object
		$user = json_decode($this->show_users($params));
		foreach($user as $value) { $profile = $value[0]; }
		
		// Pull user's topics
		//$topics = json_decode($this->show_topics($params));
		$topics = $this->show_topics($params);
		if (!empty($topics)) { foreach($topics->users as $value) { $profile->topics = (object) $value->topics; } } else { $profile->topics = new stdClass; }
		
		// Pull user's influencers
		$influencers = json_decode($this->influenced_by($params));
		foreach($influencers->users as $value) { $profile->influencers = (object) $value->influencers; }
		
		// Pull people influenced by the user
		$influencees = json_decode($this->influencer_of($params));
		foreach($influencees->users as $value) { $profile->influencees = (object) $value->influencees; }

		return $profile;
	}

	// ------------------------------------------------------------------------

	/**
	 * Executes the API request using cURL
	 *
	 * @param string $method API method being used
	 * @return mixed
	 * @author Patrick Popowicz
	 */
	private function _execute($route, $params)
	{
		// Preliminary checks and variable settings
		if (empty($params)) { return FALSE; }
		$users = (is_array($params)) ? implode(',', $params) : $params;
		$post = (substr_count($users, ',') > 0) ? TRUE : FALSE;

		// Set target URL
		$this->_target = $this->_klout_api . $this->_klout_routes[$route] . '.' . $this->_klout_format . '?' . 'key=' . $this->_klout_apikey . ((!$post) ? "&users={$users}" : '');
		
		// Use cURL to fetch
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_URL, $this->_target);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		
		if ($post)
		{
			curl_setopt($curl, CURLOPT_POST, $post);
			curl_setopt($curl, CURLOPT_POSTFIELDS, array('users' => $users));	
		}
		
		return ($this->_response = curl_exec($curl)) ? $this->_response : FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	* Returns the response value
	*
	* @return mixed
	* @author Patrick Popowicz
	*/
	public function response()
	{
		return $this->_response;
	}
	
	// ------------------------------------------------------------------------

	/**
	* Returns the last target value
	*
	* @return mixed
	* @author Patrick Popowicz
	*/
	public function last_target()
	{
		return $this->_target;
	}
}

/* End of file Klout.php */
/* Location: ./application/libraries/Klout.php */