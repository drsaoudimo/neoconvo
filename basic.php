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
    $servername = "us-west-2.6d9c06bb-d8ba-4a98-a6fc-cabcb527ea89.aws.ybdb.io";
    $username = "admin";
    $password = "iMY1LwJ4oMmA5YWqquuURuC716xQbK";
    $dbname = "yugabyte";
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
