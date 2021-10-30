<html>
<head>
	<title>Picture upload</title>
</head>
<body>
	<?php
		if($data['error'] != null){
			echo "<p>$data</p>";
		}

		// foreach($data['pictures'] as $picture)
		// 	echo "<img src='/uploads/$picture->filename'>"
	?>

	<h1>Upload a new picture</h1>
	<a href="/Profile/index">Home</a><br><br>
	<form method="post" enctype="multipart/form-data">
		Select an image file to upload:<input type="file" name="newPicture"><br>
        Caption: <input type="text" name="caption"><br>
		<input type="submit" name="action">
	</form>

</body>
</html>