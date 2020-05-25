<?php  
  require 'scripts/connection.php';
  session_start(); 

  function logout() {
    session_destroy();
	$_SESSION = array();
	header('Location:index.php');
  }

  if (isset($_GET['logout'])) {
    logout();
  }

  if(!isset($_SESSION['username'])){
	  session_destroy();
	  header('Location:index.php');
	  
  }
  
  $conn = connect();
  $users = getUsers($conn);
 
?>
<html>
	<head>
		<script src="js/jquery-3.4.1.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/bootstrap-theme.css" rel="stylesheet" />
		
			<div class="container text-white" >
				<div class="row">
					<div class="col-lg-2 col-md-2 col-sm-2"></div>
					<div class="col-lg-8 col-md-8 col-sm-8">
						<a href="home.php"><img src="images/mainlogo.png" style="width:100%" alt="mainlogo"/></a>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2"></div>
				</div>
			</div>
	
	</head>
	<body class="bg-dark text-white">

		<form id="mainform" action="scripts/edituserparams.php?mode=edit" method="post">
		<div class="row h-100 ml-2 mr-2">
			<div class="col-lg-12">
				<table class="table">
				  <thead>
					<tr>
					
					  <th scope="col">Username</th>
					  <th scope="col">Email</th>
					  <th scope="col">Reputazione</th>
					  <th scope="col">Amministratore</th>
					  <th scope="col"></th>
					</tr>
				  </thead>
				  <tbody>
					<?php
						foreach($users as $user){
							if($user['deleted']!=1){
								echo '<tr>
									<td>'.$user['username'].'</td>
									<td>'.$user['email'].'</td>
									<td>'.$user['reputazione'].'</td>
									<td>
										<div class="form-check">';
								if(intval($user['amministratore'])==1)
									echo '  		<input class="form-check-input" type="checkbox" name="roles[]" value="'.$user['username'].'" id="defaultCheck1" checked="checked">';
								else
									echo '  		<input class="form-check-input" type="checkbox" name="roles[]" value="'.$user['username'].'" id="defaultCheck1" >';
								
								echo '		</div>
									</td>
									<td>
									<button id="elimina'.$user['username'].'" class="btn btn-danger">Elimina</button>
									</td>
									</tr>
									<script>
									$( "#elimina'.$user['username'].'" ).click(function() {
											$("#mainform").attr("action","scripts/edituserparams.php?mode=delete&username='.$user['username'].'" );	  
											});
									</script>';
							}
						}
					
					?>
					
				  </tbody>
				</table>
				<div class="row ml-2">
						<button type="submit" class="btn btn-success">Salva</button>
				</div>
				<div class="row ml-2 mt-1 text-warning">
						<b>ATTENZIONE: &nbsp;</b> Al salvataggio dei dati, verrà eseguito il logout a fini di sicurezza.
				</div>
				
				<?php
					if(isset($_GET['error']) && $_GET['error']=="noadmin"){
						echo '	<div class="row ml-2 mt-1 text-danger">
									<b>ERRORE! &nbsp;</b> Deve essere presente nel sistema almeno un amministratore!
								</div>';
					}
				?>
			</div>
		</div>
	</form>
</html>