
<?php
	require 'connection.php';
	session_start();
	$movieid = $_GET['movieid'];
	$usernamereview = $_GET['usernamereview'];
	
	$conn = connect();
	try {

		$conn->beginTransaction();
		
		$data = deleteReview($conn, array($usernamereview,$movieid));
		$conn->commit();
		
		header('Location:../schedafilm.php?idfilm='.$movieid);
	}
	catch(PDOException $e)
	{
		$conn->rollBack();
		echo "Connection failed: " . $e->getMessage();
	}

	 
	 
	 

	
?>