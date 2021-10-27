<html>
<head><title>Wall View</title></head><body>

<h1><?php echo "Welcome {$data['profile']->first_name} {$data['profile']->last_name}!"?></h1>
<form action='' method='post'>
	Search for a person: <input type="text" name="searchTextbox">
	<input type="submit" value="Search" name="search">
</form>
<a href="/Profile/logout">Logout</a><br>
<a href="/Profile/index/<?php echo $data['profile']->profile_id; ?>">Home</a><br>
<a href="/Profile/editProfile">Edit Profile</a><br>
<a href="/Profile/settings">Settings (password, 2-FA)</a><br>
<a href="/Profile/inbox">View Inbox</a><br>
<a href="/Profile/outbox">View Outbox</a><br>
<a href="/Profile/newMessage">Create new message</a><br>
<a href="/Profile/notifications">View notifications</a><br>
<!-- use session variables as global variable -->
<?php echo $_SESSION['user_id']?>

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
		<figcaption></figcaption>
	</figure><br>";
}
?>
<h2>Public messages you posted</h2>


</body>
</html>