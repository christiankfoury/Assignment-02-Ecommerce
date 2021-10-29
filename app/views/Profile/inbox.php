<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inbox</title>
</head>
<body>
    <h1>Welcome to your inbox.</h1>
    <br><br>
    <?php
    foreach ($data as $messages){

        $profile = new \app\models\Profile();
        $profile = $profile->get($messages->sender);
        echo "
        <table border=1>
        <tr>
            <th>Message from $profile->first_name $profile->last_name</th>
            <th><a href=''>Read</a></th>
        </tr>
        <tr>
            <td>$messages->message</td>
        </tr>
        </table>
        ";
    }
    ?>
</body>
</html>