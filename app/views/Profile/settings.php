<!DOCTYPE html>
<html lang="en">
<head>
    <title>Settings</title>
</head>
<body>
    <?php
    echo "<h1>Settings for $data->first_name $data->last_name</h1>"
    ?>

    <a href="/User/changePassword">Change password</a><br>
    <a href="/User/twofa">Two-factor authentication token</a>
</body>
</html>