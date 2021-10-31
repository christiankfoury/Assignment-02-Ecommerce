<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile Creation</title>
</head>
<body>
	<h1>Logged in! Profile Creation</h1>
	<?php

	if (isset($data['error'])) {
		echo "<h3>{$data['error']}</h3>";
	}

	?>
    <form action='' method='post'>
	First name: <input type='text' name='first_name'/><br>
	Middle name: <input type='text' name='middle_name'/><br>
	Last name: <input type='text' name='last_name'/><br>
	<input type='submit' name='action' value='Done' />
</form>
</body>
</html>