<?php
session_start();
unset($_SESSION['id']);
echo '<meta http-equiv="refresh" content="0; url=index.php">';
/*
include 'basic.php';
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbus", $dbus, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //whether ip is from share internet
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //whether ip is from proxy
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        //whether ip is from remote address
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    $sql="INSERT INTO LHISTORY (login_id, login_date, email, password, ip_add, access) VALUES ('$id', NOW(), '-', '-', '$ip_address', 'Logout');";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    unset($_SESSION["id"]);
    echo '<meta http-equiv="refresh" content="0; url=login.php">';
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
*/
?>