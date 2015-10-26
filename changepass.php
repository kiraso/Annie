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
Change Password form
<hr>
<?PHP
if(isset($_POST['Back'])){
	echo '<script>window.location = "MemberPage.php";</script>';
}
	
?>
<?PHP
	if(isset($_POST['submit'])){
		$Oldpassword= trim($_POST['Oldpassword']);
		$Newpassword = trim($_POST['Newpassword']);
		$Confirm = trim($_POST['Confirmpass']);
		if($Newpassword == $Confirm){
		$query = "SELECT * FROM LOGIN WHERE PASSWORD='$Oldpassword'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row){
			$query1 = "UPDATE LOGIN SET PASSWORD = '$Newpassword' WHERE PASSWORD='$Oldpassword'";
			$parseRequest1 = oci_parse($conn, $query1);
			oci_execute($parseRequest1);
			
			echo '<script>window.location = "MemberPage.php";</script>';
		}else{
			echo "ChangePass fail.";
			}}else{ 
			echo "ChangePass fail.";
			}
			
	};
	oci_close($conn);
?>

<form action='changepass.php' method='post'>
	Oldpassword <br>
	<input name='Oldpassword' type='input'><br>
	NewPassword<br>
	<input name='Newpassword' type='password'><br><br>
	Confirm<br>
	<input name='Confirmpass' type='password'><br><br>
	<input name='submit' type='submit' value='Confirm'>
	<input name='Back' type='submit' value='Back'>
</form>
