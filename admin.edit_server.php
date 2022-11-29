<?php
defined("access") or die("Nedozvoljen pristup");
$id = addslashes($_GET['id']);

$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));
$srv =  mysql_fetch_array(mysql_query("SELECT * FROM serverinfo WHERE id='$id'"));

if($srv['id'] == ""){
die("<script> alert('Server koji trazite ne postoji.'); document.location.href='/'; </script>");
}

if($info['rank'] == "0" or $info['rank'] == ""){
   die("<script> alert('You dont have acess'); document.location.href='/'; </script>");
} else {
?>

<h3><center><?php echo $srv['hostname']; ?></center></h3>

<form class="test_class" action="/admin_process.php?task=edit_server" method="POST">
<label>IP adresa: </label><input type="text" name="ip" value="<?php echo "$srv[ip]:$srv[port]"; ?>" disabled="disabled"> <div class="space_contact1"></div>


                    <label>Igra:</label>
					<select name="game" id="game">
						<?php foreach ($gt_allowed_games as $gamefull => $gamesafe): ?>
						<option value="<?php echo $gamesafe; ?>"><?php echo $gamefull; ?></option>
						<?php endforeach; ?>
					</select>
					<div class="space_contact1"></div>
					
                    <label>Lokacija:</label>
					<select name="location" id="location">
						<?php foreach ($gt_allowed_countries as $locationfull => $locationsafe): ?>
						<option value="<?php echo $locationsafe; ?>"><?php echo $locationfull; ?></option>
						<?php endforeach; ?>
					</select>
					<div class="space_contact1"></div>

                    <label>Mod:</label>
					<select name="mod">
						<?php foreach($gt_allowed_mods as $modfull => $modsafe): ?>
						<option value="<?php echo $modsafe; ?>"><?php echo $modfull; ?></option>
						<?php endforeach; ?>
					</select>
					<div class="space_contact1"></div>

					<label>Najbolji rank:</label> <input type="text" name="best_rank" value="<?php echo $srv['best_rank']; ?>"> <br /><div class="space_contact1"></div>
<label>Najgori rank:</label> <input type="text" name="worst_rank" value="<?php echo $srv['worst_rank']; ?>"> <br /><div class="space_contact1"></div>
<label>Sajt/forum:</label>  <input type="text" name="forum" value="<?php echo $srv['forum']; ?>"> <br /><div class="space_contact1"></div>
<label>Dodao server:</label> <input type="text" name="added" value="<?php echo $srv['added']; ?>">	<br /><div class="space_contact1"></div>
<label>Vlasnik servera:</label> <input type="text" name="owner" value="<?php echo $srv['owner']; ?>">	<br /><div class="space_contact1"></div>
<input type="hidden" name="sid" value="<?php echo $id; ?>">

<button class="edit_server">Izmeni</button>					
</form>

<br />

<?php } ?>