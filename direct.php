<?php
include 'basic.php';
$title="Convos";

// Get people who are in connection with current user
try {
    $sql = "SELECT id, uname, pimage FROM MAIN WHERE (id IN (SELECT requestFrom FROM CONVOS WHERE requestTo='$id' AND status=1)) OR (id IN (SELECT requestTo FROM CONVOS WHERE requestFrom='$id' AND status=1));";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $z=0;
    $chlist="";
    while ($r=$stmt->fetch()){
        $zoka=$r['id'];
        $uname=$r['uname'];
        $img=$r['pimage'];
        if ($mobile==1) {
            $chlist.="
            <button name='idd' value='$zoka' class='economica dre' style='font-size:25px;width:100%;border-bottom:1px solid lightgray;'>
            <img src='uploads/$img' style='object-fit:cover;margin:10px;margin-left:15px;height:45px;width:45px;border-radius:45px;float:left;'>$uname
            </button>";
        } else {
            $chlist.="
            <button name='idd' value='$zoka' class='economica dre' style='line-height:35px;'>
            <img src='uploads/$img' style='margin:10px;margin-left:40px;height:45px;width:45px;border-radius:45px;float:left;object-fit:cover;'>
<div style='display:inline-block;line-height:25px;padding-top:7px;'>$uname</div>
            <br><div class='narrow' style='font-size:18px;display:inline-block;line-height:18px;'>Send $uname a message</div>
	    </button>";
        }
        $z++;
    }
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

if ($chlist=="") {
  $chlist="<div style='padding:15px;background-color:white;border-bottom:1px solid lightgray;font-size:16px;' class='narrow'>You don't have any convos yet.<br>Send someone a convo request to chat with them.</div>";
}

$noselect="";
// display user friends in direct section
if ($mobile==1) {
    $content="<div class='economica' style='padding:10px 10px 10px 15px;
        position:fixed;
        top:0;
        width:100%;
        z-index:9;
        line-height:30px;
        font-size: 25px;
        color: white;
        background-color: #0f8ec7;'>Convos</div>
<div style='height:100%;background-color::#F0F0F0;'>
    <form action='direct1.php' method='post' style='margin-top:50px;'>
        $chlist
    </form>

</div>";
} else {
    $content="
    <div class='narrow' style='font-size:18px;position:fixed;top:60px;left:0;height:calc(100% - 60px);background-color:white;width:25%;'>
        <div class='economica' style='font-size:25px;margin: 40px 0px 20px 40px;'>
            Convos
        </div>
        <form action='direct1.php' method='post'>
            $chlist
        </form>
    </div>
    <div class='economica' style='color:white;font-size:25px;width:75%;height:100%;padding-top:40px;background-color:white;margin:0px;margin-left:25%;background-image:url(../Images/young.jpg);text-align:center;background-repeat:no-repeat;background-size:cover;'>
        Select someone to chat with them here.
    </div>";
}
include 'template.php';
?>
