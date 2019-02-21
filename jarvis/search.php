<?php
set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');
echo '<head><meta http-equiv="refresh" content="600"></head>';

$consumerKey    = '';
$consumerSecret = '';
$oAuthToken     = '';
$oAuthSecret    = '';

$consumerKey    = '';
$consumerSecret = '';
$oAuthToken     = '';
$oAuthSecret    = '';

$e_up = '⬆️';
$e_up1 = '▲';

echo $up = "&#x25B2;";
echo $dn = "&#x25BC;";

echo $up = "&#9650;";
echo $dn = "&#9660;";


# API OAuth
require_once('twitteroauth.php');

$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);

# your code to retrieve data goes here, you can fetch your data from a rss feed or database

// szukaj popularnych tweetów
function search($tweet, $q = "tv"){
	$users = $tweet->get('search/tweets', array('q' => $q, 'lang' => "pl", 'result_type' => 'popular'));
	$a = json_decode($users, true);
	echo "<pre>";
	print_r($a);
	foreach ($a as $key => $user) {
		//echo $user['screen_name']." ".$user['id']." Follow user <br>";
		//$ret = $tweet->post('friendships/create', array('user_id' => $user['id']));
	}	
}

//search($tweet, $q = "ma");


// search users and follow
function podpowiedzi1($tweet){
	$users = $tweet->get('users/suggestions', array('max_results' => ""));
	$a = json_decode($users, true);
	echo "<pre>";
	print_r($a);
	foreach ($a as $key => $user) {
		//echo $user['screen_name']." Follow user <br>";
		//$ret = $tweet->post('friendships/create', array('user_id' => $user['id']));
	}	
}
//podpowiedzi1($tweet);

// szukaj i frenduj
function podpowiedzi($tweet, $q = "muzyka"){
	$users = $tweet->get('users/search', array('q' => $q));
	$a = json_decode($users, true);
	echo "<pre>";
	//print_r($a);
	foreach ($a as $key => $user) {
		echo $user['screen_name']." ".$user['id']." Follow user <br>";
		$ret = $tweet->post('friendships/create', array('user_id' => $user['id']));
	}	
}
//podpowiedzi($tweet);

// search sugestion and follow 
function podpowiedzi2($tweet){
	$users = $tweet->get('users/suggestions', array('max_results' => ""));
	$a = json_decode($users, true);
	echo "<pre>";
	print_r($a);
	foreach ($a as $key => $user) {
		podpowiedzi($tweet, $user['name']);
		//echo $user['screen_name']." Follow user <br>";
		//$ret = $tweet->post('friendships/create', array('user_id' => $user['id']));
	}	
}
//podpowiedzi2($tweet);


// search users
function searchGeoLatLongAndFollow($tweet, $lat = "37.7821120598956", $long = "-122.400612831116", $max = "500"){
	$users = $tweet->get('geo/search', array('lat' => $lat, 'long' => $long, 'max_results' => $max));
	$a = json_decode($users, true);
	echo "<pre>";
	print_r($a);
	foreach ($a as $key => $user) {
		//echo $user['screen_name']." Follow user <br>";
		//$ret = $tweet->post('friendships/create', array('user_id' => $user['id']));
	}
	
}
// geo location
function searchGeoTownAndFollow($tweet, $search = "NewYork", $max = "500"){
	$users = $tweet->get('geo/search', array('query' => $search, 'max_results' => $max));
	$a = json_decode($users, true);
	echo "<pre>";
	print_r($a);
	foreach ($a as $key => $user) {
		//echo $user['screen_name']." Follow user <br>";
		//$ret = $tweet->post('friendships/create', array('user_id' => $user['id']));
	}
	
}
// search town and WOEID
function searchPlaceGeo($tweet, $lat = "52.23", $lng = "21.01"){
	//Your search URL is: https://api.twitter.com/1.1/search/tweets.json?q=&geocode=-22.912214,-43.230182,1km&lang=pt&result_type=recent
	//$users = $tweet->get('trends/place', array('id' => $qu, 'exclude' => "hashtags"));
	$users = $tweet->get('trends/closest', array('lat' => $lat, 'long' => $lng));
	$a = json_decode($users, true);
	echo "<pre>";
	print_r($a);
	foreach ($a as $key => $user) {
		//echo $user['screen_name']." Follow user <br>";
		//$ret = $tweet->post('friendships/create', array('user_id' => $user['id']));
	}	
}
//searchPlaceGeo($tweet, "52.23", "21.01");

// Szukaj posty użytkownika i polub jego posty i retweetuj
function userPostHome($tweet, $qu = "@fxstareu", $cnt = 1){
	$x = $tweet->get('statuses/home_timeline', array('screen_name' => $qu, 'count' => $cnt));
	$a = json_decode($x, true);
	echo "<pre>";
	//print_r($a);
	foreach ($a as $key => $user) {
		echo $user['id_str']." ";
		echo $ret = $tweet->post('favorites/create', array('id' => $user['id_str']));
		echo $ret = $tweet->post('statuses/retweet', array('id' => $user['id_str']));
	}	
}
userPostHome($tweet, "@fxstarbot", 6);


// Szukaj posty użytkownika i polub posty
function userPost($tweet, $qu = "@fxstareu", $cnt = 1){
	$x = $tweet->get('statuses/user_timeline', array('screen_name' => $qu, 'count' => $cnt));
	$a = json_decode($x, true);
	echo "<pre>";
	print_r($a);
	foreach ($a as $key => $user) {
		echo $user['id_str']." ";
		echo $ret = $tweet->post('favorites/create', array('id' => $user['id_str']));
	}	
}
//userPost($tweet, "@fxstareu", 5);


// Szukaj posty użytkownika i retwwetuj
function userPostRetweet($tweet, $qu = "@fxstareu", $cnt = 1){
	$x = $tweet->get('statuses/user_timeline', array('screen_name' => $qu, 'count' => $cnt));
	$a = json_decode($x, true);
	echo "<pre>";
	print_r(asort($a));
	foreach ($a as $key => $user) {
		echo $user['id_str']." ";
		echo $ret = $tweet->post('statuses/retweet', array('id' => $user['id_str']));
	}	
}
//userPostReTweet($tweet, "@fxstareu", 5);


// search hashtags with place -- Popularne #hashtagi and tweet wth hashtag
function searchPlace($tweet, $qu = 1){
	//Your search URL is: https://api.twitter.com/1.1/search/tweets.json?q=&geocode=-22.912214,-43.230182,1km&lang=pt&result_type=recent
	//$users = $tweet->get('trends/place', array('id' => $qu, 'exclude' => "hashtags"));
	$users = $tweet->get('trends/place', array('id' => $qu));
	$a = json_decode($users, true);
	echo "<pre>";
	print_r($a);
	if ($a['errors'][0]['code'] == 34) {
		echo "Podaj inną lokalizację! (ERROR)";
		die();
	}
	foreach ($a[0]['trends'] as $key => $user) {
		
		$msg = "#Witaj ".$user['name']." Jest godzina ".date('H:i:s',time())."";
		if(strlen($msg) <= 140)
		{
		   echo $user['name'];    
		   $ss = $tweet->post('statuses/update', array('status' => $msg));
		   file_put_contents('twitter.txt', $ss, FILE_APPEND | LOCK_EX);
		}
		//$ret = $tweet->post('friendships/create', array('user_id' => $user['id']));
	}	
}
// Polska 	23424923
// koszalin 501584, Warszawa 523920 Wrocław 526363, Kraków 502075, szczecin 521598, Poznań 514048, Lublin 514049, bialystok 486134
//searchPlace($tweet, 23424923);


// search tweets with word or geocode
function searchGeo($tweet, $qu = ""){
	// Your search URL is: https://api.twitter.com/1.1/search/tweets.json?q=&geocode=-22.912214,-43.230182,1km&lang=pt&result_type=recent
	$users = $tweet->get('search/tweets', array('q' => $qu));
	$a = json_decode($users, true);
	echo "<pre>";
	print_r($a);
	foreach ($a as $key => $user) {
		//echo $user['screen_name']." Follow user <br>";
		//$ret = $tweet->post('friendships/create', array('user_id' => $user['id']));
	}
	
}
//searchGeo($tweet, "fxstar");

// time line
function searchUser($tweet, $qu = "fxstareu"){
	// Your search URL is: https://api.twitter.com/1.1/search/tweets.json?q=&geocode=-22.912214,-43.230182,1km&lang=pt&result_type=recent
	$users = $tweet->get('statuses/user_timeline', array('screen_name' => $qu));
	$a = json_decode($users, true);
	echo "<pre>";
	print_r($a);
	foreach ($a as $key => $user) {
		//echo $user['screen_name']." Follow user <br>";
		//$ret = $tweet->post('friendships/create', array('user_id' => $user['id']));
	}	
}
//searchUser($tweet, "fxstareu");


// search and follow
//searchGeoTownAndFollow($tweet, "warszawa");
//searchGeoLatLongAndFollow($tweet, "37.7821120598956", "-122.400612831116");


//$tweet->post('statuses/update', array('status' => 'here the content of your tweet, you can add hashtags or links'));
echo "Hello";
?>
