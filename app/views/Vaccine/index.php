<html>
<head><title>Vaccine index - for an animal</title></head><body>

<a href="/Vaccine/insert/<?php echo $data['animal']->animal_id; ?>">Create a new vaccine</a>

<?php $this->view('Main/details',$data['animal']); //call the animal details view ?>

<table>
	<tr><th>Type</th><th>Date</th><th>actions</th></tr>
<?php
foreach($data['vaccines'] as $vaccine){

	echo "<tr>
			<td>$vaccine->type</td>
			<td>$vaccine->date</td>
			<td>
				<a href='/Vaccine/details/$vaccine->vaccine_id'>details</a> | 
				<a href='/Vaccine/edit/$vaccine->vaccine_id'>edit</a> | 
				<a href='/Vaccine/delete/$vaccine->vaccine_id'>delete</a>
			</td>
		</tr>";
}
?>
</table>
</body>
</html>