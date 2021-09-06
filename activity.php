<?php
include 'basic.php';
$title="Activity";

// Get id of people who have sent follow requests to current user
try {
    $sql = "SELECT id, uname, gender, pimage FROM MAIN WHERE id IN (SELECT requestFrom FROM FOLLOWERS WHERE requestTo='$id' AND status=0);";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $i=0;
    $folist="";
    while ($r=$stmt->fetch()){
        $uid= $r['id'];
        $uname=$r['uname'];
        $gender=$r['gender'];
        $image=$r['pimage'];
        $folist.="<div style='width:calc(100% - 30px);margin-left:15px;border-top:0.5px solid lightgray;'></div>
           <form action='pu2.php'>
           <button class='economica' name='id' value='$uid' style='border:none;text-align:left;width:calc(100% - 120px);display:inline-block;
background-color:transparent;font-size:25px;line-heiight:20px;'>
           <img src='uploads/$image' style='height:45px;width:45px;border-radius:45px; margin:10px;margin-left:15px;float:left;'>
           <div style='margin-top:5px;'>$uname</div>
           <div class='narrow' style='font-size:16px;'>20 year old $gender</div>
           </button>
           </form>
           <form action='pu3.php' method='post' style='float:right;margin-top:-60px;'>
           <button class='narrow sachiiReject' name='freject' value='$uid' style='height:auto;margin-left:5px;margin-right:5px;width:50px;
font-size:15px;border-radius:5px;background-color:#FF4136;padding:5px;'>Reject</button>
           <button class='narrow sachiiAccept' name='faccept' value='$uid' style='height:auto;width:50px;font-size:15px;border-radius:5px;
background-color:#0074D9;padding:5px;'>Accept</button>
           </form>";
        $i++;
    }
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}


if ($folist=="") {
    $folist="<div class='narrow' style='font-size:16px;margin-bottom:10px;margin-left:15px;'>You don't have any Follow Requests yet.</div>";
}

if ($mobile==1) {
$content="
<div style='height:100%;background-color:#F0F0F0;'>
<div class='economica' style='padding:10px 10px 10px 15px;
        position:fixed;
        top:0;
        width:100%;
        z-index:9;
        line-height:30px;
        font-size: 25px;
        color: white;
        background-color: #0f8ec7;'>Activity</div>

<div style='width:100%;font-size:25px;margin-top:15px;background-color:white;border-top:1px solid lightgray;border-bottom:1px solid lightgray;'>
<div class='economica' style='margin-left:15px;padding-top:10px;margin-bottom:10px;'>
Follow Requests ($i)
</div>
$folist
</div>

</div>";

} else {
    $content = "<div class='post'>
    $folist
    </div>";
}
include 'template.php';
?>
