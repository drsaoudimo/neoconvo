<?php

// function to get user id
function get_id($conn, $uname, $passw) {
    try {
        $sql = "SELECT id from MAIN WHERE uname='$uname' AND password='$passw';";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $r = $stmt->fetch();
        $id = $r['id'];
        return $id;
    } catch(PDOException $e) {
        echo "<br><br><br><br>" . $sql . "<br>" . $e->getMessage();
    }
}

?>