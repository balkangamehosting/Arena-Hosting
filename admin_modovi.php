<?php
defined("access") or die("Nedozvoljen pristup");

if($info['rank']!= '1'){exit();}

?>
<div class="container_24">

	<div class="grid_24">
		
		<?php
			if($_GET['edit']){
			$getid = mysql_real_escape_string($_GET['edit']);
				$box_name = mysql_fetch_array(mysql_query("SELECT id,ime,game,opis,mapa,lokacija FROM modovi WHERE id='$getid'"));
			}
			if($_GET['delete']){
			$getid = mysql_real_escape_string($_GET['delete']);
				mysql_query("DELETE FROM modovi WHERE id='$getid'");
				header("Location: /admin/igre");
			}
		?>
		<div style="width:500px;float:left;">
			<div class="blokba" ><?php if($_GET['edit']){echo "Izmjeni";} else {echo "Dodaj novi"; } ?> mod</div>
			<br /><style>label {width:130px !important; float:left; } a {color:orange;text-decoration:none;}</style>
			

				<form class="test_class" method="POST" action="">
				<?php if($_GET['edit']){echo '<input type="hidden" name="izmjeni_masinu"></input>';} else {echo '<input type="hidden" name="dodaj_masinu"></input>'; } ?>
				
				<label>Ime moda:</label> <input type='text' name="name" required="required" value="<?php if($_GET['edit']){echo "$box_name[ime]";} else {echo "DeathMatch"; } ?>"><br /><br />
				<label>Igra:</label> 
				
				<select name="igra">
					<?php 
						$game_s = mysql_query("SELECT id,name,mapa FROM igre ");
						while($redba = mysql_fetch_array($game_s)){
						if($_GET['edit'] and $redba['id'] == $box_name['game']){$selected = "selected";}else{$selected = "";}
							echo "<option $selected value='$redba[id]'>$redba[name]</option>";
						}
					?>
				</select><br /><br />
			<label>Opis:</label> 
				<input type='text' name="opis" required="required" value="<?php if($_GET['edit']){echo "$box_name[opis]";} else {echo ""; } ?>"><br /><br />
				<label>Default mapa:</label> <input type='text' name="mapa" placeholder="de_dust2" required="required"  value="<?php if($_GET['edit']){echo "$box_name[mapa]";} else {echo ""; } ?>"><br /><br />
				
				<label>Lokacija:</label> <input type='text' name="lokacija" required="required" value="<?php if($_GET['edit']){echo "$box_name[lokacija]";} else {echo "/home/gamefiles/FOLDER"; } ?>"> <small style="color:red;">Bez / na kraju !!</small><br /><br />
				<label>&nbsp;</label><button class="edit_server"><?php if($_GET['edit']){echo "Sacuvaj!";} else {echo "Dodaj"; } ?>!</button>
				</form>
				<?php
					if($_POST['lokacija']){
						$name 		= mysql_real_escape_string(strip_tags($_POST['name']));
						$igra 	= mysql_real_escape_string(strip_tags($_POST['igra']));
						$opis 		= mysql_real_escape_string(strip_tags($_POST['opis']));
						$mapa 		= mysql_real_escape_string(strip_tags($_POST['mapa']));
						$lokacija = mysql_real_escape_string(strip_tags($_POST['lokacija']));
						
						
						

							
							if($_GET['edit']){
								mysql_query("UPDATE modovi SET ime='$name', game='$igra', opis='$opis', mapa='$mapa', lokacija='$lokacija' WHERE id='$getid'") or die(mysql_error());
								header("Location: /admin/modovi");
							} else {
								mysql_query("INSERT INTO modovi (ime,game,opis,mapa,lokacija) VALUES ('$name','$igra','$opis','$mapa','$lokacija')") or die(mysql_error());
								header("Location: /admin/modovi");
							}
								
							
					}
				?>
			
			
		</div>
<div style="width:400px;float:right;"><div class="blokba" >Lista modova</div>
			<br />
			<?php
		
				$lista_masina = mysql_query("SELECT * FROM modovi");
				while($l = mysql_fetch_array($lista_masina)){
					echo "#".$l['id']." ".$l['ime']." <span style='float:right'> <a href='/admin/modovi&edit=".$l['id']."'>Uredi</a> - <a href='/admin/modovi&delete=".$l['id']."'>Obrisi</a></span><hr />";
				}
				
				
				
			?>
			</div>
	<br style="clear:both" />
		<div class="clear"></div>
		
	</div>		
<div class="clear"></div>
</div>