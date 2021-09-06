<?php
include 'basic.php';
if (isset($_GET['id'])) {
    $d=$_GET['id'];
    $_SESSION['vid'] = $d;
} elseif (isset($_SESSION['vid'])) {
    $d=$_SESSION['vid'];
}
if (isset($_SESSION['notification']) && $mobile==0) {
    echo $_SESSION['notification'];
    unset($_SESSION['notification']);
}
if($id==$d) {
   echo '<meta http-equiv="refresh" content="0; url=profile.php">';
}

// Get user information
try {
    $sql = "SELECT fname, uname, bio, age, gender, pimage, cimage FROM MAIN WHERE id='$d';";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $r=$stmt->fetch();
    $fn=$r['fname'];
    $un=$r['uname'];
    $bio=$r['bio'];
    $age=$r['age'];
    $gender=$r['gender'];
    $img=$r['pimage'];
    $cimg=$r['cimage'];
} catch(PDOException $e) {
    echo "User information not retrieved successfully<br>";
    echo $sql . "<br>" . $e->getMessage();
}

// Get posts by current user
try {
    $sql = "SELECT post, date, image, vdo FROM POSTS WHERE postBy='$d' order by id desc;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $k=0;
    while($r=$stmt->fetch()) {
        $post=$r['post'];
        $postb=$id;
        $myDate=$r['date'];
        $myImage=$r['image'];
        $myVdo=$r['vdo'];

        // Check whether the post has a video in it
        if ($myVdo=="") {
            $postVdo="";
        } else {
            $postVdo="
            <div style='display:inline;font-size:100px;'>
                <video style='width:100%;' controls>
                    <source src='uploads/$myVdo' type='video/mp4'>
                    <source src='uploads/$myVdo' type='video/ogg'>
                    Your browser does not support the video tag.
                </video>
            </div>";
        }

        // Check whether the post has an image in it
        if ($myImage=="") {
            $postImage="";
        } else {
            $postImage="<img src='uploads/$myImage' style='width:100%;' alt='Image in Post'>";
        }

        // Check whether the post has text in it
        if ($post=="") {
            $myPost="";
        } else {
            $myPost="<div style='word-wrap:break-word;margin:10px 15px;color:black;'>$post</div>";
        }

        // Display post
        if ($mobile==1) {
           $loll[$k]="<div class='narrow' style='width:100%; 
    text-align:left;
    margin-bottom:15px;
    background-color: white;
    border-bottom:1px solid lightgray;
    font-size: 16px;padding-bottom:10px;'>
    <div style='background-color:#0f8ec7;'>
    <img src='uploads/$img' class='pro' style='margin: 10px;height: 45px; width: 45px; border-radius: 45px;float:left;object-fit:cover;'>
    <div style='margin-left: 65px;height:55px;color:white;font-size:12px;padding-top:10px;' class='narrow'>
        <form action='pu2.php'>
        <button name='id' value='$postb' class='economica'
        style='background-color:transparent;font-size:25px;color:white;border:none;'>
        $un
        </button><br>
        $myDate
        </form>
    </div>
    </div>
          $postImage
          $postVdo
          $myPost
    </div>";
        } else {
            $loll[$k]="
            <div class='post'>
                <div style='border-bottom: 0.5px solid black;margin: 0px 10px;'>
                    <img src='uploads/$img' class='postImage' style='margin-left:0px;'>
                    <div style='margin-left: 55px;height:57px;padding-top:8px;'>
                        <form action='pu2.php'>
                            <button name='id' value='$postb' class='postBy economica'>$un</button>
                        </form>
                        <div class='narrow' style='font-size:14px;'>$myDate</div>
                    </div>
                </div>
                $postImage
                $postVdo
                $myPost
            </div>";
        }
        $k++;
    }
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

if(isset($loll)) {
    $lolalist=implode("", $loll);
} else {
    if ($mobile==1) {
        $lolalist="<br><div class='narrow' style='font-size:16px;'>You haven't posted anything yet.</div>";
    } else {
        $lolalist="<div class='narrow' style='background-color:white;border-radius:10px;width:calc(100% - 20px);border:0.5px solid lightgray;padding:10px;margin-top:15px;font-size:18px;'>$un hasn't posted anything yet.</div>";
    }
    $k=0;
}

$frt=null;
// Get people who have sent follow requests to this user but haven't been accepted yet
try {
    $sql="SELECT requestFrom FROM FOLLOWERS WHERE requestTo='$d' AND status=0;";
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    $he=0;
    while ($r=$stmt->fetch()) {
        $frt[$he]=$r['requestFrom'];
    }
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$uid=null;
// Get people who follow this user
try {
    $sql3="SELECT id, uname, pimage FROM MAIN WHERE id IN (SELECT requestFrom FROM FOLLOWERS WHERE (requestTo='$d' AND status=1));";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->execute();
    $z=0;
    $zrlist="";
    while ($r3=$stmt3->fetch()){
        $uid[$z]= $r3['id'];
        $uname=$r3['uname'];
        if (strpos($uname, " ")) {
  	  $uname=substr($uname, strpos($uname, " "));
        }
	$image=$r3['pimage'];
        if ($mobile==1) {
            $zrlist.="<div style='margin: 0px 5px 0px 5px;display:inline-block;'>
            <img src='uploads/$image' style='height: 90px; width: 90px; margin: 10px 0px 0px 0px; float: left; object-fit:cover; border:none;border-radius:5px;'>
            <form action='pu2.php'>
            <button class='zachii narrow' name='id' value='$uid[$z]' style='background-color:transparent;text-align:center;width:100%;font-size:16px;color:black;margin-top:0px;margin-bottom:0px;border:none;'>
            $uname
            </button>
            </form>
            </div>";
        } else {
        $zrlist.="
        <div style='margin: 0px 5px 0px 5px;display:inline-block;'>
               <img src='uploads/$image' style='height: 90px; width: 90px; margin: 10px 0px 0px 0px; float: left; object-fit:cover; border:none;border-radius:5px;'>
               <form action='pu2.php'>
               <button class='zachii narrow' name='id' value='$uid[$z]' style='background-color:transparent;text-align:center;width:100%;font-size:18px;margin-top:0px;margin-bottom:0px;border:none;'>
               $uname
               </button>
               </form>
               </div>";
        }
        $z++;
    }
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

if ($zrlist=="") {
    $sad="$un doesn't have any followers yet";
    $zame=0;
} else {
    $sad="";
    $zame=$z;
}

// check for follow request combinations
if ($uid!=null && in_array($id, $uid)) {
    // current user follows this user
    if ($mobile==1) {
        $fr="<button name='unfollow' class='narrow' style='background-color:white;border:none;font-size:16px;'>Unfollow</button>";
    } else {
        $fr="<button name='unfollow' class='narrow' style='cursor:pointer;background-color:white;color:blue;
border:none;font-size:18px;padding: 0px 10px 0px 10px; line-height:35px;border-left: 1px solid dimgray;'>Unfollow</button>";
    }
} elseif ($frt!=null && in_array($id, $frt)) {
    if ($mobile==1) {
        $fr="Requested";
    } else {
        $fr="<button class='narrow' style='background-color:white;color:dimgray;border:none;font-size:18px;padding: 0px 10px 0px 10px;
line-height:35px;border-left: 1px solid dimgray;border-right: 1px solid dimgray;' disabled>Requested</button>";
    }
} else {
    // current user does not chat with this user
    if ($mobile==1) {
        $fr="<button name='follow' class='narrow' style='background-color:white;border:none;font-size:16px;'>Follow</button>";
    } else {
        $fr="<button name='follow' class='narrow' style='cursor:pointer;background-color:white;color:blue;border:none;
font-size:18px;padding: 0px 10px; line-height:35px;border-left: 1px solid dimgray;border-right: 1px solid dimgray;'>Follow</button>";
    }

}

// Bio
if ($bio=="") {
    if ($mobile==1) {
      $bio="<a href='edit.php' style='color:black;'>Add Bio</a>";
    } else {
      $bio="<a href='edit.php' style='color:white;'>Add Bio</a>";
    }
  }

// Cover Image
if($cimg=="") {
    $top="<div style='width:100%;background-color:dimgray;'>
        <form action='edit.php' method='post'>
            <button class='narrow' name='code' value='4' style='font-size:16px;border-radius:10px;cursor:pointer;margin:20px;float:right;color:white;background-color:transparent;border:0.5px solid white;padding:10px;'>Add Cover Image</button>
        </form>
        <div style='text-align:left;'>
            <img src='uploads/$img' style='border: 1px solid dimgray;object-fit:cover; padding: 3px;margin:20px; margin-left:45px; float:left;height:150px; width:150px;border-radius:150px;background-color:white;margin-top:180px;'>
            <div class='economica' style='font-size:40px; margin-right:auto; padding-top:242px;padding-bottom:10px;color:white;'>
                $un
                <div style='font-size:18px;height:18px;' class='narrow'>$bio</div>
            </div>
        </div>
    </div>";
    $yop="
    <div class='narrow' style='font-size:15px;background-color:#0f8ec7;height:180px;width:100%;text-align:center;'>
	        <form action='edit.php' method='post'>
        <button name='code' value='4' class='narrow'
style='font-size:16px;color:white;border-radius:5px;background-color:transparent;margin:10px;padding:5px;
border:0.5px solid white;float:right;'>Add Cover Image</button>
        </form>
    </div>";
} else {
    $top="
    <div style='width:100%;background-color:dimgray;background-image:url(../uploads/$cimg);background-repeat:no-repeat;background-size:cover;object-fit:cover;height:300px;'>
        <img src='uploads/$img' style='border: 1px solid dimgray;object-fit:cover; padding: 3px;margin:20px;margin-bottom:0px;margin-left:43px;float:left;height:150px;width:150px;border-radius:150px;background-color:white;margin-top:165px;'>
        <div class='economica' style='font-size:40px;color:white;display:inline-block;margin-top:220px;'>
            $un
            <div style='font-size:18px;height:18px;' class='narrow'>$bio</div>
        </div>
    </div>";
    $yop="
    <div style='background-color:#0f8ec7;height:180px;width:100%;text-align:center;background-image:url(../uploads/$cimg);background-repeat:no-repeat;background-size:cover;object-fit:cover;'>
        <form action='edit.php' method='post'>
        <button name='code' value='4' class='narrow' 
style='font-size:16px;color:white;border-radius:5px;background-color:transparent;margin:10px;padding:5px;
border:0.5px solid white;float:right;'>Update Cover Image</button>
        </form>
    </div>";
}

// Title
$title = $un;

if ($mobile==1) {
    $content="
    <div style='text-align:center;background-color:#F0F0F0;'>
        $yop
        <div style='background-color:white;'>
            <img src='uploads/$img' style='object-fit:cover;height:150px; width:150px;border-radius:150px;border:1px solid dimgray; padding: 3px;margin-top:-130px;background-color:white;'>
            <div class='economica' style='font-size:25px;margin-top:10px;'>$un</div>
            <div class='narrow' style='font-size:16px;border-bottom:0.5px solid lightgray;margin:5px 10px 0px 10px;padding-bottom:15px;'>
            $bio
            </div>
	    <div class='narrow' style='font-size:16px;margin-top:10px;padding-bottom:10px;margin-left:10px;margin-right:10px;border-bottom:0.5px solid lightgray;'>
            <form action='edit.php' method='post'>
              <button name='code' value='1' style='width:50%;font-size:16px;border:none;border-right:1px solid lightgray;background-color:transparent;' class='narrow'>Edit Profile Info</button>
              <button name='code' value='3' style='width:49%;font-size:16px;border:none;background-color:transparent;' class='narrow'>Update Profile Image</button>
            </form>
          </div>
        </div>
        <div style='width:calc(100% - 20px);border-bottom:1px solid lightgray;background-color:white;font-size:16px;text-align:left;padding:10px;margin-bottom:15px;' class='narrow'>
            <div class='economica' style='font-size:20px;margin-bottom:5px;'>Information:</div>
            <div style='width:auto;margin-right:10px;display:inline-block;float:left;'>
	        Name:<br>
                Gender:<br>
                Age:<br>
            </div>
	    $fn<br>
            $gender<br>
            $age<br>
        </div>
        <div style='width:100%;border-bottom:1px solid lightgray;border-top:1px solid lightgray;background-color:white;font-size:16px;text-align:left;margin-bottom:15px;' class='narrow'>
            <div class='economica' style='font-size:20px;margin-left:10px;margin-top:10px;'>Followers ($zame):</div>
            <div style='overflow-x:scroll;display:flex;margin:10px;margin-bottom:0px;padding-bottom:10px;'>
                $sad
		$zrlist
            </div>
        </div>
        <div style='width:100%;border-top:0.5px solid lightgray;'></div>
        $lolalist
        <br><br><br><br>
    </div>";
} else {
    $content="$top
<div style='width:100%;border:1px solid dimgray;border-right:none;border-left:none;height:35px;background-color:white;'>
    <form action='pu2.php' method='post'>
        $fr
    </form>
</div>

<div style='width:calc(25% - 0.5px);float:left;border-right:0.5px solid lightgray;background-color:white;'>
    <div class='economica' style='margin:10px; margin-left:40px;margin-top:30px;font-size:25px;'>Information</div>
    <div class='narrow' style='margin:15px;margin-left:40px;font-size:18px;'>
    Name: $fn <br>
    Gender: $gender <br>
    Age: $age <br>
    </div>
</div>

<div style='width:calc(50% - 1px);padding-top:10px;display:inline-block;' class='narrow'>
    $lolalist
</div>

<div style='width:calc(25% - 0.5px);float:right;border-left:0.5px solid lightgray;background-color:white;'>
    <div class='economica' style='margin:10px; margin-left:15px;margin-top:30px;font-size:25px;'>Followers ($zame)</div>
    <div class='narrow' style='margin:15px;font-size:18px;'>
        $sad
        $zrlist
    </div>
</div>";
}
include 'template.php';
?>

<?php
$vid = $_SESSION['vid'];

if (isset($_POST['follow'])) {
    try {
        $sql = "INSERT INTO FOLLOWERS (requestFrom, requestTo) VALUES ('$id', '$vid');";
        $conn->exec($sql);
        echo "<meta http-equiv='refresh' content='0; url=pu2.php'>";
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
} elseif (isset($_POST['unfollow'])) {
    try {
        $sql = "DELETE FROM FOLLOWERS WHERE requestFrom='$id' AND requestTo='$vid';";
        $conn->exec($sql);
        echo "<meta http-equiv='refresh' content='0; url=pu2.php'>";
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

// 504 lines of code
?>