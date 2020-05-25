

<?php
	require 'connection.php';
	

	$login_username = $_POST["usr"];
	$login_password = $_POST["pwd"];
	if(!$login_username && !$login_password){
		 header('Location:index.php?errore=nodata');
	}else if(!$login_username){
		 
		 header('Location:index.php?errore=nousr');
	 }else if(!$login_password){
		 
		 header('Location:index.php?errore=nopwd');
	 }else{
		 
			$conn = connect();
			try {
				
				$found = 0;
				$admin = -1;
				$profilepic="";
				$rep = 0.0;
				$data = getUsers($conn);
				foreach($data as $row ){  
						if($row['username']== $login_username && $row['password']== $login_password && $row['deleted']!=1){
							$found = 1;
							$admin = $row['amministratore'];
							$rep = $row['reputazione'];
							$profilepic = $row['immagineprofilo'];
						}
				}  
				
				if(!$found){
					header('Location:../index.php?errore=invalide');
				}else{
					session_start();
					$_SESSION['username'] = $login_username;
					$_SESSION['amministratore'] = $admin;
					$_SESSION['reputazione'] = $rep;
					$_SESSION['immagineprofilo'] = $profilepic;
					header('Location:../home.php');
					
				}
			

			}
			catch(PDOException $e)
			{
				
				echo "Connection failed: " . $e->getMessage();
			}
	 }
	
?>