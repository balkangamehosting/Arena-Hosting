<?php 
	session_start();
	include('connect_db.php');
	if($_SESSION['userid'] == ""){
	   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
	}
	error_reporting(1);
	
	$page = $_GET['page'];
	if($page == "getftp"){
		$pin 	= mysql_real_escape_string(strip_tags($_GET['pin']));
		$server = mysql_real_escape_string(strip_tags($_GET['server']));
		
		$info = mysql_fetch_array(mysql_query("SELECT pin FROM users WHERE userid='$_SESSION[userid]'"));
		
		if($info['pin'] == $pin){
			$sinfo = mysql_fetch_array(mysql_query("SELECT ftp_password FROM servers WHERE id='$server' and userid='$_SESSION[userid]'"));
			echo $sinfo['ftp_password'];
			
		} else {
			echo "0";
		}
		
	}
	if($page == "reinstal"){
		$pin 	= mysql_real_escape_string(strip_tags($_GET['pin']));
		$server = mysql_real_escape_string(strip_tags($_GET['server']));
		
		$info = mysql_fetch_array(mysql_query("SELECT pin FROM users WHERE userid='$_SESSION[userid]'"));
		
		if($info['pin'] == $pin){
			echo "1";
			
		} else {
			echo "0";
		}
		
	}
	if($page == "kupon_check"){
		$kupon 	= mysql_real_escape_string(strip_tags($_GET['kupon']));
		
		$k_a = mysql_query("SELECT id,percent FROM kuponi WHERE code='$kupon'");
		$kupon_q = mysql_num_rows($k_a);
		$fetch = mysql_fetch_array($k_a);
		if($kupon_q == 1){
			echo "<font color=green>Validan kod! -$fetch[percent] %</font>";
		} else {
			echo "<font color=red>Nevažeći kod! </font>";
		}
		
	}
	if($page == "calculate"){
		$box 	= mysql_real_escape_string(strip_tags($_GET['box']));
		$slots 	= mysql_real_escape_string(strip_tags($_GET['slots']));
		$period = mysql_real_escape_string(strip_tags($_GET['period']));
		$gameo  = mysql_real_escape_string(strip_tags($_GET['gameo']));
		
		$q = mysql_query("SELECT cijena FROM slots WHERE game='$gameo' and slots='$slots' and type='$box' ")or die(mysql_error());
		$slots_price_q = mysql_fetch_array($q);
		
		$pricel = (float) $slots_price_q['cijena'];
		$pricen = round(konvertuj($pricel, "DIN"), 1);
		
		if($period == '1'){
			$final = $pricen;
		} else if($period == '2'){
			$final = $pricen * (95 / 100);
		} else if($period == '3'){
			$final = $pricen * (90 / 100);
		} else if($period == '6'){
			$final = $pricen * (80 / 100);
		} 
		$final = round($final, 1);
		
		echo $final. " € <span>/mjesečno</span>";
	}
	if($page == "check_port"){
		$game = mysql_Real_escape_String($_GET['game']);
		$port = mysql_Real_escape_String($_GET['port']);
		$sinfo = mysql_num_rows(mysql_query("SELECT id FROM servers WHERE game='$game' and port='$port'"));
		
		if($sinfo == 0){
			echo "
			<font color=lightgreen>Slobodno!</font>
			";
		} else {
			echo "
			<font color=red>Zauzet!</font>
			";
		}
	}
	if($page == "port_change"){
		$query = mysql_query("SELECT port FROM servers WHERE game='$game'") or die(mysql_error());
		$select_last_row_port  = mysql_fetch_array($query);
		$pref_port = $select_last_row_port['port']+1;
	}
	if($page == "pay_calculator"){
		$server = mysql_real_escape_string(strip_tags($_GET['serverid']));
		
		$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$server'"));
		
		if($info['userid'] == $_SESSION['userid']){
			
			$price = (float) $info['price'];
			
			$trenutno_kesa = get_ukupno_kes($_SESSION['userid']); 
			$trenutno_kesa = str_replace(",", "", $trenutno_kesa);
			$trenutno_kesa = str_replace(".", "", $trenutno_kesa);
			$trenutno_kesa = str_replace(" ", "", $trenutno_kesa);
			$trenutno_kesa = (float) $trenutno_kesa;
			
			if($trenutno_kesa >= $price){ $cani = "<font color=lightgreen>dovoljno</font>"; $on = 1;} else {$cani = "<font color=red>$trenutno_kesa nedovoljno</font>"; $on = 0;}
			
			?>
			<table>
				<tr>
				<td width="100"><b>Cijena:</b></td>
				<td><?php echo $info['price']; ?> €</td>
				</tr>
				
				<tr>
				<td><b>Ističe za:</b> </td>
				<td><?php echo countdown($info['datum_isteka'], "istekao"); ?></td>
				
				</tr>
			</table> <br />
			Na računu imate <b><?php echo get_ukupno_kes($_SESSION['userid']); ?> €</b> što je <?php echo $cani; ?> za plaćanje ovog servera.<?php if($on == 0){exit(); }else {} ?><br /><br />
			<small>Uplate koje odgovaraju iznosu su: <br />
			<ul>
			<?php
				$fakturisanje_q = valutiraj_posebno($_SESSION['userid']);
				$i=0;
				foreach($fakturisanje_q as $key => $iznos){
				
					if($iznos >= $price){
					$i++;
						echo "<li>~ <a target='_blank' title='Klikom otvaraš novi prozor sa uplatom.' href='/gp/billing/pregledaj/$key'>#$key sa iznosom $iznos €</a></li>";
					} 
					
				}

				if($i==0){
					$array = array();
					foreach($fakturisanje_q as $key => $iznos){
					$iznos = (float) $iznos;		
					$zbir[$key] = $iznos;
					}
					$ukupno_plus = implode("+", $zbir);
					echo "<li>~ <a target='_blank' href='javascript:;'>Uplate $ukupno_plus €</a></li>";
				}

			?>
			</ul><br /></small>
			Da li želite platiti ovaj server novcem sa Vašeg računa?
			 </li><br /><br />
                    <li>
                        <label for="submit" class="topalign">&nbsp;</label>

                        <button onClick="window.location='/server_process.php?task=pay&serverid=<?php echo $server; ?>';" class="edit_server">Da</button> 


						<button onClick="window.location='/gp/billing';" class="edit_server">Ne</button>
                        
                    </li><br />
			<?php
			
		} else {
			echo "0";
		}
		
	}
?>