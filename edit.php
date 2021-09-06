<?php
include 'basic.php';
$title="Settings";
if (isset($_POST['code'])) {
    $code=$_POST['code'];
} elseif (isset($_SESSION['code'])) {
    $code=$_SESSION['code'];
}else {
    $code="1";
}

try {
    $sql = "SELECT uname, bio, pimage, cimage from MAIN WHERE id='$id';";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $r=$stmt->fetch();
    $uname=$r['uname'];
    $bio=$r['bio'];
    $im=$r['pimage'];
    $cim=$r['cimage'];
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

if ($mobile==1) {
    // mobile content
    if ($code=="0") {
    $content="
    <div class='economica' style='padding:10px 10px 10px 15px;position:fixed;
        top:0;
        width:100%;
        z-index:9;
        line-height:30px;
        font-size: 25px;
        color: white;
        background-color: #0f8ec7;'>Account Settings</div>
    <form action='edit.php' method='post'>
            <button name='code' value='1' class='narrow dre' style='margin-top:50px;font-size:16px;padding-left:15px;'>Edit Profile Information</button>
            <button name='code' value='2' class='narrow dre' style='font-size:16px;padding-left:15px;'>Change Password</button>
            <button name='code' value='3' class='narrow dre' style='font-size:16px;padding-left:15px;'>Update Profile Image</button>
            <button name='code' value='4' class='narrow dre' style='font-size:16px;padding-left:15px;'>Update Cover Image</button>
            <button name='code' value='5' class='narrow dre' style='font-size:16px;padding-left:15px;'>Privacy</button>
            <button name='code' value='6' class='narrow dre' style='font-size:16px;padding-left:15px;'>Login Activity</button>
    </form>";
    } elseif ($code=="1") {
        $_SESSION['code']="1";
        $content = "
        <div class='economica' style='padding:10px 10px 10px 15px;position:fixed;top:0;width:100%;z-index:9;line-height:30px;font-size: 25px;color: white;background-color: #0f8ec7;'>Edit Profile Information</div>
        <div style='height:100%;'>
        <form action='edit.php' method='post' class='narrow'>
            <div style='float:left;width:90px;text-align:right;margin-top:60px;margin-right:10px;height:40px;line-height:40px;font-size:16px;'>Username:</div><input type='text' name='uname' class='lgnbtn lola2 narrow' value='$uname' style='width:60%;margin-top:60px;'><br>
            <div style='float:left;width:90px;text-align:right;margin-right:10px;height:40px;line-height:40px;font-size:16px;'>Bio:</div><input type='text' name='bio' class='lgnbtn lola2 narrow' value='$bio' style='width:60%;'><br>
            <div style='float:left;width:90px;text-align:right;margin-right:10px;height:40px;line-height:40px;font-size:16px;'>Interests:</div><textarea name='inter' class='lgnbtn lola2 narrow' style='height:100px;resize:none;padding-top:8px;width:60%;'>$in</textarea><br>
            <input type='submit' name='submit1' value='Submit' class='lgnbtn logbtn lola2 narrow' style='width:90%;margin-left:5%;font-size:16px;'>
        </form>
        </div>";
    } elseif ($code=="2") {
        $_SESSION['code']="2";
        $content = "
        <div style='text-align:left;margin-left:25%;padding:40px;width:calc(75% - 80px);height:100%;font-size:18px;' class='narrow'>
        <div class='economica' style='font-size:25px;'>Change Password<br><br></div>
        <form action='edit.php' method='post'>
            <div style='float:left;width:100px;text-align:right;margin-right:10px;height:40px;line-height:40px;'>Old Password:</div><input type='password' name='opass' class='lgnbtn lola2 narrow'><br>
            <div style='float:left;width:100px;text-align:right;margin-right:10px;height:40px;line-height:40px;'>New Password:</div><input type='password' name='npass' class='lgnbtn lola2 narrow'><br>
            <input type='submit' name='submit2' value='Change Password' class='lgnbtn logbtn lola2 narrow' style='margin-left:110px;'>
        </form>
        </div>";
    } elseif ($code=="3") {
        $_SESSION['code']="3";
        $content = "
        <div class='economica' style='padding:10px 10px 10px 15px;position:fixed;top:0;width:100%;z-index:9;line-height:30px;font-size: 25px;color: white;background-color: #0f8ec7;'>Update Profile Image</div>
        <div style='height:100%;' class='narrow'>
            <img src='uploads/$im' style='height:160px;width:160px;border-radius:160px;margin: 65px 0px 15px 15px;'>
            <form action='edit.php' method='post' enctype='multipart/form-data' style='margin-left:15px;'>
                Select Image to Upload:
                <input type='file' name='fileToUpload' id='fileToUpload' accept='image/*'></br></br>
                <input type='submit' name='submit3' value='Upload Image' class='lgnbtn logbtn lola2 narrow' style='width:calc(100% - 15px);font-size:16px;'>
            </form>
        </div>";
    } elseif ($code=="4") {
        $_SESSION['code']="4";
	if ($cim=="") {
	$iii="You don't have a cover image yet.<br><br>";
	} else {
	$iii="<img src='uploads/$cim' style='width:100%;margin-bottom:20px;'>";
	}
	$content = "
        <div class='economica' style='padding:10px 10px 10px 15px;position:fixed;top:0;width:100%;z-index:9;line-height:30px;font-size: 25px;color: white;background-color: #0f8ec7;'>Update Cover Image</div>
        <div style='height:100%;margin-top:50px;' class='narrow'>
	    <div style='margin-left:15px;margin-top:15px;'>$iii</div>
            <form action='edit.php' method='post' enctype='multipart/form-data' style='margin-left:15px;'>
                Select Image to Upload:
                <input type='file' name='fileToUpload' id='fileToUpload' accept='image/*'></br></br>
                <input type='submit' name='submit4' value='Upload Image' class='lgnbtn logbtn lola2 narrow' style='width:calc(100% - 15px);font-size:16px;'>
            </form>
        </div>";
    } elseif ($code=="5") {
        $_SESSION['code']="5";
        $content = "
        <div class='economica' style='padding:10px 10px 10px 15px;position:fixed;top:0;width:100%;z-index:9;line-height:30px;font-size: 25px;color: white;background-color: #0f8ec7;'>Privacy</div>
        <div style='height:100%;' class='narrow'>
            <div class='narrow' style='font-size:16px;padding-top:65px;margin-left:15px;'>Coming soon..</div>
        </div>";
    } elseif ($code=="6") {
        $_SESSION['code']="6";
        $content = "
        <div class='economica' style='padding:10px 10px 10px 15px;position:fixed;top:0;width:100%;z-index:9;line-height:30px;font-size: 25px;color: white;background-color: #0f8ec7;'>Login Activity</div>
        <div style='height:100%;' class='narrow'>
            <div class='narrow' style='font-size:16px;padding-top:65px;margin-left:15px;'>Coming soon..</div>
        </div>";
    }
} else {
    $content = "
    <div class='narrow' style='font-size:18px;position:fixed;top:60px;left:0;height:calc(100% - 60px);background-color:white;width:25%;'>
        <div class='economica' style='font-size:25px;margin: 40px 0px 0px 40px;'>
            Settings<br><br>
        </div>
        <form action='edit.php' method='post'>
            <button name='code' value='1' class='narrow choose'>Edit Profile Information</button>
            <button name='code' value='2' class='narrow choose'>Change Password</button>
            <button name='code' value='3' class='narrow choose'>Update Profile Image</button>
            <button name='code' value='4' class='narrow choose'>Update Cover Image</button>
            <button name='code' value='5' class='narrow choose'>Privacy</button>
            <button name='code' value='6' class='narrow choose'>Login Activity</button>
        </form>
    </div>";
    if ($code=="1") {
        $_SESSION['code']="1";
        $content .= "
        <div style='text-align:left;margin-left:25%;padding:40px;width:calc(75% - 80px);height:100%;font-size:18px;' class='narrow'>
        <div class='economica' style='font-size:25px;'>Edit Profile Information<br><br></div>
        <form action='edit.php' method='post'>
            <div style='float:left;width:100px;text-align:right;margin-right:10px;height:40px;line-height:40px;'>Username:</div><input type='text' name='uname' class='lgnbtn lola2 narrow' value='$uname'><br>
            <div style='float:left;width:100px;text-align:right;margin-right:10px;height:40px;line-height:40px;'>Bio:</div><input type='text' name='bio' class='lgnbtn lola2 narrow' value='$bio'><br>
            <input type='submit' name='submit1' value='Submit' class='lgnbtn logbtn lola2 narrow' style='margin-left:110px;'>
        </form>
        </div>";
    } elseif ($code=="2") {
        $_SESSION['code']="2";
        $content .= "
        <div style='text-align:left;margin-left:25%;padding:40px;width:calc(75% - 80px);height:100%;font-size:18px;' class='narrow'>
        <div class='economica' style='font-size:25px;'>Change Password<br><br></div>
        <form action='edit.php' method='post'>
            <div style='float:left;width:100px;text-align:right;margin-right:10px;height:40px;line-height:40px;'>Old Password:</div><input type='password' name='opass' class='lgnbtn lola2 narrow'><br>
            <div style='float:left;width:100px;text-align:right;margin-right:10px;height:40px;line-height:40px;'>New Password:</div><input type='password' name='npass' class='lgnbtn lola2 narrow'><br>
            <input type='submit' name='submit2' value='Change Password' class='lgnbtn logbtn lola2 narrow' style='margin-left:110px;'>
        </form>
        </div>";
    } elseif ($code=="3") {
        $_SESSION['code']="3";
        $content .= "
        <div style='text-align:left;margin-left:25%;padding:40px;width:calc(75% - 80px);height:100%;font-size:18px;' class='narrow'>
        <div class='economica' style='font-size:25px;'>Update Profile Image<br><br></div>
        <img src='uploads/$im' style='object-fit:cover;height:160px;width:160px;border-radius:160px;margin-bottom:20px;'>
        <form action='edit.php' method='post' enctype='multipart/form-data'>
            Select Image to Upload:
            <input type='file' name='fileToUpload' id='fileToUpload' accept='image/*'></br></br>
            <input type='submit' name='submit3' value='Upload Image' class='lgnbtn logbtn lola2 narrow'>
        </form>
        </div>";
    } elseif ($code=="4") {
        $_SESSION['code']="4";
        if ($cim=="") {
        $iii="You don't have a cover image yet.<br><br>";
        } else {
        $iii="<img src='uploads/$cim' style='width:100%;margin-bottom:20px;'>";
        }
	$content .= "
        <div style='text-align:left;margin-left:25%;padding:40px;width:calc(75% - 80px);height:100%;font-size:18px;' class='narrow'>
        <div class='economica' style='font-size:25px;'>Update Cover Image<br><br></div>
	$iii
        <form action='edit.php' method='post' enctype='multipart/form-data'>
            Select Image to Upload:
            <input type='file' name='fileToUpload' id='fileToUpload' accept='image/*'></br></br>
            <input type='submit' name='submit4' value='Upload Image' class='lgnbtn logbtn lola2 narrow'>
        </form>
        </div>";
    } elseif ($code=="5") {
        $_SESSION['code']="5";
        $content .= "
        <div style='text-align:left;margin-left:25%;padding:40px;width:calc(75% - 80px);height:100%;font-size:18px;' class='narrow'>
        <div class='economica' style='font-size:25px;'>Privacy<br><br></div>
        Coming soon...
        </div>";
    } elseif ($code=="6") {
        $_SESSION['code']="6";
        $content .= "
        <div style='text-align:left;margin-left:25%;padding:40px;width:calc(75% - 80px);height:100%;font-size:18px;' class='narrow'>
        <div class='economica' style='font-size:25px;'>Login Activity<br><br></div>
        Coming soon...
        </div>";
    }
}
include 'template.php';
?>
<?php
include 'basic.php';
if (isset($_POST['submit1'])) {
    // edit profile info
    $uname = addslashes($_POST['uname']);
    $bio = addslashes($_POST['bio']);
    $in = addslashes($_POST['inter']);
    try {
        $sql="UPDATE MAIN SET uname='$uname', bio='$bio',  rec_date=NOW(), interests='$in' WHERE id='$id';";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
	if ($mobile==1) {
	  echo '<meta http-equiv="refresh" content="0;url=edit.php" />';
	} else {
          echo "<div class='narrow' style='position:fixed;left:25%;bottom:0;padding: 10px 0px 10px 40px;background-color:#0f8ec7;color:white;width:75%;font-size:18px;'>Profile information updated successfully</div>";
        }
     } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
} elseif (isset($_POST['submit2'])) {
    // change password
    $opass = $_POST['opass'];
    $npass = $_POST['npass'];
    try {
        $sql="SELECT password FROM MAIN WHERE id='$id';";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $r=$stmt->fetch();
        $pass=$r['password'];
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    if ($pass==$opass) {
        try {
            $sql="UPDATE MAIN SET password='$npass' WHERE id='$id';";
            $stmt=$conn->prepare($sql);
            $stmt->execute();
            echo "<div class='narrow' style='position:fixed;left:25%;bottom:0;padding: 10px 0px 10px 40px;background-color:#0f8ec7;color:white;width:75%;font-size:18px;'>Password changed successfully</div>";
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    } else {
        echo "<div class='narrow' style='position:fixed;left:25%;bottom:0;padding: 10px 0px 10px 40px;background-color:#0f8ec7;color:white;width:75%;font-size:18px;'>Password Incorrect</div>";
    }
} elseif (isset($_POST['submit3'])) {
    include 'basic.php';
    $loa="";
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        $l = "Image not uploaded, rename your file and try uploading again.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $l = "Image not uploaded, image size is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $l = "Image not uploaded, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $content = "<div class='narrow' style='position:fixed;left:25%;bottom:0;padding: 10px 0px 10px 40px;background-color:#0f8ec7;color:white;width:75%;font-size:18px;'>$l</div>";
    } else {
        // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $img=basename( $_FILES["fileToUpload"]["name"]);
            try {
                $sql = "UPDATE MAIN SET pimage='$img' WHERE id='$id'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                if ($mobile==1) {
          	  echo '<meta http-equiv="refresh" content="0;url=edit.php" />';
        	} else {
                  echo "<div class='narrow' style='position:fixed;left:25%;bottom:0;padding: 10px 0px 10px 40px;background-color:#0f8ec7;color:white;width:75%;font-size:18px;'>Image uploaded successfully.</div>";
                }
	    } catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
        } else {
            echo "<div class='narrow' style='position:fixed;left:25%;bottom:0;padding: 10px 0px 10px 40px;background-color:#0f8ec7;color:white;width:75%;font-size:18px;'>There was an error uploading your file.</div>";
        }
    }
} elseif (isset($_POST['submit4'])) {
    include 'basic.php';
    $loa="";
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        $l = "Image not uploaded, rename your file and try uploading again.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $l = "Image not uploaded, image size is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $l = "Image not uploaded, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $content = "<div class='narrow' style='position:fixed;left:25%;bottom:0;padding: 10px 0px 10px 40px;background-color:#0f8ec7;color:white;width:75%;font-size:18px;'>$l</div>";
    } else {
        // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $cimg=basename( $_FILES["fileToUpload"]["name"]);
            try {
                $sql = "UPDATE MAIN SET cimage='$cimg' WHERE id='$id'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                echo "<div class='narrow' style='position:fixed;left:25%;bottom:0;padding: 10px 0px 10px 40px;background-color:#0f8ec7;color:white;width:75%;font-size:18px;'>Image uploaded successfully.</div>";
            } catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
        } else {
            echo "<div class='narrow' style='position:fixed;left:25%;bottom:0;padding: 10px 0px 10px 40px;background-color:#0f8ec7;color:white;width:75%;font-size:18px;'>There was an error uploading your file.</div>";
        }
    }
}
?>
<style>
    .logbtn {
        color: white;
        background-color: #0f8ec7;
        cursor: pointer;
        padding: 0px;
    }
    .logbtn:hover {
        background-color: blue;
    }
    .lgnbtn{
        height: 40px;
        width: 300px;
        margin-bottom: 10px;
        padding-left: 10px;
        border-radius: 10px;
        border: 0.5px solid lightgray;
    }
    .choose {
        width:100%;font-size:18px;height:40px;border: 0.5px solid lightgray;border-right:none;border-top:none;padding-left:40px;text-align:left;background-color:white;cursor:pointer;
    }
    .choose:hover {
        background-color: lightgray;
    }
</style>
