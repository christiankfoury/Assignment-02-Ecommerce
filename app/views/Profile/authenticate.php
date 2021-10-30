<!DOCTYPE html>
<html lang="en">

<head>
    <title>2-Factor authentication</title>
</head>

<body>
    <h1>2-factor authentication</h1>
    <?php 
    if (isset($data)) {
        echo "<h3>$data</h3>";
    }
    ?>
    <form method="post" action="">
        <label>Current code:<input type="text" name="currentCode" /></label>
        <input type="submit" name="action" value="Verify code" />
    </form>
</body>

</html>