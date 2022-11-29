<div class="akcije" style="font-size:15px;" >
	<?php 
	if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
}
	
	if(empty($_GET['url'])){
		$ftp_url = "/";
	} else {
		$ftp_url = $_GET['url'];
	}
	
	
	$conftp 	= ftp_connect($box_name['ip']) or die("Ne mogu se spojiti sa FTP serverom.");
	$loginftp	= ftp_login($conftp, $select_fetch['ftp_username'], $select_fetch['ftp_password']) or die("Pogrešna autentikacija.");
	
	
	#ftp_chdir($conftp, $ftp_url);
	if($_POST['novi_folder']){
		if(!empty($_POST['novi_folder'])){
			ftp_mkdir($conftp, $ftp_url."/".$_POST['novi_folder']);
		}
	}
	if($_POST['dodaj_fajl']){

		$fajl = $_FILES["fajl_novi"]["tmp_name"];	
		$ime_fajla = $_FILES["fajl_novi"]["name"];
		$putanja_na_serveru = ''.$ftp_url.'/'.$ime_fajla.'';
		
		if (ftp_put($conftp, $putanja_na_serveru, $fajl, FTP_BINARY)) {
			echo "success";
			} else {
			echo "dismiss";
			}

	}
	
	$rawftp		= ftp_rawlist($conftp, $ftp_url);
	foreach ( $rawftp as $folder ){
                    $struc = array();
                    $current = preg_split( "/[\\s]+/", $folder );
                    $struc['perms'] = $current[0];
                    $struc['permsn'] =  $current[0] ;
                    $struc['number'] = $current[1];
                    $struc['owner'] = $current[2];
                    $struc['group'] = $current[3];
                    $struc['size'] = $current[4] ;
                    $struc['month'] = $current[5];
                    $struc['day'] = $current[6];
                    $struc['time'] = $current[7];
                    $struc['name'] = $current[8];
                      if ( $struc['perms']{0}  == "d" ){
                            $folders[] = $struc;
                        } else if($struc['perms']{0} == "-") {
                            $files[] = $struc;
                        }
						
                    
                } 
				
	
	if($_GET['file'] == "8c7dd922ad47494fc02c388e12c00eac"){
		ftp_delete($conftp, $_GET['url']);
		echo "<script>window.location='/gp/server/$id/webftp';</script>";
	}
				
	?>
	<?php
		if(!empty($_GET['edit'])){
		$getfile = $_GET['edit'];
		
		$secure_file = str_replace("/","" ,$getfile);
		
		$explodeGetFile = explode("/", $getfile);
		$explodeLast	= end($explodeGetFile);
		
		$lokacija_header = str_replace($explodeLast, "", $getfile);
		
		$local_file = "tmp_files/".time()."-$select_fetch[ftp_username]-$secure_file";
		fopen($local_file, "w");
		fwrite($local_file, "");
		$remote_file = $getfile;
		if(ftp_get($conftp, $local_file, $remote_file, FTP_BINARY)){
			$filegt = file_get_contents($local_file);
		}
		
		
		$jen = explode("/", $getfile);
		$jenba = array_slice($jen, 0, -1);
		$final = implode("/", $jenba);
		
		
		
		if($_POST['ime_edit']){

			$naziv = $_POST['ime_edit'];
			$sadrzaj = $_POST['content'];
			$rem_file = $getfile;
			
			$secure_name = str_replace("/","" ,$naziv);
			
			$exp = explode("/", $getfile);

				$expba = array_slice($exp, 0, -1);
				$string = implode("/", $expba);
				
			if($game_fetch['protocol'] == "samp" and $naziv == "server.cfg"){
					$pattern = "/^.*\bport\b.*$/m";
					$matches = array();
					preg_match($pattern, $sadrzaj, $matches);
					$matche = $matches[0];
					$portnew = str_replace("port ", "", $matche);
					$portnew = str_replace(" ", "", $portnew);
					
					if(intval($portnew) != $select_fetch['port']){
						exit("Ne smijete mjenjati port!");
					} 
					
					$patternba = "/^.*\bmaxplayers\b.*$/m";
					$matchesba = array();
					preg_match($patternba, $sadrzaj, $matchesba);
					$matcheba = $matchesba[0];
					$maxp = str_replace("maxplayers ", "", $matcheba);
					$maxp = str_replace(" ", "", $maxp);
					
					if(intval($maxp) != $select_fetch['slots']){
						exit("Ne smijete mjenjati broj slotova!");
					}
					
			}
			
			$locala = "tmp_files/".time()."-$select_fetch[ftp_username]-$secure_name";
			$otvori = fopen($locala, "w");
			fwrite($otvori, $sadrzaj);
			
			
			
			
			
			ftp_chdir($conftp, "/".$string."/");

			ftp_put($conftp, $naziv, $locala, FTP_BINARY) or die("<script>window.location.reload();</script>");
					

				unlink($locala); // delete file

			
			
			if($explodeLast != $naziv){
				ftp_rename($conftp, $rem_file, $string."/".$naziv);
			}
			
			echo "<script>window.location='/gp/server/$id/webftp/&url=$string';</script>";
		}	
		
		?>
		<div class="blokba" ><?php echo $explodeLast; ?></div>
		<form class="test_class" method="POST" style="margin-left:15px;"  action="">
				<input type="text" style="width:96%;padding:10px;font-size:16px;" name="ime_edit" value="<?php echo $explodeLast; ?>"><br /><br />
				<textarea name="content" style="resize:none;width:97%;height:400px;max-width:97%;max-height:400px;"><?php echo $filegt; ?></textarea><br />
				<button class="edit_server">Sačuvaj!</button><br />

			</form>
		<?php
		} else {
	?>
	<style>a {color:white; text-decoration:none;} #webftp {font-size:13px !important;} #webftp img {margin-right:5px;}</style>
	<a href="/gp/server/<?php echo $id; ?>/webftp"><img width="16" src="/img/pp-home.png" style="vertical-align:middle"></a> &rsaquo; 
	<?php
					$eks = explode("/",$_GET['url']);
					
					$url = array();
					
					foreach($eks as $path){
					
					
						if(!empty($path)){
						array_push($url, $path);
						$pathba = implode("/", $url);
						
							echo "<a href='/gp/server/$id/webftp/&url=$pathba'>".$path."</a> &rsaquo; ";
						}
					}
					
				?>
				
				<br /><br />
	
	<table id="webftp">

    <tbody>
        <tr>
            <th>Ime</th>
            <th>Velicina</th>
            <th>Permisije</th>
            <th>Korisnik</th>
            <th>Grupa</th>
            <th width="120">Modifikovan</th>
            <th width="140">Akcija</th>
        </tr>
        <?php
			foreach ( $folders as $y ){
				$ipsilonName = $y['name'];
				if(empty($_GET['url'])){
					$pet = "/$ipsilonName";
				} else {
					$pet = "".$_GET['url']."/$ipsilonName";
				}
				if($ipsilonName != "."){
				if($ipsilonName == ".."){ $ipsilonName = "<b style='color:yellow'><< Nazad</b>"; }else {$ipsilonName = $ipsilonName;}
					echo "<tr>";
					echo "<td><img src='/img/pp-folder.png'> <a href='/gp/server/$id/webftp/&url=$pet' > $ipsilonName</a></td>";
					echo "<td>/</td>";
					echo "<td>".$y['perms']."</td>";
					echo "<td>".$y['owner']."</td>";
					echo "<td>".$y['group']."</td>";
					echo "<td style='color:grey'>".$y['month']." ".$y['day']." ".$y['time']."</td>";
					echo "</tr>";
					}
				}		
				foreach ( $files as $x ){
				$iksilonName = $x['name'];
				$sajz = ceil($x['size']/1024);
					echo "<tr>";
					echo "<td><img src='/img/pp-file.png'> <a href='/gp/server/$id/webftp/edit/".$_GET['url']."/$iksilonName' > $iksilonName</a></td>";
					echo "<td>".$sajz." KB</td>";
					echo "<td>".$x['perms']."</td>";
					echo "<td>".$x['owner']."</td>";
					echo "<td>".$x['group']."</td>";
					echo "<td style='color:grey'>".$y['month']." ".$y['day']." ".$y['time']."</td>";
					echo "<td><a href='/gp/server/$id/webftp/&url=".$_GET['url']."/$iksilonName&file=8c7dd922ad47494fc02c388e12c00eac'><img style='vertical-align:middle;' src='/img/pp-delete.png' /> Obriši</a> 
					
					&nbsp; 
					
					<a  href='/gp/server/$id/webftp/edit/".$_GET['url']."/$iksilonName'><img style='vertical-align:middle;' src='/img/pp-edit.png' /> Izmjeni</a></td>";
					echo "</tr>";
				}
				
			?>
    </tbody>

</table><br />
<div style="float:right;width:350px;" >
<div class="blokba">Uploaduj fajl</div>
<form class="test_class" method="POST" enctype="multipart/form-data" action="">
				<input style="width:340px;height:30px;" type="file" name="fajl_novi" required="required"> <br /><div class="space_contact1"></div> 
				<input type="submit" value="Upload!" name="dodaj_fajl" class="edit_server"></input>
			</form>
</div>
<div class="blokba">Napravi folder</div>
<form class="test_class" method="POST" enctype="multipart/form-data" action="">
				<input type="text" name="novi_folder" required="required" placeholder="Unesite ime foldera.."><br /><br />
				
				<button class="edit_server">Dodaj!</button><br />

			</form>
			<br style="clear:both" />
<?php } ?>
</div>