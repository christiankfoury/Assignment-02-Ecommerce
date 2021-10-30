<!DOCTYPE html>
<html lang="en">

<head>
    <title>Notifications</title>
</head>

<body>
    <h1>Your Notifications</h1>
    <a href="/Profile/index">Home</a><br><br>
    <?php
    foreach ($data as $unseenLikes) {
        foreach ($unseenLikes as $unseenLike) {
            $picture = new \app\models\Picture();
            $picture = $picture->get($unseenLike->picture_id);

            $profile = new \app\models\Profile();
            $profile = $profile->getWithProfile($unseenLike->profile_id);

            echo "
            <table border=1>
                <tr>
                    <td>$profile->first_name $profile->last_name liked your picture.</td>
                    <td><img src=\"/uploads/$picture->filename\" width=100px></td>
                    <td><a href=\"/Profile/viewNotification/$unseenLike->picture_id/$unseenLike->profile_id\">View</td>
                </tr>
            </table>
            ";
        }
    }
    ?>
</body>

</html>