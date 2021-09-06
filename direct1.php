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
        $chlist.="
        <button name='idd' value='$zoka' class='economica dre'>
        <img src='uploads/$img' style='margin:10px;margin-left:40px;height:45px;width:45px;border-radius:45px;float:left;object-fit:cover;'>$uname
        </button>";
        $z++;
    }
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

if (isset($_POST['idd'])) {
    $d=$_POST['idd'];
} elseif(isset($_SESSION['fo'])) {
    $d=$_SESSION['fo'];
} else {
    echo 'An error occured.';
}

try {
    $sql = "SELECT uname, pimage from MAIN WHERE id='$d';";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $r=$stmt->fetch();
    $un=$r['uname'];
    $img=$r['pimage'];
    $sql="UPDATE MESSAGES SET status=1 where message_from='$d' AND message_to='$id';";
    $stmt=$conn->prepare($sql);
    $stmt->execute();
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

// prepare the messages
$messages="";
try {
    $sql = "SELECT message from MESSAGES WHERE (message_from='$d' AND message_to='$id') OR (message_from='$id' AND message_to='$d');";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($r=$stmt->fetch()) {
      $message=$r['message'];
      try {
        $sql1 = "SELECT message_from FROM MESSAGES WHERE message='$message';";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute();
        $r1=$stmt1->fetch();
        $message_from=$r1['message_from'];
        if ($mobile==1) {
          // for mobile
          if ($message_from==$d) {
	    // from other user
            if (strlen($message)>=40) {
              $messages.="
	      <div style='width:100%;display:inline-block;'>
	        <div class='narrow m-message-r' style='width:60%;'>$message</div>
              </div>";
            } else {
              $messages.="
              <div style='width:100%;display:inline-block;'>
                <div class='narrow m-message-r'>$message</div>
              </div>";
            }
          } else {
            // from current user
            if (strlen($message)>=40) {
              $messages.="
	      <div style='width:100%;display:inline-block;'>
                <div class='narrow m-message-s' style='width: 60%;'>$message</div>
              </div>";
            } else {
              $messages.="
	      <div style='width:100%;display:inline-block;'>
	        <div class='narrow m-message-s'>$message</div>
              </div>";
            }
          }
        } else {
          // for desktop
          if ($message_from==$d) {
            if (strlen($message)>=40) {
              $messages.="
	      <div style='width:100%;display:inline-block;'>
                <div class='narrow m-message-r' style='width: 60%;'>$message</div>
	      </div>";
            } else {
              $messages.="
	      <div style='width:100%;display:inline-block;'>
	        <div class='narrow m-message-r' style='font-size:18px;'>$message</div>
 	      </div>";
            }
          } else {
            if (strlen($message)>=40) {
              $messages.="
              <div style='width:100%;display:inline-block;'>
	        <div class='narrow m-message-s' style='width: 60%;font-size: 18px;'>$message</div>
	      </div>";
            } else {
              $messages.="
              <div style='width:100%;display:inline-block;'>
	        <div class='narrow m-message-s' style='font-size: 18px;'>$message</div>
	      </div>";
            }
          }
        }
      } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
    }
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$_SESSION['fo']=$d;

if ($mobile==1) {
    // Content for mobile browsers
    $content="
        <div style='position:fixed;width: 100%;background-color:#0f8ec7;'>
            <form action='pu2.php'>
                <button name='id' value='$d' class='economica' style='color:white;font-size:25px;height:65px;line-height:65px;width:100%;text-align:left;background-color:transparent;border:none;'>
                    <img src='uploads/$img' style='margin: 10px 10px 10px 15px;height:45px;width:45px;border-radius:45px;float:left;object-fit:cover;'>$un
                </button>
            </form>
        </div>
        <div id='tal' style='width:100%;height:100%;text-align:left;padding-bottom: 100px;padding-top:65px; background-color:#F0F0F0;'>
            $messages
           </div>
            <div style='position:fixed;bottom:50px;width:100%;'>
            <form action='direct1.php' method='post'>
            <input type='text' class='narrow'
                name='mess' autocomplete='off'
                placeholder='Type a message...' 
                style='padding-left:15px;border:none;
                    width:calc(100% - 50px);
                    height:50px;
                    font-size:16px;' />
            <button style='height:50px;width:50px;float:right;
                color:#0f8ec7; background-color:white;
                border:none;'>
                <i class='material-icons'>send</i>
            </button>
        </form>
        </div>";
} else {
    $content="
    <div class='narrow' style='border-right:0.5px solid lightgray;font-size:18px;position:fixed;top:60px;left:0;height:calc(100% - 60px);background-color:white;width:25%;'>
        <div class='economica' style='font-size:25px;margin: 40px 0px 0px 40px;'>
            Convos
        </div>
        <div style='margin-bottom:20px;'></div>
        <form action='direct1.php' method='post'>
            $chlist
        </form>
    </div>
    <div id='tal' style='color:white;font-size:25px;width:calc(75% - 1px);height:calc(100% - 60px);background-color:#F0F0F0;margin-left:25%;padding-top:100px;'>
        <form action='pu2.php'>
            <button name='id' value='$d' class='economica' style='position:fixed;top:60px;border:none;border-left:0.5px solid lightgray;border-bottom:0.5px solid lightgray;padding-top:25px;font-size:25px;line-height:55px;width:100%;background-color:white;height:90px;text-align:left;'>
                <img src='uploads/$img' style='margin:10px;margin-left:15px;margin-top:10px;height:45px;width:45px;border-radius:45px;float:left;object-fit:cover;'>
                $un
            </button>
        </form>
        $messages
        <form action='direct1.php' method='post'>
        <button style='position:fixed;z-index:1;border-radius:30px;height:30px;width:30px;background-color:transparent;color:#0074D9;border:none;bottom:7px;right:5px;cursor:pointer;'>
        <i class='material-icons'>send</i>
        </button>
        <input type='text' class='narrow' name='mess' placeholder='Type a message...' autocomplete='off' style='padding-left:15px;border:none;position:fixed;bottom:0;right:0;width:calc(75% - 1px);height:50px;font-size:18px;' />
        </form>
    </div>";
}
include 'template.php';
?>

<?php
include 'basic.php';
if(isset($_POST['mess'])) {
    $mes=addslashes($_POST['mess']);

try {
    $sql = "INSERT INTO MESSAGES (message_from, message_to, message, status)
    VALUES ('$id', '$d', '$mes', 0);";
    $conn->exec($sql);
    echo '<meta http-equiv="refresh" content="0; url=direct1.php">';
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

}
?>
<script>
    var objDiv = document.getElementById("tal");
    objDiv.scrollTop = objDiv.scrollHeight;
</script>
<style>
.m-message-r, .m-message-s {
  border-radius: 10px;
  padding: 5px 10px;
  margin: 15px 15px 0px 15px;
  font-size: 16px;
  display: inline-block;
  word-wrap: break-word;
  background-color: white;
  color: black;
  text-align: left;
}
.m-message-s {
  background-color: #0f8ec7;
  color: white;
  float: right;
}
</style>
