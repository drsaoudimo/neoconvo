<?php
include 'basic.php';
if (isset($id)) {
    include 'home1.php';
} else { 
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>NeoConvo</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="Images/neoLogo.PNG" type="image/png">
        <link rel="apple-touch-icon" href="Images/neoLogo.PNG">
        <link rel='stylesheet' href='styles.css'>
    </head>
    <body>

    <?php if ($mobile==1) { ?>

    <div class='head-m'><a href='index.php' style='text-decoration:none;color:white;'>NeoConvo</a></div>
    <div class='economica' style='font-size:25px;margin:20px 20px 0px 20px;width:calc(100% - 40px);color:white;'>
      Log Into NeoConvo
      <div class='narrow' style='font-size:16px;'>
        It's free and always will be.<br><br>
	<form action='index.php' method='post'>
	<input type='text' name='uname' autocomplete='off' class='narrow' placeholder='Username'
style='width:100%;border:none;height:35px;font-size:16px;padding-left:15px;margin-bottom:10px;border-radius:35px;' />
	<input type='password' name='password' class='narrow' placeholder='Password'
style='width:100%;border:none;height:35px;font-size:16px;padding-left:15px;margin-bottom:10px;border-radius:35px;' />
	<input type='submit' name='submit' value='Log In' class='narrow pott'
style='width:100%;height:40px;font-size:16px;padding-left:15px;border-radius:40px;' />
	</form><br>
	Don't have an account? <a href='register.php' style='text-decoration:none;color:white;font-weight:bold;'>Sign Up</a>
      </div>
    </div>

<?php } else {?>

  <div class='head'><a href='index.php' style='text-decoration:none;color:white;'>NeoConvo</a></div>
    <div style='border-top:0.5px solid white;margin: 0px 0px 0px 20px;color:white;'>
      <div class='narrow' style='margin-left:20px;height:calc(100%- 60px);font-size:18px;'>
        </br></br>
        <h1 class='economica' style='font-size:40px;font-weight:100;'>
        Log Into NeoConvo
        </h1>
        It's free and always will be.<br><br>
	<form action='index.php' method='post'>
        <input type='text' name='uname' class='narrow inp' placeholder='Username'/><br>
        <input type='password' name='password' class='narrow inp' placeholder='Password'/><br>
        <input type='submit' name='submit' value='Log In' class='narrow lbtn'/>
        </form>
        Don't have an account? <a href='register.php' style='color:white;text-decoration:none;'>Create one.</a>

      </div>
    </div>

<?php // 250 lines of code 
} ?>
<div class='narrow' style='text-align:center;color:#757575;background-color:#f2f2f2;font-size:15px;padding-top:20px;padding-bottom:20px;'>
<a href='terms.php' class='pinks'>Terms of Service</a> ·
<a href='privacy.php' class='pinks'>Privacy Policy</a>
<div style='margin-left:15%;border-top:#ccc 1px solid;width:70%;margin-top:20px;margin-bottom:20px;'></div>
© 2021 Netonvo.&nbsp All rights reserved.
</div>

<?php } ?>
  </body>
</html>

<?php

require_once('retrieve.php');

// check form submission
if (isset($_POST['submit']) && !empty($_POST['uname']) && !empty($_POST['password'])) {
  $uname=$_POST['uname'];
  $passw=$_POST['password'];
  // get user id
  $id = get_id($conn, $uname, $passw);
  // check user credentials
  if ($id > 0) {
      // user credentials are correct
      $_SESSION['id'] = $id;
      echo '<meta http-equiv="refresh" content="0; url=index.php">';
  } else {
      // user credentials are incorrect
      if ($mobile==1) {
          echo '<div class="narrow" style="text-align:left;padding-left:20px;color:red;font-size:16px;width:calc(100% - 20px);">Wrong Email and/or Password.</div>';
      } else {
          echo "<div class='narrow' style='font-size:18px;margin-left:40px;color:red;'>Wrong Email and/or Password.</div>";
      }
  }
}
?>