<!--Page for browsing invitation lists in different category-->
<?php 
include 'functions.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Fooriend Invitation Browse">
    <title>Fooriend Invitation Browse</title>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<script>
	$(function() {
		$( "#datepickerfrom" ).datepicker({dateFormat: 'yy-mm-dd'});
		$( "#datepickerto" ).datepicker({dateFormat: 'yy-mm-dd'});
	});
    </script>
	<style type="text/css">
		#innercontainer{
			padding:20px;
		}
		input,select{
          border-radius: 3px;
        }

	</style>
</head>

<body>
	<div id="outercontainer">
	<!--header for logo and login info-->
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
      	<!--search window-->
  	    <div id="search">
  	    <div class="clear"></div>
			<form id="search_form_index" name="search_form_index" method="post" action="search.php">
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
      	<!--browse area-->
      	<?php
      		$invitation_category_id_url = 0;
		    //get the invitation id from the url
			$invitation_category_id_url = $_GET['invitation_category_id'];
			//check the number and show the corrsponding category items
			if($invitation_category_id_url == 1)
			{
				echo "<h2>Cook Together</h2>";
			}
			else if($invitation_category_id_url == 2)
			{
				echo "<h2>Share Food</h2>";
			}
			else if($invitation_category_id_url == 3)
			{
				echo "<h2>Restaurant Companion</h2>";
			}
			else
			{
				echo "<h2>Sorry, there is no such category.</h2>";
			}

			//grab the invitation data from table invitation_list in database
			$mysqli = getConnection();
    		$stmt =  $mysqli->stmt_init();
    		if($stmt->prepare("SELECT invitation_id, pic_url, title, invitation_date, city, post_date, is_available FROM invitation_list WHERE invitation_category_id = ? ORDER BY post_date DESC"))
		    {
		        $stmt->bind_param("i",$invitation_category_id_url);
		        $stmt->execute();           
		        $stmt->bind_result($invitationid, $picurl, $title, $invitationdate, $city, $postdate, $isavailable);
		        $stmt->store_result();
		        if($stmt->num_rows){
		        	while($stmt->fetch())
		        	{
		        		echo "<div class=\"browse\">";
		                echo "<h3>".ucfirst($title)."</h3>";
		                echo "<a href=\"invitation_detail.php?invitation_id=".$invitationid."\"target=\"_blank\">";
		                echo "<img src=\"".$picurl."\"/>";
		                echo "</a>";
		                echo "<p>".ucfirst($city)."&nbsp&nbsp&nbsp".$invitationdate;
		                //check whether the invitation is available, if not, show the user it is full
		                if($isavailable == 0)
		                {
		                	echo "<span class=\"full\">(FULL!)</span>";
		                }
		                echo "</div>";
		        	}
		        }
		        $stmt->close();
		        //$_SESSION['previousurl'] = "browse.php?invitation_category_id=".$invitation_category_id_url;
		        $mysqli->close();
    		}

      	?>
      	<!--div for clear the float style-->
      	<div class="clear">
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