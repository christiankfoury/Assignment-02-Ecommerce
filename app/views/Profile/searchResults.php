<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Results</title>
</head>
<body>
    <h1>User Results</h1>
    <?php
    foreach ($data as $result){
        echo "<a href='/Profile/wall/$result->profile_id'>$result->first_name $result->last_name</a><br>";
    }
    ?>
</body>
</html>