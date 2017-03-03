<!--Page for search-->
<?php 
include 'functions.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Fooriend Invitation Search">
	<title>Fooriend Invitation Search</title>
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
		span.clear{
			clear:both;
			display: block;
		}
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

  	    <div id="search">
  	    <div class="clear"></div>
			<form name="search_form_index" method="post" action="search.php">
			<div>
				<p>category</p>
				<select name="category">
				<?php
				if(isset($_POST["search_submit_check"]))
				{
					//set the default selected category
					if($_POST['category'] == 1)
					{
						echo "<option value=\"1\" selected=\"selected\">Cook Together</option>";
						echo "<option value=\"2\" >Share Food</option>";
						echo "<option value=\"3\" >Restaurant Companion</option>";
						echo "<option value=\"4\" >All</option>";
					}
					else if($_POST['category'] == 2)
					{
						echo "<option value=\"1\" >Cook Together</option>";
						echo "<option value=\"2\" selected=\"selected\">Share Food</option>";
						echo "<option value=\"3\" >Restaurant Companion</option>";
						echo "<option value=\"4\" >All</option>";
					}
					else if($_POST['category'] == 3)
					{
						echo "<option value=\"1\" >Cook Together</option>";
						echo "<option value=\"2\" >Share Food</option>";
						echo "<option value=\"3\" selected=\"selected\">Restaurant Companion</option>";
						echo "<option value=\"4\" >All</option>";
					}
					else
					{
						echo "<option value=\"1\" >Cook Together</option>";
						echo "<option value=\"2\" >Share Food</option>";
						echo "<option value=\"3\" >Restaurant Companion</option>";
						echo "<option value=\"4\" selected=\"selected\">All</option>";
					}
				}
				?>
				</select>
			</div>
			<div>
				<P>where</P>
				<?php
				echo "<input type=\"text\" name=\"address\" value=\"".$_POST['address']."\" placeholder=\"street,city,zipcode\"/>";
				?>
			</div>
			<div>
				<p>when</p>
				<?php
				echo "<input id=\"datepickerfrom\" type=\"text\" name=\"datepickerfrom\" value=\"".$_POST['datepickerfrom']."\" />";
				?>		
				to
				<?php
				echo "<input id=\"datepickerto\" type=\"text\" name=\"datepickerto\" value=\"".$_POST['datepickerto']."\" />";
				?>
			</div>
			<div><input id="searchbutton" name="Submit" type="submit" value="Search" /></div>			
			<div><input type="hidden" name="search_submit_check" value="1"/></div>	
			<span class="clear"></span>	
			</form>
		</div>

      	<div id="innercontainer">
      	<?php
  		$searchcategory=$_POST['category'];
  		$searchplace=$_POST['address'];
  		$searchtimefrom=$_POST['datepickerfrom'];
  		$searchtimeto=$_POST['datepickerto'];

  		if($searchtimefrom=="")
  		{
  			$searchtimefrom = "1900-01-01";
  		}

  		if($searchtimeto=="")
  		{
  			$searchtimeto = "6000-12-31";
  		}

		$mysqli = getConnection();
		$stmt =  $mysqli->stmt_init();

		if($searchcategory!=4)
		{
			if($stmt->prepare("SELECT invitation_id, pic_url, title, invitation_date, city, post_date, is_available FROM invitation_list WHERE invitation_category_id = ? AND (addressline LIKE CONCAT('%',?,'%') OR city LIKE CONCAT('%',?,'%') OR zip LIKE CONCAT('%',?,'%')) AND invitation_date >= ? AND invitation_date <= ? ORDER BY post_date DESC"))
		    {
		        $stmt->bind_param("isssss", $searchcategory, $searchplace, $searchplace, $searchplace, $searchtimefrom, $searchtimeto);
		        $stmt->execute();           
		        $stmt->bind_result($invitationid, $picurl, $title, $invitationdate, $city, $postdate, $isavailable);
		        $stmt->store_result();
		        if($stmt->num_rows)
		        {
		        	while($stmt->fetch())
		        	{
		        		echo "<div class=\"browse\">";
		                echo "<h3>".$title."</h3>";
		                echo "<a href=\"invitation_detail.php?invitation_id=".$invitationid."\"target=\"_blank\">";
		                echo "<img src=\"".$picurl."\"/>";
		                echo "</a>";
		                echo "<p>".$city."&nbsp&nbsp&nbsp".$invitationdate;
		                if($isavailable == 0)
		                {
		                	echo "<span class=\"full\">(FULL!)</span>";
		                }
		                echo "</div>";
		        	}
		        }
		        else
		        {
		        	echo "<p>Sorry, no result found.</p>";
		        }
		        $stmt->close();
    		}
		}

		else
		{
			if($stmt->prepare("SELECT invitation_id, pic_url, title, invitation_date, city, post_date, is_available FROM invitation_list WHERE (addressline LIKE CONCAT('%',?,'%') OR city LIKE CONCAT('%',?,'%') OR zip LIKE CONCAT('%',?,'%')) AND invitation_date >= ? AND invitation_date <= ? ORDER BY post_date DESC"))
		    {
		        $stmt->bind_param("sssss", $searchplace, $searchplace, $searchplace, $searchtimefrom, $searchtimeto);
		        $stmt->execute();           
		        $stmt->bind_result($invitationid, $picurl, $title, $invitationdate, $city, $postdate, $isavailable);
		        $stmt->store_result();
		        if($stmt->num_rows){
		        	while($stmt->fetch())
		        	{
		        		echo "<div class=\"browse\">";
		                echo "<h3>".$title."</h3>";
		                echo "<a href=\"invitation_detail.php?invitation_id=".$invitationid."\"target=\"_blank\">";
		                echo "<img src=\"".$picurl."\"/>";
		                echo "</a>";
		                echo "<p>".$city."&nbsp&nbsp&nbsp".$invitationdate;
		                if($isavailable == 0)
		                {
		                	echo "<span class=\"full\">(FULL!)</span>";
		                }
		                echo "</div>";
		        	}
		        }
		        else
		        {
		        	echo "<p>Sorry, no result found.</p>";
		        }
		        $stmt->close();
    		}

		}
		//$_SESSION['previousurl'] = "search.php";
		$mysqli->close();
      	?>
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