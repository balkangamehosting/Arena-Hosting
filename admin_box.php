<?php
defined("access") or die("Nedozvoljen pristup");

if($info['rank']!= '1'){exit();}

?>
<div class="container_24">

	<div class="grid_24">
		
		<?php
			if($_GET['edit']){
			$getid = mysql_real_escape_string($_GET['edit']);
				$box_name = mysql_fetch_array(mysql_query("SELECT name,location,ip,username,password FROM masine WHERE id='$getid'"));
			}
			if($_GET['delete']){
			$getid = mysql_real_escape_string($_GET['delete']);
				mysql_query("DELETE FROM masine WHERE id='$getid'");
			}
		?>
		<div style="width:500px;float:left;">
			<div class="blokba" ><?php if($_GET['edit']){echo "Izmjeni";} else {echo "Dodaj novu"; } ?> mašinu</div>
			<br /><style>label {width:130px !important; float:left; } a {color:orange;text-decoration:none;}</style>
			

				<form class="test_class" method="POST" action="">
				<?php if($_GET['edit']){echo '<input type="hidden" name="izmjeni_masinu"></input>';} else {echo '<input type="hidden" name="dodaj_masinu"></input>'; } ?>
				
				<label>IP Mašine:</label> <input type='text' name="ip" required="required" value="<?php if($_GET['edit']){echo "$box_name[ip]";} else {echo "0.0.0.0"; } ?>"><br /><br />
				<label>Username:</label> <input type='text' name="user" required="required" value="<?php if($_GET['edit']){echo "$box_name[username]";} else {echo "root"; } ?>"><br /><br />
				
				<label>Password:</label> <input type='text' name="pw" <?php if($_GET['edit']){echo "";} else {echo 'required="required"'; } ?> placeholder="*******"> <br /><br />
				<label>Ime mašine:</label> <input type='text' name="ime" placeholder="Premium" required="required"  value="<?php if($_GET['edit']){echo "$box_name[name]";} else {echo ""; } ?>"><br /><br />
				
				<label>Lokacija:</label> <input type='text' name="lokacija" required="required" value="<?php if($_GET['edit']){echo "$box_name[location]";} else {echo "Njemačka"; } ?> "><br /><br />
				<label>&nbsp;</label><button class="edit_server"><?php if($_GET['edit']){echo "Sacuvaj!";} else {echo "Dodaj"; } ?>!</button>
				</form>
				<?php
					if($_POST['lokacija']){
						$ipMasina 		= mysql_real_escape_string(strip_tags($_POST['ip']));
						$userMasina 	= mysql_real_escape_string(strip_tags($_POST['user']));
						$pwMasina 		= mysql_real_escape_string(strip_tags($_POST['pw']));
						$imeMasina 		= mysql_real_escape_string(strip_tags($_POST['ime']));
						$lokacijaMasina = mysql_real_escape_string(strip_tags($_POST['lokacija']));
						
						if($_GET['edit'] and empty($pwMasina)){
							$pwMasina = "$box_name[password]";
						}
						
						if(!empty($ipMasina) and !empty($userMasina) and !empty($pwMasina)){
							include('phpseclib/SSH2.php');

							$ssh = new Net_SSH2($ipMasina);
							if (!$ssh->login($userMasina, $pwMasina)) {
							$_SESSION['error'] = 'Ne mogu se konektovati na masinu.';
								header("Location: /admin/box");
							} else { 
							if($_GET['edit']){
								mysql_query("UPDATE masine SET ip='$ipMasina', username='$userMasina', password='$pwMasina', name='$imeMasina', location='$lokacijaMasina' WHERE id='$getid'") or die(mysql_error());
							} else {
								mysql_query("INSERT INTO masine (ip,username,password,name,location) VALUES ('$ipMasina','$userMasina','$pwMasina','$imeMasina','$lokacijaMasina')") or die(mysql_error());
								header("Location: /admin/box");
							}
								
							}
							
					
					}
					}
				?>
			
			
		</div>
<div style="width:400px;float:right;"><div class="blokba" >Lista mašina</div>
			<br />
			<?php
		
				$lista_masina = mysql_query("SELECT * FROM masine");
				while($l = mysql_fetch_array($lista_masina)){
					echo "#".$l['id']." ".$l['name']." - ". $l['ip']." <a href='/admin/box&edit=".$l['id']."'>Uredi</a> - <a href='/admin/box&delete=".$l['id']."'>Obrisi</a><br />";
				}
				
				
				
			?>
			</div>
	<br style="clear:both" />
		<div class="clear"></div>
		
	</div>		
<div class="clear"></div>
</div>