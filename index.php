<?php

	// register the vendors including the Facebook SDK
	require 'vendor/autoload.php';

	// Load the FacebookSession class
	use Facebook\FacebookSession;

	// Set the initial Facebook App ID and Secret key
	// get your App ID and Secret from here (https://developers.facebook.com/apps/)
	$App_ID 	= "XXX";
	$App_Secret = "YYY";
	FacebookSession::setDefaultApplication($App_ID, $App_Secret);

	