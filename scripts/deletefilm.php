
<?php
	require 'connection.php';
	session_start();
	$movieid = $_GET['movieid'];

	
	$conn = connect();
	try {

		$conn->beginTransaction();
		$data = deleteFilm($conn, array($movieid));		
		$conn->commit();
		
		header('Location:../home.php');
	}
	catch(PDOException $e)
	{
		$conn->rollBack();
		echo "Connection failed: " . $e->getMessage();
	}

	 
	 
	 

	
?>