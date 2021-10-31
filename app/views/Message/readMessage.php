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
          <table border=1><tr><td><p>$data->message</p></td></tr></table> </table>
          <br>
          <a href='/Profile/inbox'>Return to inbox</a>";

    ?>
</body>
</html>