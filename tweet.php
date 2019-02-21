<?php
require_once("jarvis/twitteroauth.php"); //Path to twitteroauth library you downloaded in step 3
 
$twitteruser = "UtkarshaniJ"; //user name of twitter account
$notweets = 5; //no tweets you want to retrieve
$consumerkey = "SgWdidbZOAKZC9ywCJ09yPNHp"; 
$consumersecret = "r10X17U2PkYp3uGZJymMHkR1bYqv5Am29V1vDarnzRexFYMqAO"; 
$accesstoken = "1273912386-kDXkKTgpOqXUq5lF2ovjM94MSGWYuYZlepHAH9P"; 
$accesstokensecret = "CCtW9l8jTbubx5wMpnLx1wMgjmn6RuzoZwpukOvNjmrN0"; 
 
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}
 
$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
 
$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);

echo $tweets;