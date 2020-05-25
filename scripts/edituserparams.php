
<?php
	require 'connection.php';
	session_start();

	$roles = $_POST["roles"];
	
	if(isset($_GET['mode']))
		$mode = $_GET['mode'];
	
	if(isset($_GET['username']))
		$username = $_GET['username'];
	
	$counter = 0;
	$counteradmins = 0;
	$ok = 1;
	$conn = connect();
	try {


		
			foreach($roles as $role){
				$counter++;
			}
			
		
				$conn->beginTransaction();
				
				if($mode=="edit" && $counter >= 1 ){
					
					setRolesToZero($conn,array());
					foreach($roles as $role){
						$data = editRoles($conn, array($role));
					}
					
				}else if ($mode=="delete" && (!in_array($username,$roles) || $counter > 1) ){
					
						deleteUser($conn,array($username));
					
				}else
				{
					$ok = 0;
					header('Location:../controlpanel.php?error=noadmin');
					
				}
				

	}
	catch(PDOException $e)
	{
		$conn->rollBack();
		echo "Connection failed: " . $e->getMessage();
	}

	if($ok == 1){
		
			 
			  $conn->commit();
			  session_destroy();
			  unset($_SESSION);
			  header('Location:../index.php');
		 
	 
	}

	
?>