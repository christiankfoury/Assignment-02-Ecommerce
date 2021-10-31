<html>
<head><title>Wall View</title></head><body>

<h1><?php echo "Welcome {$data['profile']->first_name} {$data['profile']->last_name}!"?></h1>
<form action='' method='post'>
	Search for a person: <input type="text" name="searchTextbox">
	<input type="submit" value="Search" name="search">
</form>
<a href="/Profile/logout">Logout</a><br>
<a href="/Profile/index">Home</a><br>
<a href="/Profile/editProfile">Edit Profile</a><br>
<a href="/Profile/settings">Settings (password, 2-FA)</a><br>
<a href="/Profile/inbox">View Inbox</a><br>
<a href="/Profile/outbox">View Outbox</a><br>
<a href="/Profile/notifications">Notifications: <?php echo $data['notificationsCount'] ?></a><br>

<h1>Wall View</h1>
<a href="/Picture/newPost">Make new post</a>

<h2>Images you posted</h2>

<?php
// FOR LIKES AND READ/UNREAD STATUS (LIKE/UNLIKE), EITHER PUT IN ARRAY AND  / 2 - 1 
// OR HAVE AN ARRAY OF 3 VALUES, 1RST THE IMAGE, 2ND NUMBER LIKES, 3RD READ/UNREAD/(LIKE/UNLIKE)
// 2nd method better in my opinion
for ($i = 0; $i < count($data['pictures']); $i++) {
	echo "
	<figure>
		<img src=\"/uploads/{$data['pictures'][$i]->filename}\" style='width:200px'>
  		<figcaption>{$data['pictures'][$i]->caption}</figcaption>
		<figcaption>{$data['likesNumber'][$i]['COUNT(*)']} like(s)</figcaption>
		<figcaption><a href=\"/Picture/editPost/{$data['pictures'][$i]->picture_id}\">edit</a> <a href=\"/Picture/deletePost/{$data['pictures'][$i]->picture_id}\">delete</a></figcaption>
	</figure><br>";
}
?>
<h2>Public messages you posted</h2>
<?php 
for ($i = 0; $i < count($data['messages']); $i++) {
	$time = new \app\controllers\Time();
	echo "
	<table border=1>
	<tr>
		<th>Message to {$data['profiles'][$i]->first_name} {$data['profiles'][$i]->last_name} at {$time::convertDateTime($data['messages'][$i]->timestamp)}</th>
	</tr>
	<tr>
		<td>{$data['messages'][$i]->message}</td>
	</tr>
	</table><br>";
}
?>

</body>
</html>