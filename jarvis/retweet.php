<?php
try{
error_reporting('E_ALL');
set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');
echo '<head><meta http-equiv="refresh" content="600"></head>';

$consumerKey    = '';
$consumerSecret = '';
$oAuthToken     = '';
$oAuthSecret    = '';
	
# path folder
$path = dirname("__FILE__");
$dir = (__DIR__);
	
# API OAuth
require_once(twitteroauth.php');


$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);

// Szukaj posty użytkownika i polub jego posty i retweetuj
// Search homeline and like or retweet posts
// cnt - how many posts
function userHomeRT($tweet, $qu = "@fxstareu", $like = 1, $rt = 1, $cnt = 10){
	$x = $tweet->get('statuses/home_timeline', array('screen_name' => $qu, 'count' => $cnt));
	$a = json_decode($x, true);
	echo "<pre>";
	//print_r($a);
	foreach ($a as $key => $user) {
		// echo $user['id_str']." ";

		if ($like == 1) {
			// like
			echo $ret = $tweet->post('favorites/create', array('id' => $user['id_str']));
		}
		
		if ($rt == 1) {
			// retweet
			echo $ret = $tweet->post('statuses/retweet', array('id' => $user['id_str']));
		}		
	}	
}


// Retweet homeline posts
userHomeRT($tweet, "@qflashpl", 5);

// Send tweet
// $tweet->post('statuses/update', array('status' => '💚 #qflashpl http://qflash.pl 😍 http://qflash.pl/qflash-pl') );
$tweet->post('statuses/update', array('status' => 'Komunikator internetowy 💚 #qflashpl http://qflash.pl 😍 http://qflash.pl/qflash-pl '.date('Y-m-d H',time()) ) );
echo "<br>Works fine :)";

}catch(Exception $e){
	echo "Some error <br>";
	// get error code and message
	echo $e->getCode();
	echo '<br>';
	echo $e->getMessage();
}
?>
