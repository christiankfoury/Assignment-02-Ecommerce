<html>
<head><title>Animal index</title></head><body>

<form action='' method='post'>
	Search for a person: <input type="text" name="searchTextbox">
	<input type="submit" value="Search" name="search">
</form>
<a href="/Profile/logout">Logout</a><br>
<a href="/Profile/editProfile">Edit Profile</a><br>
<a href="/Profile/settings">Settings (password, 2-FA)</a><br>
<a href="/Profile/inbox">View Inbox</a><br>
<a href="/Profile/outbox">View Outbox</a><br>
<a href="/Profile/notifications">View notifications</a><br>
<!-- use session variables as global variable -->
<?php echo $_SESSION['user_id']?>

<h1>Wall View</h1>
<a href="/Picture/newPost">Make new post</a>

<h2>Images of profile id<?php echo $data['profile_id']?></h2>
<h2>Public messages of profile id<?php echo $data['profile_id']?></h2>


</body>
</html>