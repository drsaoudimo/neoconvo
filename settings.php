<?php
include 'basic.php';
$title="Settings";
$content="
<div class='economica' style='padding:10px 10px 10px 15px;
        position:fixed;
        top:0;
        width:100%;
        z-index:9;
        line-height:30px;
        font-size: 25px;
        color: white;
        background-color: #0f8ec7;'>Settings</div>
        <form action='profile.php'>
        <button class='narrow dre' style='margin-top:50px;font-size:16px;padding-left:15px;'>View Profile</button>
        </form>
        <form action='edit.php' method='post'>
        <button name='code' value='0' class='narrow dre' style='font-size:16px;padding-left:15px;'>Account Settings</button>
        <button name='code' value='0' class='narrow dre' style='font-size:16px;padding-left:15px;'>Privacy Settings</button>
        </form>
        <form action='people.php'>
        <button class='narrow dre' style='font-size:16px;padding-left:15px;'>Find People</button>
        </form>
        <form action='logout.php'>
        <button class='narrow dre' style='font-size:16px;padding-left:15px;'>Logout</button>
        </form>
";
include 'template.php';
?>