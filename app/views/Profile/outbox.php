<!DOCTYPE html>
<html lang="en">
<head>
    <title>Outbox</title>
</head>
<body>
    <h1>Welcome to your Outbox</h1>

    <?php
    for ($i = 0; $i < count($data['messages']); $i++) {
        $time = new \app\controllers\Time();
        //$message_id = $data['messages->message_id'];
        echo "
        <table border=1>
        <tr>
            <th>Message to {$data['profiles'][$i]->first_name} {$data['profiles'][$i]->last_name} at {$time::convertDateTime($data['messages'][$i]->timestamp)}</th>
            <td><a href=\"/Message/deleteMessage/{$data['messages'][$i]->message_id}\">Delete</a>
        </tr>
        <tr>
            <td>{$data['messages'][$i]->message}</td>
        </tr>
        </table><br>";
    }
    ?>
    <a href="/Profile/index/<?php echo $data['profile_id']?>">Return to home</a>
</body>
</html>