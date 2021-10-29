<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wall View</title>
</head>
<body>
<h1><?php echo "{$data['profile']->first_name} {$data['profile']->last_name}'s wall"?></h1>

<h1>Wall View</h1>
<a href="/Message/createMessage/<?php echo $data['profile']->profile_id;?>">Message user</a>

<h2>Images</h2>

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
<h2>Public messages</h2>
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