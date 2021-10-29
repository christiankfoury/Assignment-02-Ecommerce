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
        if($messages->read_status == "to_reread"){
            $messages->read_status = "to reread";
        }        
        echo "
        <table border=1>
        <tr>
            <th>Message from $profile->first_name $profile->last_name ($messages->read_status)</th>
            <th><a href='/Message/readMessage/$messages->message_id'>Read</a></th>
            <th><a href='/Message/toRereadMessage/$messages->message_id'>Reread</a></th>
        </tr>
        <tr>
            <td>$messages->message</td>
        </tr>
        </table>
        <br>
        ";
    }
    
    ?>
</body>
</html>