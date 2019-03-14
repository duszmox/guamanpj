<?php
	require_once("math.inc.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>INDEX</title>
</head>
<body>
	<form>
		<input type="text" name="num1"><br>
		<input type="text" name="num2">	<br>
		<select name="option">
			<option value="add">Add</option>
			<option value="substract">Substract</option>
			<option value="multiply">Multiply</option>
		</select>	
		<input type="submit" value='OK'>
	</form>

	<?php
	$num1 = $_GET['num1'];
	$num2 = $_GET['num2'];
	$option = $_GET['option'];		
	
	if(isset($_GET['num1']) && (isset($_GET['num2']) && isset($_GET['option']))){
		$num1 = $_GET['num1'];
		$num2 = $_GET['num2'];
		$option = $_GET['option'];		
		
		$object = new Math($num1, $num2);

		switch ($option) {
			case 'add':
				echo $object->add();
			break;
			case 'substract':
				echo $object->substract();
			break;
			case 'multiply':
				echo $object->multiply();
			break;
			}
	}
	
	?>
</body>
</html>