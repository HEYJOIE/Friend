<?php 
include 'functions.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="A website to build a social network through food">
        <title>Fooriend Help</title>
        <link rel="stylesheet" href="css/main.css">
        <style type="text/css">
            #header{
                border-bottom: 2px solid #ff3;
            }
            #innercontainer{
                padding:70px;
                color:#fff;
            }
            #innercontainer h2{
                margin:0;
                padding: 0;
            }
        </style>

    </head>
    
    <body>
    <div id="outercontainer">
    	<div id="header">
    		<h1><a id="logo" href="index.php"><img src="img/logo.png" alt="Fooriend" /></a></h1>
            <ul>
            <?php             
                 if($_SESSION['loginUserid']){
                    echo "<li id=\"invitationpost\"><a href=\"invitation_post.php\">Post an invitation</a></li>";
                    echo "<li id=\"account\"><dl><dt><a href=\"#\">".ucfirst($_SESSION["logedgivenname"])."</a></dt>"; ?>
                    <dd><a href="my_profile.php">My Profile</a></dd>
                    <dd><a href="my_invitation.php">Manage Invitations</a></dd>
                    <!--<dd><a href="#">Account Settings</a></dd>-->
                    <dd><a href="index.php?Logout=1">Logout</a></dd>
                    <?php
                    echo "</dl></li>";
                 }
                 else{
                    echo "<li id=\"register\"><a href=\"register.php\">Register</a></li>";
                    echo "<li id=\"login\"><a href=\"login.php\">Login</a></li>";
                 }
            ?>
            </ul>
    	</div>
        <div id=innercontainer>
        <h2>Contact</h2>
        <p>For any help, please contact us: solemomjun@gmail.com. Also, you can refer to our report:&nbsp;<a href="FooriendReportForAlpha.pdf" target="_blank">Fooriend_Report_For_Alpha.pdf</a> and our screen video: <a href="Screen_Video_For_Fooriend.mp4" target="_blank">Screen_Video_For_Fooriend.mp4</a></p>
        </div>
        <div id="footer">
            <ul>
                <li><a href="about.php">about us</a></li>
                <li><a href="help.php">help</a></li>
            </ul>
        </div>
    </div>
    </body>
</html>