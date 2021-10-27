<!DOCTYPE html>
<html lang="en">

<head>
    <title>Settings</title>
</head>

<body>
    <?php
    echo "<h1>Password change for {$data['profile']->first_name} {$data['profile']->last_name}</h1>"
    ?>

    <?php
    if (isset($data['error'])) {
        echo $data['error'];
    }
    ?>

    <form action='' method='post'>
        Current password: <input type='password' name='current_password' /><br>
        New Password: <input type='password' name='new_password' /><br>
        Password confirmation: <input type='password' name='password_confirm' /><br>
        <input type='submit' name='action' value='Update' />
    </form>
</body>

</html>