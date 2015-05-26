<?php 
	require_once("dbconnection.php");
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	/*
	* Logges the user in, this by comparing the the password entered with the password thats 
	* in the same row as the username in the database.
	* SQL injection proof
	*
	* @link Admin will be send to the admin page, other users will be send to the profile page.
	* @return session with loggend in username, user id and boolean: logged in.
	*/
	if ($_SERVER['REQUEST_METHOD'] == "POST"){

			$username = isset($_POST['username']) ? mysqli_real_escape_string($connection, strtolower($_POST['username'])) : '';
			$password = isset($_POST['password']) ? mysqli_real_escape_string($connection, md5($_POST['password'])) : '';

			$sql = "SELECT * FROM users WHERE username = '$username'";
			$result = mysqli_query($connection, $sql);
			$row = mysqli_fetch_array($result);

			if ($password == $row['password'])
			{
				$_SESSION['gebruiker_id'] = $row['id'];
			    $_SESSION['gebruiker'] = $username;
				$_SESSION['logged_in'] = true;
				if ($_SESSION['gebruiker'] == 'admin')
				{
					header('Location:adminpage.php');
		            echo '<h1>Welcome back admin, you will be sent to the adminpage in an instance!</h1>';
		        }
		        else
		        {
		        	header('Location:my_profile.php');
		            echo '<h1>You are succesfully logged in.</h1>';
		        }
			}	
			else
			{
				header('Refresh: 1; url=index.php');
			    echo "<h1>Wrong Username / Password</h1>";
			}
		}

?>
