<?php
include 'basic.php';
$title="NeoConvo";
try {
    $sql = "SELECT pimage FROM MAIN WHERE id='$id';";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $r=$stmt->fetch();
    $pimage = $r['pimage'];
} catch(PDOException $e) {
    echo "ERROR R2:" . $e->getMessage() . "<br>";
}

// Create Customised Feed
try {
    $sql="SELECT postBy, post, date, image, vdo FROM POSTS WHERE (postBy IN (SELECT requestTo FROM FOLLOWERS WHERE requestFrom='$id' and status=1)) OR (postBy IN (SELECT requestFrom FROM FOLLOWERS WHERE requestTo='$id' AND status=1)) OR postBy='$id' ORDER BY id desc;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $k=0;
    while($r=$stmt->fetch()) {
        $post=$r['post'];
        $postb=$r['postBy'];
        $myDate=$r['date'];
        $myImage=$r['image'];
        $myVdo=$r['vdo'];
        $sql="SELECT uname, pimage from MAIN where id='$postb';";
        $stmtt = $conn->prepare($sql);
        $stmtt->execute();
        $r2=$stmtt->fetch();
        $uname=$r2['uname'];
        $img=$r2['pimage'];
        if ($myVdo=="") {
            $postVdo="";
        } else {
            $postVdo="<video style='height:auto; width:100%;' controls autoplay muted>
  <source src='uploads/$myVdo' type='video/mp4'>
Your browser does not support the video tag.
</video>";
        }
        if ($myImage=="") {
            $postImage="";
        } else {
            $postImage="<img src='uploads/$myImage' style='width:100%; height:auto;' alt='Image in Post'>";
        }
        if ($post=="") {
            $myPost="";
        } else {
            $myPost="<div style='word-wrap:break-word;margin:10px 15px 10px 15px;'>$post</div>";
        }
if ($mobile==1) {
$loll[$k]="
<div class='narrow' style='width:100%; 
    text-align:left;
    padding-bottom:10px;
    border-bottom: 1px solid lightgray;
    margin-bottom:15px;
    background-color:white;
    font-size: 16px;'>
    <div style='background-color:#0f8ec7;'>
    <img src='uploads/$img' style='margin:10px;margin-left:15px;height:45px;width:45px;border-radius:45px;float:left;object-fit:cover;'>
    <div style='margin-left: 70px;height:55px;color:white;font-size:12px;padding-top:10px;' class='narrow'>
        <form action='pu2.php'>
        <button name='id' value='$postb' class='economica' style='background-color:transparent;font-size:25px;color:white;border:none;'>
        $uname
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
                    <button name='id' value='$postb' class='postBy economica'>$uname</button>
                </form>
                <div class='narrow' style='font-size:14px;'>$myDate</div>
            </div>
        </div>
        $postImage$postVdo$myPost
    </div>";
        }
        $k++;
    }
} catch(PDOException $e) {
    echo "ERROR R2: " . $e->getMessage() . "<br>";
}

// People you may not know
try {
    $mySql = "SELECT id, uname, age, gender, pimage FROM MAIN WHERE (id NOT IN (SELECT requestTo FROM FOLLOWERS WHERE (requestFrom='$id' AND status=1) UNION SELECT requestFrom FROM FOLLOWERS WHERE (requestTo='$id' AND status=1))) AND id!='$id';";
    $myStmt = $conn->prepare($mySql);
    $myStmt->execute();
    $p=0;
    while ($myR=$myStmt->fetch()) {
        $pid=$myR['id'];
        $userUname=$myR['uname'];
        $userGender=$myR['gender'];
	    $userAge=$myR['age'];
        $userImage=$myR['pimage'];
        $recArray[$p]="<div style='border-bottom:0.5px solid gray;width:100%;'></div>
        <form action='pu2.php'>
        <div class='sur'>
        <img src='uploads/$userImage' alt='$userUname profile picture' style='height:45px; width:45px;border-radius:45px;margin:10px;margin-left:15px;object-fit:cover;'>
        <button name='id' value='$pid' class='economica pur'>$userUname<br>
        <div style='font-size:16px;text-decoration:none;' class='narrow'>$userAge year old $userGender</div>
        </button>
        </form>
        </div>";
        $p++;
    }
} catch(PDOException $e) {
    echo "ERROR R3: " . $e->getMessage() . "<br>";
}

if (isset($loll)) {
    $lolalist=implode("", $loll);
} else {
    if ($mobile==1) {
        $lolalist="
<div class='narrow' style='background-color:white;font-size:16px;border-top:0.5px solid lightgray;border-bottom:0.5px solid lightgray;text-align:center;padding:10px;width:calc(100% - 20px);'>
NeoConvo is a stranger social networking site. Using this site you can connect with strangers from over the world.<br><br>
You can search for stragers based on their age, gender and interests, view their profiles and send them convo requests.
<br><br>Once they accept your convo request, they'll be in a connection with you. Once you're in a connection with someone,
you can chat with them on the convos page.<br><br>
You get convo requests from other strangers as well. You can view all the convo requests you get in the requests tab (the second button from the right).<br><br>
Moreover, you can post on the site and can decide whether everyone or only the people you're in a connection can see.


        </div>";
    } else {
    $lolalist="
        <div class='economica' style='margin:0px;background-image:url(../images/confetti.gif);border-radius: 10px;background-color: white;margin:10px 40px;width: calc(100% - 81px);border:0.5px solid lightgray;padding:50px 0px 50px 0px;font-size:25px;text-align:center;'>
            You're now a member of NeoConvo!<br>Follow other people in order to view their posts here.
        </div>";
    }
}
if (isset($recArray)) {
    $recList=implode("", $recArray);
} else {
    $recList="You know everyone on this site.<br>Wait a while to get new recommendations.";
}
if($mobile==1) {
    $content="<div class='economica' style='padding:10px 10px 10px 15px;
        position:fixed;
        top:0;
        width:100%;
        z-index:9;
        line-height:30px;
        font-size: 25px;
        color: white;
        background-color: #0f8ec7;'>NeoConvo</div>
    <div style='width:100%;text-align:left;margin-bottom:15px;margin-top:50px;border-bottom:1px solid lightgray;background-color:white;'>     
    <form action='connect4.php' method='post' enctype='multipart/form-data'>
    <img src='uploads/$pimage' style='height:45px;width:45px;border-radius:45px;margin:10px;margin-left:15px;float:left;'>
    <textarea class='narrow' style='width: calc(100% - 75px); height: 65px;resize:none;font-size:16px;border: none; padding:10px;padding-left:0px;background-color:transparent;' placeholder='Write something here...' name='post'></textarea>
    <div style='height:0px;border-top:0.5px solid black;margin-right:10px;margin-left:10px;'></div>
    <div class='upload-btnq-wrapper'>
    <button class='btnq narrow' style='margin:10px;margin-right:5px;'>Photo</button>
    <input type='file' accept='image/*' name='fileToUpload' id='fileToUpload'>
    </div>
    <div class='upload-btnq-wrapper'>
    <button class='btnq narrow' style='margin-bottom:10px;'>Video</button>
    <input type='file' name='vid' id='vid'>
    </div>
    <button class='narrow btnq' style='width: 60px; float: right; border-radius: 5px;padding:5px; margin: 10px;font-size:16px;background-color:lime;color:black;'>Post</button>
    </form>
    </div>
    $lolalist
    <br><br><br><br>";
} else {
    // for computers
    $content="
<div style='width:calc(25% - 0.5px);float:left;border-right:0.5px solid lightgray;background-color:white;height:calc(100% - 60px);position:fixed;top:60px;left:0;'>
    <div class='economica' style='margin:10px; margin-left:40px;margin-top:20px;font-size:25px;'>Buttons</div>
    <div class='narrow' style='margin-left:40px;font-size:18px;'>
    More Buttons Coming Here
    </div>
</div>
    
<div style='width:50%;margin-left:25%;padding-top:10px;' class='narrow'>
    <div class='post'>
        <img src='uploads/$pimage' class='postImage'>
        <form action='connect4.php' method='post' enctype='multipart/form-data'>
            <textarea class='narrow' style='width: calc(100% - 65px); resize: none; font-size:18px; color:black; height:auto;min-height: 65px; border: none; padding:10px;background-color:transparent;' placeholder='Write something here...' name='post'></textarea>
            <div style='border-top:0.5px solid black;margin-left:10px;margin-right:10px;'></div>
            <div class='upload-btnq-wrapper'>
                <button class='narrow' style='color:white;font-size:18px;cursor:pointer;border-radius:5px;background-color:#0074D9;padding:5px;border:none;margin-left:10px;margin-top:10px;'>Photo</button>
                <input type='file' accept='image/*' name='fileToUpload' id='fileToUpload'>
            </div>
            <div class='upload-btnq-wrapper'>
                <button class='narrow' style='color:white;font-size:18px;cursor:pointer;border-radius:5px;background-color:#0074D9;padding:5px;border:none;'>Video</button>
                <input type='file' accept='video/*' name='vid' id='vid'>
            </div>
            <button class='narrow postbtn'>Post</button>
        </form>
    </div>
    $lolalist

</div>

<div style='width:calc(25% - 0.5px);float:right;border-left:0.5px solid lightgray;background-color:white;height:calc(100% - 60px);position:fixed;top:60px;right:0;'>
    <div class='economica' style='margin:10px; margin-left:15px;margin-top:20px;font-size:25px;'>People like you</div>
    <div class='narrow' style='font-size:18px;'>$recList</div>
    <div style='border-top:0.5px solid black; width:100%;'></div>
    <div class='narrow' style='margin:15px;font-size:18px;'>Netonvo © 2021</div>
</div>";
}
include 'template.php';
// 320 lines of code
?>