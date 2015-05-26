<?php  
	// toon error report
  ini_set('display_errors',1);
  error_reporting(E_ALL);

	require_once('dbconnection.php');


	/*
	* Registers new users
	*
	* @return Deze functie voegt door middel van de gegeven informatie die gebruikers in het
	*registratie formulier invullen een nieuwe gebruiker toe aan de database.
	*Er wordt gecheckt of de gebruiker al bestaat in de database.
	*Het wachtwoord wordt encrypted opgeslagen in de database.
	*/
	if ($_SERVER['REQUEST_METHOD'] == "POST"){
		$length = 16; // 16 Chars long
		$key = "";
		for ($i=1;$i<=$length;$i++) {
    	// Alphabetical range
        	$alph_from = 65;
            $alph_to = 90;

        // Numeric
            $num_from = 48;
            $num_to = 57;

        // Add a random num/alpha character
            $chr = rand(0,1)?(chr(rand($alph_from,$alph_to))):(chr(rand($num_from,$num_to)));
            if (rand(0,1)) $chr = strtolower($chr);
            $key.=$chr; 
		}

		$username = isset($_POST['gebruikersnaam']) ? mysqli_real_escape_string($connection , strtolower(strip_tags($_POST['gebruikersnaam']))) : '';
		$password = isset($_POST['wachtwoord']) ? mysqli_real_escape_string($connection ,md5($_POST['wachtwoord'])) : '';
		$surname = isset($_POST['voornaam']) ? mysqli_real_escape_string($connection ,strip_tags($_POST['voornaam'])) : '';
		$email = isset($_POST['email']) ? mysqli_real_escape_string($connection ,strip_tags($_POST['email'])) : '';
		$lastname = isset($_POST['achternaam']) ? mysqli_real_escape_string($connection ,strip_tags($_POST['achternaam'])) : '';
		$birthYear = isset($_POST['geboortejaar']) ? $_POST['geboortejaar'] : '';
		$apikey = $key;
		
		$sql1 = "SELECT * FROM users WHERE username = '$username'";
		$result = mysqli_query($connection, $sql1);
		$row = mysqli_fetch_array($result);

		if ($username == $row['username'])
		{
			echo "<h2>Deze username bestaat al.</h2>";
			header('Refresh: 2; url=index.php');
		}
		else
		{
			$sql = "INSERT INTO `i272815_studie`.`users` (`id`, `username`, `firstname`, `lastname`, `e-mail`, `birthdate`, `password`, `apikey`) VALUES (NULL, '$username', '$surname', '$lastname', '$email', '$birthYear', '$password', '$apikey');";
			
			$conn = mysqli_query($connection, $sql);

			header('Refresh: 2; url=index.php');
			echo "<h2>You are succesfully registered!</h2>";
		}
	}

?>
