<?php
defined("access") or die("Nedozvoljen pristup");

if($info['rank']!= '1'){exit();}

?>
<div class="container_24">

	<div class="grid_24">
		
		<?php
			if($_GET['edit']){
			$getid = mysql_real_escape_string($_GET['edit']);
				$box_name = mysql_fetch_array(mysql_query("SELECT name,lokacija,protocol,mapa,komanda FROM igre WHERE id='$getid'"));
			}
			if($_GET['delete']){
			$getid = mysql_real_escape_string($_GET['delete']);
				mysql_query("DELETE FROM igre WHERE id='$getid'");
				header("Location: /admin/igre");
			}
		?>
		<div style="width:500px;float:left;">
			<div class="blokba" ><?php if($_GET['edit']){echo "Izmjeni";} else {echo "Dodaj novu"; } ?> igru</div>
			<br /><style>label {width:130px !important; float:left; } a {color:orange;text-decoration:none;}</style>
			

				<form class="test_class" method="POST" action="">
				<?php if($_GET['edit']){echo '<input type="hidden" name="izmjeni_masinu"></input>';} else {echo '<input type="hidden" name="dodaj_masinu"></input>'; } ?>
				
				<label>Ime igre:</label> <input type='text' name="name" required="required" value="<?php if($_GET['edit']){echo "$box_name[name]";} else {echo "Counter-Strike: GO"; } ?>"><br /><br />
				<label>Mapa default:</label> <input type='text' name="mapa" required="required" value="<?php if($_GET['edit']){echo "$box_name[mapa]";} else {echo "de_dust2"; } ?>"><br /><br />
				
				<label>GT protokol:</label> <input type='text' name="protocol" value="<?php if($_GET['edit']){echo "$box_name[protocol]";} else {echo ""; } ?>" placeholder="halflife"> <br /><br />
				<label>Komanda za start:</label> <input type='text' name="komanda" placeholder="./hlds_start +maxplayers {slots} +ip {ip}" required="required"  value="<?php if($_GET['edit']){echo "$box_name[komanda]";} else {echo ""; } ?>"><br /><small style="color:grey;">{ip} {port} {slots} {map}</small><br /><br />
				
				<label>Lokacija:</label> <input type='text' name="lokacija" required="required" value="<?php if($_GET['edit']){echo "$box_name[lokacija]";} else {echo "/home/gamefiles/FOLDER"; } ?>"> <small style="color:red;">Bez / na kraju !!</small><br /><br />
				<label>&nbsp;</label><button class="edit_server"><?php if($_GET['edit']){echo "Sacuvaj!";} else {echo "Dodaj"; } ?>!</button>
				</form>
				<?php
					if($_POST['lokacija']){
						$name 		= mysql_real_escape_string(strip_tags($_POST['name']));
						$mapa 	= mysql_real_escape_string(strip_tags($_POST['mapa']));
						$protocol 		= mysql_real_escape_string(strip_tags($_POST['protocol']));
						$komanda 		= mysql_real_escape_string(strip_tags($_POST['komanda']));
						$lokacija = mysql_real_escape_string(strip_tags($_POST['lokacija']));
						
						
						

							
							if($_GET['edit']){
								mysql_query("UPDATE igre SET name='$name', mapa='$mapa', protocol='$protocol', komanda='$komanda', lokacija='$lokacija' WHERE id='$getid'") or die(mysql_error());
								header("Location: /admin/igre");
							} else {
								mysql_query("INSERT INTO igre (name,mapa,protocol,komanda,lokacija) VALUES ('$name','$mapa','$protocol','$komanda','$lokacija')") or die(mysql_error());
								header("Location: /admin/igre");
							}
								
							
					}
				?>
			
			
		</div>
<div style="width:400px;float:right;"><div class="blokba" >Lista igara</div>
			<br />
			<?php
		
				$lista_masina = mysql_query("SELECT * FROM igre");
				while($l = mysql_fetch_array($lista_masina)){
					echo "#".$l['id']." ".$l['name']." <span style='float:right'> <a href='/admin/igre&edit=".$l['id']."'>Uredi</a> - <a href='/admin/igre&delete=".$l['id']."'>Obrisi</a></span><hr />";
				}
				
				
				
			?>
			</div>
	<br style="clear:both" />
		<div class="clear"></div>
		
	</div>		
<div class="clear"></div>
</div>