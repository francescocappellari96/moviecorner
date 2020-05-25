
<?php
	require 'connection.php';
	session_start();
	
	$ok = 1;
	$titolo;
	$durata;
	$datauscita;
	$trama;

	$locandina='';
	$target_file='';
	$attori;
	$registi;
	$generi;
	$casa;
	$mode = $_GET["mode"];

	$ruolo = array();
	$oldmovieid;
	
	if(isset($_GET["oldmovieid"]))
		$oldmovieid=$_GET["oldmovieid"];
	
	if(isset($_POST["titolo"]) && $_POST["titolo"]!='')
		$titolo = $_POST["titolo"];
	else
		$ok = 0;
	
	if(isset($_POST["durata"]) && $_POST["durata"]!='')
		$durata = $_POST["durata"];
	else
		$ok = 0;
	
	if(isset($_POST["datauscita"]) && $_POST["datauscita"]!=''){
		$datauscita = str_replace("-",":",$_POST["datauscita"]);
	}else
		$ok = 0;
	
	if(isset($_POST["trama"])&& $_POST["trama"]!='')
		$trama = $_POST["trama"];
	else
		$ok = 0;
	
	if(isset($_POST["casaproduzione"])&& $_POST["casaproduzione"]!='')
		$casa = $_POST["casaproduzione"];
	else 
		$ok = 0;
	
	

		$target_dir = "../images/tmp/";
		$target_file = $target_dir . basename($_FILES["locandina"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		
		if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
				$target_file = '';
			} else {
				if (move_uploaded_file($_FILES["locandina"]["tmp_name"], $target_file)) {
					//echo "The file ". basename( $_FILES["locandina"]["name"]). " has been uploaded.";
				} else {
					
						echo "Sorry, there was an error uploading your file.<br>";
						$target_file = '';
					
				}
			}
	
	
	$locandina = returnBase64Image($target_file);
	if($mode=="edit" && $target_file=='')
		$locandina = $_SESSION['locandina'];
	
	
	
	if(isset($_POST["attori"]))
		$attori = $_POST['attori'];
	
	if(isset($_POST["registi"]))
		$registi = $_POST['registi'];

	if(isset($_POST["generi"]))
		$generi = $_POST['generi'];
	
	
	
	$conn = connect();
	if($ok==1){
	
		try {

			
			$conn->beginTransaction();
			if($mode=='new')
				$data = addFilm($conn,array($titolo,$durata,$datauscita,$casa,$_SESSION['username'],$locandina,$trama));
			else
				$data = editFilm($conn,array($titolo,$durata,$datauscita,$casa,$locandina,$trama,$oldmovieid));
			
			
			if($mode=='new'){
				$lastId= getLastInsertId($conn);
				$lastId = $lastId[0][0];
		
			}else{
				$lastId = $oldmovieid;
			}
			
			if($mode=='edit'){
				//droppo tutte le righe e le reinserisco. Avrebbe poco senso settare a null solo le chiavi esterne 
				deleteGenresFilm($conn,array($lastId));
				deleteActorsFilm($conn,array($lastId));
				deleteDirectorsFilm($conn,array($lastId));
				
			}
			foreach($attori as $attore){
				if(isset($_POST['ruolo'.$attore]))
					addActorsToFilm($conn,array($_POST['ruolo'.$attore],$lastId,$attore));
				
			}
			
			foreach($registi as $regista){
				
				addDirectorsToFilm($conn,array($lastId,$regista));
				
			}
			
			
			foreach($generi as $genere){
				
				addGenresToFilm($conn,array($lastId,$genere));
				
			}
			$conn->commit();
			if(isset($_SESSION['locandina']))
				unset($_SESSION['locandina']);
			
			unlink($target_file);
			header('Location:../home.php');
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
	 
	 function returnBase64Image($string){
		if($string==''){
			$image = imagecreatefromstring(file_get_contents("../images/nolocandina.jpg"));
		}else{
			
			$image = imagecreatefromstring(file_get_contents($string));
		}
		ob_start();
		imagepng($image);
		$contents =  ob_get_contents();
		ob_end_clean();
		
		return 'data:image/png;base64,'.base64_encode($contents);
		 
		 
	 }
	 

	
?>