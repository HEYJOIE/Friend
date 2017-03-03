<?php 
include 'functions.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Fooriend Invitation Detail">
    <title>Fooriend Invitation Detail</title>
    <link rel="stylesheet" href="css/main.css">
    <style type="text/css">
      img.inviimg{
        width:300px;
        height:200px;
        display: block;
        float:left;
        margin:20px;
      }
      #header{
        border-bottom:2px solid #ff3;
      }
      #innercontainer{      
        color:white;
      }
      #detail{
        margin-left:350px;
        width:650px;
      }
      #detail form{
        float:right;
        margin-bottom:30px;
      }
      #detail form input{
        width:100px;
        height:40px;
      }
      ul{
        padding:0;
        list-style-type: none;
      }
      input,select{
          border-radius: 3px;
      }
    </style>
    <script type="text/javascript">
    //the function is for checking whether the user confirm delete
      function confirmDelete()
      {
      var deletebtn=document.getElementById("deletesubmitcheck");
      var delformEle=document.getElementById("deleteform");
      
      if(confirm("Really want to delete this invitation?"))
      {
        deletebtn.setAttribute("value",1);
        delformEle.setAttribute("onsubmit","return true");
      }
      else
      {
        delformEle.setAttribute("onsubmit","return false");
      }
    }
    //the function is for checking whether the user confirm cancel join
    function confirmCancelJoin()
      {
      var cancelbtn=document.getElementById("cancelsubmitcheck");
      var cancelformEle=document.getElementById("canceljoinform");
      
      if(confirm("Really want to cancel the join?"))
      {
        cancelbtn.setAttribute("value",1);
        cancelformEle.setAttribute("onsubmit","return true");
      }
      else
      {
        cancelformEle.setAttribute("onsubmit","return false");
      }
    }
    </script>
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
      
    <div id= "innercontainer">
    <h2>Invitation Details</h2>
    <?php
    $invitation_id_url = 0;
    // get the invitation id from the URL
    $invitation_id_url = $_GET['invitation_id'];
    $mysqli = getConnection();
    $stmt =  $mysqli->stmt_init();
    //grab the detailed information from the database
    if ($stmt->prepare("SELECT * FROM invitation_list WHERE invitation_id = ?")) 
    {
      $stmt->bind_param("i", $invitation_id_url);
      $stmt->execute();
      $stmt->bind_result($invid,$postuserid,$title,$invdate,$invtime,$address,$city,$country,$zip,$guestsnum,$invcateid,$postdate,$picurl,$guestsremaining,$isavailable);
      $stmt->store_result();
      if($stmt->num_rows)
      {
        $stmt->fetch();
        
        echo "<img class=\"inviimg\" src=\"".$picurl."\"/>";
        echo "<div id=\"detail\">";
        echo "<p id=\"invitation_title\">Title:".ucfirst($title)."</p>";
        $stmt2 =  $mysqli->stmt_init();
        if($stmt2->prepare("SELECT invitation_category_name from invitation_category where invitation_category_id = ?"))
        {
          $stmt2->bind_param("i",$invcateid);
          $stmt2->execute();
          $stmt2->bind_result($invcatename);
          $stmt2->store_result();
          if($stmt2->num_rows){
            $stmt2->fetch();
            echo "<p>Invitation Category:".$invcatename."</p>";
          }
          $stmt2->close();
        }

        $stmt3 =  $mysqli->stmt_init();
        if($stmt3->prepare("SELECT surname, givenname,username from user where user_id = ?")){
          $stmt3->bind_param("i",$postuserid);
          $stmt3->execute();
          $stmt3->bind_result($postsurname,$postgivenname,$postusername);
          $stmt3->store_result();
          if($stmt3->num_rows){
            $stmt3->fetch();
            echo "<p>Poster:".ucfirst($postgivenname)."&nbsp".ucfirst($postsurname)."(".$postusername.")</p>";
          }
          $stmt3->close();
        }
       
        echo "<p>Invitation Time:".$invdate."&nbsp".$invtime."</p>";
        echo "<p>Invitation Address:".ucfirst($address).",&nbsp".ucfirst($city).",&nbsp".ucfirst($country).",&nbsp".strtoupper($zip)."</p>";
        echo "<p>Gross Number of Guests:".$guestsnum."</p>";
        echo "<p>Available Number of Guests :".$guestsremaining."</p>";
        if($invcateid!=3)
        {
          echo "<p>Dishes:</p>";
          $stmt4 =  $mysqli->stmt_init();
          if($stmt4->prepare("SELECT user_id, dish_name, dish_description, dish_category_id from dish_list where invitation_id = ?"))
          {
            $stmt4->bind_param("i", $invitation_id_url);
            $stmt4->execute();
            $stmt4->bind_result($userid, $dishname, $dishdescrip, $dishcateid);
            $stmt4->store_result();
            if($stmt4->num_rows)
            {
              echo "<dl>";
              //echo $stmt4->num_rows;
              while($stmt4->fetch())
              {
                $stmt5 =  $mysqli->stmt_init();
                $stmt6 =  $mysqli->stmt_init();
                if($stmt5->prepare("SELECT surname, givenname, username from user where user_id = ?"))
                {
                  $stmt5->bind_param("i",$userid);
                  $stmt5->execute();
                  $stmt5->bind_result($surname,$givenname,$username);
                  $stmt5->store_result();
                  if($stmt5->num_rows)
                  {
                    $stmt5->fetch();
                    echo "<dt>".ucfirst($givenname)."&nbsp".ucfirst($surname);
                    //echo "<dt>".$userid;
                    if($userid == $postuserid)
                    {
                      echo "(Host,".$username.")";
                    }
                    else
                    {
                      echo "(Guest,".$username.")";
                    }
                    echo "</dt>";
                  }
                  $stmt5->close();
                }

                echo "<dd>".ucfirst($dishname)."(";

                if($stmt6->prepare("SELECT dish_category_name from dish_category where dish_category_id = ?"))
                {
                  $stmt6->bind_param("i",$dishcateid);
                  $stmt6->execute();
                  $stmt6->bind_result($dishcatename);
                  $stmt6->store_result();
                  if($stmt6->num_rows)
                  {
                    $stmt6->fetch();
                    echo "".$dishcatename.")";
                  }
                  $stmt6->close();
                }
                //echo "".$dishcateid.")";
                echo "<p>".ucfirst($dishdescrip)."</p></dd>";
                
              }
              echo "</dl>";
            }
            $stmt4->close();
          }
          if($invcateid==2)
          {
            echo "<ul>Joined Guests:";
            $stmt10 =  $mysqli->stmt_init();
            if($stmt10->prepare("SELECT user.givenname, user.surname, user.username from join_list left join user on join_list.join_user_id = user.user_id where join_list.invitation_id = ?"))
            {
              $stmt10->bind_param("i",$invitation_id_url);
              $stmt10->execute();
              $stmt10->bind_result($joinguestgivenname, $joinguestsurname, $joinguestusername);
              $stmt10->store_result();
              while($stmt10->fetch())
              {
                echo "<li>".ucfirst($joinguestgivenname)."&nbsp".ucfirst($joinguestsurname)."(".$joinguestusername.")</li>";
              }
              $stmt10->close();
            }
            echo "</ul>";
          }
        }
        else
        {
          echo "<p>Restaurant Cuisine Category:";
          $stmt7 =  $mysqli->stmt_init();
          if($stmt7->prepare("SELECT restaurant_category_id from restaurant_category where invitation_id = ?"))
          {
              $stmt7->bind_param("i",$invitation_id_url);
              $stmt7->execute();
              $stmt7->bind_result($rescateid);
              $stmt7->store_result();
              $stmt7->fetch();
              $stmt8 =  $mysqli->stmt_init();
              if($stmt8->prepare("SELECT dish_category_name from dish_category where dish_category_id = ?"))
              {
                $stmt8->bind_param("i",$rescateid);
                $stmt8->execute();
                $stmt8->bind_result($restcatename);
                $stmt8->store_result();

                if($stmt8->num_rows){
                  $stmt8->fetch();
                  echo "".$restcatename."</p>";
                }
                $stmt8->close();
              }
              $stmt7->close();
          }
          echo "<ul>Joined Guests:";
          $stmt9 =  $mysqli->stmt_init();
          if($stmt9->prepare("SELECT user.givenname, user.surname, user.username from join_list left join user on join_list.join_user_id = user.user_id where join_list.invitation_id = ?"))
          {
            $stmt9->bind_param("i",$invitation_id_url);
            $stmt9->execute();
            $stmt9->bind_result($joingivenname, $joinsurname, $joinusername);
            $stmt9->store_result();
            while($stmt9->fetch())
            {
              echo "<li>".ucfirst($joingivenname)."&nbsp".ucfirst($joinsurname)."(".$joinusername.")</li>";
            }
            $stmt9->close();
          }
          echo "</ul>";
        }

        echo "<p>Post Time:".$postdate."</p>";
        
        //if($isavailable == 1 && $_SESSION['loginUserid']!=0)
        if($_SESSION['loginUserid']!=0)
        {
          if ( $postuserid == $_SESSION['loginUserid'])
          {
            
            echo "<form id=\"deleteform\" method=\"post\" action=\"delete.php?invitation_id=".$invitation_id_url."\">";
            ?>
            <input id="deletesubmit" name="deletesubmit" type="submit" value="Delete" onclick="confirmDelete()" />
            <input id="deletesubmitcheck" name="deletesubmitcheck" type="hidden" value="0" />
            </form>
            <?php
          }
          else
          {
            $stmt11 =  $mysqli->stmt_init();
            if($stmt11->prepare("SELECT join_id from join_list where join_user_id = ? AND invitation_id = ?"))
            {
              $stmt11->bind_param("ii", $_SESSION['loginUserid'], $invitation_id_url);
              $stmt11->execute();
              $stmt11->bind_result($joinid);
              $stmt11->store_result();
              //$stmt11->fetch();
              if($stmt11->num_rows)
              {

                echo "<form id=\"canceljoinform\" method=\"post\" action=\"cancel_join.php?invitation_id=".$invitation_id_url."\">";
                ?>
                <input type="submit" name="canceljoinsubmit" value="Cancel Join" onclick="confirmCancelJoin()"/>
                <input id="cancelsubmitcheck" name="cancelsubmitcheck" type="hidden" value="0" />
                </form>
                <?php
              }
              else if($isavailable ==1)
              {
                echo "<form method=\"post\" action=\"join.php?invitation_id=".$invitation_id_url."\">";
                echo "<input type=\"submit\" name=\"joinsubmit\" value=\"Join\" />";
                echo "</form>";
              }
            }
            $stmt11->close();           
          }
        }
        echo "</div>";
      }
      else
      {
        echo "<p>Sorry,there is no such invitation.</p>";
      }
      $stmt->close();
      //$_SESSION['previousurl'] = "invitation_detail.php?invitation_id=".$invitation_id_url;
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