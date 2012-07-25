<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Klout API v1 library for CodeIgniter
*
* @license Creative Commons Attribution 3.0 <http://creativecommons.org/licenses/by/3.0/>
* @version 1.0
* @author Patrick Popowicz <http://patrickpopowicz.com>
* @copyright Copyright (c) 2011, Patrick Popowicz <http://patrickpopowicz.com>
*/

/*
|--------------------------------------------------------------------------
| Klout API Target Url
|--------------------------------------------------------------------------
|
| URL target for the Klout API.
|
*/
$config['klout_api']		= "http://api.klout.com/1/";

/*
|--------------------------------------------------------------------------
| Klout API Key
|--------------------------------------------------------------------------
|
| API key provided by Klout after logging in to Mashable.
|
*/
$config['klout_apikey']		= "";

/*
|--------------------------------------------------------------------------
| Klout Response Format
|--------------------------------------------------------------------------
|
| Data format of the expected response.
|
| Supported formats ar:
|	* json (default)
|	* xml
|
*/
$config['klout_format']		= "json";

/*
|--------------------------------------------------------------------------
| Klout Supported Endpoint Routes
|--------------------------------------------------------------------------
|
| Routes for supported endpoints.
|
|	$config['klout_routes']['show_users'] = 'users/how';
|
| This route indicates which endpoint should be loaded when the named route
| is called. In the below example, the "users/how" endpoint would be
| loaded when $this->klout->show_users() is called.
|
|	$config['klout_routes']['show_users'] = 'users/show';
|
*/
// Standard routes
$config['klout_routes']['klout']			= "klout";
$config['klout_routes']['show_users']		= "users/show";
$config['klout_routes']['show_topics']		= "users/topics";
$config['klout_routes']['influenced_by']	= "soi/influenced_by";
$config['klout_routes']['influencer_of']	= "soi/influencer_of";

// Vanity routes
$config['klout_routes']['score']			= "klout";
$config['klout_routes']['influencers']		= "soi/influenced_by";
$config['klout_routes']['influencees']		= "soi/influencer_of";

/* End of file klout.php */
/* Location: ./application/config/klout.php */