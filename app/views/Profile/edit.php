<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile edit</title>
</head>
<body>
	<h1>Edit Profile</h1>
    <a href="/Profile/index">Home</a><br><br>
	<?php

	if (isset($data['error'])) {
		echo "<h3>{$data['error']}</h3>";
	}

	?>
    <form action='' method='post'>
	First name: <input type='text' name='first_name' value='<?php echo $data['first_name']; ?>'/><br>
	Middle name: <input type='text' name='middle_name' value='<?php echo $data['middle_name'];?>'/><br>
	Last name: <input type='text' name='last_name' value='<?php echo $data['last_name'];?>'/><br>
	<input type='submit' name='action' value='Done' />
</form>
</body>
</html>