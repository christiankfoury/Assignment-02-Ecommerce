<html>
<head><title>Add a Vaccine</title></head><body>

<?php $this->view('Main/details',$data); //call the animal details view ?>

Adding a vaccine for  
<?php echo $data->colour, " ", $data->species; ?>

<form action='' method='post'>
	Vaccine type: <input type='text' name='type' /><br>
	Vaccine date: <input type='date' name='date' /><br>
	<input type='submit' name='action' value='Create' />
</form>

</body></html>