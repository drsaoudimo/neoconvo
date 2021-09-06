<?php
include 'basic.php';
$title="Sharing Post";
echo "<br><br><br><br>";
echo "<br>
<div style='font-size:18px;margin-left:40px;background-color:white;width:500px;padding:20px;' class='narrow'>
<div style='font-size:20px;' class='mih'>Attempting to share post...</div><br>";
$content="";
$uploadOk=1;
// Get video if selected
if (isset($_FILES["vid"]["name"])) {
    $target_file_video = "uploads/" . basename($_FILES["vid"]["name"]);
    if (move_uploaded_file($_FILES["vid"]["tmp_name"], $target_file_video)) {
        $video=basename( $_FILES["vid"]["name"]);
    } else {
        echo '--> Your Video could not be uploaded due to an unknown reason. Sharing post anyway.';
        $video = null;
    }
} else {
    echo "<div style='color:red;'>--> No video is provided.</div>";
    $video = null;
}

// Get image if selected
if ($_FILES["fileToUpload"]["name"] != "") {
    echo "<div style='color:lime;'>--> Image is provided</div>";
    $target_file_image = "uploads/" . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file_image, PATHINFO_EXTENSION));
    // Check if file already exists
    if (file_exists($target_file_image)) {
        $error1="--> Image not uploaded because a similar file already exists.<br>
            --> To resolve this issue, rename your image and try uploading again.<br>";
        $uploadOk=0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 50000000000000 && $img!=null) {
        $error2= "--> Image not uploaded because image size is too large.<br>";
        $uploadOk=0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $img!=null) {
        $error3= "--> Your image could not be uploaded because only jpg, jpeg, png & gif images are allowed.<br>";
        $uploadOk = 0;
    }
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file_image)) {
        $img=basename( $_FILES["fileToUpload"]["name"]);
    }
} else { 
    echo "<div style='color:red;'>--> No image is provided.</div>";
    $img=null;
}


if(isset($_POST['post']) && !empty($_POST['post'])) {
    $post = nl2br($_POST['post']);
    echo "<div style='color:lime;'>--> Text is provided</div>";
    $uploadOk=1;
} else {
    echo "<div style='color:red;'>--> No text is provided.</div>";
}

if($img==null && !isset($post) && $video==null) {
    $uploadOk=0;
    $error4="--> You can't share an empty post<br>--> A post must contain at least text or an image or a video.";
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk==0) {
     echo "<br><div style='color:red;' class='mih'>POST NOT SHARED SUCCESSFULLY</div><br>";
     echo "--> Possible reasons:<br>";
    echo "$error1 $error2 $error3 $error4";
    echo "</div>";
} else {
    echo "--> No known errors have been encountered yet.<br>--> Proceeding to share post.<br>";
        if (date("m")==1) {
          $month="January";
        }  elseif (date("m")==2) {
          $month="February";
        } elseif (date("m")==3) {
          $month="March";
        } elseif (date("m")==4) {
          $month="April";
        } elseif (date("m")==5) {
          $month="May";
        } elseif (date("m")==6) {
          $month="June";
        } elseif (date("m")==7) {
          $month="July";
        } elseif (date("m")==8) {
          $month="August";
        } elseif (date("m")==9) {
          $month="September";
        } elseif (date("m")==10) {
          $month="October";
        } elseif (date("m")==11) {
          $month="November";
        } elseif (date("m")==12) {
          $month="December";
        } else {
          $month="November";
        }
        $myDate= date("d") ." ".$month." ". date("Y");
        try {
            $sql = "INSERT INTO POSTS (postBy, post, date, image, vdo)
            VALUES ('$id', '$post', '$myDate', '$img', '$video')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            echo '<br><div style="color:lime;" class="mih">POST SHARED SUCCESSFULY</div><br><meta http-equiv="refresh" content="2; url=home1.php">';
        } catch(PDOException $e) {
            echo "<br><div style='color:red;' class='mih'>POST NOT SHARED SUCCESSFULLY</div><br>";
            // $sql . "<br>" . $e->getMessage();
            echo "--> Possible reasons:<br>--> 1) Single quote in post text.<br>--> 2) Emoticons in post.";
        }
        echo "</div>";
}
include 'template.php';
?>
