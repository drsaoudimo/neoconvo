<?php
// get current id session_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}

// Connect to MySQL
if (!isset($conn)) {
    $servername = "ec2-44-205-177-160.compute-1.amazonaws.com";
    $username = "kxnejnuswwwqot";
    $password = "346cbdb84eb2bcb934788e7e427b0452660f3eb09a88bf28ebc173dd9f9721df";
    $dbname = "dcu7aq99o0njc4";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection Error" . $e->getMessage();
    }
}

require_once 'Mobile_Detect.php'; 
$detect = new Mobile_Detect(); 
if ($detect->isMobile()) { 
    $mobile=1;
} else {
    $mobile=0;
}
?>
