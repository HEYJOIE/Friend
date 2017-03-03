<!--Page for login-->
<?php 
include 'functions.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="description" content="Fooriend Login">
    <title>Fooriend Login</title>
    <link rel="stylesheet" href="css/main.css">
    <style type="text/css">
	form{
		width:25%;
		margin:0 auto;
	}
	form p{
		color:#fff;
	}
	input{
		width:100%;
		height:25px;
		border-radius: 3px;
	}
	#header{
		border-bottom: 2px solid #ff3;
	}

	#loginbtn{
        width:50%;
        margin-left: 25%;
        margin-top: 20px;
        margin-bottom:60%;
	}
	.wronginfo{
		color:#a5240a;
	}
    </style>
</head>
<body>
<div id="outercontainer">
	<div id="header">
    <h1><a id="logo" href="index.php"><img src="img/logo.png" alt="Fooriend" /></a></h1>
    </div>
    <div id="innercontainer">
    <h2>Fooriend Login</h2>
	<form id="login_window" name="login_window" method="post" action="login.php">
	<p>Username:</p>
	<input type="text" name="username" />
	<p>Password:</p>
	<input type="Password" name="password" />
	<input type="hidden" name="login_submit_check" value="1"/> 
	<p><input id="loginbtn" type="submit" name="submit" value="Login" /></p>
		<?php
	    if(isset($_POST["login_submit_check"]))
	    {
	    	//$loged_userid = 0;
	        $username_input = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
	        $password_input = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
	        $mysqli = getConnection();
	        //check whether the username is valid or the password is correct
	        $stmt =  $mysqli->prepare("SELECT user_id, givenname, surname FROM user WHERE username = ? AND password = ?");
	        $stmt->bind_param("ss", $username_input, $password_input);	        
	        $stmt->execute();	        
	        $stmt->bind_result($loged_userid,$loged_givenname,$loged_surname);
	        $stmt->store_result();
	        $stmt->fetch();

	        if($stmt->num_rows){
	        	//echo "number of rows is".$stmt->num_rows;
	        	//echo "<p>Id of the user is".$loged_userid."</p>";
	        	$_SESSION["loginUserid"] = $loged_userid;
	        	$_SESSION["logedgivenname"] = $loged_givenname;
	        	$_SESSION["logedsurname"] = $loged_surname;
	        	//echo $_SESSION["loginUserid"];
	        	header('Location:index.php');
	        	//header('Location:'.$_SERVER['HTTP_REFERER']);
	        	//header('Location:'.$_SESSION['previousurl']);
	        }
	        else
	        {
	        	$stmt2 =  $mysqli->prepare("SELECT username FROM user WHERE username = ?");
	        	$stmt2->bind_param("s", $username_input);
	        	$stmt2->execute();
	        	$stmt2->bind_result($username);
	        	$stmt2->store_result();
	        	if(!$stmt2->num_rows){
	        		echo "<p class=\"wronginfo\"> Invalid username. </p>";
		    		$_SESSION["loginUserid"] = 0;
	        	}
	        	else{
	        		echo "<p class=\"wronginfo\"> Wrong password. </p>";
		            $_SESSION["loginUserid"] = 0;
	        	}
	        	$stmt2->close();
	        }
	    
	        $stmt->close();	        
	        $mysqli->close();
        }
	    ?>
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