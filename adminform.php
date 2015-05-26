<?php
	session_start();
	require_once("dbconnection.php");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	// Controleren of de bezoeker ingelogd is 
	if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) 
	{
	    header("Location: index.php");
	}
?>

<div id="adminForm">
	<h3>Add picture</h3>
	<form action="adminpage.php" method="post" enctype="multipart/form-data">
		<input type="file" name="upload"/>
		<select name="fileCategory">
		<option value="abstract">Abstract</option>
		<option value="gamechar">Game Characters</option>
		<option value="festivals">Festivals</option>
		</select>
		<button type="submit" name="submitUpload">Upload</button>
	</form>
	<?php
		include("upload.php");
	?>
	
	<h3>Remove picture</h3>
	<form action="adminpage.php" method="post">
		<?php
		//Selecteer alle plaatjes van de tabel photos en zet deze in een list box.
		$sql = "SELECT `urlpath` FROM `photos`";
		echo "<select name=picOption value=''>Photos</option>"; // list box select command
		foreach ($connection->query($sql) as $row)
		{//Array or records stored in $row
			echo "<option value=$row[urlpath]>$row[urlpath]</option>"; 
		}
		echo "</select>";// Closing of list box
		?>
		<button type="submit" name="delete" >Delete Pic</button>
	</form>
	
	<h3>Delete users</h3>
	<form action="adminpage.php" method="post">
		<?php
		//Selecteer alle gebruikers uit de tabel users en zet deze in een list box.
		$sql = "SELECT `username` FROM `users` WHERE `username`!='admin'";
		echo "<select name=userOption value=''>Username</option>";
		foreach ($connection->query($sql) as $row)
		{//Array or records stored in $row
			echo "<option value=$row[username]>$row[username]</option>"; 
		}
		echo "</select>";// Closing of list box
		?>
		<button type="submit" name="delete" >Delete User</button>
	</form>
	<?php
	
	/*
	* verwijdert de geslecteerde gebruiker uit de database.
	*
	* @return Gebruiker is verwijdert
	*/
	if (isset($_POST['delete']))
	{
		$selectOption = $_POST['userOption'];
		$sqlDeleteUser = "DELETE FROM `i272815_studie`.`users` WHERE `users`.`username` = '$selectOption';";
		$result = mysqli_query($connection, $sqlDeleteUser);
		header("Refresh: 2; url=adminpage.php");
		echo "<h3>De gebruiker is verwijdert.</h3>";
	}
	
	/*
	* verwijdert de geslecteerde afbeelding uit de database.
	*
	* @return Afbeelding is verwijdert
	*/
	if (isset($_POST['deleteImg']))
	{
		$selectpOption = $_POST['picOption'];
		$sqlDeletePic = "DELETE FROM `i272815_studie`.`photos` WHERE `photos`.`urlpath` = '$selectpOption';";
		$result = mysqli_query($connection, $sqlDeletePic);
		header("Refresh: 2; url=adminpage.php");
		echo "<h2>De afbeelding is verwijdert uit de databank</h2>";

	}
?>
</div>

