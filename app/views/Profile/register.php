<html>
<head><title>Register</title></head><body>
<h1>Register a new user</h1>
<?php 
if ($data != null) {
	echo "<h3>$data</h3>";
}
?>
<form action='' method='post'>
	Username: <input type='text' name='username' /><br>
	Password: <input type='password' name='password' /><br>
	Password confirmation: <input type='password' name='password_confirm' /><br>
	<input type='submit' name='action' value='Register' />
</form>
<a href="/Profile/login">Login Here</a>

</body></html>