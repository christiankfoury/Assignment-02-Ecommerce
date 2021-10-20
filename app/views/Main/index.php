<html>
<head><title>Animal index</title></head><body>

<a href="/Main/insert">Create a new animal</a>
<table>
	<tr><th>Species</th><th>Colour</th><th>actions</th></tr>
<?php
foreach($data as $animal){

	echo "<tr>
			<td>$animal->species</td>
			<td>$animal->colour</td>
			<td>
				<a href='/Main/details/$animal->animal_id'>details</a> | 
				<a href='/Main/edit/$animal->animal_id'>edit</a> | 
				<a href='/Main/delete/$animal->animal_id'>delete</a> |
				<a href='/Vaccine/index/$animal->animal_id'>vaccination</a>
			</td>
		</tr>";
}
?>
</table>
</body>
</html>