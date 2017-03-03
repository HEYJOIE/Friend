<!--Page for invitation post-->
<?php 
include 'functions.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Fooriend Invitation Post">
    <title>Fooriend Invitation Post</title>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link type="text/css" href="css/main.css" rel="stylesheet">
    <!--<script type="text/javascript" src="scripts/function.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script>
		$(function() {
		$( "#invidate" ).datepicker({dateFormat: 'yy-mm-dd'});
		});
		//change the form content according to the invitation category
		function changeContent()
		{
			var invicate = document.getElementById("invicategory").value;
			var dishEle=document.getElementById("dish");
			var dishdesEle=document.getElementById("dishdescrip");
			if(invicate == 3)
			{
				while (dishEle.firstChild) {
					dishEle.removeChild(dishEle.firstChild);
				}
				while (dishdesEle.firstChild) {
					dishdesEle.removeChild(dishdesEle.firstChild);
				}
			}
			else
			{
				if(!dishEle.firstChild){

					var label1=document.createElement("label");
					var label2=document.createElement("label");
					
					var nodetext1=document.createTextNode("Dish Name:");
					var nodetext2=document.createTextNode("Dish Description:");
					label1.appendChild(nodetext1);
					label2.appendChild(nodetext2);

					var inputdish=document.createElement("input");
					//var inputdishdescrip=document.createElement("input");
					var inputdishdescrip=document.createElement("textarea");

					inputdish.setAttribute('name','invidish');
					inputdish.setAttribute('type','text');
					inputdishdescrip.setAttribute('name','invidishdescrip');

					dishEle.appendChild(label1);
					dishEle.appendChild(inputdish);
					
					dishdesEle.appendChild(label2);
					dishdesEle.appendChild(inputdishdescrip);
				}
			}
		}

    </script>
    <style type="text/css">
    	#header{
    		border-bottom:2px solid #ff3;
    	}
    	form{
    		width:450px;
    		margin:0 auto;
    		color: #fff;
    	}
    	input,select,textarea{
    		outline: none;
    		border:none;
    		background-color: transparent;
    		border-bottom: 1.5px solid #fff;
    		width:200px;
    		color:#fff;
    		font-family: sans-serif, arial;
    		font-size:16px;
    	}
    	select{
    		background-color: #58774E;
    	}
    	form div{
    		margin:15px;
    	}
    	form div label{
    		display: block;
    		width:200px;
    		float: left;
    		text-align: right;
    		margin-right: 10px;
    	}
    	#submit{
    		background: #fff;
    		width: 100px;
    		height: 30px;
			margin:20px 200px;
			color:#000;
    	}
    	.required{
    		color:#ff3;
    	}
    	#instruction{
    		float: right;
    		font-size: 10px;
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
      	<h2>Invitation Post</h2>
      	<form id="invitation_post_form" name="invitation_post_form" method="post" action="invitation_insert.php" enctype="multipart/form-data">
      		<div>
	      	<label><span class="required">*</span>Category:</label>
	      	<select id="invicategory" name="invicategory" onchange="changeContent()">
				<option value="1">Cook Together</option>
				<option value="2">Share Food</option>
				<option value="3">Restaurant Companion</option>
	    	</select>
	    	</div>

	    	<div>
	    	<label><span class="required">*</span>Title/Restaurant Name:</label>
	    	<input type="text" name="invititle" />
	    	</div>
	    	<div>
	    	<label><span class="required">*</span>Date:</label>
	    	<input id="invidate" type="text" name="invidate" />
	    	</div>
	    	<div>
	    	<label><span class="required">*</span>Time:</label>
	    	<input type="time" name="invitime" />
	    	</div>
	    	<div>
	    	<label><span class="required">*</span>Addressline:</label>
	    	<input type="text" name="inviaddress" />
	    	</div>
	    	<div>
	    	<label><span class="required">*</span>City:</label>
	    	<input type="text" name="invicity" />
	    	</div>
	    	<div>
	    	<label>Zipcode:</label>
	    	<input type="text" name="invizip" />
	    	</div>
	    	<div>
	    	<label><span class="required">*</span>Country:</label>
	    	<input type="text" name="invicountry" />
	    	</div>
	    	<div>
	    	<label><span class="required">*</span>Number of guests:</label>
	    	<input type="number" name="inviguestsnum" />
	    	</div>
	    	<div id="dish">
	    	<label class="mayremove"><span class="required">*</span>Dish Name:</label>
	    	<input class="mayremove" type="text" name="invidish" />
	    	</div>
	    	<div id="dishdescrip">
	    	<label class="mayremove">Dish Description:</label>
	    	<textarea class="mayremove" name="invidishdescrip"></textarea>
	    	</div>
	    	<div>
	    	<label><span class="required">*</span>Cuisine Category:</label>
	    	<select name="invicuisinecate">

	    	<?php
	    		$mysqli = getConnection();
    			$stmt =  $mysqli->stmt_init();
    
    			if ($stmt->prepare("SELECT dish_category_id, dish_category_name FROM dish_category"))
    			{
    				$stmt->execute();
    				$stmt->bind_result($cuisineid, $cuisinename);
    				$stmt->store_result();
    				while($stmt->fetch())
    				{
    					echo "<option value=".$cuisineid.">".$cuisinename."</option>";
    				}
    				$stmt->close();
    			}
    			$mysqli->close();
	    	?>
	    	</select>
	    	</div>
			<div>
	    	<label>Image Upload:</label>
	    	<input type="file" name="invipic" />
	    	<p id="instruction"><span class="required">*</span>for required fields</p> 
	    	</div>
	   		
	    	<input id="submit" type="submit" name="invipostsubmit" value="Post" />
	    	<input type="hidden" name="invipostcheck" value="1" />
      	</form>
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