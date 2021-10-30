<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile Creation</title>
</head>
<body>
	<h1>Logged in! Profile Creation</h1>
    <form action='' method='post'>
	First name: <input type='text' name='first_name' value='<?php if (isset($data['first_name'])) echo $data['first_name']; ?>'/><br>
	Middle name: <input type='text' name='middle_name' value='<?php if (isset($data['middle_name'])) echo $data['middle_name'];?>'/><br>
	Last name: <input type='text' name='last_name' value='<?php if (isset($data['last_name'])) echo $data['last_name'];?>'/><br>
	<input type='submit' name='action' value='Done' />
</form>
</body>
</html>