<?php
include 'basic.php';
$title = 'Request';
if (isset($_POST['accept'])) {
    $fo = $_POST['accept'];
    try {
        $sql = "UPDATE CONVOS SET status=1 WHERE requestTo='$id' AND requestFrom='$fo';";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $content = "<div class='economica' style='width:100%;font-size:25px;text-align:center;margin-top:300px;'>Request Accepted.<meta http-equiv='refresh' content='1; url=profile.php'>";
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
} elseif (isset($_POST['reject'])) {
    $fo=$_POST['reject'];
    try {
        $sql="DELETE FROM CONVOS WHERE requestTo='$id' AND requestFrom='$fo' AND status=0;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $content = 'Request Rejected.<meta http-equiv="refresh" content="1; url=profile.php">';
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
} elseif (isset($_POST['faccept'])) {
    $fo = $_POST['faccept'];
    try {
        $sql = "UPDATE FOLLOWERS SET status=1 WHERE requestTo='$id' AND requestFrom='$fo';";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $content = "<div class='economica' style='width:100%;font-size:25px;text-align:center;margin-top:300px;'>Request Accepted.<meta http-equiv='refresh' content='1; url=profile.php'>";
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
} elseif (isset($_POST['freject'])) {
    $fo=$_POST['freject'];
    try {
        $sql="DELETE FROM FOLLOWERS WHERE requestTo='$id' AND requestFrom='$fo' AND status=0;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $content = 'Request Rejected.<meta http-equiv="refresh" content="1; url=profile.php">';
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}
include 'template.php';
?>
