
<?php
	require 'connection.php';
	session_start();

	$text = $_POST["comment"];
	$usernamecommento = $_SESSION["username"];
	$idfilm = intval($_SESSION['idfilm']);
	$usernamerecensione = $_GET['usernamereview'];
	$conn = connect();
	try {

		$conn->beginTransaction();
		$data = addComment($conn,array($usernamecommento,$usernamerecensione,$text,$idfilm));
		
		if(floatval($_SESSION['reputazione'])+0.001<=1){
			$data = updateRep($conn,array(0.001,$_SESSION['username']));
			$_SESSION['reputazione']= $_SESSION['reputazione'] + 0.001;
		}else{
			$data = updateRep($conn,array(1-floatval($_SESSION['reputazione']),$_SESSION['username']));
			$_SESSION['reputazione']= 1-floatval($_SESSION['reputazione']);
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