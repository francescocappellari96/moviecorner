
<?php
	require 'connection.php';
	session_start();
	

	$mode = $_GET["mode"];
	$oldmovieid;
	
	if(isset($_GET["movieid"]))
		$oldmovieid = $_GET["movieid"];
	
	$ok = 1;
	
	$datanascita;
	$nome;
	$cognome;
	$genere;
	
	$nazione;
	
	if(isset($_POST["datanascita"]) || $_POST["datanascita"]!="")
		$datanascita = str_replace("-",":",$_POST["datanascita"]);
	
	if(isset($_POST["nome"]) || $_POST["nome"]!="")
		$nome = $_POST["nome"];
	
	if(isset($_POST["cognome"]) || $_POST["cognome"]!="")
		$cognome = $_POST["cognome"];
	
	if(isset($_POST["genere"]) || $_POST["genere"]!="")
		$genere = $_POST["genere"];
	
	if(isset($_POST["nazione"]) || $_POST["nazione"]!="")
		$nazione = $_POST["nazione"];
	
	
	
	$conn = connect();
	
	if($ok == 1){
		try {

			
			$conn->beginTransaction();
		
			if($_GET['entity'] == "actor")
				addActor($conn,array($nome,$cognome,$datanascita));
			else if($_GET['entity'] == "director")
				addDirector($conn,array($nome,$cognome,$datanascita));
			else if($_GET['entity'] == "genre")
				addGenre($conn,array($genere));
			else if($_GET['entity'] == "productionhouse")
				addProductionHouse($conn,array($nome,$nazione));
			
			
			$conn->commit();

			
			if($mode=="edit")
				header('Location:../nuovofilm.php?mode='.$mode.'&movieid='.$oldmovieid);
			else
				header('Location:../nuovofilm.php?mode='.$mode);
		}
		catch(PDOException $e)
		{
			$conn->rollBack();
			echo "Connection failed: " . $e->getMessage();
		}
	}else{
			if($mode=="new")
				header('Location:../nuovofilm.php?mode='.$mode.'&error=nodata');
			else
				header('Location:../nuovofilm.php?mode='.$mode.'&error=nodata&movieid='.$oldmovieid);
	}


	
?>