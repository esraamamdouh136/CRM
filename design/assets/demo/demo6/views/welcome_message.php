
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Shrka App</title>
		<style>
			body{
				margin-top:20px;
			}
			#InputText{
				width:50%;
			}#Submit{
				width:20%;
				margin-top:20px;
			}
			
		</style>
	</head>
	<body>

	<div id="container">
		<center> 
			<form action="http://demo.shrka.com/shrkaApp/View/getvideo" method="POST" enctype="multipart/form-data">
				<label>ID:  </label>				
				<input type="Text" id="InputText" name="ID" required/><br><br>
				<label>Title: </label><input type="Text" id="InputText" name="Title" required/>				
				<br>
				<select name="ChossenCat" required>
				<?php
					 // Open your drop down box
					// Loop through the query results, outputing the options one by one
					$count = 0;
					while ($count<sizeof($cat)) {
					   echo '<option value="'.$cat[$count]['Name'].'">'.$cat[$count]['Name'].'</option>';
					   $count++;
					}
				?>
				<input type="checkbox" name="featured" value="1">featured<br>
				</select>
				<input type="submit" name="Get Image" id="Submit" />	
			</form>
		</center>
	</div>

	</body>
</html>