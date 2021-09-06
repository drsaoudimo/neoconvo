<?php 
include 'basic.php';
$title = 'Search Netingineer';
try {
    $sql="SELECT id, uname, age, gender, pimage FROM MAIN WHERE id!='$id' AND id NOT IN (SELECT requestTo FROM FOLLOWERS WHERE requestFrom='$id' AND status=1) AND id NOT IN (SELECT requestFrom FROM FOLLOWERS WHERE requestTo='$id' AND status=1);";
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    $people="";
    while($r=$stmt->fetch()) {
        $sid=$r['id'];
        $un=$r['uname'];
	$age=$r['age'];
        $gn=$r['gender'];
        $im=$r['pimage'];
        if ($mobile==1) {
            $people.="
            <button name='id' value='$sid' class='narrow' style='font-size:16px;width:90%;text-align:left;background-color:white;height:101px;margin-top:10px;border: 1px solid lightgray;border-radius:10px;'>
            <img src='uploads/$im' alt='image' style='object-fit:cover;float:left;height:100px;width:100px;border-radius: 10px 0px 0px 10px;margin-right:20px;'>
            <div class='economica' style='font-size:25px;margin:10px;'>$un</div>
            $gn, $age
            </button>";
        } else {
            $people.="
            <button name='id' value='$sid' class='narrow koh' style='padding-right:20px;cursor:pointer;font-size:18px;border-radius:20px; border:0.5px solid lightgray;text-align:left;height:151px;width:calc(50% - 40px);display:inline-block;margin:0px 20px 20px 0px;'>
            <img src='uploads/$im' alt='image' style='float:left;object-fit:cover;height:150px;width:150px;margin-right:20px;border-radius:20px 0px 0px 20px;'>
            <div class='economica' style='font-size:30px;margin:15px;'>$un</div>
            $gn, $age
            </button>";
        }
    }
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

if ($mobile==1) {
    if(isset($_SESSION['results'])) {
        // Search results page for mobile
        $title="Search Results";
        $finSearResults=$_SESSION['results'];
        $content="<div style='text-align:center;background-color:white;'>
        <form action='people.php' method='post' style='width:90%;margin-left:5%;padding-top:15px;text-align:left;'>
        <div class='narrow' style='font-size:16px;'>Search for strangers using their age and gender.</div>
        <select name='age' class='narrow' style='margin-top:10px;height:40px;width:calc(35% - 5px);border-radius:40px;float:left;margin-right:10px;border:1px solid lightgray;font-size:16px;background-color:white;padding-left:10px;'>
          <option value='13'>13</option>
          <option value='14'>14</option>
          <option value='15'>15</option>
          <option value='16'>16</option>
          <option value='17'>17</option>
          <option value='18'>18</option>
          <option value='19'>19</option>
          <option value='20'>20</option>
          <option value='21'>21</option>
          <option value='22'>22</option>
          <option value='23'>23</option>
          <option value='24'>24</option>
        </select>
        <select name='gender' class='narrow' style='margin-top:10px;height:40px;width:calc(45% - 20px);border-radius:40px;border:1px solid lightgray;padding-left:10px;margin-right:10px;background-color:white;font-size:16px;'>
          <option value='Male'>Male</option>
          <option value='Female'>Female</option>
        </select>
        <button name='search' class='narrow' style='width:20%;font-size:16px;height:40px;border-radius:40px;border:1px solid lightgray;background-color:#0f8ec7;color:white;'>Search</button>
        </form>
        <div style='background-color:#0f8ec7;width:100%;height:100%;border-top:1px solid lightgray;margin-top:15px;background-color:#F0F0F0;'>
        <form action='pu2.php'>
        $finSearResults
        </form>
        </div>
        </div>";
        unset($_SESSION['results']);
    } else {
        // Explore page for mobile
        $content="<div style='text-align:center;background-color:white;'>
        <form action='people.php' method='post' style='width:90%;margin-left:5%;padding-top:15px;text-align:left;'>
        <div class='narrow' style='font-size:16px;'>Search for strangers using their age and gender.</div>
        <select name='age' class='narrow' style='margin-top:10px;height:40px;width:calc(35% - 5px);border-radius:40px;float:left;margin-right:10px;border:1px solid lightgray;font-size:16px;background-color:white;padding-left:10px;'>
          <option value='13'>13</option>
          <option value='14'>14</option>
          <option value='15'>15</option>
          <option value='16'>16</option>
          <option value='17'>17</option>
          <option value='18'>18</option>
          <option value='19'>19</option>
          <option value='20'>20</option>
          <option value='21'>21</option>
          <option value='22'>22</option>
          <option value='23'>23</option>
          <option value='24'>24</option>
        </select>
        <select name='gender' class='narrow' style='margin-top:10px;height:40px;width:calc(45% - 20px);border-radius:40px;border:1px solid lightgray;padding-left:10px;margin-right:10px;background-color:white;font-size:16px;'>
          <option value='Male'>Male</option>
          <option value='Female'>Female</option>
        </select>
        <button name='search' class='narrow' style='width:20%;font-size:16px;height:40px;border-radius:40px;border:1px solid lightgray;background-color:#0f8ec7;color:white;'>Search</button>
        </form>
        <div style='background-color:#0f8ec7;width:100%;height:100%;border-top:1px solid lightgray;margin-top:15px;background-color:#F0F0F0;'>
        <form action='pu2.php'>
        $people
        </form>
        </div>
        </div>";
    }
} else {
    if(isset($_SESSION['results'])) {
        // Search results page for desktop
        $title="Search Results";
        $finSearResults=$_SESSION['results'];
        $tol=$_SESSION['tol'];
        $content = "
        <div class='narrow' style='padding-left:40px;font-size:18px;position:fixed;top:60px;left:0;height:calc(100% - 60px);background-color:white;width:calc(25% - 40px);'>
        <div class='economica' style='font-size:25px;margin: 40px 0px 5px 0px;'>Search results for</div>
        $tol
        <div style='width:calc(100% - 40px);margin-top:20px;margin-bottom:20px;border-top:0.5px solid black;'></div>
        Search for strangers based on their<br>age and gender.
        <form action='people.php' method='post'>
        <select name='age' class='lola3 narrow' style='margin-top:20px;cursor:pointer;height:40px;width:35%;border-radius:10px;margin-right:10px;border:0.5px solid lightgray;padding-left:10px;'>
          <option value='13'>13</option>
          <option value='14'>14</option>
          <option value='15'>15</option>
          <option value='16'>16</option>
          <option value='17'>17</option>
          <option value='18'>18</option>
          <option value='19'>19</option>
          <option value='20'>20</option>
          <option value='21'>21</option>
          <option value='22'>22</option>
          <option value='23'>23</option>
          <option value='24'>24</option>
        </select>
        <select name='gender' class='lola3 narrow' style='margin-top:20px;cursor:pointer;height:40px;width:45%;border-radius:10px;border:0.5px solid lightgray;padding-left:10px;'>
          <option value='Male'>Male</option>
          <option value='Female'>Female</option>
        </select>
        <button name='search' style='margin-bottom:40px;margin-top:20px;font-size:18px;background-color:#0f8ec7;color:white;width:calc(80% + 15px);border:0.5px solid lightgray;height:40px;border-radius:40px;' class='narrow'>Search</button>
        </form>
        <div style='border-top:0.5px solid black;width:35%;float:left;margin-right:17px;'></div>
        <div style='border-top:0.5px solid black;width:35%;float:right;margin-right:40px;'></div>
        <div style='margin-top:-10px;'>or</div>
        <div style='margin-top:30px;margin-bottom:20px;'>Search for strangers using their username.</div>
            <form action='people.php' method='post'>
                <input name='purr'
                    type='text'
                    placeholder='Search for people'
                    class='narrow'
                    style='width:calc(100% - 82px);
                        height:40px;
                        font-size:18px;
                        border-radius: 40px 0px 0px 40px;
                        border: 0.5px solid lightgray;
                        padding-left: 10px;
                        display:inline-block;'>
                    <button style='height:40px;border-radius:0px 40px 40px 0px;margin-top:-40px;background-color:#0f8ec7;color:white;border:0.5px solid lightgray;margin-left:-5px;width:40px;' class='fa fa-search'></button>
            </form>
        </div>
        <div style='text-align:center;margin-left:25%;padding:40px;width:calc(75% - 80px);height:100%;'>
        <form action='pu2.php'>
            $finSearResults
        </form>
        </div>";
        unset($_SESSION['results']);
    } else {
        // Explore page for desktop
        $content = "
        <div class='narrow' style='padding-left:40px;font-size:18px;position:fixed;top:60px;left:0;height:calc(100% - 60px);background-color:white;width:calc(25% - 40px);'>
        <div class='economica' style='font-size:25px;margin: 40px 0px 20px 0px;'>Search for people</div>
        Search for strangers based on their<br>age and gender.
        <form action='people.php' method='post'>
        <select name='age' class='lola3 narrow' style='margin-top:20px;cursor:pointer;height:40px;width:35%;border-radius:10px;margin-right:10px;border:0.5px solid lightgray;padding-left:10px;'>
          <option value='13'>13</option>
          <option value='14'>14</option>
          <option value='15'>15</option>
          <option value='16'>16</option>
          <option value='17'>17</option>
          <option value='18'>18</option>
          <option value='19'>19</option>
          <option value='20'>20</option>
          <option value='21'>21</option>
          <option value='22'>22</option>
          <option value='23'>23</option>
          <option value='24'>24</option>
        </select>
        <select name='gender' class='lola3 narrow' style='margin-top:20px;cursor:pointer;height:40px;width:45%;border-radius:10px;border:0.5px solid lightgray;padding-left:10px;'>
          <option value='Male'>Male</option>
          <option value='Female'>Female</option>
        </select>
        <button name='search' style='margin-bottom:40px;margin-top:20px;font-size:18px;background-color:#0f8ec7;color:white;width:calc(80% + 15px);border:0.5px solid lightgray;height:40px;border-radius:40px;' class='narrow'>Search</button>
        </form>
        <div style='border-top:0.5px solid black;width:35%;float:left;margin-right:17px;'></div>
        <div style='border-top:0.5px solid black;width:35%;float:right;margin-right:40px;'></div>
        <div style='margin-top:-10px;'>or</div>
        <div style='margin-top:30px;margin-bottom:20px;'>Search for strangers using their username.</div>
            <form action='people.php' method='post'>
                <input name='purr'
                    type='text'
                    placeholder='Search for people'
                    class='narrow'
                    style='width:calc(100% - 82px);
                        height:40px;
                        font-size:18px;
                        border-radius: 40px 0px 0px 40px;
                        border: 0.5px solid lightgray;
                        padding-left: 10px;
                        display:inline-block;'>
                    <button style='height:40px;border-radius:0px 40px 40px 0px;margin-top:-40px;background-color:#0f8ec7;color:white;border:0.5px solid lightgray;margin-left:-5px;width:40px;' class='fa fa-search'></button>
            </form>
        </div>
        <div style='text-align:center;margin-left:25%;padding:40px;width:calc(75% - 80px);height:100%;'>
        <form action='pu2.php'>
            $people
        </form>
        </div>";
    }
}
include 'template.php';
?>
<?php
if (isset($_POST['search'])) {
	include 'basic.php';
    $age=$_POST['age'];
    $gender=$_POST['gender'];
    $tol="$age year old $gender";
    $_SESSION['tol']=$tol;
    try {
        $sql = "SELECT id, uname, gender, age, interests, pimage from MAIN WHERE age='$age' AND gender='$gender';";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $finSearResult="";
        while ($r=$stmt->fetch()) {
            $sid=$r['id'];
            $sun=$r['uname'];
            $sim=$r['pimage'];
            $sgn=$r['gender'];
	    $age=$r['age'];
            $sin=$r['interests'];
            if ($sin=="") {
                $sin="$sun isn't interested in anything yet.";
            } else {
                $sin="Interested in $sin";
            }
            if($mobile==1) {
                $finSearResult.="
                <button name='id' value='$sid' class='narrow' style='font-size:16px;width:90%;text-align:left;background-color:white;height:101px;margin-top:10px;border: 1px solid lightgray;border-radius:10px;'>
                <img src='uploads/$sim' alt='image' style='object-fit:cover;float:left;height:100px;width:100px;border-radius: 10px 0px 0px 10px;margin-right:20px;'>
                <div class='economica' style='font-size:25px;margin:10px;'>$sun</div>
                $age year old $sgn. $sin
                </button>";
            } else {
                $finSearResult.="
                <button name='id' value='$sid' class='narrow koh' style='padding-right:20px;cursor:pointer;font-size:18px;border-radius:20px; border:0.5px solid lightgray;text-align:left;height:151px;width:calc(50% - 40px);display:inline-block;margin:0px 20px 20px 0px;'>
                <img src='uploads/$sim' alt='image' style='float:left;object-fit:cover;height:150px;width:150px;margin-right:20px;border-radius:20px 0px 0px 20px;'>
                <div class='economica' style='font-size:30px;margin:15px;'>$sun</div>
                $age year old $sgn. $sin
                </button>";
            }
        }
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    if($finSearResult=="") {
        $finSearResult="<div class='economica' style='font-size:25px;'>No Results Found.</div>";
    }
    $_SESSION['results']=$finSearResult;
    echo '<meta http-equiv="refresh" content="0;url=people.php" />';
} elseif (isset($_POST['purr']) && !empty($_POST['purr'])) {
    $tol=$_POST['purr'];
    $_SESSION['tol']=$tol;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbus", $dbus, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT id, uname, gender, interests, pimage from MAIN WHERE uname LIKE '%$tol%';";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $finSearResult="";
        while ($r=$stmt->fetch()) {
            $sid=$r['id'];
            $sun=$r['uname'];
            $sim=$r['pimage'];
            $sgn=$r['gender'];
            $sin=$r['interests'];
            if ($sin=="") {
                $sin="$sun isn't interested in anything yet.";
            } else {
                $sin="Interested in $sin";
            }
            $finSearResult.="
                <button name='id' value='$sid' class='narrow koh' style='padding-right:20px;cursor:pointer;font-size:18px;border-radius:20px; border:0.5px solid lightgray;text-align:left;height:151px;width:calc(50% - 40px);display:inline-block;margin:0px 20px 20px 0px;'>
                <img src='uploads/$sim' alt='image' style='float:left;object-fit:cover;height:150px;width:150px;margin-right:20px;border-radius:20px 0px 0px 20px;'>
                <div class='economica' style='font-size:30px;margin:15px;'>$sun</div>
                20 year old $sgn. $sin
                </button>";
        }
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    if($finSearResult=="") {
        $finSearResult="<div class='economica' style='font-size:25px;'>No Results Found.</div>";
    }
    $_SESSION['results']=$finSearResult;
    echo '<meta http-equiv="refresh" content="0;url=people.php" />';
}
?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.sbtn{
    background-color:white;
    text-align:left;
    border: none;
    cursor:pointer;
}
.sbtn:hover {
    background-color:lightgray;
}
.na{
   color:white;
   font-family: 'Oswald', sans-serif;
}
.koh{
    background-color:white;
}
.koh:hover{
    background-color:lightgray;
}
</style>
