<!--public php functions-->
<?php
//connect the database
function getConnection(){// change the details below for your db connection
	$conn = new mysqli("localhost", "s1534951", "NlPdtfZJSL", "s1534951");
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}	
	return $conn;	
}

//only show three invitation lists in index page for every category
function indexShowThree($invitation_category){
	$mysqli = getConnection();
    $stmt =  $mysqli->stmt_init();
    //if($stmt->prepare("SELECT invitation_id, pic_url, title, invitation_date, city, post_date FROM invitation_list WHERE invitation_category_id = $invitation_category AND is_available = 1 ORDER BY post_date DESC"))
    if($stmt->prepare("SELECT invitation_id, pic_url, title, invitation_date, city, post_date, is_available FROM invitation_list WHERE invitation_category_id = $invitation_category ORDER BY post_date DESC"))
    {
        $stmt->execute();           
        $stmt->bind_result($invitationid, $picurl, $title, $invitationdate, $city, $postdate, $isavailable);
        $stmt->store_result();
        if($stmt->num_rows > 3){

            for ($i=1;$i<=3;$i++)
            {
                $stmt->fetch();
                echo "<div class=\"browse\">";
                echo "<h3>".ucfirst($title)."</h3>";
                echo "<a href=\"invitation_detail.php?invitation_id=".$invitationid."\" target=\"_blank\">";
                echo "<img src=\"".$picurl."\"/>";
                echo "</a>";
                echo "<p>".ucfirst($city)."&nbsp&nbsp&nbsp".$invitationdate;
                if($isavailable == 0)
                {
                	echo "<span class=\"full\">(FULL!)</span>";
                }
                echo "</p>";
                echo "</div>";
            }
        }
        else{
        	while($stmt->fetch())
        	{
        		echo "<div class=\"browse\">";
                echo "<h3>".ucfirst($title)."</h3>";
                echo "<a href=\"invitation_detail.php?invitation_id=".$invitationid."\"target=\"_blank\">";
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
        $stmt->close();
        $mysqli->close();
    }
}
?>
