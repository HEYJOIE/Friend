<!--Page for introducing our group-->
<?php 
include 'functions.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="A website to build a social network through food">
        <title>Fooriend About</title>
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
        <!--logo and login banner-->
    	<div id="header">
    		<h1><a id="logo" href="index.php"><img src="img/logo.png" alt="Fooriend" /></a></h1>
            <ul>
            <?php  
                //check whether there is a user login           
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
        <!--introduction of the website and ourselves-->
        <div id=innercontainer>
        <h2>What is Fooriend</h2>
        <p>The Fooriend webiste aims to build a social network through food, that is making friends by sharing food. You can invite others to cook together so that everyone can have the opportunity to learn to cook exotic cuisine, or just share your excess food to avoid wastage, or ask for restaurant companionship to have a wonderful dating.</p>
        <h2>Who are We</h2>
        <p>We are students from MSc Design Informatics program in University of Edinburgh and this website is our coursework for Dynamic Web Design. Our group is called "Chinese Leaf" for we are all chinese girls. The group members are: Xiangjun Liu for back-end development, Wenjing Chen for front-end development and Xinwei Du for interface design.</p>
        <p>For more information, please refer to the report:&nbsp;<a href="FooriendReportForAlpha.pdf" target="_blank">FooriendReportForAlpha.pdf</a></p>
        </div>
        <!--footer-->
        <div id="footer">
            <ul>
                <li><a href="about.php">about us</a></li>
                <li><a href="help.php">help</a></li>
            </ul>
        </div>
    </div>
    </body>
</html>