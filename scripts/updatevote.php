
<?php
	require 'connection.php';
	session_start();

	$user = $_GET["user"];
	$idfilm = $_GET['idfilm'];
	$type = $_GET['type'];
	$idcommento = 0;
	
	if(isset($_GET['idcommento']))
		$idcommento = intval($_GET['idcommento']);
	
	if(isset($_GET['userlikes'])){
		$conn = connect();
		try {

			$conn->beginTransaction();
			
			
			
			if(isset($type) && $type=="review" ){
				$reputazioneRecensione = getReputation($conn,$user);
				$data = updateVote($conn, array($user,$idfilm),$_GET['userlikes'],'review');
				
				if($_GET['userlikes']=='down'){
					
					if(floatval($reputazioneRecensione[0]['reputazione'])-0.01 >=-1)
						updateRep($conn,array(-0.01,$user));
					else
						updateRep($conn,array(-(1+floatval($reputazioneRecensione[0]['reputazione'])),$user));
				}
			}else{
				$reputazioneCommento = getReputation($conn,$_GET['usernamecommento']);
				$data = updateVote($conn, array($idcommento),$_GET['userlikes'],'comment');
				
				if($_GET['userlikes']=='down'){
					if(floatval($reputazioneCommento[0]['reputazione'])-0.01 >=-1)
						updateRep($conn,array(-0.01,$_GET['usernamecommento']));
					else
						updateRep($conn,array(-(1+floatval($reputazioneRecensione[0]['reputazione'])),$_GET['usernamecommento']));
				}
			}
			
			$conn->commit();
			
			header('Location:../schedafilm.php?idfilm='.$_SESSION['idfilm']);
		}
		catch(PDOException $e)
		{
			$conn->rollBack();
			echo "Connection failed: " . $e->getMessage();
		}	
		
	}

	
?>