<?php

	session_start();
	
	// register the vendors including the Facebook SDK
	require 'vendor/autoload.php';

	// Load the Facebook classes
	use Facebook\Facebook;
	
	// Set the initial Facebook App ID and Secret key
	// get your App ID and Secret from here (https://developers.facebook.com/apps/)
	$AppID 	= "XXX";
	$AppSecret = "YYY";
	
	// get the current AccessToken from the session if exists
	$accessToken = (isset($_SESSION['facebook_access_token']))? $_SESSION['facebook_access_token'] : null;
	
	// initiate the Facebook class
	$fb = new Facebook([
		'app_id' => $AppID,
		'app_secret' => $AppSecret,
		'default_access_token' => $accessToken
	]);
	
	try {
		// if there is no AccessToken in the PHP Session
		if(!$accessToken){
			// try to get new AccessToken from the RedirectLoginHelper
			$helper = $fb->getRedirectLoginHelper();
			$accessToken = $helper->getAccessToken();
			
			// Update the Default AccessToken
			$fb->setDefaultAccessToken($accessToken);
			
			// store the new AccessToken in the PHP Session
			$_SESSION['facebook_access_token'] = (string) $accessToken;
		}
	} catch( FacebookSDKException $ex ) {
		// When Facebook returns an error.
		$accessToken = null;
	} catch( \Exception $ex ) {
		// When validation fails or other local issues.
		$accessToken = null;
	}

	if (isset($accessToken)) {
		// Logged in!
		try {
			// Get the current user info
			$response = $fb->get('me');
			
			// Output user name.
			$me = $response->getGraphUser();
			echo $me->getName();
			
		} catch (FacebookRequestException $ex) {
			// The Graph API returned an error.
			print_r( $ex );
		} catch (\Exception $ex) {
			// Some other error occurred.
			print_r( $ex );
		}
	} else {
		// Not logged in!
		$helper = $fb->getRedirectLoginHelper();
		$loginUrl = $helper->getLoginUrl('http://localhost/starter-php-v4/',array('email'));
		echo '<a href="' . $loginUrl . '">Login</a>';
	}