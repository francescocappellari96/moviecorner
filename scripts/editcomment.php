
<?php
	require 'connection.php';
	session_start();

	$text = $_POST["commentedit"];
	$idcommento = $_GET['idcomm'];
	$conn = connect();
	try {

		$conn->beginTransaction();
		$data = editComment($conn, array($text,$idcommento));
		$conn->commit();
		header('Location:../schedafilm.php?idfilm='.$_SESSION['idfilm']);
		
		unset($_SESSION['idcommento']);
	}
	catch(PDOException $e)
	{
		$conn->rollBack();
		echo "Connection failed: " . $e->getMessage();
	}

	 
	 
	 

	
?>