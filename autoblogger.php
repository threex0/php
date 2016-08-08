<?php
session_start(); //Start an HTTP Session
require_once realpath(dirname(__FILE__) . '/vendor/autoload.php'); //Requirement to have the Google API library installed
	//Use Composer if possible!
require_once("env.php"); //Environment Variables
require_once("errors.php"); //Verbose Logging
require_once("random.php"); //Contains current loginc for random posting
/************************************************
  ATTENTION: Fill in these values! Make sure
  the redirect URI is to this page, e.g:
  http://localhost:8080/user-example.php
  Defined in evn.php file:
  $client_id
  $client_secret
  $redirect_uri
 ************************************************/
$client = new Google_Client();  //Create new client object
$client->setClientId($client_id);  //Set ClientID in client object
$client->setClientSecret($client_secret);  //Set Client Secret in client object
$client->setAccessType("offline"); //Offline and prompt allow me to run the script indefinitely without re-auth
$client->setApprovalPrompt("force");
$client->setDeveloperKey($apiKey); //Set to my blog's API key
$client->setRedirectUri($redirect_uri); //Redirect URI's must also be approved on Google's API Auth side
$client->setScopes('email');  //At the bare minimum the profile/email scope is required for access for most Google apps.
$client->setScopes('profile');
$client->setScopes('https://www.googleapis.com/auth/blogger');
//$client->useApplicationDefaultCredentials();
/************************************************
  If we're logging out we just need to clear our
  local access token in this case
 ************************************************/
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}
/************************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
 ************************************************/
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}
/************************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}
/************************************************
  If we're signed in we can go ahead and retrieve
  the ID token, which is part of the bundle of
  data that is exchange in the authenticate step
  - we only need to do a network call if we have
  to retrieve the Google certificate to verify it,
  and that can be cached.
 ************************************************/
if ($client->getAccessToken()) {
  $_SESSION['access_token'] = $client->getAccessToken();
  $token_data = $client->getAccessToken();
  //var_dump($refresh);
  
  if($client->isAccessTokenExpired()) {
	  
  }
}
echo "User Query - Retrieving An Id Token";
if (strpos($client_id, "googleusercontent") == false) {
  echo missingClientSecretsWarning();
  exit;
}

if (isset($authUrl)) {
  echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
} else {
  echo "<a class='logout' href='?logout'>Logout</a>";
}


if (isset($token_data)) {
	$blogger = new Google_Service_Blogger($client);  //Blogger Object from Google PHP API library
	$post = new Google_Service_Blogger_Post;  //Post Object
	$author = new Google_Service_Blogger_PostAuthor; //Author Object
	$blog = new Google_Service_Blogger_PostBlog; //This object contains the actual POST methods, so it's important to use this one. 

	//Set Author ID, ID is pulled from Blogger
	$author->setId($bloggerUser);
	//Set the Blog ID
	$blog -> setId($blogId);		
	//Interval between posts in seconds
	$postIntvl = 300;
	
	//echo("Entering Loop");
	while(true) {  //Runs indefinitely.  I would cron this, but that requires an automatic login to google
		//Subsequently this requires a service account.
		//Blogger does not support service accounts at this time, probably to prevent this exact behaviour
		//This is a workaround, I run this on a custom server without a curl timeout and so I can kill the process if it fails
		$content = create_nonsense();  //random.php creates nonsense paragraphs
		$title = create_title(); //creates one random line per
		
		//Set various attributes of the post below before posting them.
		$post->setAuthor($author); 
		$post->setBlog($blog);
		$post->setContent($content . "<br/><br/>  My name is Autoblognonymous, I post every 5 minutes when I can.");
		$post->setTitle($title);
		//Get a reply from the http post object
		$postReply = $blogger->posts->insert($blogId,$post);
		//var_dump($postReply);
		
		sleep($postInvl);
	}
	
	//var_dump($token_data);
}
?>
