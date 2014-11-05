<html>
<?php include('header.php');?>
<body>
<?php include('menu.php');	?>
<form action="">
<p>Code<br><input name="vorname" type="text" size="30" maxlength="30"></p>
<p>Kuerzel<br><input name="vorname" type="text" size="10" maxlength="30"></p>
<input type="reset" value=" Abbrechen" id="abb">
<input type="submit" value=" Absenden " id="button">


</form>

<br /><br />
<br /><table border="1">
  <tr>
	<th>Nr</th>
    <th>Code</th>
    <th>Kuerzel</th>
	<th>Edit</th>
	<th>Delete</th>
  </tr>
  <tr>
	<td>1</td>
    <td>Kaution</td>
    <td>Kt</td>
	<td><a href=""><img src="images/b_edit.png" alt="bearbeiten"></a></td>
	<td><a href=""><img src="images/b_drop.png" alt="bearbeiten"></a></td>
  </tr>
    <tr>
	<td>2</td>
    <td>HzL</td>
    <td>HzL</td>
	<td><a href=""><img src="images/b_edit.png" alt="bearbeiten"></a></td>
	<td><a href=""><img src="images/b_drop.png" alt="bearbeiten"></a></td>
  </tr>
  
</table>
</body>
</html>
