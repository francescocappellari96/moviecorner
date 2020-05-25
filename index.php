<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
	<head>
		<script src="js/bootstrap.min.js"></script>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/bootstrap-theme.css" rel="stylesheet" />
	</head>
	<body class="bg-dark">
	<div class="container" >
				<img src="images/mainlogo.png" class="img-fluid" alt="mainlogo">
			</div>
			<div class="container">
			<div class="row">
				<div class="col-lg"></div>
				<div class="col-lg">
					<h3><p class="text text-center text-white"> Login </p></h3>
				</div>
				<div class="col-lg"></div>
			</div>
			<div class="row">
				<div class="col-lg"></div>
				<div class="col-lg">
					<form action="scripts/submit.php" method="post">
						<div class="form-group">
							<label for="usr" class="text-white">Username</label>
							<input type="text" class="form-control" id="usr" name="usr">
						</div>
						<div class="form-group">
							<label for="pwd" class="text-white">Password</label>
							<input type="password" class="form-control" id="pwd" name="pwd">
						</div>
						<button type="submit" class="btn btn-success" >Login</button>
					</form>
				</div>
				<div class="col-lg"></div>
			</div>	
			<div class="row">
				<div class="col-lg"></div>
				<div class="col-lg">
				<?php  
				
					if(!isset($_GET['errore'])){
						$_GET["errore"]="";
					}else{
					
						if ($_GET['errore'] == 'nousr') {
						  echo "<font color=red>Inserire un username valido!</font>";
						  
						}	
						if ($_GET['errore'] == 'nodata') {
						  echo "<font color=red>Immettere username e password!</font>";
						}
						if ($_GET['errore'] == 'nopwd') {
						  echo "<font color=red>Inserire la password!</font>";
						}	
						if ($_GET['errore'] == 'invalide') {
						  echo "<font color=red>Le credenziali che hai fornito non sono valide!</font>";
						}
					}
					
					
				?>
				</div>
				<div class="col-lg"></div>
			</div>
			<div class="row">
				<div class="col-lg"></div>
				<div class="col-lg text-white">
					<p>Non hai un account? <a href="signup.php">Registrati</a></p>
				</div>
				<div class="col-lg"></div>
			</div>
		</div>
		
	</body>
</html>