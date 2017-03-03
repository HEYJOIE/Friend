<!--php action for user to cancel join-->
<?php

include 'functions.php';
session_start();

$invitation_id_url = 0;
// get the invitation id from URL
$invitation_id_url = $_GET['invitation_id'];
$joinuserid=$_SESSION['loginUserid'];

//check whether the user submit the cancel join form
if($_POST['cancelsubmitcheck'])
{
    $mysqli = getConnection();
    $stmt =  $mysqli->stmt_init();
    $stmt2 =  $mysqli->stmt_init();
    //if the user confirm the cancelletion, then delete the information from the join_list in database
    if($stmt->prepare("DELETE FROM join_list WHERE invitation_id = ? AND join_user_id = ?"))
    {
    	$stmt->bind_param("ii",$invitation_id_url,$joinuserid);
    	$stmt->execute();
    	$stmt->close();
    }
    //at the same time, update the remaining guests number in invitation_list, making it plus one
    if($stmt2->prepare("UPDATE invitation_list SET guests_remaining = guests_remaining+1, is_available = 1 where invitation_id=?"))
    {
        $stmt2->bind_param("i", $invitation_id_url);
        $stmt2->execute();
        $stmt2->close();
    }

    //check if there are some records in dish_list, if yes, delete from dish_list
    $stmt3=$mysqli->stmt_init();
    if($stmt3->prepare("SELECT dish_id FROM dish_list WHERE invitation_id = ? AND user_id = ?"))
    {	
    	$stmt3->bind_param("ii",$invitation_id_url,$joinuserid);
    	$stmt3->execute();
    	$stmt3->bind_result($dishid);
    	$stmt3->store_result();
    	if($stmt3->num_rows)
    	{
    		$stmt4 = $mysqli->stmt_init();
    		if($stmt4->prepare("DELETE FROM dish_list WHERE invitation_id = ? AND user_id = ?"))
    		{
    			$stmt4->bind_param("ii",$invitation_id_url,$joinuserid);
    			$stmt4->execute();
    			$stmt4->close();
    		}
    	}
    	$stmt3->close();
    }
    $mysqli->close();
    //return to the invitation detail page
    header("Location: invitation_detail.php?invitation_id=".$invitation_id_url);
}
?>
