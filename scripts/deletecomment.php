
<?php
	require 'connection.php';
	session_start();
	$commentid = intval($_GET['id']);
	$conn = connect();
	try {

		
		$conn->beginTransaction();
		$data = deleteComment($conn, array($commentid));
		$conn->commit();
		header('Location:../schedafilm.php?idfilm='.$_SESSION['idfilm']);
	}
	catch(PDOException $e)
	{
		$conn->rollBack();
		echo "Connection failed: " . $e->getMessage();
	}

	 
	 
	 

	
?>