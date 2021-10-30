<!DOCTYPE html>
<html lang="en">
<head>
    <title>Message</title>
</head>
<body>
    <?php
    $profile = new \app\models\Profile();
    $profile = $profile->get($data->sender);

    echo "<h1>Message from $profile->first_name $profile->last_name</h1>
          <p>$data->message</p> <br>
          <a href='/Profile/inbox'>Return to inbox</a>";

    ?>
</body>
</html>