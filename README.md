CodeIgniter-Klout
====================

Installation
------------

1. Add config/klout.php file to your application/config folder.
2. Add libraries/Klout.php file into your application/libraries folder.

Requirements
------------

1. CodeIgniter
2. Klout API Key, `http://developer.klout.com/`

Initializing the Library
------------------------

Values used by the API can be set one of three ways

* by entering the values in the library's config file (i.e. config/klout.php)
* by passing the values in an array when loading the library (i.e. $this->load->library('klout', $params))
* by manually overriding prior values by passing an array to the set_config() method

#### set_config( array *$params* )

`$params = array(
				'klout_apikey' => 'apikey',
				'klout_format' => 'json',
				);
$this->klout->set_config($params));`

API Methods
-----------

## Klout

klout( mixed *$users*)

Method returns the Klout score for one or more users.

#### Usage

`if ($result = $this->klout->klout('twitter_user'))
{
	// Parameters correctly set, $result will be whatever the API returns
}`

#### Parameters

**users : The user or users that need scores returned**

* The users parameter can also be either a numerical array or comma-separated string
* Method may also be called using $this->klout->score()

## Show_Users

show_users( mixed *$users*)

Method returns the extended information for one or more users.

#### Usage

`if ($result = $this->klout->show_users('twitter_user'))
{
	// Parameters correctly set, $result will be whatever the API returns
}`

#### Parameters

**users : The user or users that need information returned**

* The users parameter can also be either a numerical array or comma-separated string

## Show_Topics

show_topics( mixed *$users*)

Method returns up to five influential topics for one or more users.

#### Usage

`if ($result = $this->klout->show_users('twitter_user'))
{
	// Parameters correctly set, $result will be whatever the API returns
}`

#### Parameters

**users : The user or users that need information returned**

* The users parameter can also be either a numerical array or comma-separated string
* The information returned by Show_Topics can be unreliable. If a user has no topics, the API returns `NULL` with JSON and an empty `users` tag with XML

## Influenced_By

influenced_by( mixed *$users*)

Method returns up to five users that influence for one or more users.

#### Usage

`if ($result = $this->klout->influenced_by('twitter_user'))
{
	// Parameters correctly set, $result will be whatever the API returns
}`

#### Parameters

**users : The user or users that need information returned**

* The users parameter can also be either a numerical array or comma-separated string
* Method may also be called using $this->klout->influencers()

## Influencer_Of

influencer_of( mixed *$users*)

Method returns up to five users one or more users influence.

#### Usage

`if ($result = $this->klout->influencer_of('twitter_user'))
{
	// Parameters correctly set, $result will be whatever the API returns
}`

#### Parameters

**users : The user or users that need information returned**

* The users parameter can also be either a numerical array or comma-separated string
* Method may also be called using $this->klout->influencees()

## Profile

profile( string *$user*)

Method returns the a compiled profile based on the above methods for a single user in a stdClass object.

#### Usage

`if ($result = $this->klout->profile('twitter_user'))
{
	// Parameters correctly set, $result will be whatever the API returns
}`

#### Parameters

**user : The user to be profiled**

* The user parameter must be a single user string


### Note: Klout API Response & Return Values
Depending on the return format, the return value will change. The response() method will return whatever was returned by the Klout API is the chosen format, no additional formatting is done (i.e. JSON and XML will still need to be parsed). The last target URL that was called can be shown by calling the last_target() method.

For more information on the API, see `http://developer.klout.com/`.

#### Changes

2011-12-03

* Initial