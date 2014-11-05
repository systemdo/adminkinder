<html>
<?php include('header.php');?>
<body>
<?php    
include('menu.php');
$heute = date("Y-m-d"); 
$m=date("m");
$y=date("y"); 	
	?>
<p></p>
<form action="">
<p>Belegnr:<br><input name="vorname" type="text" value="<?php echo '6'.$y[1].'201'.$m;?>" size="8" maxlength="30"></p>
<p>Datum:<br><input name="vorname" type="text" value="<?php echo $heute;?>" size="8" maxlength="30"></p>
<p>Auszug Nr:<br><input name="vorname" type="text" size="10" maxlength="30"></p>
<p>Code<br>
<select>
	<option value="volvo">HzL</option>
	<option value="saab">Kaution</option>
	<option value="opel">Einrichtungsgeld</option>
	<option value="audi">Strom</option>
	<option value="audi">Gas</option>
	<option value="audi">Bekleidungsgeld</option>
	<option value="audi">Instandhaltung</option>
	<option value="audi">Reisekasse</option>
	<option value="audi">Spargeld</option>
</select>
</p>
<p>Vorgang<br><input name="vorname" type="text" size="30" maxlength="30"></p>
<p>Kind<br>
<select>
  <option value="volvo">Martin</option>
  <option value="saab">Sebastian</option>
  <option value="opel">Lara</option>
  <option value="audi">Maria</option>
</select>
</p>
<p>Betrag<br><input name="vorname" type="text" size="4" maxlength="30"></p>
<input type="reset" value=" Abbrechen" id="abb">
<input type="submit" value=" Absenden " id="button">
<br /><br />
<br /><br />

</form>
<p>Vormonat</p>
<br /><br /><br />

<table border="1">
  <tr>
    <th>HzL</th>
    <th>Kaution</th>
    <th>Einrichtungsgeld</th>
	<th>Miete</th>
	<th>Strom</th>
	<th>Gas</th>
	<th>Bekleidungsgeld</th>
	<th>Instandhaltung</th>
	<th>Reisekasse</th>
	<th>Spargeld</th>
	<th>Gesamt</th>
	
  </tr>
  <tr>
    <td>200,02</td>
    <td>1196,51</td>
    <td>110,35</td>
	<td>1656,61</td>
	<td>40</td>
    <td>85,38</td>
	<td>13,50</td>
	<td>- 230,41</td>
	<td>- 480,41</td>
	<td>- 480,41</td>
	<td>800</td>
  </tr>

</table>


<hr>
  <p>Laufende Kosten</p>
    <br /><br />
<br /><table border="1">
  <tr>
    <th>Belegnr.</th>
    <th>Datum</th>
    <th>Auszugnr.</th>
	<th>Code</th>
	<th>Vorgang</th>
	<th>Kind</th>
	<th>Betrag</th>
	<th>Edit</th>
	<th>Delete</th>
	
  </tr>
  <tr>
    <td>6420101</td>
    <td>12.06.14</td>
    <td>1</td>
	<td>HzL</td>
	<td>Miete WG</td>
    <td>MAria Jose</td>
	<td>13,50</td>
	<td><a href=""><img src="images/b_edit.png" alt="bearbeiten"></a></td>
	<td><a href=""><img src="images/b_drop.png" alt="bearbeiten"></a></td>
  </tr>
   <tr>
    <td>6420101</td>
    <td>12.06.14</td>
    <td>2</td>
	<td>Kaution</td>
	<td>Barauszahlung</td>
    <td>Martin</td>
	<td>13,50</td>
	<td><a href=""><img src="images/b_edit.png" alt="bearbeiten"></a></td>
	<td><a href=""><img src="images/b_drop.png" alt="bearbeiten"></a></td>
  </tr>
 
</table>
<hr>
<p>Gesamt Laufender Monat</p>
<br /><br /><br />

<table border="1">
  <tr>
    <th>HzL</th>
    <th>Kaution</th>
    <th>Einrichtungsgeld</th>
	<th>Miete</th>
	<th>Strom</th>
	<th>Gas</th>
	<th>Bekleidungsgeld</th>
	<th>Instandhaltung</th>
	<th>Reisekasse</th>
	<th>Spargeld</th>
	<th>Gesamt</th>
  </tr>
  <tr>
    <td>200,02</td>
    <td>1196,51</td>
    <td>110,35</td>
	<td>1656,61</td>
	<td>40</td>
    <td>85,38</td>
	<td>13,50</td>
	<td>- 230,41</td>
	<td>- 480,41</td>
	<td>- 480,41</td>
	<td>400</td>
  </tr>
  
</table>
</body>
</html>