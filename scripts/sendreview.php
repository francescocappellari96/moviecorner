
<?php
	require 'connection.php';
	session_start();

	$text = $_POST["review"];
	$rating = $_POST["rating"];

	$conn = connect();
	try {

		$conn->beginTransaction();
		$data = addReview($conn,array($text,$rating,$_SESSION['username'],intval($_SESSION['idfilm']),0,0));
		
		if(floatval($_SESSION['reputazione'])+0.02<=1){
			$data = updateRep($conn,array(0.02,$_SESSION['username']));
			$_SESSION['reputazione'] = $_SESSION['reputazione']+0.02;
		}else{
			$data = updateRep($conn,array(1-floatval($_SESSION['reputazione']),$_SESSION['username']));
			$_SESSION['reputazione'] = 1-floatval($_SESSION['reputazione']);
		}
		$conn->commit();
		
		header('Location:../schedafilm.php?idfilm='.$_SESSION['idfilm']);
	}
	catch(PDOException $e)
	{
		$conn->rollBack();
		echo "Connection failed: " . $e->getMessage();
	}

	 
	 
	 

	
?>