<!--php action for posting a new invitation-->
<?php

include 'functions.php';
session_start();

$invi_category_id=$_POST['invicategory'];
$invi_title=$_POST['invititle'];
$invi_date=$_POST['invidate'];
$invi_time=$_POST['invitime'];
$invi_address=$_POST['inviaddress'];
$invi_city=$_POST['invicity'];
$invi_zip=$_POST['invizip'];
$invi_country=$_POST['invicountry'];
$invi_guests_num=$_POST['inviguestsnum'];
if(isset($_POST['invidish']))
{
	$invi_dish=$_POST['invidish'];
}

if(isset($_POST['invidishdescrip']))
{
	$invi_dish_descrip=$_POST['invidishdescrip'];
}

$invi_cuisine_category_id=$_POST['invicuisinecate'];
//$invi_img=$_POST['invipic'];
$post_user=$_SESSION['loginUserid'];

//move the img file to my destination "img" file folder
if($_FILES["invipic"]["name"]!=""&&$_FILES["invipic"]["name"]!=NULL){
	move_uploaded_file($_FILES["invipic"]["tmp_name"],
      "img/" . $_FILES["invipic"]["name"]);
	$invi_img = "img/".$_FILES["invipic"]["name"];
}
else{
	$invi_img = "img/sample.png";
}


$last_insert_id=0;

if($_POST['invipostcheck'])
{
	//check whether the user has filled all the required fields
	if($invi_title!=""&&$invi_date!=""&&$invi_time!=""&&$invi_address!=""&&$invi_city!=""&&$invi_country!=""&&$invi_guests_num!="")
	{
	$mysqli = getConnection();
	$stmt =  $mysqli->stmt_init();

	if ($stmt->prepare("INSERT INTO invitation_list(post_user_id, title, invitation_date, invitation_time, addressline, city, country, zip, guests_number, invitation_category_id, post_date, pic_url, guests_remaining, is_available) VALUES(?,?,?,?,?,?,?,?,?,?,NOW(),?,?,1)"))
	{
		$stmt->bind_param("isssssssiisi",$post_user,$invi_title,$invi_date,$invi_time,$invi_address,$invi_city,$invi_country,$invi_zip,$invi_guests_num,$invi_category_id,$invi_img,$invi_guests_num);
		$stmt->execute();
		$last_insert_id = $mysqli->insert_id;
		$stmt->close();
	}

	if($invi_category_id!=3)
	{
		$stmt1 = $mysqli->stmt_init();

		if($stmt1->prepare("INSERT INTO dish_list(invitation_id, user_id, dish_name, dish_description,dish_category_id) VALUES (?,?,?,?,?)"))
		{
			$stmt1->bind_param("iissi",$last_insert_id,$post_user,$invi_dish,$invi_dish_descrip,$invi_cuisine_category_id);
			$stmt1->execute();
			$stmt1->close();
		}
	}
	else
	{
		$stmt2 = $mysqli->stmt_init();
		if($stmt2->prepare("INSERT INTO restaurant_category(invitation_id,restaurant_category_id) VALUES (?,?)"))
		{
			$stmt2->bind_param("ii",$last_insert_id,$invi_cuisine_category_id);
			$stmt2->execute();
			$stmt2->close();
		}
	}
	$mysqli->close();
	header('Location: index.php');
	}
	else
	{		
		echo "<script language='javascript'>alert('You must fill all the required fields, please check.');window.history.back(-1);</script>";
	}
}

?>