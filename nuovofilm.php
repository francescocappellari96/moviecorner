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
					require "scripts/connection.php";
					
					$conn = connect();
					session_start();
					$mode = $_GET['mode'];
					if($_GET['mode']=='new'){
						echo '<h1>Aggiungi film</h1>';
					}else{
						echo '<h1>Modifica film</h1>';
						
						
						$movie = getMovie($conn,$_GET['movieid']);
						$actors = getActors($conn,$_GET['movieid']);
						$directors = getDirectors($conn,$_GET['movieid']);
						$genres = getGenres($conn,$_GET['movieid']);
						$productionhouse =getProductionHouse($conn,$_GET['movieid']);
						
						$oldmovieid = $_GET['movieid'];
						$_SESSION['locandina'] = $movie[0]['locandina'];
						
						
					}
					if(isset($_GET['error']) && $_GET['error']=="nodata"){
							echo '<p class="text-danger">Errore: immettere tutti i dati!</p>';
						
						}
				?>
				</div>
				
				<?php
					if($mode=="new")
						echo '<form class="w-100" enctype="multipart/form-data" action="scripts/addfilm.php?mode='.$mode.'" method="post">';
					else
						echo '<form class="w-100" enctype="multipart/form-data" action="scripts/addfilm.php?mode='.$mode.'&oldmovieid='.$oldmovieid.'" method="post">';
						 
				?>
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div class="card bg-secondary">
					  <div class="card-body">
						 <div class="form-group">
							<label for="exampleInputEmail1">Titolo</label>
							<input type="text" class="form-control" id="titolo" name="titolo" aria-describedby="Titolo" placeholder="Inserisci titolo">
							<label for="exampleInputEmail1">Durata</label>
							
							<div class="row">
								<div class="ml-3 col-xs-2">
									<input type="time" class="form-control" name="durata" id="durata" aria-describedby="Titolo" >
								</div>
							</div>
							<label for="exampleInputEmail1">Data uscita</label>
							<input type='date' class="form-control" name='datauscita' id='data' />
							<label for="exampleInputEmail1">Trama</label>
							<textarea type="text" class="form-control" id="trama" name="trama" aria-describedby="Titolo" placeholder="Inserisci trama"></textarea>
							<label for="exampleInputEmail1">Locandina</label>
							 <div class="custom-file">
								<input type="file" name="locandina" class="custom-file-input" id="locandina" aria-describedby="inputGroupFileAddon01">
								<label class="custom-file-label"  for="inputGroupFile01">Scegli locandina</label>
							 </div>
						  </div>
					  </div>
					</div>
					
					<?php
					echo '<script>';
					
						if($mode=='edit'){				
							
							echo '$("#titolo").val("'.$movie[0]['titolo'].'");';
							
							echo '$("#durata").val("'.$movie[0]['durata'].'");';
							echo '$("#data").val("'.$movie[0]['datauscita'].'");';
							echo '$("#trama").val("'.$movie[0]['trama'].'");';
							
						}
					echo '</script>';
					?>
					
					<div class="row  mt-3 ml-1 mb-2">
						
							<h3>Seleziona attori</h3>
						
					<?php
						if($_GET['mode']=='new'){
							echo'<a href="nuovaentita.php?entity=actor&mode=new">';
						}else{
							echo'<a href="nuovaentita.php?entity=actor&mode=edit&idfilm='.$oldmovieid.'">';
							
						}
					?>
							<button type="button" class="btn btn-success mr-3 ml-3" >
								Nuovo attore
							</button>
						</a>
						
					</div>
					<div class="card bg-secondary ">
					
					  <div class="card-body">
						<div class="col-lg-12">
						 <div class="form-group">
						<?php
							
							$data = getAllActors($conn);
							
							foreach($data as $attore){
								
								echo '	<div class="row">
											<div class="col-lg-8">
												<label class="checkbox" ><input type="checkbox" id="actors'.$attore['idattore'].'" name="attori[]" value="'.$attore['idattore'].'">'.'&nbsp;'.$attore['nome'].' '.$attore['cognome'].'</label>
											</div>
											<div class="col-lg-4 " >
												<select class="form-control mt-1"  id="ruolo'.$attore['idattore'].'" name="ruolo'.$attore['idattore'].'">
													<option value="Protagonista">Protagonista</option>
													<option value="Co-protagonista">Co-protagonista</option>
													<option value="Comparsa">Comparsa</option>
													<option value="Doppiatore">Doppiatore</option>
												</select>
											</div>
										</div>';
										
							}
							
							if($mode=='edit'){	
								$roles = getActors($conn,$oldmovieid);
								echo '<script>';
								foreach($roles as $role){
									
									echo '	$("#ruolo'.$role['idattore'].'").val("'.$role['ruolo'].'");';
									
								}
								
								foreach($actors as $actor)
									echo '$("#actors'.$actor[0].'").prop("checked",true);';
								
								echo '</script>';
							}
						?>
						
						 </div>
						</div>
						<div class="col-lg-6">
						</div>
					  </div>
					</div>
					
					<div class="row  mt-3 ml-1">
						
							<h3>Seleziona registi</h3>
							
							<?php
								if($_GET['mode']=='new'){
									echo'<a href="nuovaentita.php?entity=director&mode=new">';
								}else{
									echo'<a href="nuovaentita.php?entity=director&mode=edit&idfilm='.$oldmovieid.'">';
									
								}
							?>
								<button type="button" class="btn btn-success mr-3 ml-3" >
									Nuovo regista
								</button>
							</a>
						
					</div>
					<div class="card bg-secondary mt-2">
					  <div class="card-body">
						<div class="col-lg-6">
						 <div class="form-group">
						<?php
						
							$data = getAllDirectors($conn);
							
							foreach($data as $regista){
								
								echo '<label class="checkbox"><input type="checkbox" name="registi[]" id="director'.$regista['idregista'].'" value="'.$regista['idregista'].'">'.'&nbsp;'.$regista['nome'].' '.$regista['cognome'].'</label><br>';

							}
							
							if($mode=='edit'){	
								echo '<script>';
								
								foreach($directors as $director)
									echo '$("#director'.$director[0].'").prop("checked",true);';
								
								echo '</script>';
							}

						?>
						
						 </div>
						</div>
						<div class="col-lg-6">
						</div>
					  </div>
					</div>
					<div class="row  mt-3 ml-1">
						
							<h3>Seleziona generi</h3>
							<?php
								if($_GET['mode']=='new'){
									echo'<a href="nuovaentita.php?entity=genre&mode=new">';
								}else{
									echo'<a href="nuovaentita.php?entity=genre&mode=edit&idfilm='.$oldmovieid.'">';
									
								}
							?>
							<button type="button" class="btn btn-success mr-3 ml-3" >
								Nuovo genere
							</button>
							</a>
						
					</div>
					<div class="card bg-secondary mt-2">
					  <div class="card-body">
						<div class="col-lg-6">
						
						<div class="form-group">
						<?php
							$data = getAllGenres($conn);
							
							foreach($data as $genere){
								
								echo '<label class="checkbox"><input type="checkbox" name="generi[]" id="genre'.$genere['idgenere'].'" value="'.$genere['idgenere'].'">'.'&nbsp;'.$genere['genere'].'</label><br>';

							}
							
							if($mode=='edit'){	
								echo '<script>';
								
								foreach($genres as $genre)
									echo '$("#genre'.$genre[0].'").prop("checked",true);';
								
								echo '</script>';
							}

						?>
						
						 </div>
						</div>
						<div class="col-lg-6">
						</div>
					  </div>
					</div>
					<div class="row  mt-3 ml-1">
						
					<h3>Seleziona casa di produzione</h3>
						<?php
								if($_GET['mode']=='new'){
									echo'<a href="nuovaentita.php?entity=productionhouse&mode=new">';
								}else{
									echo'<a href="nuovaentita.php?entity=productionhouse&mode=edit&idfilm='.$oldmovieid.'">';
									
								}
							?>
						<button type="button" class="btn btn-success mr-3 ml-3" >
							Nuova casa di produzione
						</button>
						</a>
						
					</div>
					<div class="card bg-secondary mt-2">
					  <div class="card-body">
						<div class="col-lg-2">
							<div class="form-group">
							 <?php
							  echo '	<select class="form-control"  id="casaprod" name="casaproduzione">';
							  
											$data = getAllProductions($conn);
											
											foreach($data as $casaprod){
												echo '<option  value="'.$casaprod['idcasa'].'">'.$casaprod['nome'].'</option>';
												
											}
								
							  echo'		</select>';
							  
							   echo '<script>';
							 
								 echo '	$("#casaprod").val('.$productionhouse[0]['idcasa'].');';
							  echo '</script>';
							  ?>
							</div>
						
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