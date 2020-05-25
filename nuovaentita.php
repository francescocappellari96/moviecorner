<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
	<head>
		<script src="js/jquery-3.4.1.js"></script>
		<script src="js/popper.min.js"></script>
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
	
			<div class="row ml-1 mr-1">
				<div class="col-sm-12 col-md-12 col-lg-12">
				
				<?php
					if($_GET['entity']=="actor")
						echo '<h1>Nuovo attore</h1>';
					else if($_GET['entity']=="director")
						echo '<h1>Nuovo regista</h1>';
					else if($_GET['entity']=="genre")
						echo '<h1>Nuovo genere</h1>';
					else if($_GET['entity']=="productionhouse")
						echo '<h1>Nuova casa di produzione</h1>';
				?>
				</div>
				
				<?php
					if($_GET['mode']=='edit')
						echo '<form class="w-100" action="scripts/addentity.php?entity='.$_GET['entity'].'&mode='.$_GET['mode'].'&movieid='.$_GET['idfilm'].'" method="post">';
					else
						echo '<form class="w-100" action="scripts/addentity.php?entity='.$_GET['entity'].'&mode='.$_GET['mode'].'" method="post">';
				?>
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div class="card bg-secondary">
					  <div class="card-body">
						 <div class="form-group">
							<?php
								if($_GET['entity']=="actor" || $_GET['entity']=="director"){
									echo '<label for="exampleInputEmail1">Nome</label>
									<input type="text" class="form-control" id="nome" name="nome" aria-describedby="Titolo" placeholder="Inserisci nome">
									<label for="exampleInputEmail1">Cognome</label>
									<input type="text" class="form-control" id="cognome" name="cognome" aria-describedby="Titolo" placeholder="Inserisci cognome">
									<label for="exampleInputEmail1">Data nascita</label>
									<input type="date" class="form-control" name="datanascita" id="datanascita" />';
								}else if($_GET['entity']=="genre"){
									
									echo '<label for="exampleInputEmail1">Genere</label>
										  <input type="text" class="form-control" id="genere" name="genere" aria-describedby="Titolo" placeholder="Inserisci genere">';
									
								}else if($_GET['entity']=="productionhouse"){
									
									echo '<label for="exampleInputEmail1">Nome</label>
										  <input type="text" class="form-control" id="nome" name="nome" aria-describedby="Titolo" placeholder="Inserisci nome">
										  <label for="exampleInputEmail1">Nazione</label>
										  <input type="text" class="form-control" id="nazione" name="nazione" aria-describedby="Titolo" placeholder="Inserisci nazione">
										  
										  ';
									
								}
							?>
						  </div>
					  </div>
					</div>
					<div class="card mt-2 mr-2 bg-dark" style="border: none;">
						<div class="col-lg-6">
						</div>
							
						<div class="col-lg-6 ">
							<button class="btn btn-success " type="submit" id="salva" >
										Salva
							</button>
						</div>
					</div>
					<br><br><br>
				</div>
				</form>
			</div>
	</body>
</html>