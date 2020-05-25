<?php 
	require 'scripts/connection.php'; 
	session_start();
	
	if(!isset($_SESSION['username'])){
	  session_destroy();
	  header('Location:index.php');
	  
	}

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
						<a href="home.php"> <img src="images/mainlogo.png" style="width:100%" alt="mainlogo"/></a>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2"></div>
				</div>
			</div>
	
	</head>
	<body class="bg-dark">
		<div class="row">
			<div class="container text-white" >
				<div class="col-lg-2 col-md-2 col-sm-2">
				</div>
				<div class="col-lg-8 col-md-8 col-sm-8">
				<?php 
					$conn = connect(); 
					$data = getMovie($conn, $_GET['idfilm']);
					$deletedusers = getUserState($conn);
					$datauscita = $data[0]['datauscita'];
					$_SESSION['idfilm'] = $data[0]['idfilm'];
					echo '<div class="row">';
					echo '	<div class="col-lg-5 ">';
					echo '		<img style="max-width:100%;max-height:100%;" src="'.$data[0]['locandina'].'"/>';
					echo '	</div>';
					echo '	<div class="col-lg-6 " >';
					echo '		<h2>Scheda del film<br> "'.$data[0]['titolo'].'"</h2> ';
					echo '		<p>'.$data[0]['trama'].'</p>';
					echo '			<p><b>Diretto da:</b>';
									$data = getDirectors($conn, $_GET['idfilm']);
									foreach($data as $row){
										
										echo ' '.$row['nome'].' '.$row['cognome'].',';
										
									}
					echo '</p>';
					echo '			<p><b>Data di uscita:</b>';
									
									$yrdata= strtotime($datauscita);
									echo ' '.date('d F Y',$yrdata);
									
										
									
					echo '</p>';
					echo '			<p><b>Casa di produzione:</b>';
									$data = getProductionHouse($conn, $_GET['idfilm']);
									foreach($data as $row){
										
										echo ' '.$row['nome'].', '.$row['nazione'];
										
									}
					echo '</p>';
					echo '			<p><b>Cast:</b>';
									$data = getActors($conn, $_GET['idfilm']);
									foreach($data as $row){
										
										echo ' '.$row['nome'].' '.$row['cognome'].' ('.$row['ruolo'].'),';
										
									}
					echo '</p>';
					echo '			<p><b>Genere:</b>';
									$data = getGenres($conn, $_GET['idfilm']);
									foreach($data as $row){
										
										echo ' '.$row['genere'];
										
									}
									
					echo '</p>';
					$data = getRating($conn, $_GET['idfilm']);				
					echo '			<br><p><b>Giudizio:</b>';
									for($i=0; $i<5; $i = $i+1){
										$tempimg="";
										if($i<$data[0]['mediaGiudizi']){
											$tempimg="corncoloured";
										}else{
											$tempimg="corngrey";
										}			
										echo '		<img src="images/'.$tempimg.'.png" style="max-width:100%;max-height:100%;"/>';	
									}
					echo '</p>';
					echo '	</div>';
					echo '	<div class="col-lg-1 ">';
						if($_SESSION['amministratore']==1){
							echo '<a href="nuovofilm.php?mode=edit&movieid='.$_GET['idfilm'].'"><img  style="cursor:pointer;" id="editfilm'.$_GET['idfilm'].'" src="images/pencilwhite.png"/>&nbsp;&nbsp;</a>';
							echo '<a href="scripts/deletefilm.php?movieid='.$_GET['idfilm'].'"><img  style="cursor:pointer;" id="removefilm'.$_GET['idfilm'].'" src="images/crosswhite.png"/>&nbsp;&nbsp;</a>';
							
						}
					echo '  </div>';
					echo '</div>';		
					
				?>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2">
				</div>
			</div>
		</div>
		<div class="row mt-5"></div>
		<div class="container">
			<div class="row w-100">
				<div class="col-lg-2 col-md-2 col-sm-2"></div>
				<div class="col-lg-8 col-md-8 col-sm-8"></div>
							<?php
												
									$conn = connect();
									$data = getReviews($conn, $_GET['idfilm']);
									
									foreach($data as $row ){ 
										
									
										$comments = getComments($conn,$_GET['idfilm'],$row['username']);
										
										echo '<div class="card bg-secondary text-white w-100 mt-1" >
											  <div class="card-body">
												<div class="row">
													<div class="col-sm-8 col-md-8 col-lg-8">
													</div>
													<div class="col-sm-4 col-md-4 col-lg-4">';
										
											if($_SESSION['username']== $row['username']){
												
												echo '<img  style="cursor:pointer;" id="edit'.$_GET['idfilm'].$row['username'].'" src="images/pencil.png"/>&nbsp;&nbsp;';
												
											}
											
											if($_SESSION['username']== $row['username'] || $_SESSION['amministratore']==1){
											
												echo '<a id="delete'.$_GET['idfilm'].$row['username'].'" href="scripts/deletereview.php?movieid='.$_GET['idfilm'].'&usernamereview='.$row['username'].'"><img src="images/cross.png"/></a>';
												
											}
											if($_SESSION['username']!= $row['username']){
												$found = 0;
												foreach($deletedusers as $du){
													if($row['username']==$du['username'])
														$found = 1;
													
												}
												if($_SESSION['reputazione']>=0 && $found==0){
												
													
													echo '<a class="ml-1" href="scripts/updatevote.php?type=review&userlikes=up&user='.$row['username'].'&idfilm='.$_GET['idfilm'].'"><img src="images/thumbup.png"/>&nbsp;</a>'.$row['upvotes'].'&nbsp;&nbsp;';
													echo '<a href="scripts/updatevote.php?type=review&userlikes=down&user='.$row['username'].'&idfilm='.$_GET['idfilm'].'"><img src="images/thumbdown.png"/>&nbsp;</a>'.$row['downvotes'].'&nbsp;&nbsp;';
												}
												if($_SESSION['reputazione']<0 || $found==1){
													echo '<img style="opacity: 0.5;" src="images/thumbup.png"/>&nbsp;'.$row['upvotes'].'&nbsp;&nbsp;
														  <img style="opacity: 0.5;" src="images/thumbdown.png"/>&nbsp;'.$row['downvotes'].'&nbsp;&nbsp;';
													
												}
											}
											
										echo '			</div>';
										echo '		</div>';
										
										
										//JQuery che gestisce la comparsa e la scomparsa dell'editor delle recensioni
										echo '<script type="text/javascript">
											$( "#edit'.$_GET['idfilm'].$row['username'].'" ).unbind().click(function() {
										
												$("#'.$_GET['idfilm'].$row['username'].'").hide();
										
												$("#showcomments'.$_GET['idfilm'].$row['username'].'").hide();
												$("#newReview").hide();
												$("#edit'.$_GET['idfilm'].$row['username'].'").hide();
												$("#delete'.$_GET['idfilm'].$row['username'].'").hide();
												$("#rating'.$_GET['idfilm'].$row['username'].'").hide();
												$("#textarea'.$_GET['idfilm'].$row['username'].'").show();
												$("#reviewedit'.$_GET['idfilm'].$row['username'].'").val("'.$row['testo'].'");
												$("#ratingradio'.$_GET['idfilm'].$row['username'].'").show();
												$("#save'.$_GET['idfilm'].$row['username'].'").show();
												$("#cancel'.$_GET['idfilm'].$row['username'].'").show();
											});
										
											$(document).on ("click", "#cancel'.$_GET['idfilm'].$row['username'].'", function() {
									
												$("#'.$_GET['idfilm'].$row['username'].'").show();
												$("#showcomments'.$_GET['idfilm'].$row['username'].'").show();
												$("#newReview").show();
												$("#edit'.$_GET['idfilm'].$row['username'].'").show();
												$("#delete'.$_GET['idfilm'].$row['username'].'").show();
												$("#rating'.$_GET['idfilm'].$row['username'].'").show();
												$("#textarea'.$_GET['idfilm'].$row['username'].'").hide();
												$("#ratingradio'.$_GET['idfilm'].$row['username'].'").hide();
												$("#save'.$_GET['idfilm'].$row['username'].'").hide();
												$("#cancel'.$_GET['idfilm'].$row['username'].'").hide();
											});
										  </script>';												
										
										
										echo '		<div class="row">
													<div class="col-sm-12 col-md-12 col-lg-12" id="'.$_GET['idfilm'].$row['username'].'">
														<b>'.$row['username'].'</b><br>
															'.$row['testo'].'
													</div>
												<form action="scripts/editreview.php " class="w-100" method="post">
													<div class="col-sm-8 col-md-8 col-lg-8" style="display:none;" id="textarea'.$_GET['idfilm'].$row['username'].'">
														<textarea class="form-control" name="reviewedit" id="reviewedit'.$_GET['idfilm'].$row['username'].'" rows="4"></textarea>
													</div>
										
													<div class="col-sm-4 col-md-4 col-lg-4 mt-1" style="display:none;" name="ratingedit" id="ratingradio'.$_GET['idfilm'].$row['username'].'">
														<b>Valuta il film:</b>
														<label class="radio-inline"><input type="radio" value="1" name="ratingedit" checked>1</label>&nbsp;
														<label class="radio-inline"><input type="radio" value="2" name="ratingedit">2</label>&nbsp;
														<label class="radio-inline"><input type="radio" value="3" name="ratingedit">3</label>&nbsp;
														<label class="radio-inline"><input type="radio" value="4" name="ratingedit">4</label>&nbsp;
														<label class="radio-inline"><input type="radio" value="5" name="ratingedit">5</label>
													</div>
									
										
												</div>
												<div class="row align-items-end">
													<div class="col-sm-8 col-md-8 col-lg-8 mt-2">
													<button id="showcomments'.$_GET['idfilm'].$row['username'].'" style="border:none;  background-color: gainsboro; cursor:pointer;" class="btn btn-primary text-dark" type="button" data-toggle="collapse" data-target="#showcomments2'.$_GET['idfilm'].$row['username'].'" aria-expanded="false" aria-controls="showcomments">
														Mostra commenti
													 </button>
									
														<button  style="display:none;" id="save'.$_GET['idfilm'].$row['username'].'" class=" btn btn-success text-white" type="submit" aria-expanded="false" >
														Salva
													  </button>
										
													<button  style="display:none;" id="cancel'.$_GET['idfilm'].$row['username'].'" class=" btn btn-danger text-white" type="button"   aria-expanded="false" >
														Annulla
													  </button>
													</form>
														<div class="collapse" id="showcomments2'.$_GET['idfilm'].$row['username'].'">';
										
										
																	foreach($comments as $comment){
																		
										echo '						<div class="card bg-dark text-white mt-1" >
																	<div class="card-body">
																		<div class="row">';
										
																			if($_SESSION['username']== $comment['usernamecommento']){
																				
																				echo '<img width="20px" height="20px" style="cursor:pointer;" id="editcomment'.$comment['idcommento'].'" src="images/pencilwhite.png"/>&nbsp;&nbsp;';

																		
																			}
																			
																			if($_SESSION['username']== $comment['usernamecommento'] || $_SESSION['amministratore']==1){
																				echo '<a  id="deletecomment'.$comment['idcommento'].'" href="scripts/deletecomment.php?id='.$comment['idcommento'].'"><img width="20px" height="20px" src="images/crosswhite.png"/></a>';
																			}
																			if($_SESSION['username']!= $comment['usernamecommento']){
																				
																				$found = 0;
																				foreach($deletedusers as $du){
																					if($comment['usernamecommento']==$du['username'])
																						$found = 1;
																					
																				}
																				if($_SESSION['reputazione']>=0 && $found==0){
																					echo '<a class="ml-1" href="scripts/updatevote.php?type=comment&userlikes=up&idcommento='.$comment['idcommento'].'&usernamecommento='.$comment['usernamecommento'].'"><img src="images/thumbup.png"/>&nbsp;</a>'.$comment['upvotes'].'&nbsp;&nbsp;
																						  <a href="scripts/updatevote.php?type=comment&userlikes=down&idcommento='.$comment['idcommento'].'&usernamecommento='.$comment['usernamecommento'].'"><img src="images/thumbdown.png"/>&nbsp;</a>'.$comment['downvotes'].'&nbsp;&nbsp;';
																				}
																				if($_SESSION['reputazione']<0 || $found==1){
																					echo '<img style="opacity: 0.5;" src="images/thumbup.png"/>&nbsp;'.$comment['upvotes'].'&nbsp;&nbsp;
																					<img style="opacity: 0.5;" src="images/thumbdown.png"/>&nbsp;'.$comment['downvotes'].'&nbsp;&nbsp;';
																					
																				}
																			}//fine riga icone modifica e upvotes
																			
																			
										echo '								</div>
																		<div class="row mt-1" id="usernamecommento'.$comment['idcommento'].'">
																			<b>
																			'.$comment['usernamecommento'].'
																				
																			</b>
																		</div>
																		<div class="row" id="testocommento'.$comment['idcommento'].'">
																			'.$comment['testo'].'
																		</div>

																		<form action="scripts/editcomment.php?idcomm='.$comment['idcommento'].'" method="post">
																		
																			<div class="row w-100" style="display:none;" id="editorcommento'.$comment['idcommento'].'">
																				<div class="col-sm-12 w-100">
																					<textarea class="form-control " name="commentedit" id="comment'.$comment['idcommento'].'" rows="2"></textarea>
																				</div>
																			</div>
																			<div class="row mt-2" style="display:none;" id="bottonicommento'.$comment['idcommento'].'">
																				<div class="col-sm-6">
																					<button  id="salvacommento'.$comment['idcommento'].'" class=" btn btn-success text-white" type="submit" aria-expanded="false" >
																						Salva
																					</button>
										
																					<button   id="cancelcommento'.$comment['idcommento'].'" class=" btn btn-danger text-white" type="button"   aria-expanded="false" >
																						Annulla
																					</button>
																				</div>
																				<div class="col-sm-6"></div>

																			</div>
																		</form>
																	</div>
																</div>'; //fine card
										
										
										//JQuery script che gestirà la comparsa e la scomparsa dell'editor dei commenti	
										echo '						<script type="text/javascript">
																		$( "#editcomment'.$comment['idcommento'].'" ).unbind().click(function() {
																		$("#editcomment'.$comment['idcommento'].'").hide();							
																		$("#deletecomment'.$comment['idcommento'].'").hide();	
																		$("#usernamecommento'.$comment['idcommento'].'").hide();		
																		$("#testocommento'.$comment['idcommento'].'").hide();
																		$("#newcomment'.$_GET['idfilm'].$row['username'].'").hide();	
																		$("#comment'.$comment['idcommento'].'").val("'.$comment['testo'].'");													
																		$("#editorcommento'.$comment['idcommento'].'").show();
																		$("#bottonicommento'.$comment['idcommento'].'").show();
																	});
											
																	$(document).on ("click", "#cancelcommento'.$comment['idcommento'].'", function() {
																		$("#editcomment'.$comment['idcommento'].'").show();							
																		$("#deletecomment'.$comment['idcommento'].'").show();		
																		$("#usernamecommento'.$comment['idcommento'].'").show();	
																		$("#testocommento'.$comment['idcommento'].'").show();	
																		$("#newcomment'.$_GET['idfilm'].$row['username'].'").show();
																		$("#editorcommento'.$comment['idcommento'].'").hide();
																		$("#bottonicommento'.$comment['idcommento'].'").hide();
											
																	});

																</script>';		
																	}//fine foreach commenti
																	
										if($_SESSION['reputazione']>=-0.3 || in_array($comment['usernamecommento'],$deletedusers)){		
										
											echo '						<div class="card bg-dark text-white mt-1" id="newcomment'.$_GET['idfilm'].$row['username'].'">
																		<div class="card-body">
																			<div class="row">
																				<b>Scrivi un commento</b>
																			</div>
																			<div class="row ">
																			<form class="form-group w-100" action="scripts/sendcomment.php?usernamereview='.$row['username'].'" method="post">
																				<div class="form-group mt-1">
																					<textarea class="form-control " name="comment" id="comment" rows="2"></textarea>
																				</div>
																			</div>
																			<div class="row">
																					<button type="submit" name="submit" class="btn btn-success">Invia</button>
										
																			</div>
																			</form>
																		</div>
																	</div>'; //fine div inserimento commento
										}
										
										echo '				</div>';
										echo '			</div>';
										echo '			<div class="col-sm-4 col-md-4 col-lg-4" id="rating'.$_GET['idfilm'].$row['username'].'">';
																for($i=0; $i<5; $i = $i+1){
																	if($i<$row['giudizio']){
										echo '							<img src="images/corncoloured.png" width="40px" height="40px"/>';
																	}else{
										echo '							<img src="images/corngrey.png" width="40px" height="40px"/>';	
																		}							
																	}
										echo '			</div>
												</div>
											</div>
										</div>';
									}  //fine foreach recensioni
											
							
						$nreviews= getReviewsByUser($conn,$_SESSION['username'],$_GET['idfilm']);
													
						if(intval($nreviews[0][0])==0 && $_SESSION['reputazione']>=0.3){	
							echo '<div class="card bg-secondary text-white w-100 mt-1" id="newReview">
								<form action="scripts/sendreview.php" method="post">
									<div class="card-body">
										<div class="row">
													<div class="col-sm-12 col-md-12 col-lg-12">	
														<b>Tu</b><br>
												
														<div class="form-group w-100 mt-1">
															<textarea class="form-control" name="review" id="review" rows="4"></textarea>
														</div>
														
											  </div>
										</div>
										<div class="row">
											<div class="col-sm-8 col-md-8 col-lg-8">	
												<button type="submit" name="submit" class="btn btn-success">Invia</button>
											</div>
											<div class="col-sm-4 col-md-4 col-lg-4">
												<b>Valuta il film:</b>
												<label class="radio-inline"><input type="radio" value="1" name="rating" checked>1</label>&nbsp;
												<label class="radio-inline"><input type="radio" value="2" name="rating">2</label>&nbsp;
												<label class="radio-inline"><input type="radio" value="3" name="rating">3</label>&nbsp;
												<label class="radio-inline"><input type="radio" value="4" name="rating">4</label>&nbsp;
												<label class="radio-inline"><input type="radio" value="5" name="rating">5</label>
											</div>
										</div>
									</div>
								</form>
								</div>';
						}
						?>
					<div class="col-lg-2 col-md-2 col-sm-2"></div>
			</div>
		</div>
	</body>
</html>