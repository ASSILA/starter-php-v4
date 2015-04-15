<?php

	// register the vendors including the Facebook SDK
	require 'vendor/autoload.php';

	// Load the Facebook classes
	use Facebook\FacebookSession;
	use Facebook\FacebookRequest;
	use Facebook\GraphPage;
	
	// Set the initial Facebook App ID and Secret key
	// get your App ID and Secret from here (https://developers.facebook.com/apps/)
	$App_ID 	= "XXX";
	$App_Secret = "YYY";
	FacebookSession::setDefaultApplication($App_ID, $App_Secret);

	// Get the Application level Access Token
	$session = FacebookSession::newAppSession();
	
	// Using Graph API to get a Page information
	$page = (new FacebookRequest(
		$session, 'GET', '/Jawwal.059'
	))->execute()->getGraphObject(GraphPage::className());
	// Output page name.
	echo $page->getName();