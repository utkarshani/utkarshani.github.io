<?php
// Orginal Twiter API PHP https://github.com/pedroventura/pv-auto-tweets
// Twitter API PHP examples https://github.com/fxstar/auto-tweets-php-api

$consumerKey    = 'Consumer-Key';
$consumerSecret = 'Consumer-Secret';
$oAuthToken     = 'OAuthToken';
$oAuthSecret    = 'OAuth Secret';

# API OAuth
require_once('twitteroauth.php');
$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);

// get followers id list last 5000
echo $tweet->get('followers/ids', array('screen_name' => 'YOUR-SCREEN-NAME-USER', 'count'=> 5000));
//$tweet->get('followers/ids', array('screen_name' => 'YOUR-SCREEN-NAME-USER', 'cursor' => 9999999999));

// get followers list with name last 200
echo $tweet->get('followers/list', array('screen_name' => 'YOUR-SCREEN-NAME-USER', 'count' => 200));
//$tweet->get('followers/list', array('screen_name' => 'YOUR-SCREEN-NAME-USER', 'cursor' => 9999999999));

// send message to followers last 200
$out="";
$t = json_decode($tweet->get('followers/list', array('screen_name' => 'YOUR-SCREEN-NAME-USER', 'count' => 200)), true);
foreach ($t['users'] as $user) {
    $tweet->post('direct_messages/new', array('screen_name' => $user['screen_name'], 'text' => 'Hello!'));
    $out = $out."Username ".$user['screen_name']." ID ".$user['id_str']."<br>";
}
// save to file
file_put_contents('followers.txt', $out);

// send private message
echo $tweet->post('direct_messages/new', array('screen_name' => 'SCREEN-NAME-USER', 'text' => 'Hell ha wrrrrrrr......'));

// New Tweet message
$tweetMessage = 'This is a tweet to my Twitter account via PHP @fxstareu. PHP API the best ...';

// Check for 140 characters
if(strlen($tweetMessage) <= 140)
{    
   echo  $tweet->post('statuses/update', array('status' => $tweetMessage));
}

// Auto follow users
function auto_follow($toa)
{ 
    $followers = $toa->get('followers/ids', array('cursor' => -1));
    $friends = $toa->get('friends/ids', array('cursor' => -1));
 	
 	$a = json_decode($followers, true);
 	$b = json_decode($friends, true);
 	
    foreach ($a['ids'] as $id) {
        if (empty($b['ids']) or !in_array($id, $b['ids'])) {
        	echo $id." Following user <br>";
            $ret = $toa->post('friendships/create', array('user_id' => $id));
        }
    }
}

// Follow yours followers 
auto_follow($tweet);

// search users and follow
function searchAndFollow($tweet, $search = "fxstareu"){
	$users = $tweet->get('users/search', array('q' => $search));
	$a = json_decode($users, true);
	foreach ($a as $key => $user) {
		echo $user['screen_name']." Follow user <br>";
		$ret = $tweet->post('friendships/create', array('user_id' => $user['id']));
	}
	//print_r($a);
}

// search and follow
searchAndFollow($tweet, "fxstareu");


// all followers to file with send private messages 
// (request limit 180 per 15 min)
$out="";
$cursor = "-1";

$t = json_decode($tweet->get('followers/list', array('screen_name' => 'microsoft', 'count' => 200)), true);
if (isset($t['errors'])) {
	echo "ERRORS !!!!! ";
	print_r($t['errors']);
	die();
}

$cursor = $t['next_cursor_str'];
while ($cursor != 0) {
	foreach ($t['users'] as $user) {
	    //$tweet->post('direct_messages/new', array('screen_name' => $user['screen_name'], 'text' => 'Hello!'));
	    $out = $out.$user['screen_name']."<br>";
	}
	$out = $out."NEXTPART";
	sleep(1);	
	$t = json_decode($tweet->get('followers/list', array('screen_name' => 'microsoft', 'cursor' => $cursor, 'count' => 200)),true);
	$cursor = $t['next_cursor_str'];
}

echo $out;
// save to file
file_put_contents('users.txt', $out);



// Geo location town lat long
// search geo
function searchGeoLatLong($tweet, $lat = "37.7821120598956", $long = "-122.400612831116", $max = "500"){
	$users = $tweet->get('geo/search', array('lat' => $lat, 'long' => $long, 'max_results' => $max));
	$a = json_decode($users, true);
	echo "<pre>";
	print_r($a);
	foreach ($a as $key => $user) {
		//echo $user['screen_name']." Follow user <br>";
		//$ret = $tweet->post('friendships/create', array('user_id' => $user['id']));
	}
	
}
function searchGeoTown($tweet, $search = "NewYork", $max = "500"){
	$users = $tweet->get('geo/search', array('query' => $search, 'max_results' => $max));
	$a = json_decode($users, true);
	echo "<pre>";
	print_r($a);
	foreach ($a as $key => $user) {
		//echo $user['screen_name']." Follow user <br>";
		//$ret = $tweet->post('friendships/create', array('user_id' => $user['id']));
	}
	
}
// search and follow
searchGeoTown($tweet, "warszawa");
searchGeoLatLong($tweet, "37.7821120598956", "-122.400612831116");
?>
