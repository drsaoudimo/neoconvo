<?php
include 'basic.php';

// Get user information
try {
    $sql = "SELECT fname, uname, bio, age, gender, pimage, cimage FROM MAIN WHERE id='$id';";
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
    $sql = "SELECT post, date, image, vdo FROM POSTS WHERE postBy='$id' order by id desc;";
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
        $lolalist="<div class='narrow' style='background-color:white;border-radius:10px;width:calc(100% - 20px);border:0.5px solid lightgray;padding:10px;margin-top:15px;font-size:18px;'>You haven't posted anything yet.</div>";
    }
    $k=0;
}

// Get people who are in connection with current user
try {
    $sql = "SELECT id, uname, pimage FROM MAIN WHERE id IN (SELECT requestFrom FROM FOLLOWERS WHERE requestTo='$id' AND status=1);";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $z=0;
    $zrlist="";
    while ($r=$stmt->fetch()){
        $uid= $r['id'];
        $uname=$r['uname'];
        if (strpos($uname, " ")) {
          $uname=substr($uname, strpos($uname, " "));
        }
        $image=$r['pimage'];
        if ($mobile==1) {
            $zrlist.="<div style='display:inline-block;'>
            <form action='pu2.php'>
            <button class='narrow' name='id' value='$uid' style='display:inline-block;background-color:transparent;text-align:center;font-size:16px;color:black;margin: 0px 5px 0px 5px;border:none;'>
            <img src='uploads/$image' style='height: 90px; width: 90px;object-fit:cover;border-radius:5px;'><br>
            $uname
            </button>
            </form>
            </div>";
        } else {
            $zrlist.="<div style='margin: 0px 5px 0px 5px;display:inline-block;'>
            <img src='uploads/$image' style='height: 90px; width: 90px; margin: 10px 0px 0px 0px; float: left; object-fit:cover; border:none;border-radius:5px;'>
            <form action='pu2.php'>
            <button class='zachii narrow' name='id' value='$uid' style='background-color:transparent;text-align:center;width:100%;font-size:18px;color:black;margin-top:0px;margin-bottom:0px;border:none;'>
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
    $sad="<div style='font-size:18px;' class='narrow'>You don't have any followers yet.</div>";
    $zame=0;
} else {
    $sad="";
    $zame=$z;
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
    $top="
    <div class='cimage'>
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
<div class='pnav'>
    <a href='edit.php' class='pbtn' style='border-left: 1px solid dimgray;'>Edit Profile Info</a>
    <a href='edit.php' class='pbtn'>Update Profile Image</a>
    <a href='edit.php' class='pbtn'>Update Cover Image</a>
    <a href='people.php' class='pbtn'>Find People</a>
</div>

<div class='pleft'>
    <div class='phead'>Information</div>
    Name: $fn <br>
    Gender: $gender <br>
    Age: $age <br>

</div>

<div class='narrow' style='width:calc(50% - 1px);padding-top:10px;display:inline-block;'>
    $lolalist
</div>

<div class='pright'>
    <div class='phead'>Followers ($zame)</div>
    $sad
    $zrlist
</div>";
}
include 'template.php';
// 383 lines of code
?>
<script>
import Icon from '@material-ui/core/Icon';
</script>
<style>
a{
    text-decoration:none;
    color:blue;
}
a:hover {
    text-decoration:underline;
}
</style>