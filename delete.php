<!--php action for deleting invitation list-->
<?php

include 'functions.php';
session_start();

header('Location: index.php');
$invitation_id_url = 0;
//get the invitation id from the URL
$invitation_id_url = $_GET['invitation_id'];

//check whether the user submit the delete form
if($_POST['deletesubmitcheck'])
{
    $mysqli = getConnection();
    $stmt =  $mysqli->stmt_init();
    $stmt1 = $mysqli->stmt_init();
    $stmt3 = $mysqli->stmt_init();
    $stmt5 = $mysqli->stmt_init();
    //if yes, delete the invitation record from the invitation_list in database
    if($stmt->prepare("DELETE FROM invitation_list WHERE invitation_id = ?"))
    {
    	$stmt->bind_param("i",$invitation_id_url);
    	$stmt->execute();
    	$stmt->close();
    }
    //check if there are some records in join_list, if yes, delete from join_list
    if($stmt1->prepare("SELECT join_id FROM join_list WHERE invitation_id = ?"))
    {	
    	$stmt1->bind_param("i",$invitation_id_url);
    	$stmt1->execute();
    	$stmt1->bind_result($joinid);
    	$stmt1->store_result();
    	if($stmt1->num_rows)
    	{
    		$stmt2 = $mysqli->stmt_init();
    		if($stmt2->prepare("DELETE FROM join_list WHERE invitation_id = ?"))
    		{
    			$stmt2->bind_param("i",$invitation_id_url);
    			$stmt2->execute();
    			$stmt2->close();
    		}
    	}
    	$stmt1->close();
    }
    //check if there are some records in dish_list, if yes, delete from dish_list
    if($stmt3->prepare("SELECT dish_id FROM dish_list WHERE invitation_id = ?"))
    {	
    	$stmt3->bind_param("i",$invitation_id_url);
    	$stmt3->execute();
    	$stmt3->bind_result($dishid);
    	$stmt3->store_result();
    	if($stmt3->num_rows)
    	{
    		$stmt4 = $mysqli->stmt_init();
    		if($stmt4->prepare("DELETE FROM dish_list WHERE invitation_id = ?"))
    		{
    			$stmt4->bind_param("i",$invitation_id_url);
    			$stmt4->execute();
    			$stmt4->close();
    		}
    	}
    	$stmt3->close();
    }
    //check if there are some records in restaurant_category, if yes, delete from restaurant_category
    if($stmt5->prepare("SELECT invitation_id FROM restaurant_category WHERE invitation_id = ?"))
    {	
    	$stmt5->bind_param("i",$invitation_id_url);
    	$stmt5->execute();
    	$stmt5->bind_result($inviid);
    	$stmt5->store_result();
    	if($stmt5->num_rows)
    	{
    		$stmt6 = $mysqli->stmt_init();
    		if($stmt6->prepare("DELETE FROM restaurant_category WHERE invitation_id = ?"))
    		{
    			$stmt6->bind_param("i",$invitation_id_url);
    			$stmt6->execute();
    			$stmt6->close();
    		}
    	}
    	$stmt5->close();
    }
    $mysqli->close();
}
?>
