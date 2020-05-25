<?php

	
	function connect(){
		
		$credentials = parse_ini_file("config.ini");
		$servername = $credentials["servername"];
		$username = $credentials["username"];
		$password = $credentials["password"];
		
		try{
			$conn = new PDO("mysql:host=$servername;dbname=progettoBasi", $username, $password);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		}
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
		
	}
	
	
	function getUsers($connection){
		
		$sql = 'select * from utentiregistrati';
		
		return executeQuery($connection,$sql);
	}
	
	function getReputation($connection,$username){
		
		$sql = 'select reputazione from utentiregistrati where username="'.$username.'"';
		
		return executeQuery($connection,$sql);
	}
	
	function addUser($connection,$data){
		
		$sql = 'insert into progettobasi.utentiregistrati values (?,?,?,?,?,?,0)';
		$statement= $connection->prepare($sql);
		$statement->execute($data);
		
		
	}
	
	function addReview($connection,$data){
		
		$sql = 'insert into recensioni values (?,?,?,?,?,?)';
		$statement= $connection->prepare($sql);
		$statement->execute($data);
		
		
	}

	function editReview($connection,$data){
		
		$sql = 'update  recensioni set testo = ?, giudizio = ? where username=? and idfilm = ?';
		$statement= $connection->prepare($sql);
		$statement->execute($data);
		
		
	}
	
	function editRoles($connection,$data){
		
		$sql = 'update utentiregistrati set amministratore = 1 where username=?';
		$statement= $connection->prepare($sql);
		$statement->execute($data);
		
		
	}
	
	function setRolesToZero($connection,$data){
		
		$sql = 'update utentiregistrati set amministratore = 0';
		$statement= $connection->prepare($sql);
		$statement->execute($data);
		
		
	}
	
	function editFilm($connection,$data){
		
		$sql = 'update film set titolo = ?, durata = ?, datauscita=?, idcasa=?, locandina=?, trama=? where idfilm = ?';
		$statement= $connection->prepare($sql);
		$statement->execute($data);
		
		
	}
	
	function updateRep($connection,$data){
		
		$sql = 'update utentiregistrati set reputazione = reputazione + ? where username=? ';
		$statement= $connection->prepare($sql);
		$statement->execute($data);
		
	}

	function editComment($connection,$data){
		
		$sql = 'update commenti set testo = ? where idcommento=? ';
		$statement= $connection->prepare($sql);
		$statement->execute($data);
		
		
	}
	
	function deleteReview($connection,$data){
		
		$sql = "delete from recensioni where username=? and idfilm = ?";
		
		$statement= $connection->prepare($sql);
		$statement->execute($data);
	}
	
	
	function deleteUser($connection,$data){
		
		$sql = "update utentiregistrati set deleted = 1 where username=? ";
		
		$statement= $connection->prepare($sql);
		$statement->execute($data);
	}
	
	function deleteGenresFilm($connection,$data){
		
		$sql = "delete from generifilm where idfilm = ?";
		
		$statement= $connection->prepare($sql);
		$statement->execute($data);
	}
	
	function deleteActorsFilm($connection,$data){
		
		$sql = "delete from tipoattore where idfilm = ?";
		
		$statement= $connection->prepare($sql);
		$statement->execute($data);
	}
	
	function deleteDirectorsFilm($connection,$data){
		
		$sql = "delete from registifilm where idfilm = ?";
		
		$statement= $connection->prepare($sql);
		$statement->execute($data);
	}
	
	function deleteFilm($connection,$data){
		
		$sql = "delete from film where idfilm = ?";
		
		$statement= $connection->prepare($sql);
		$statement->execute($data);
	}
	
	function deleteComment($connection,$data){
		
		$sql = "delete from commenti where idcommento = ?";
		
		$statement= $connection->prepare($sql);
		$statement->execute($data);
	}
	
	
	function updateVote($connection,$data,$state,$type){
		$sql = "";
		
		if($state == 'up'){
			if($type=='review')
				$sql = "update recensioni set upvotes = upvotes + 1 where username=? and idfilm = ?";
			else
				$sql = "update commenti set upvotes = upvotes + 1 where idcommento=?";
		}else{
			if($type=='review')
				$sql = "update recensioni set downvotes = downvotes + 1 where username=? and idfilm = ?";
			else
				$sql = "update commenti set downvotes = downvotes + 1 where idcommento=?";
		}

		$statement= $connection->prepare($sql);
		$statement->execute($data);
		
	}
	
	function getMovieList($connection,$orderby,$restriction){
			
		
			$sql = "select film.*,AVG(recensioni.giudizio) as mediaGiudizi from film left join recensioni on film.idfilm = recensioni.idfilm ";
			$sql = $sql." where film.titolo like '%".$restriction."%' ";
			$sql = $sql." group by (film.idfilm)";
			 
			if($orderby=='rating'){
				$sql = $sql." order by mediaGiudizi DESC";
			}else if($orderby=='name'){
				$sql = $sql." order by titolo ASC";
			}
		
		return executeQuery($connection,$sql);
	}
	
	
	
	function getAllActors($connection){
			
		
		$sql = "select * from attori ";

		return executeQuery($connection,$sql);
	}
	
	
	
	function addComment($connection,$data){
		
		$sql = 'insert into commenti (usernamecommento,username,testo,idfilm,upvotes,downvotes) values(?,?,?,?,0,0)';
		$statement= $connection->prepare($sql);
		$statement->execute($data);
		
	}
	
	function addFilm($connection,$data){
		
		$sql = 'insert into film (titolo,durata,datauscita,idcasa,username,locandina,trama) values(?,?,?,?,?,?,?)';
		$statement= $connection->prepare($sql);
		$statement->execute($data);
		
		
	}
	
	
	function addActorsToFilm($connection,$data){
		
		$sql = 'insert into tipoattore (ruolo,idfilm,idattore) values(?,?,?)';
		$statement= $connection->prepare($sql);
		$statement->execute($data);

	}
	
	function addActor($connection,$data){
		
		$sql = 'insert into attori (nome,cognome,datanascita) values(?,?,?)';
		$statement= $connection->prepare($sql);
		$statement->execute($data);

	}
	
	function addDirector($connection,$data){
		
		$sql = 'insert into registi (nome,cognome,datanascita) values(?,?,?)';
		$statement= $connection->prepare($sql);
		$statement->execute($data);

	}
	
	
	function addGenre($connection,$data){
		
		$sql = 'insert into generi (genere) values(?)';
		$statement= $connection->prepare($sql);
		$statement->execute($data);

	}
	
	function addProductionHouse($connection,$data){
		
		$sql = 'insert into caseproduzione (nome,nazione) values(?,?)';
		$statement= $connection->prepare($sql);
		$statement->execute($data);

	}
	function addDirectorsToFilm($connection,$data){
		
		$sql = 'insert into registifilm (idfilm,idregista) values(?,?)';
		$statement= $connection->prepare($sql);
		$statement->execute($data);

	}
	
	function addGenresToFilm($connection,$data){
		
		$sql = 'insert into generifilm (idfilm,idgenere) values(?,?)';
		$statement= $connection->prepare($sql);
		$statement->execute($data);

	}
	
	function getLastInsertId($connection){
		$sql = 'select last_insert_id()';
		
		return executeQuery($connection,$sql);
	}
	
	
	
	function getComments($connection,$idfilm,$username){
			
		$sql = "select * from commenti where username='".$username."' and idfilm=".$idfilm;

		return executeQuery($connection,$sql);
	}
	
	
	function getMovie($connection,$id){
		
		$sql='select * from film where idfilm ='.$id;
		return executeQuery($connection,$sql);

		
	}
	
	function getReviews($connection,$id){
		
		$sql='select * from recensioni where idfilm ='.$id;
		return executeQuery($connection,$sql);
		
	}
	
	function getUserState($connection){
		
		$sql='select * from utentiregistrati where deleted = 1';
		return executeQuery($connection,$sql);
	}
	
	function getReviewsByUser($connection,$username,$id){
		
		$sql='select count(*) from recensioni where username ="'.$username.'" and idfilm='.$id;
		return executeQuery($connection,$sql);
		
	}
	
	function getProductionHouse($connection,$id){
		
		$sql='select  caseproduzione.idcasa,nome,nazione from film inner join caseproduzione on caseproduzione.idcasa = film.idcasa and film.idfilm = '.$id;
		return executeQuery($connection,$sql);

	}
	
	
	
	function getGenres($connection,$id){
	
		$sql='select * from generi inner join generifilm on generi.idgenere = generifilm.idgenere where generifilm.idfilm = '.$id;
		return executeQuery($connection,$sql);
		
	}
	
	
	function getDirectors($connection,$id){
		
		$sql='select  * from registi inner join registifilm on registifilm.idregista = registi.idregista and registifilm.idfilm ='.$id;
		return executeQuery($connection,$sql);

		
	}
	
	
	function getActors($connection,$id){
		
		$sql='select * from attori join tipoattore on attori.idattore = tipoattore.idattore where tipoattore.idfilm='.$id;
		return executeQuery($connection,$sql);
	}
	
	
	
	function getAllDirectors($connection){
		
		$sql='select  * from registi';
		return executeQuery($connection,$sql);

		
	}
	
	function getAllProductions($connection){
		
		$sql='select  * from caseproduzione';
		return executeQuery($connection,$sql);

		
	}
	
	function getAllGenres($connection){
		
		$sql='select  * from generi';
		return executeQuery($connection,$sql);

		
	}
	
	function getRating($connection,$id){
		
		$sql='select AVG(recensioni.giudizio) as mediaGiudizi from film left join recensioni on film.idfilm = recensioni.idfilm where film.idfilm='.$id.' group by (film.idfilm)';
		return executeQuery($connection,$sql);

		
	}
	
	
	function executeQuery($connection,$sql){
		$array = array();
		foreach($connection->query($sql) as $row){
				$array[] = $row;
				
			}
			return $array;
		
	}

?>