<!--Page for joining a list-->
<?php 
include 'functions.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  	<head>
	    <meta charset="utf-8">
	    <meta name="description" content="Fooriend Join Page">
	    <title>Fooriend Invitation Join</title>
	    <link rel="stylesheet" href="css/main.css">
	    <style type="text/css">
	    form{
    		width:25%;
    		margin:0 auto;
    	}
    	form p{
    		color:#fff;
    	}
    	input,textarea,select{
    		width:100%;
    		height:25px;
    		border-radius: 3px;
    	}
    	#joinwindowforrestaurant p{
    		text-align: center;
    	}
	    #header{
	    	border-bottom: 2px solid #ff3;
	    }
		.joinbtn{
    		width:50%;
    		margin-left: 25%;
    		margin-top: 20px;
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
		  	<div id="innercontainer">
		  	<h2>Join Invitation Form</h2>
		  	<?php
		  	$invitation_id_url = 0;
		    
		    $invitation_id_url = $_GET['invitation_id'];
		    $mysqli = getConnection();
		    $stmt =  $mysqli->stmt_init();
		    $stmt2 = $mysqli->stmt_init();
		    if ($stmt->prepare("SELECT invitation_category_id FROM invitation_list WHERE invitation_id = ?"))
		    {
		    	$stmt->bind_param("i", $invitation_id_url);
		    	$stmt->execute();
		    	$stmt->bind_result($invicateid);
		    	$stmt->store_result();
		    	$stmt->fetch();
		    	//if this is a cook together invitation, you need to fill the dish form
		    	if($invicateid==1)
		    	{
		    		echo "<form name=\"joinwindowforcook\" method=\"post\" action=\"join.php?invitation_id=".$invitation_id_url."\">";
		    		echo "<p>Dish Name:</p>";
		    		echo "<input type=\"text\" name=\"dishname\" />";
		    		echo "<p>Dish Description:</p>";
		    		echo "<textarea name=\"dishdescription\"></textarea>";
		    		echo "<p>Dish Category:</p>";
		    		if($stmt2->prepare("SELECT dish_category_id, dish_category_name FROM dish_category"))
		    		{
		    			$stmt2->execute();
		    			$stmt2->bind_result($dishcateid, $dishcatename);
		    			$stmt2->store_result();
		    			echo "<select name=\"dishcate\">";
		    			while($stmt2->fetch())
		    			{
    					echo "<option value=\"".$dishcateid."\">".$dishcatename."</option>";
		    			}
		    			echo "</select>";
		    		}
		    		echo "<p>";
		    		echo "<input class=\"joinbtn\" type=\"submit\" name=\"joinoksubmit\" value=\"OK\" />";
		    		echo "</p>";
		    		echo "<input type=\"hidden\" name=\"joinok_submit_check\" value=\"1\"/>"; 
		    		echo "</form>";
		    		$stmt2->close();
		    	}
		    	//if these are other two kinds of invitation, you need to confirm your join
		    	else
		    	{
		    		echo "<form id=\"joinwindowforrestaurant\" name=\"joinwindowforrestaurant\" method=\"post\" action=\"join.php?invitation_id=".$invitation_id_url."\">";
		    		echo "<p>Please confirm your join:</p>";
		    		//echo "<p>";
		    		echo "<input class=\"joinbtn\" type=\"submit\" name=\"joinconfirmforrest\" value=\"Join Confirm\" />";
		    		//echo "</p>";
		    		echo "<input type=\"hidden\" name=\"joinconfirm_submit_check\" value=\"1\"/>"; 
		    		echo "</form>"; 
		    	}

		    	$stmt->close();
		    }

		    //if you confirm your join, update the related tables in database
		    if(isset($_POST["joinok_submit_check"])||isset($_POST["joinconfirm_submit_check"]))
		    {
		    	
		    	$stmt4 = $mysqli->stmt_init();
		    	$stmt5 = $mysqli->stmt_init();
		    	$stmt6 = $mysqli->stmt_init();
		    	if(isset($_POST["joinok_submit_check"]))
		    	{
		    		$stmt3 = $mysqli->stmt_init();
		    		//update the dish_list
			    	if ($stmt3->prepare("INSERT INTO dish_list (invitation_id, user_id, dish_name, dish_description, dish_category_id) VALUES (?,?,?,?,?)")) 
					{

					    $stmt3->bind_param("iissi", $invitation_id_url, $_SESSION['loginUserid'],$_POST['dishname'],$_POST['dishdescription'],$_POST['dishcate']);
					    $stmt3->execute();
						//$last_insert_id = $mysqli->insert_id;
					    $stmt3->close();
					}
				}
				//update the join_list
				if ($stmt4->prepare("INSERT INTO join_list (invitation_id, join_user_id) VALUES (?,?)")) 
				{

				    $stmt4->bind_param("ii", $invitation_id_url, $_SESSION['loginUserid']);
				    $stmt4->execute();
					//$last_insert_id = $mysqli->insert_id;
				    $stmt4->close();
				}
				//update the invitation_list
				if($stmt5->prepare("UPDATE invitation_list SET guests_remaining = guests_remaining-1 where invitation_id=?"))
				{
					$stmt5->bind_param("i", $invitation_id_url);
					$stmt5->execute();
					$stmt5->close();
				}

				if($stmt6->prepare("SELECT guests_remaining FROM invitation_list WHERE invitation_id= ?"))
				{
					$stmt6->bind_param("i", $invitation_id_url);
					$stmt6->execute();
					$stmt6->bind_result($guestsremain);
					$stmt6->store_result();
					$stmt6->fetch();
					if($guestsremain==0)
					{
						$stmt7 = $mysqli->stmt_init();
						if($stmt7->prepare("UPDATE invitation_list SET is_available = 0 WHERE invitation_id= ?"))
						{
							$stmt7->bind_param("i", $invitation_id_url);
							$stmt7->execute();
							$stmt7->close();
						}
					}
					$stmt6->close();
				}
				//return to the invitation detail page
				header("Location: invitation_detail.php?invitation_id=".$invitation_id_url."");
		    }
		    $mysqli->close();
		  	?>
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