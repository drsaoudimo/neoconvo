<?php
include_once 'acti_noti.php';
if ($mobile==0) {
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="icon" href="Images/neoLogo.PNG" style="border-radius:5px;">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="Stylesheet.css" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
        <div id="wrapper" style='height:100%;width:100%;border:none;background-color:#F0F0F0;'>
            <nav id='navigation' style='height:60px;background-color:#0f8ec7;z-index:50;'>
                <div class='kro economica' style='color:white;margin:0px;padding:0px;line-height:60px;margin-left:40px;font-size:30px;'>NeoConvo</div>
                <ul id="nav" style='text-align:center;'>
                    <div style='position:fixed;top:5px;right:40px;'>
                        <li class='narrow'><a href="home1.php"  class='nbtn'><i class="material-icons">home</i></a></li>
                        <li class='narrow'><a href="people.php" class='nbtn'><i class="material-icons">search</i></a></li>
                        <li class='narrow'><a href="profile.php" class='nbtn'><i class="material-icons">person</i></a></li>
                        <li class='narrow'><a href="direct.php" class='nbtn'><i class="material-icons">question_answer</i></a><?php echo $tor; ?></li>
                        <li class='narrow'><a href="activity.php" class='nbtn'><i class="material-icons">notifications</i></a><?php echo $por; ?></li>
                        <li class='narrow'><a href="edit.php" class='nbtn'><i class="material-icons">settings</i></a></li>
                        <li class='narrow'><a href="logout.php" class='nbtn'><i class="material-icons">logout</i></a></li>
                    </div>
                </ul>       
            </nav>
            <div style='margin-top:60px;'>
                <?php echo $content; ?>
            </div>
         </div>
    </body>
</html>

<?php
} else {
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="Images/logo.PNG" style="border-radius:5px;">
        <link rel="stylesheet" type="text/css" href="Styles/Stylesheet.css" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined" rel="stylesheet">
        <title><?php echo $title;?></title>
    </head>
    <style>
    .foh{
	z-index: 9;
        background-color: white;
        position:fixed;
        bottom:0px;
        width:100%;
        height:50px;
    }
</style>
<?php
    if ($act_count==0) {
        $acti="";
    } else {
        $acti="<div style='background-color:red;
            height:15px;
            width:15px;
            color:white;
            border-radius:15px;
            position:absolute;
            line-height:15px;
            margin-top:-25px;
            margin-left:15px;
            font-size:10px;
            text-align:center;'>
            $act_count
            </div>";
    }
    if ($dir_count==0) {
        $dire="";
    } else {
        $dire="<div style='background-color:red;
            height:15px;
            width:15px;
	    color: white;
            text-align:center;
            border-radius: 15px;
            position:absolute;
            margin-top:-25px;
            margin-left: 15px;
            font-size:10px;'>
            $dir_count
            </div>";
    }
?>
    <body>
        <div class="foh">
            <ul id='nav' style="border-top:1px solid lightgray;height:20px;width:100%;padding-left:15px;">
                <li style="padding:15px;"><a href="home1.php" style="padding:0px;margin:0px;color:black;"><i class="material-icons-outlined">home</i></a></li>
                <li style="padding:15px;"><a href="people.php" style="margin:0px; padding:0px;color:black;"><i class="material-icons-outlined">search</i></a></li>
                <li style="padding:15px;"><a href="profile.php" style="margin:0px;padding:0px;color:black;"><i class="material-icons-outlined">person</i></a></li>
                <li style="padding:15px;"><a href="direct.php" style="margin:0px;padding:0px;color:black;"><i class="material-icons-outlined">question_answer</i><?php echo $dire; ?></a></li>
                <li style="padding:15px;"><a href="activity.php" style="padding:0px;margin:0px;color:black;"><i class="material-icons-outlined">notifications</i><?php echo $acti; ?></a></li>
                <li style="padding:15px;"><a href="settings.php" style="padding:0px;margin:0px;color:black;"><i class="material-icons-outlined">settings</i></a></li>
            </ul>
        </div>
        <div style='width:100%;background-color:#F0F0F0;'>
            <?php echo $content ?>
        </div>
    </body>
</html>
<?php } ?>