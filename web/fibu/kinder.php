<html>
<?php include('header.php');?>
<body>
<?php include('menu.php');	?>
<form action="">
<p>Vorname:<br><input name="vorname" type="text" size="30" maxlength="30"></p>
<p>Nachname:<br><input name="vorname" type="text" size="30" maxlength="30"></p>
<p>FibuNr.:<br><input name="vorname" type="text" size="7" maxlength="30"></p>


<p>Kto fuehrg. ab<br><input name="vorname" type="text" size="11" maxlength="30"></p>
<input type="reset" value=" Abbrechen" id="abb">
<input type="submit" value=" Absenden " id="button">

</form><br /><br />
<br /><table border="1">
  <tr>
    <th>Vorname</th>
    <th>Nachname</th>
	<th>Einrichtung</th>
	<th>Kto fuehrg. ab</th>
	<th>Edit</th>
	<th>Delete</th>
  </tr>
  <tr>
    <td>Maria</td>
    <td>Jose</td>
	<td>EWG Kotti</td>
    <td>00.01.00</td>
	<td><a href=""><img src="images/b_edit.png" alt="bearbeiten"></a></td>
	<td><a href=""><img src="images/b_drop.png" alt="bearbeiten"></a></td>
  </tr>
  <tr>
    <td>Milj&ouml;h</td>
    <td>Kiez</td>
	<td>TEW Mitte</td>
    <td>00.01.00</td>
	<td><a href=""><img src="images/b_edit.png" alt="bearbeiten"></a></td>
	<td><a href=""><img src="images/b_drop.png" alt="bearbeiten"></a></td>
  </tr>
</table>
</body>
</html>
