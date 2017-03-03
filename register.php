<!--Page for register-->
<?php 
include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="description" content="Fooriend Register">

    <title>Fooriend Register</title>
    <link rel="stylesheet" href="css/main.css">
    <script type="text/javascript" src="scripts/function.js"></script>
    <!--
    <script>
    	function identicalUsername(){
            alert ("This username has already existed, please input again."); 
        }
        function identicalPassword(){
        	alert ("The passwords you input should be identical.");
        }
    </script>
    -->
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
    	#registerbtn{
    		width:50%;
    		margin-left: 25%;
    		margin-top: 20px;
    	}
    	#instruction{
    		float: right;
    		font-size: 10px;
    	}
    	.wronginfo{
    		color:#a5240a;
    		font-weight: bold;
    	}
    	.required{
    		color:#ff3;
    	}
    </style>
</head>
<body>
<div id="outercontainer">
	<div id="header">
    <h1><a id="logo" href="index.php"><img src="img/logo.png" alt="Fooriend" /></a></h1>
    </div>
    <div id="innercontainer">
	<h2>Fooriend Registration</h2>
	<form id="register_window" name="register_window" method="post" action="register.php">
	<p><span class="required">*</span>Surname:</p>
	<input type="text" name="surname" />
	<p><span class="required">*</span>Givenname:</p>
	<input type="text" name="givenname" />
	<p><span class="required">*</span>Username:</p>
	<input type="text" name="username" placeholder="please input your email to register" />
	<p><span class="required">*</span>Password:</p>
	<input type="Password" name="password" />
	<p><span class="required">*</span>Reenter password:</p>
	<input type="Password" name="password_reenter" />
	<input type="hidden" name="register_submit_check" value="1"/>
	<p id="instruction"><span class="required">*</span>for required fields</p> 
	<p><input id="registerbtn" type="submit" name="submit" value="Register" /></p>

	<?php
	    if(isset($_POST["register_submit_check"]))
	    {
	        $surname_input = $_POST['surname'];
	        $givenname_input = $_POST['givenname'];
	        $username_input = $_POST['username'];
	        $password_input = $_POST['password'];
	        $password_reenter = $_POST['password_reenter'];
	     	if($surname_input!="" && $givenname_input!="" && $username_input!="" && $password_input!="" && $password_reenter!="")
	     	{
		        $mysqli = getConnection();
		        $stmt =  $mysqli->prepare("SELECT username FROM user WHERE username = ?");
		        $stmt->bind_param("s", $username_input);
		        $stmt->execute();
		        $stmt->bind_result($username);
		        $stmt->store_result();
		        if($stmt->num_rows)
		        {
		        	echo "<p class=\"wronginfo\"> This username has already existed, please input again. </p>";
		        }
		        elseif($password_input != $password_reenter){
		        	echo "<p class=\"wronginfo\"> The passwords you input should be identical. </p>";
		        }
		        else{
		        	$stmt2=$mysqli->prepare("INSERT INTO user(surname,givenname,username,password)  VALUES (?,?,?,?)");
		            $stmt2->bind_param("ssss",$surname_input,$givenname_input,$username_input,$password_input);
		            $stmt2->execute();
		            $stmt2->close();
		            header('Location:index.php');
		        }
		        $stmt->close();
		        $mysqli->close();
	        }    
	        else
	        {
	        ?>
	        	<p class="wronginfo">You must fill all the required fields, please check.</p>
	        <?php      
	        }	       
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