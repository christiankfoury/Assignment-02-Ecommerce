<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Post</title>
</head>
<body>
    <?php
    echo 
    "<form method='post'>
    <img src='/uploads/$data->filename' width='200px'><br>
    Caption: <input type='text' name='caption' value='$data->caption'><br>
    <input type='submit' name='action' value='Change'>
    </form>    
    ";
    ?>
</body>
</html>