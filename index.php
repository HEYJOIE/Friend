
include 'functions.php';
session_start();

//check whether the user has loged out
if (!isset($_GET['Logout'])) {
  $_GET['Logout'] = 0;
}
//if the user has loged out, refresh the SESSION
if($_GET['Logout']){
$_SESSION = array();
}

//using SESSION to record the login user information
if (!isset($_SESSION['loginUserid'])) {
  $_SESSION['loginUserid'] = 0;
}
if (!isset($_SESSION['logedgivenname'])) {
  $_SESSION['logedgivenname'] = "";
}
if (!isset($_SESSION['logedsurname'])) {
  $_SESSION['logedsurname'] = "";
}
//if (!isset($_SESSION['previousurl'])) {
  //$_SESSION['previousurl'] = "index.php";
//}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="description" content="A website to build a social network through food">
      <title>Fooriend Homepage</title>
      <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
      <link rel="stylesheet" href="css/main.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
		  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
      <script type="text/javascript" src="scripts/function.js"></script>
      <script>
        //refer to function.js, it is for scroller
        QQ.scroll('scrollcontainer', 'scroller', 3, {trigger: 0});

    		$(function() {
    			$( "#datepickerfrom" ).datepicker({dateFormat: 'yy-mm-dd'});
    			$( "#datepickerto" ).datepicker({dateFormat: 'yy-mm-dd'});
    		});
      </script>
      <style type="text/css">
        input,select{
          border-radius: 3px;
        }
      </style>
    </head>
    
    <body>
    <div id="outercontainer">
    	<div id="header">
    		<h1><a id="logo" href="index.php"><img src="img/logo.png" alt="Fooriend" /></a></h1>
            <ul>
            <?php   
                //if the user loged in, then show "post an invitation" and "my profile"          
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
                 //else, show "register" and "login"
                 else{
                    echo "<li id=\"register\"><a href=\"register.php\">Register</a></li>";
                    echo "<li id=\"login\"><a href=\"login.php\">Login</a></li>";
                 }
            ?>
            </ul>
    	</div>
    	<div id="introduction">
            <!--the pics scroller-->
            <div id="scrollcontainer">
                <table id="scroller" >
                <tr>
                <td><img src="img/cooktogether.png" /></td>
                <td><img src="img/sharefood.png" /></td>
                <td><img src="img/restaurantcompanion.png" /></td>
                </tr>
                </table>
            <ul id="page"></ul>
        </div>
    	</div>
    	<div id="search">
    		<form name="search_form_index" method="post" action="search.php">
    			<div>
    				<p>category</p>
    				<select name="category">
    					<option value="1">Cook Together</option>
    					<option value="2">Share Food</option>
    					<option value="3">Restaurant Companion</option>
                        <option value="4">All</option>
    				</select>
    			</div>
    			<div>
    				<P>where</P>
    				<input type="text" name="address" placeholder="street,city,zipcode" />
    			</div>
    			<div>
    				<p>when</p>
    				<input id="datepickerfrom" type="text" name="datepickerfrom" value="" />
    				to
    				<input id="datepickerto" type="text" name="datepickerto" value="" />
    			</div>
    			<div><input id="searchbutton" name="Submit" type="submit" value="Search" /></div>
                <input type="hidden" name="search_submit_check" value="1"/>	
    		</form>
    	</div>
     	<div id="innercontainer">
     		<div id="cook">
     		<h2>Cook Together</h2>
            <a class="more" href="browse.php?invitation_category_id=1">more>></a>
                <?php
                indexShowThree(1);//refer to functions.php
                ?>
     		</div>
     		<div id="share">
     		<h2>Share Food</h2>
            <a class="more" href="browse.php?invitation_category_id=2">more>></a>
     			<?php
                indexShowThree(2);
                ?>
     		</div>
     		<div id="restaurant">
     		<h2>Restaurant Companion</h2>
            <a class="more" href="browse.php?invitation_category_id=3">more>></a>
     			<?php
                indexShowThree(3);
                ?>
     		</div>
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
