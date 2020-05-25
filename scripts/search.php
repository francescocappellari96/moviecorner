
<?php
	
	session_start();
	$order;
	if(isset($_POST["restriction"]))
		$_SESSION['restriction'] = $_POST["restriction"];

	if(isset($_POST["name"]))
		$order = 'name';
	else
		$order = 'rating';
	
	if(isset($_POST["rating"]))
		$order = 'rating';
	else
		$order = 'name';
	

	
	if(isset($_SESSION['restriction']) && $_SESSION['restriction']!='')
		header('Location:../home.php?orderby='.$order.'&restriction='.$_SESSION['restriction']);
	else
		header('Location:../home.php?orderby='.$order);
	

?>