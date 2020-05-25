

<?php
	require 'connection.php';
	

	$newuser = $_POST["usr"];
	$newpassword = $_POST["pwd"];
	$newmail = $_POST["email"];
	$confirmpassword = $_POST["pwd2"];
	$success = 1;
	$imagePath = '';
	
	if(!$newuser && !$newpassword && !$newmail && !$confirmpassword ){
		 header('Location:../signup.php?errore=nodata');
	}else if(!$newuser){
		 
		 header('Location:../signup.php?errore=nousr');
	 }else if(!$newpassword){
		 
		 header('Location:../signup.php?errore=nopwd');
		 
	 }else if(!$newmail){
		 
		 header('Location:../signup.php?errore=nomail');
		 
	 }else if($newpassword != $confirmpassword){
		 
		 header('Location:../signup.php?errore=pswdiff');
		 
	 }else{
		 
		$target_dir = "../images/tmp/";
		$target_file = $target_dir . basename($_FILES["profpic"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
			$target_file = '';
		} else {
			if (move_uploaded_file($_FILES["profpic"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
				$target_file = '';
			}
		}
		
				$conn = connect();
				try {
			
					
					$data = getUsers($conn);
					$alreadyExists = 0;
					foreach($data as $row ){  
						if($row['username'] == $newuser ){
							$alreadyExists = 1;
							$success = 0;
							header('Location:../signup.php?errore=usralreadyexists');
							break;
						}else if($row['email'] == $newmail ){
							$alreadyExists = 1;
							$success = 0;
							header('Location:../signup.php?errore=mailalreadyexists');
							break;
						}
					
					}
										
					if(!$alreadyExists){
						$conn->beginTransaction();
						$array = array($newuser,$newmail,$newpassword,0,0,returnBase64Image($target_file));
						$data = addUser($conn,$array);
						$conn->commit();
						
					}
					
				}
				catch(PDOException $e)
				{
					$conn->rollBack();
					echo "Connection failed: " . $e->getMessage();
				}
			
			
			if($success){
				
				session_start();
				
				
				$_SESSION['username'] = $newuser;
				$_SESSION['amministratore'] = 0;
				$_SESSION['reputazione'] = 0;
				$_SESSION['immagineprofilo'] = returnBase64Image($target_file);
				unlink($target_file);
				header('Location:../home.php');
			}
			

	 }
	 
	 
	 function returnBase64Image($string){
		if($string==''){
			$image = imagecreatefromstring(file_get_contents("../images/genericUser.jpg"));
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