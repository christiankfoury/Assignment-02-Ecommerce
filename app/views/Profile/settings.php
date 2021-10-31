<!DOCTYPE html>
<html lang="en">

<head>
    <title>Settings</title>
</head>

<body>
    <?php
    echo "<h1>Settings for {$data['profile']->first_name} {$data['profile']->last_name}</h1>"
    ?>
    <a href="/Profile/index">Home</a><br><br>

    <h3>Password</h3>
    <a href="/User/changePassword">Change password</a><br><br>
    <h3>2-Factor authentication</h3>
    <a href="/User/createtwofa">Create or update your 2-factor authentication</a><br>
    <?php
    if (!$data['two_factor_authentication'] == '') {
        echo "<a href=\"/User/deletetwofa\">Delete 2 factor authentication</a><br>";
    }
    ?>

</body>

</html>