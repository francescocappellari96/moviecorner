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
	<div class="col">
				<article class="card-body mx-auto text-white" style="max-width: 400px;">
					<h4 class="card-title mt-3 text-center">Crea un account</h4>
					<p class="text-center">Immetti i tuoi dati</p>
		
					<form autocomplete="off" action="scripts/validate.php" method="post" enctype="multipart/form-data">
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-user"></i> </span>
							 </div>
							<input name="usr" class="form-control" placeholder="Username" type="text">
						</div> <!-- form-group// -->
						
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
							 </div>
							<input autocomplete="off" name="email" class="form-control" value="" placeholder="Indirizzo email" type="email">
						</div> <!-- form-group// -->
						

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
							</div>
							<input autocomplete="off" class="form-control" name="pwd" value="" placeholder="Inserisci password" type="password">
						</div> <!-- form-group// -->
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
							</div>
							<input class="form-control" placeholder="Ripeti password" name="pwd2" type="password">
						</div> <!-- form-group// -->   
						
						<div class="form-group input-group">
						 
						  <div class="custom-file">
							<input type="file" name="profpic" class="custom-file-input" id="profpic" aria-describedby="inputGroupFileAddon01">
							<label class="custom-file-label"  for="inputGroupFile01">Scegli foto</label>
						  </div>
						</div>
						
						<div class="form-group">
							<button type="submit" name="uploadeverything" class="btn btn-primary btn-block"> Crea l'account  </button>
						</div> <!-- form-group// -->      
																				
					</form>
					<div class="row">
							<?php
								if(isset($_GET['errore'])){
									if($_GET['errore']=='nodata'){
										
										echo '<p class="text-danger">Inserire i dati!</p>';
										
									}else if($_GET['errore']=='nousr'){
										
										echo '<p class="text-danger">Inserire un username!</p>';
										
									}else if($_GET['errore']=='nopwd'){
										echo '<p class="text-danger"></p>';
										
									}else if($_GET['errore']=='Inserire la nuova password!'){
										
										echo '<p class="text-danger"></p>';
										
									}else if($_GET['errore']=='nomail'){
										
										echo '<p class="text-danger">Inserire la mail!</p>';
										
									}else if($_GET['errore']=='pswdiff'){
										
										echo '<p class="text-danger">Le due password non coincidono!</p>';
										
									}else if($_GET['errore']=='usralreadyexists'){
										
										echo '<p class="text-danger">Il nome utente esiste già!</p>';
										
									}else if($_GET['errore']=='mailalreadyexists'){
										
										echo '<p class="text-danger">L\'indirizzo mail è già presente!</p>';
										
									}
								}
							?>
					</div> <!-- form-group// --> 
				</article>
			</div>
	</body>
</html>