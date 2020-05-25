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
  
  if (isset($_GET['idfilm'])) {
	
    header('Location:schedafilm.php?idfilm='.$_GET['idfilm']);
  }
  
?>
<html>
	<head>
		<script src="js/bootstrap.min.js"></script>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/bootstrap-theme.css" rel="stylesheet" />
		
			<div class="container text-white" >
				<div class="row">
					<div class="col-lg-2 col-md-2 col-sm-2"></div>
					<div class="col-lg-8 col-md-8 col-sm-8">
						<img src="images/mainlogo.png" style="width:100%" alt="mainlogo"/>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2"></div>
				</div>
			</div>
	
	</head>
	<body class="bg-dark ">
		<div class="row h-100">
			<div class="col-lg-2 col-md-2 col-sm-2">
				
				<div class="card bg-secondary text-white ml-3 mb-2" >
				  <?php echo'<img class="card-img-top" src="'.$_SESSION['immagineprofilo'].'" alt="Card image cap">'; ?>
				  <div class="card-body">
					<h5 class="card-title"><?php echo "Benvenuto, ".$_SESSION['username']."!"   ?></h5>
					<p class="card-text"><b>Reputazione: </b><?php echo $_SESSION['reputazione'];?></p>
					
						<?php 
							if($_SESSION['amministratore']) {
								if($_SESSION['reputazione']>0.5){
									echo '<div class="row mt-2">
											<a href="nuovofilm.php?mode=new" class="btn btn-success" style="width:100%">Aggiungi film</a>
										</div>';
								}
								echo'<div class="row mt-2">
										<a href="controlpanel.php" class="btn btn-success" style="width:100%">Pannello di controllo</a>
									</div>
									';					
							} 
						?>
					
					<div class="row mt-2">
						<a href="?logout=true" class="btn btn-danger" style="width:100%">Logout</a>
					</div>
				  </div>
				</div>
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8 no-float">
				<form action="scripts/search.php" method="post">
					<div class="input-group mb-3">
					
						<form action="scripts/search.php" method="post">
						  <input type="text" class="form-control" name="restriction" placeholder="Inserisci il nome di un film" aria-label="Inserisci il nome di un film" aria-describedby="basic-addon2">
						  <div class="input-group-append">
							<button class="btn btn-success"  type="submit">Cerca</button>
						  </div>
						</form>
					</div>
				</form>
				<div class="mt-2"> 
					<?php
						
						$conn = connect();
						$temp='';
						if(isset($_GET['orderby'])){
							if(isset($_SESSION['restriction']))
								$temp = $_SESSION['restriction'];
							else
								$temp = '';
							
							if($_GET['orderby']=='rating'){
								
								$data  = getMovieList($conn,'rating',$temp);
								
							}else if($_GET['orderby']=='name'){
								
								$data  = getMovieList($conn,'name',$temp);
							}

						}else{
							$data = getMovieList($conn,'default',$temp);
						}
						
						
						foreach($data as $row ){  
							
							echo '<div class="card bg-secondary text-white" >
									<div class="card-body">
										<div class="row">
											<div class="col-lg-6">
												<a href ="?idfilm='.$row['idfilm'].'"><img src="'.$row['locandina'].'"width="290" height="400";/></a>
											</div>
											<div class="col-lg-6 text-white">
												<div class="row">
													<p class="card-text"><h3><b>'.$row['titolo'].'</b></h3></p>
												</div>		
												<div class="row">
													<p class="card-text">'.$row['trama'].'</p>
												</div>

											</div>
										</div>
										<div class="row align-items-end  ">		
								
											<div class="col-sm-6">
											</div>
											<div class="col-sm-6">
													<b>Giudizio:</b>';
													for($i=0; $i<5; $i = $i+1){
														if($i<$row['mediaGiudizi']){
							echo '							<img src="images/corncoloured.png" style="max-width:100%;max-height:100%;"/>';
														}else{
							echo '							<img src="images/corngrey.png" style="max-width:100%;max-height:100%;"/>';	
														}							
													}
							echo '			</div>
										</div>
									</div>
								</div>
								<br>';
						}  
					
					?>
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 ">
				
					<div class="row text-white">
						<h3><b>Ordina per</b></h3>
					</div>
					<form action="scripts/search.php" method="post">
						<div class="row text-white bg-dark">
							<div name="rating"></div>
							<h5><button style="border:none;  background-color: inherit; cursor:pointer;" class="text-white"  type="submit"  id="rating" name="rating">Giudizio</button></h5>
						</div>
						<div class="row text-white bg-dark">
							<div name="name"></div>
							<h5><button style="border:none;  background-color: inherit; cursor:pointer;" class="text-white" type="submit"  id="name" name="name">Nome</button></h5>
						</div>
					</form>
			</div>
		</div>
</html>