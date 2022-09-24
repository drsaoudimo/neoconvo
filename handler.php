<?php

/*
 * This file handles the registration process
 * This file is used by register.php file
 * 
 * @author Mihir Trivedi <mtrivedi4@wisc.edu>
 */

if (isset($_POST['submit']) && !empty($_POST['email']) &&  !empty($_POST['fname'])  && !empty($_POST['uname']) && !empty($_POST['password'])) {
    include 'basic.php';
    $uname=$_POST['uname'];
    $fname=$_POST['fname'];
    $email=$_POST['email'];
    $pass=$_POST['password'];
    $gender=$_POST['gender'];

    try {
        $sql="INSERT INTO MAIN (uname, fname, email, gender, password)
        VALUES ('$uname', '$fname', '$email', '$gender', '$pass');";
        $conn->exec($sql);
        $_SESSION['id']=$conn->lastInsertId();
        echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}
?>