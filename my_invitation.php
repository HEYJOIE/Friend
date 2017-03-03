<!--Page for manage my invitatons-->
<?php 
include 'functions.php';
session_start();
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="A website to build a social network through food">
        <title>My Fooriend Invitations</title>
        <link rel="stylesheet" href="css/main.css">

        <style type="text/css">
            #header{
                border-bottom:2px solid #ff3;
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
        <div id="postinvitation">
        <h2>My Post Invitations</h2>
            <?php
            $user = $_SESSION['loginUserid'];

            $mysqli = getConnection();
            $stmt =  $mysqli->stmt_init();
            //grab information for post invitations
            if($stmt->prepare("SELECT invitation_id, pic_url, title, invitation_date, city, post_date, is_available FROM invitation_list WHERE post_user_id = ? ORDER BY invitation_category_id ASC"))
            {
                $stmt->bind_param("i",$user);
                $stmt->execute();           
                $stmt->bind_result($invitationid, $picurl, $title, $invitationdate, $city, $postdate, $isavailable);
                $stmt->store_result();
                if($stmt->num_rows){
                    while($stmt->fetch())
                    {
                        echo "<div class=\"browse\">";
                        echo "<h3>".ucfirst($title)."</h3>";
                        echo "<a href=\"invitation_detail.php?invitation_id=".$invitationid."\">";
                        echo "<img src=\"".$picurl."\"/>";
                        echo "</a>";
                        echo "<p>".ucfirst($city)."&nbsp&nbsp&nbsp".$invitationdate;
                        if($isavailable == 0)
                        {
                            echo "<span class=\"full\">(FULL!)</span>";
                        }
                        echo "</div>";
                    }
                }
                else
                {
                    echo "You have no post invitations.";
                }
                $stmt->close();
                //$_SESSION['previousurl'] = "browse.php?invitation_category_id=".$invitation_category_id_url;
            }

        ?>
        <div class="clear">
        </div>
        </div>

        <div id="joininvitation">
        <h2>My Joined Invitations</h2>
        <?php
            //grab information for joined invitations
            $stmt2 =  $mysqli->stmt_init();
            if($stmt2->prepare("SELECT invitation_list.invitation_id, invitation_list.pic_url, invitation_list.title, invitation_list.invitation_date, invitation_list.city, invitation_list.post_date, invitation_list.is_available FROM join_list LEFT JOIN invitation_list ON invitation_list.invitation_id = join_list.invitation_id WHERE join_user_id = ? ORDER BY invitation_list.invitation_category_id ASC"))
            {
                $stmt2->bind_param("i",$user);
                $stmt2->execute();           
                $stmt2->bind_result($invitationid, $picurl, $title, $invitationdate, $city, $postdate, $isavailable);
                $stmt2->store_result();
                if($stmt2->num_rows){
                    while($stmt2->fetch())
                    {
                        echo "<div class=\"browse\">";
                        echo "<h3>".ucfirst($title)."</h3>";
                        echo "<a href=\"invitation_detail.php?invitation_id=".$invitationid."\">";
                        echo "<img src=\"".$picurl."\"/>";
                        echo "</a>";
                        echo "<p>".ucfirst($city)."&nbsp&nbsp&nbsp".$invitationdate;
                        if($isavailable == 0)
                        {
                            echo "<span class=\"full\">(FULL!)</span>";
                        }
                        echo "</div>";
                    }
                }
                else
                {
                    echo "You have no joined invitations.";
                }
                $stmt2->close();
                //$_SESSION['previousurl'] = "browse.php?invitation_category_id=".$invitation_category_id_url;
            }
            $mysqli->close();
        ?>
        <div class="clear">
        </div>
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