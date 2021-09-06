<?php
include 'basic.php';
$dag="";
for ($i=16;$i<=120;$i++) {
  $dag.="<option>$i</option>";
}
?>
<html>
  <head>
    <title>Sign Up For NeoConvo</title>
    <link rel="icon" href="Images/neoLogo.PNG" type="image/png">
    <link rel="stylesheet" href='styles.css'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
  <body>
  <?php if ($mobile==1) { ?>
    <div class='head-m'><a href='index.php' style='text-decoration:none;color:white;'>NeoConvo</a></div>
    <div class='economica' style='font-size:25px;margin:20px 20px 0px 20px;width:calc(100% - 40px);color:white;'>
      Sign Up for NeoConvo
      <div class='narrow' style='font-size:15px;'>
        It's quick and easy.<br><br>
        <form action='register.php' method='post'>
        <input type='text' name='uname' class='narrow' placeholder='Username'
style='width:100%;border:none;height:35px;font-size:16px;padding-left:15px;margin-bottom:10px;border-radius:35px;' />
 <input type='text' name='fname' class='narrow' placeholder='Full Name'
style='width:100%;border:none;height:35px;font-size:16px;padding-left:15px;margin-bottom:10px;border-radius:35px;' />
<input type='email' name='email' class='narrow' placeholder='Email'
style='width:100%;border:none;height:35px;font-size:16px;padding-left:15px;margin-bottom:10px;border-radius:35px;' />
  <select name='gender' class='narrow'
style='width:100%;border:none;height:35px;font-size:16px;padding-left:15px;margin-bottom:10px;border-radius:35px;background-color:white;' >
<option>Male</option>
<option>Female</option>
</select>
<div style='height:35px;line-height:35px;width:15%;float:left;'>Age:</div>
    <select name='age' class='narrow'
style='width:85%;border:none;height:35px;font-size:16px;padding-left:15px;margin-bottom:10px;background-color:white;border-radius:35px;' >
<?php echo $dag; ?>
</select>
        <input type='password' name='password' class='narrow' placeholder='Password'
style='width:100%;border:none;height:35px;font-size:16px;padding-left:15px;margin-bottom:10px;border-radius:35px;' />
        <input type='submit' name='submit' value='Sign Up' class='narrow pott'
style='width:100%;height:40px;font-size:16px;padding-left:15px;border-radius:40px;' />
        </form><br>
        Already have an account? <a href='login.php' style='text-decoration:none;color:white;font-weight:bold;'>Log In</a>
      </div>
    </div>
  <?php } else { ?>
    <div class='head'><a href='index.php' style='text-decoration:none;color:white;'>NeoConvo</a></div>
    <div style='border-top:0.5px solid white;margin: 0px 0px 0px 20px;color:white;'>
      <div class='narrow' style='margin-left:20px;width:calc(40% - 20px);border-right:height:100%;float:left;font-size:18px;'>
        </br></br>
        <h1 class='economica' style='font-size:40px;font-weight:100;'>
        Sign Up for NeoConvo
        </h1>
        It's quick and easy.<br><br>
	<form action='register.php' method='post'>
          <input type='text' name='fname' class='narrow' placeholder='Full Name'
          style='width:300px;border:none;height:35px;font-size:18px;padding-left:15px;margin-bottom:10px;border-radius:35px;' /><br>
          <input type='text' name='uname' class='narrow' placeholder='Username'
          style='width:300px;border:none;height:35px;font-size:18px;padding-left:15px;margin-bottom:10px;border-radius:35px;' /><br>
	  <input type='email' name='email' class='narrow' placeholder='Email'
          style='width:300px;border:none;height:35px;font-size:18px;padding-left:15px;margin-bottom:10px;border-radius:35px;' /><br>
          <select name='gender' class='narrow'
          style='width:300px;border:none;height:35px;font-size:18px;padding-left:15px;margin-bottom:10px;border-radius:35px;'>
	  <option>Male</option>
	  <option>Female</option>
	  </select>
	  <br>
    <select name='year' class='narrow'
          style='width:300px;border:none;height:35px;font-size:18px;padding-left:15px;margin-bottom:10px;border-radius:35px;'>
	  <option>Freshman</option>
	  <option>Sophmore</option>
    <option>Junior</option>
    <option>Senior</option>
	  </select>
	  <br>
          <input type='password' name='password' class='narrow' placeholder='Password'
          style='width:300px;border:none;height:35px;font-size:18px;padding-left:15px;margin-bottom:10px;border-radius:35px;' /><br>
          <input type='submit' name='submit' value='Sign Up' class='narrow pott'
          style='width:300px;height:40px;font-size:18px;padding-left:15px;margin-bottom:10px;border-radius:40px;' />
        </form>
        Already have an account? <a href='login.php' style='text-decoration:none;color:white;'>Log In</a>
      </div>
      <img alt="welcome-image" src='Images/phone.jpg' style='width:60%;height:calc(100% - 71px);object-fit:cover;float:right;margin:0px 0px 0px 0px;'>
    </div>
  <?php } ?>
  </body>
</html>
<?php
if (isset($_POST['submit']) && !empty($_POST['email']) &&  !empty($_POST['fname'])  && !empty($_POST['uname']) && !empty($_POST['password'])) {
  include 'basic.php';
  $uname=$_POST['uname'];
  $fname=$_POST['fname'];
  $email=$_POST['email'];
  $pass=$_POST['password'];
  $year=$_POST['year'];
  $gender=$_POST['gender'];

  try {
    $sql="INSERT INTO MAIN (uname, fname, email, gender, age, password)
    VALUES ('$uname', '$fname', '$email', '$gender', '$year', '$pass');";
    $conn->exec($sql);
    $_SESSION['id']=$conn->lastInsertId();
    echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';
  } catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
  }
}
// 108 lines of code
?>
