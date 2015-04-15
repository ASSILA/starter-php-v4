<?php

	// register the vendors including the Facebook SDK
	require 'vendor/autoload.php';

	// Load the Facebook classes
	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	
	// Set the initial Facebook App ID and Secret key
	// get your App ID and Secret from here (https://developers.facebook.com/apps/)
	$App_ID 	= "XXX";
	$App_Secret = "YYY";
	FacebookSession::setDefaultApplication($App_ID, $App_Secret);
	
	// login helper with redirect_uri
	$helper = new FacebookRedirectLoginHelper( 'http://localhost/facebook/' );

	try {
		// Check if you already have an access token in the PHP Session
		if ( isset( $_SESSION['access_token'] ) ) {
			// Create new FacebookSession directly from the Access Token.
			$session = new FacebookSession( $_SESSION['access_token'] );
		} else {
			// Get access token from the code parameter in the URL.
			$session = $helper->getSessionFromRedirect();
			// store the access token in a PHP Session.
			if($session) $_SESSION['access_token'] = $session->getToken();
		}
	} catch( FacebookRequestException $ex ) {
		// When Facebook returns an error.
		$session = null;
	} catch( \Exception $ex ) {
		// When validation fails or other local issues.
		$session = null;
	}

	if ( isset( $session ) ) {
		// Successfully got a valid session for the user
		echo "Logged In";
	} else {
		// Generate the login URL for Facebook authentication.
		$loginUrl = $helper->getLoginUrl();
		echo '<a href="' . $loginUrl . '">Login</a>';
	}