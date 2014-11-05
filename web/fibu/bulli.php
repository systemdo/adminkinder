<html>
<?php 
	include('header.php');
	$heute = date("m-y");
?>
<body>
<?php include('menu.php');	?>
<form action"">
<p>Datum:<br><input name="vorname" type="text" value="<?php echo $heute;?>" size="8" maxlength="30"></p>
<input type="submit" value="export" id="button">

</form>

</body>
</html>