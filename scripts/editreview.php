
<?php
	require 'connection.php';
	session_start();

	$text = $_POST["reviewedit"];
	
	if(isset($_POST["ratingedit"]))
		$rating = $_POST["ratingedit"];
	else
		$rating = 1;

	$conn = connect();
	try {

		$conn->beginTransaction();
		$data = editReview($conn, array($text,$rating,$_SESSION['username'],$_SESSION['idfilm']));
		$conn->commit();
		header('Location:../schedafilm.php?idfilm='.$_SESSION['idfilm']);
	}
	catch(PDOException $e)
	{
		$conn->rollBack();
		echo "Connection failed: " . $e->getMessage();
	}

	 
	 
	 

	
?>