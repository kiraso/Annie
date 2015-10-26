<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "123456", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
Login form
<hr>

<?PHP
	if(isset($_POST['submit'])){
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$capcha = trim($_POST['capcha']);
			if($capcha == "AnnieIsHappy"){		
		$query = "SELECT * FROM LOGIN WHERE USERNAME='$username' and PASSWORD='$password'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row){
			$_SESSION['ID'] = $row['ID'];
			$_SESSION['NAME'] = $row['NAME'];
			$_SESSION['SURNAME'] = $row['SURNAME'];
			
			echo '<script>window.location = "MemberPage.php";</script>';
		}else{
			echo "Login fail.";
			}}else{ 
			echo "Login fail.";
			}
			
	};
	oci_close($conn);
?>

<form action='login.php' method='post'>
	Username <br>
	<input name='username' type='input'><br>
	Password<br>
	<input name='password' type='password'><br><br>
	capcha = AnnieIsHappy<br>
	<input name='capcha' type='input'><br><br>
	<input name='submit' type='submit' value='Login'>
</form>
