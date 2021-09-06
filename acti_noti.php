<?php
include 'basic.php';
// Get people who have sent messages to current user
try {
    $sql = "SELECT count(messageTo) from MESSAGES WHERE messageTo='$id' AND status=0";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $r = $stmt->fetch();
    $dir_count = $r['count(messageTo)'];
} catch(PDOException $e) {
    echo "ERROR N1: " . $e->getMessage() . "<br>";
}
// Get people who have sent follow requests to current user
try {
    $sql = "SELECT id, uname, gender, pimage FROM MAIN WHERE id IN (SELECT requestFrom FROM FOLLOWERS WHERE requestTo='$id' AND status=0);";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $i=0;
    $frlist="";
    while ($r=$stmt->fetch()){
        $uid= $r['id'];
        $uname=$r['uname'];
        $gender=$r['gender'];
        $image=$r['pimage'];
        $frlist .= "<div style='width:calc(100% - 20px);padding:0px;margin:0px 10px 0px 10px;text-align:left;'>
            <form action='pu2.php'>
                <button class='economica' name='id' value='$uid'
style='width:calc(100% - 110px);text-align:left;border:none;background-color:transparent;font-size:25px;'>
                    <img src='uploads/$image' style='height: 45px; width: 45px; border-radius: 45px; margin:10px;margin-left:0px;float:left;object-fit:cover;'>
                    <div style='margin-top:7px;'>$uname</div>
                    <div style='font-size:15px;color:black;' class='narrow'>20 year old $gender</div>
               </button>
            </form>
            <form action='pu3.php' method='post' style='float:right;margin-top:-50px;'>
               <button class='narrow' name='faccept' value='$uid'
style='cursor:pointer;font-size:15px;border-radius:10px;color:white;border:none;height:40px;width:50px;background-color:#0f8ec7;'>Accept</button>
               <button class='narrow' name='freject' value='$uid'
style='cursor:pointer;font-size:15px;border-radius:10px;color:white;border:none;height:40px;width:50px;background-color:#FF4136;margin-right:0px;'>Reject</button>
            </form>
        </div>";

        $i++;
    }
} catch(PDOException $e) {
    echo "ERROR N2: " . $e->getMessage() . "<br>";
}
$act_count = $i;
if ($frlist == "") {
    $frlist = "<div style='font-size:18px;line-height:30px;text-align:left;margin-left:10px;'>You have no follow requests.</div>";
}

if ($act_count == 0) {
    $por = "";
} else {
    $por = "<div style='actNotif'>$act_count</div>";
}
if ($dir_count==0) {
    $tor="";
} else {
    $tor="<div style='dirNotif'>$dir_count</div>";
}

?>