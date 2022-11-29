<?php
defined("access") or die("Nedozvoljen pristup");

if($info['rank']!= '1'){exit();}

?>
<div class="container_24">

	<div class="grid_24">
		
		<?php
			if($_GET['edit']){
			$getid = mysql_real_escape_string($_GET['edit']);
				$box_name = mysql_fetch_array(mysql_query("SELECT id,ime,game,opis,amxx,sma FROM plugins WHERE id='$getid'"));
			}
			if($_GET['delete']){
			$getid = mysql_real_escape_string($_GET['delete']);
				mysql_query("DELETE FROM plugini WHERE id='$getid'");
				header("Location: /admin/igre");
			}
		?>
		<div style="width:500px;float:left;">
			<div class="blokba" ><?php if($_GET['edit']){echo "Izmjeni";} else {echo "Dodaj novi"; } ?> plugin</div>
			<br /><style>label {width:130px !important; float:left; } a {color:orange;text-decoration:none;}</style>
			

				<form class="test_class" method="POST" action="" enctype="multipart/form-data">
				<?php if($_GET['edit']){echo '<input type="hidden" name="izmjeni_masinu"></input>';} else {echo '<input type="hidden" name="dodaj_masinu"></input>'; } ?>
				
				<label>Ime plugina:</label> <input type='text' name="name" required="required" value="<?php if($_GET['edit']){echo "$box_name[ime]";} else {echo "Admin Gag"; } ?>"><br /><br />
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
				<label>AMXX fajl:</label> <input type='file' name="amxx"><br /><br />
				
				<label>SMA fajl:</label> <input type='file' name="sma"> <br /><br />
				<label>&nbsp;</label><button class="edit_server"><?php if($_GET['edit']){echo "Sacuvaj!";} else {echo "Dodaj"; } ?>!</button>
				</form>
				<?php
					if($_POST['igra']){
						$name 		= mysql_real_escape_string(strip_tags($_POST['name']));
						$igra 		= mysql_real_escape_string(strip_tags($_POST['igra']));
						$opis 		= mysql_real_escape_string(strip_tags($_POST['opis']));
						$amxx 		= $_FILES['amxx']['tmp_name'];
						$sma		= $_FILES['sma']['tmp_name'];
						
						$amxxname 		= $_FILES['amxx']['name'];
						$smaname		= $_FILES['sma']['name'];
						
						
							
							if($_GET['edit']){
							
							if(!empty($amxx) or !empty($sma)){
								if(!empty($amxx)){
									move_uploaded_file($amxx,"plugins/".$amxxname);
									mysql_query("UPDATE plugins SET ime='$name', game='$igra', opis='$opis', amxx='$amxxname' WHERE id='$getid'") or die(mysql_error());
								}
								if(!empty($sma)){
									move_uploaded_file($sma,"plugins/".$smaname);
									mysql_query("UPDATE plugins SET ime='$name', game='$igra', opis='$opis', sma='$smaname' WHERE id='$getid'") or die(mysql_error());
									
								}
								
								
								
									
							} else {
								mysql_query("UPDATE plugins SET ime='$name', game='$igra', opis='$opis' WHERE id='$getid'") or die(mysql_error());
							}
								
								header("Location: /admin/modovi");
								
								
							} else {
							move_uploaded_file($amxx,"plugins/".$amxxname);
							move_uploaded_file($sma,"plugins/".$smaname);
								mysql_query("INSERT INTO plugins (ime,game,opis,amxx,sma) VALUES ('$name','$igra','$opis','$amxxname','$smaname')") or die(mysql_error());
								header("Location: /admin/modovi");
							}
								
							
					}
				?>
			
			
		</div>
<div style="width:400px;float:right;"><div class="blokba" >Lista plugina</div>
			<br />
			<?php
		
				$lista_masina = mysql_query("SELECT * FROM plugins");
				while($l = mysql_fetch_array($lista_masina)){
					echo "#".$l['id']." ".$l['ime']." <span style='float:right'> <a href='/admin/plugini&edit=".$l['id']."'>Uredi</a> - <a href='/admin/plugini&delete=".$l['id']."'>Obrisi</a></span><hr />";
				}
				
				
				
			?>
			</div>
	<br style="clear:both" />
		<div class="clear"></div>
		
	</div>		
<div class="clear"></div>
</div>