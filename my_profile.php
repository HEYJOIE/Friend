<!--Page for my profile-->
<?php 
include 'functions.php';
session_start();

$user=$_SESSION['loginUserid'];
if(isset($_POST['edit_submit_check']))
{

    if($_POST['edit_submit_check'])
    {
        $newgivenname = $_POST['givenname'];
        $newsurname = $_POST['surname'];
        $newaddress = $_POST['address'];
        $newcity = $_POST['city'];
        $newzip = $_POST['zip'];
        $newcountry = $_POST['country'];
        $newtel = $_POST['tel'];

        $mysqli = getConnection();
        $stmt =  $mysqli->stmt_init();
        //after edition, update the related user table in database
        if($stmt->prepare("UPDATE user SET givenname=?, surname=? WHERE user_id = ?"))
        {
            $stmt->bind_param("ssi",$newgivenname,$newsurname, $user);
            $stmt->execute();
            $_SESSION['logedgivenname']=$newgivenname;
            $_SESSION['logedsurname']=$newsurname;
            $stmt->close();
        }

        $stmt1 =  $mysqli->stmt_init();
        if($stmt1->prepare("SELECT user_id FROM userdetail WHERE user_id = ?"))
        {
            $stmt1->bind_param("i",$user);
            $stmt1->execute();           
            $stmt1->bind_result($userid);
            $stmt1->store_result();
            if($stmt1->num_rows)
            {
                $stmt2=$mysqli->stmt_init();
                if($stmt2->prepare("UPDATE userdetail SET addressline =?, city=?, country=?, zip=?, telephone=? WHERE user_id = ?"))
                {
                    $stmt2->bind_param("sssssi",$newaddress, $newcity, $newcountry, $newzip, $newtel, $user);
                    $stmt2->execute();
                    $stmt2->close();
                }
            }
            else
            {   
                $stmt3=$mysqli->stmt_init();
                if($stmt3->prepare("INSERT INTO userdetail VALUES(?,?,?,?,?,?)"))
                {
                    $stmt3->bind_param("isssss",$user, $newaddress, $newcity, $newzip, $newcountry, $newtel);
                    $stmt3->execute();
                    $stmt3->close();
                }
            }
        }
        $stmt1->close();
        $mysqli->close();
    }
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="A website to build a social network through food">
        <title>My Fooriend Profile</title>
        <link rel="stylesheet" href="css/main.css">      
  		<script>
        //change the input from readonly status to editable status when clicking the "edit" button
        function editInfo() {
            document.getElementById("editsubmit").remove();
            var submitBtn=document.createElement("input");
            submitBtn.setAttribute("type","submit");
            submitBtn.setAttribute("name","editsubmit");
            submitBtn.setAttribute("value","save");
            submitBtn.setAttribute("id","savesubmit");
            document.getElementById("profileform").appendChild(submitBtn);

            var enableEle = document.getElementsByTagName("input");
            //alert(enableEle.length);
            for(var i=0; i<enableEle.length; i++)
            {
                if(enableEle[i].id!="stableusername")
                {
                enableEle[i].removeAttribute("readonly");
                enableEle[i].setAttribute("class","enableedit");
                }
            }
        }

        </script>
        <style type="text/css">
            #header{
                border-bottom:2px solid #ff3;
            }
            #innercontainer div{
                margin:15px auto;
                width:300px;            
            }
            label{
                display: block;
                float: left;
                width:100px;
                color: #fff;
            }
            input{
                font-family: sans-serif, Arial;
                font-size: 16px;
                height: 25px;
                width: 200px;
                color:#fff;
            }
            input.readonly{
                background-color: transparent;
                border:none;    
            }
            input.enableedit{
                background-color: transparent;
                border:none;
                border-bottom: 1.5px solid #fff;
                outline: none;

            }
            #editsubmit, #savesubmit{
                width:100px;
                height:30px;
                margin-left:450px;
                background-color: #fff;
                border:none;
                color:#000;
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
        <h2>My Profile</h2>
        <form id="profileform" name="profileform" method="post" action="my_profile.php">
        <div>
        <label>Username:</label>
        <?php
        $user = $_SESSION['loginUserid'];
        $mysqli = getConnection();
        $stmt =  $mysqli->stmt_init();
        if($stmt->prepare("SELECT user.username, user.givenname, user.surname, userdetail.addressline, userdetail.city, userdetail.zip, userdetail.country, userdetail.telephone FROM user LEFT JOIN userdetail ON user.user_id = userdetail.user_id WHERE user.user_id = ?"))
        {
            $stmt->bind_param("i",$user);
            $stmt->execute();
            $stmt->bind_result($username, $givenname, $surname, $addressline, $city, $zip, $country, $telephone);
            $stmt->store_result();
            if($stmt->num_rows){
              $stmt->fetch();  
              echo "<input id=\"stableusername\" class=\"readonly\" type=\"text\" name=\"username\" readonly=\"true\" value=\"".$username."\"/>";
              echo "</div>";

              echo "<div>";
              echo "<label>Givenname:</label>";
              echo "<input class=\"readonly\" type=\"text\" name=\"givenname\" readonly=\"true\" value=\"".ucfirst($givenname)."\"/>";
              echo "</div>";
              
              echo "<div>";
              echo "<label>Surname:</label>";
              echo "<input class=\"readonly\" type=\"text\" name=\"surname\" readonly=\"true\" value=\"".ucfirst($surname)."\"/>";
              echo "</div>";

              echo "<div>";
              echo "<label>Address:</label>";
              echo "<input class=\"readonly\" type=\"text\" name=\"address\" readonly=\"true\" value=\"".ucfirst($addressline)."\"/>";
              echo "</div>";

              echo "<div>";
              echo "<label>City:</label>";
              echo "<input class=\"readonly\" type=\"text\" name=\"city\" readonly=\"true\" value=\"".ucfirst($city)."\"/>";
              echo "</div>";

              echo "<div>";
              echo "<label>Zipcode:</label>";
              echo "<input class=\"readonly\" type=\"text\" name=\"zip\" readonly=\"true\" value=\"".ucfirst($zip)."\"/>";
              echo "</div>";

              echo "<div>";
              echo "<label>Country:</label>";
              echo "<input class=\"readonly\" type=\"text\" name=\"country\" readonly=\"true\" value=\"".ucfirst($country)."\"/>";
              echo "</div>";

              echo "<div>";
              echo "<label>Tel:</label>";
              echo "<input class=\"readonly\" type=\"text\" name=\"tel\" readonly=\"true\" value=\"".$telephone."\"/>";
              echo "</div>";
            }        
        }
        ?>
        <input id="editsubmit" type="button" value="Edit" onclick="editInfo()" />
        <input type="hidden" name="edit_submit_check" value="1" />
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