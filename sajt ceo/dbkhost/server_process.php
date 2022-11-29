<?php 
	session_start();
	include_once ("connect_db.php");
	$infoba = mysql_fetch_array(mysql_query("SELECT rank FROM users WHERE userid='$_SESSION[userid]'"));
	$infoba_rank = $infoba['rank'];
	if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
}
?>
<style>body {margin:0;padding:0;font-family:calibri;color:white;}</style>
<div class="loading" style="background:rgba(0,0,0);position:absolute;width:100%;height:100%;color:white;float:left;z-index:100000000;font-family:calibri;">
<br /><br /><br /><br /><br /><br /><center><span style="font-size:30px;color:black;">Momenat...</span>
<div style="font-size:55px;width:100px;color:black;"><marquee>. . . . . </marquee></div></center>
</div>
<?php
	if (isset($_GET['task']) && $_GET['task'] == "start") {
			$id = mysql_real_escape_string(strip_tags($_GET['id']));
			
			if(!empty($id)){
			if($infoba_rank == '0'){
				$scan_if = mysql_query("SELECT * FROM servers WHERE id='$id' and userid='$_SESSION[userid]' ");
			} else {
				$scan_if = mysql_query("SELECT * FROM servers WHERE id='$id' ");
			}
				if(mysql_num_rows($scan_if) == 1){
					$fetch = mysql_fetch_array($scan_if);
					
					if($fetch['status'] == '1'){
						$box_name = mysql_fetch_array(mysql_query("SELECT name,location,ip,username,password FROM masine WHERE id='$fetch[box]'"));
						
						$fetch_game_info = mysql_fetch_array(mysql_query("SELECT komanda,mapa,protocol FROM igre WHERE id='$fetch[game]'"));
						
						require_once('gameq.php');
						$servers = array('server_'.$id => array($fetch_game_info['protocol'], $box_name['ip'], $fetch['port']));
						$gq = new GameQ();
						$gq->addServers($servers);
						$gq->setOption('timeout', 200);
						$gq->setFilter('normalise');
						$gq->setFilter('sortplayers');
						$data = $gq->requestData();
					
						if($data['server_'.$id]['gq_online'] == "0"){
						
							
							
							$komanda = $fetch_game_info['komanda'];
							
							$komanda = str_replace("{ip}", $box_name['ip'], $komanda);
							$komanda = str_replace("{port}", $fetch['port'], $komanda);
							$komanda = str_replace("{slots}", $fetch['slots'], $komanda);
							$komanda = str_replace("{map}", $fetch_game_info['mapa'], $komanda);
						
							$startuj = start_server($box_name['ip'], $fetch['ftp_username'], $fetch['ftp_password'], $fetch['ftp_username'], $komanda);
							
							if($startuj == 'DA'){
								$_SESSION['ok'] = "Server uspjesno startovan!";
								echo "<script>window.location='/gp/server/$id';</script>";
								die();
							} else {
								$_SESSION['error'] = "Ne mogu pokrenuti server!";
								echo "<script>window.location='/gp/server/$id';</script>";
								die();
							}
							
							
						} else {
						echo "online";
						}
					
					}
				}
			}
	}
	
	if (isset($_GET['task']) && $_GET['task'] == "stop") {
			$id = mysql_real_escape_string(strip_tags($_GET['id']));
			
			if(!empty($id)){
				if($infoba_rank == '0'){
				$scan_if = mysql_query("SELECT * FROM servers WHERE id='$id' and userid='$_SESSION[userid]' ");
				} else {
					$scan_if = mysql_query("SELECT * FROM servers WHERE id='$id' ");
				}
				
				if(mysql_num_rows($scan_if) == 1 ){
					$fetch = mysql_fetch_array($scan_if);
					
					if($fetch['status'] == '1'){
						$box_name = mysql_fetch_array(mysql_query("SELECT name,location,ip,username,password FROM masine WHERE id='$fetch[box]'"));
						
						$fetch_game_info = mysql_fetch_array(mysql_query("SELECT komanda,mapa,protocol FROM igre WHERE id='$fetch[game]'"));
						
						require_once('gameq.php');
						$servers = array('server_'.$id => array($fetch_game_info['protocol'], $box_name['ip'], $fetch['port']));
						$gq = new GameQ();
						$gq->addServers($servers);
						$gq->setOption('timeout', 200);
						$gq->setFilter('normalise');
						$gq->setFilter('sortplayers');
						$data = $gq->requestData();
					
						if($data['server_'.$id]['gq_online'] == "1"){
						
							
			
							$stopuj = stop_server($box_name['ip'], $fetch['ftp_username'], $fetch['ftp_password'], $fetch['ftp_username']);
							
							if($stopuj == 'DA'){
								$_SESSION['ok'] = "Server uspjesno stopiran!";
								header("Location: /gp/server/$id");
							} else {
								$_SESSION['error'] = "Ne mogu zaustaviti server!";
								header("Location: /gp/server/$id");
							}
							
							
						}
					
					}
				}
			}
	}
	
	if (isset($_GET['task']) && $_GET['task'] == "restart") {
			$id = mysql_real_escape_string(strip_tags($_GET['id']));
			
			if(!empty($id)){
				if($infoba_rank == '0'){
				$scan_if = mysql_query("SELECT * FROM servers WHERE id='$id' and userid='$_SESSION[userid]' ");
				} else {
					$scan_if = mysql_query("SELECT * FROM servers WHERE id='$id' ");
				}
				
				if(mysql_num_rows($scan_if) == 1 ){
					$fetch = mysql_fetch_array($scan_if);
					
					if($fetch['status'] == '1'){
						$box_name = mysql_fetch_array(mysql_query("SELECT name,location,ip,username,password FROM masine WHERE id='$fetch[box]'"));
						
						$fetch_game_info = mysql_fetch_array(mysql_query("SELECT komanda,mapa,protocol FROM igre WHERE id='$fetch[game]'"));
						
						require_once('gameq.php');
						$servers = array('server_'.$id => array($fetch_game_info['protocol'], $box_name['ip'], $fetch['port']));
						$gq = new GameQ();
						$gq->addServers($servers);
						$gq->setOption('timeout', 200);
						$gq->setFilter('normalise');
						$gq->setFilter('sortplayers');
						$data = $gq->requestData();
					
						
						
							
							
							$komanda = $fetch_game_info['komanda'];
							
							$komanda = str_replace("{ip}", $box_name['ip'], $komanda);
							$komanda = str_replace("{port}", $fetch['port'], $komanda);
							$komanda = str_replace("{slots}", $fetch['slots'], $komanda);
							$komanda = str_replace("{map}", $fetch_game_info['mapa'], $komanda);
							
							
						if($data['server_'.$id]['gq_online'] == "1"){
							stop_server($box_name['ip'], $fetch['ftp_username'], $fetch['ftp_password'], $fetch['ftp_username']);
							sleep(3);
							echo "<script>window.location='/server_process.php?task=start&id=$id';</script>";
						} else {
							start_server($box_name['ip'], $fetch['ftp_username'], $fetch['ftp_password'], $fetch['ftp_username'], $komanda);
						}
							
								$_SESSION['ok'] = "Server uspjesno startovan!";
								echo "<script>window.location='/gp/server/$id';</script>";
							die();
							
							
						}
					
					}
				}
			}
	if (isset($_GET['task']) && $_GET['task'] == "remove") {
		
		if($infoba['rank'] == '1'){
			$id = mysql_real_escape_string(strip_tags($_GET['id']));
			if(!empty($id)){
				$scan_if = mysql_query("SELECT * FROM servers WHERE id='$id'");
				
				if(mysql_num_rows($scan_if) == 1 ){
					$fetch = mysql_fetch_array($scan_if);
					
					$box_name = mysql_fetch_array(mysql_query("SELECT name,location,ip,username,password FROM masine WHERE id='$fetch[box]'"));
						
					
					remove_server($box_name['ip'], $box_name['username'], $box_name['password'], $fetch['ftp_username']);		
					mysql_query("DELETE FROM servers WHERE id='$id'");
					$_SESSION['ok'] = "Server uspjesno obrisan!";
								echo "<script>window.location='/admin';</script>";
							die();	
						
				}
			} else {
			echo "2";
		}
		} else {
			echo "1";
		}
	}
	if (isset($_GET['task']) && $_GET['task'] == "reinstall") {
			$id = mysql_real_escape_string(strip_tags($_GET['server']));
			
			if(!empty($id)){
				if($infoba_rank == '0'){
				$scan_if = mysql_query("SELECT * FROM servers WHERE id='$id' and userid='$_SESSION[userid]' ");
				} else {
					$scan_if = mysql_query("SELECT * FROM servers WHERE id='$id' ");
				}
				
				if(mysql_num_rows($scan_if) == 1 ){
					$fetch = mysql_fetch_array($scan_if);
					
					if($fetch['status'] == '1'){
						$box_name = mysql_fetch_array(mysql_query("SELECT name,location,ip,username,password FROM masine WHERE id='$fetch[box]'"));
						
						$fetch_game_info = mysql_fetch_array(mysql_query("SELECT lokacija,komanda,mapa,protocol FROM igre WHERE id='$fetch[game]'"));
						
						require_once('gameq.php');
						$servers = array('server_'.$id => array($fetch_game_info['protocol'], $box_name['ip'], $fetch['port']));
						$gq = new GameQ();
						$gq->addServers($servers);
						$gq->setOption('timeout', 200);
						$gq->setFilter('normalise');
						$gq->setFilter('sortplayers');
						$data = $gq->requestData();
					
						if($data['server_'.$id]['gq_online'] == "1"){
						
							
			
							$stopuj = stop_server($box_name['ip'], $fetch['ftp_username'], $fetch['ftp_password'], $fetch['ftp_username']);
							
							if($stopuj == 'DA'){
								reinstall_server($box_name['ip'], $box_name['username'], $box_name['password'], $fetch['ftp_username'], $id, $fetch_game_info['lokacija']);
								
								$_SESSION['ok'] = "Server uspjesno reinstaliran!";
								header("Location: /gp/server/$id");
							} else {
								$_SESSION['error'] = "Ne mogu reinstalirati server!";
								header("Location: /gp/server/$id");
							}
							echo "ok 2";
							
						} else {
							$reinstal = reinstall_server($box_name['ip'], $box_name['username'], $box_name['password'], $fetch['ftp_username'], $id, $fetch_game_info['lokacija']);
							if($reinstal == 'DA'){
							$_SESSION['ok'] = "Server uspjesno reinstaliran!";
								header("Location: /gp/server/$id");
							} else {
							$_SESSION['error'] = "Ne mogu reinstalirati server!";
								header("Location: /gp/server/$id");
							}
							echo "ok 1";
						}
					
					} else {
					echo "ok 3";
					}
				} else {
					echo "ok 4";
					}
			} else {
					echo "ok 5";
					}
	}
	
	if (isset($_GET['task']) && $_GET['task'] == "modinstal") {
			$id = mysql_real_escape_string(strip_tags($_GET['server']));
			$modid = mysql_real_escape_string(strip_tags($_GET['modid']));
			
			if(!empty($id)){
				if($infoba_rank == '0'){
				$scan_if = mysql_query("SELECT * FROM servers WHERE id='$id' and userid='$_SESSION[userid]' ");
				} else {
					$scan_if = mysql_query("SELECT * FROM servers WHERE id='$id' ");
				}
				
				if(mysql_num_rows($scan_if) == 1 ){
					$fetch = mysql_fetch_array($scan_if);
					
					if($fetch['status'] == '1'){
						$box_name = mysql_fetch_array(mysql_query("SELECT name,location,ip,username,password FROM masine WHERE id='$fetch[box]'"));
						
						$fetch_game_info = mysql_fetch_array(mysql_query("SELECT lokacija,komanda,mapa,protocol FROM igre WHERE id='$fetch[game]'"));
						
						require_once('gameq.php');
						$servers = array('server_'.$id => array($fetch_game_info['protocol'], $box_name['ip'], $fetch['port']));
						$gq = new GameQ();
						$gq->addServers($servers);
						$gq->setOption('timeout', 200);
						$gq->setFilter('normalise');
						$gq->setFilter('sortplayers');
						$data = $gq->requestData();
					$select_gamemod =  mysql_fetch_array(mysql_query("SELECT mapa,lokacija FROM modovi WHERE id='$modid'"));
						if($data['server_'.$id]['gq_online'] == "1"){
						
							
			
							$stopuj = stop_server($box_name['ip'], $box_name['username'], $box_name['password'], $fetch['ftp_username']);
							
							if($stopuj == 'DA'){
								reinstall_server($box_name['ip'], $box_name['username'], $box_name['password'], $fetch['ftp_username'], $id, $select_gamemod['lokacija']);
								mysql_query("UPDATE servers SET gamemod='$modid', default_map='$select_gamemod[mapa]' WHERE id='$id'") or die(mysql_error());
								$_SESSION['ok'] = "Mod uspjesno instaliran!";
								header("Location: /gp/server/$id");
							} else {
								$_SESSION['error'] = "Ne mogu instalirati mod!";
								header("Location: /gp/server/$id");
							}
							echo "ok 2";
							
						} else {
							$reinstal = reinstall_server($box_name['ip'], $box_name['username'], $box_name['password'], $fetch['ftp_username'], $id, $select_gamemod['lokacija']);
							
							if($reinstal == 'DA'){
							mysql_query("UPDATE servers SET gamemod='$modid', default_map='$select_gamemod[mapa]' WHERE id='$id'") or die(mysql_error());
							$_SESSION['ok'] = "Mod uspjesno instaliran!";
								header("Location: /gp/server/$id");
							} else {
							$_SESSION['error'] = "Ne mogu instalirati mod!";
								header("Location: /gp/server/$id");
							}
							echo "ok 1";
						}
					
					} else {
					echo "ok 3";
					}
				} else {
					echo "ok 4";
					}
			} else {
					echo "ok 5";
					}
	}
	
	
	if (isset($_GET['task']) && $_GET['task'] == "plugininstal") {
			$id = mysql_real_escape_string(strip_tags($_GET['server']));
			$modid = mysql_real_escape_string(strip_tags($_GET['modid']));
			
			if(!empty($id)){
				if($infoba_rank == '0'){
				$scan_if = mysql_query("SELECT * FROM servers WHERE id='$id' and userid='$_SESSION[userid]' ");
				} else {
					$scan_if = mysql_query("SELECT * FROM servers WHERE id='$id' ");
				}
				
				if(mysql_num_rows($scan_if) == 1 ){
					$fetch = mysql_fetch_array($scan_if);
					
					if($fetch['status'] == '1'){
						$box_name = mysql_fetch_array(mysql_query("SELECT name,location,ip,username,password FROM masine WHERE id='$fetch[box]'"));
						
						$fetch_game_info = mysql_fetch_array(mysql_query("SELECT lokacija,komanda,mapa,protocol FROM igre WHERE id='$fetch[game]'"));
						
						
					
						
					$reinstal = install_plugin($box_name['ip'], $box_name['username'], $box_name['password'], $fetch['ftp_username'], $modid);
							
							if($reinstal == 'DA'){
						
							$_SESSION['ok'] = "Plugin uspjesno instaliran!";
								header("Location: /gp/server/$id");
							} else {
							$_SESSION['error'] = "Ne mogu instalirati plugin!";
								header("Location: /gp/server/$id");
							}
					} else {
					echo "ok 3";
					}
				} else {
					echo "ok 4";
					}
			} else {
					echo "ok 5";
					}
	}
	
	if (isset($_GET['task']) && $_GET['task'] == "pay") {
		$id = mysql_real_escape_string(strip_tags($_GET['serverid']));
		
		if(!empty($id)){
		$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$id'"));
		
			if($info['userid'] == $_SESSION['userid']){
			
				$price = intval($info['price']);
				
				$trenutno_kesa = get_ukupno_kes($_SESSION['userid']); 
				
				if($trenutno_kesa >= $price){ $cani = "<font color=lightgreen>dovoljno</font>"; $on = 1;} else { exit(); }
				
				$fakturisanje_q = valutiraj_posebno($_SESSION['userid']);
				
				
				$cena = (float) $info['price'];
				$arr = array();
				$i=0;
				foreach($fakturisanje_q as $key => $iznos){
					if($iznos >= $cena){	
					$i++;
						array_push($arr, $iznos);
						$najmanji = min($arr);
						$najmanji = str_replace(",", ".", $najmanji);
						$ajdi = $key;
					}
				}
				
				if($i==0){
					$array = array();
					foreach($fakturisanje_q as $key => $iznos){
					$iznos = (float) $iznos;		
					$zbir[$key] = $iznos;
					}
					$ukupno_plus = implode("+", $zbir);
					$rezultat = kalkuliraj($ukupno_plus);
					
					
					$kusur  = $rezultat-$cena;
					
					if($kusur <= 0.10){ $kusur = 0.2;}
					
					foreach($zbir as $id => $iznos){

						mysql_query("UPDATE uplate SET placeni_server='$id', placen='".time()."', log='[".date("d.m.Y - G:i")."] Plaćen server sabiranjem uplata.<br />',  status='3' WHERE id='$id'");
						
					}

				} else {
				$uplata_cijena = $najmanji;
				
				$kusur  = $uplata_cijena-$cena;
				if($kusur <= 0.10){ $kusur = 0.2;}

				mysql_query("UPDATE uplate SET placeni_server='$id', placen='".time()."', log='[".date("d.m.Y - G:i")."] Plaćen server iznosom $uplata_cijena €.<br />',  status='3' WHERE id='$ajdi'");
				}
				
				$check_any = mysql_num_rows(mysql_query("SELECT id FROM uplate WHERE status='1' AND userid='$_SESSION[userid]'"));
				
				if($check_any != 0){
									  
					mysql_query("UPDATE uplate SET iznos=iznos+$kusur, log='[".date("d.m.Y - G:i")."] Dodano $kusur € kao povratak novca pri plaćanju.<br />' WHERE userid='$_SESSION[userid]' and status='1' ORDER BY id DESC LIMIT 1");
				} else {
					mysql_query("INSERT INTO uplate (iznos,datum,status,vrsta_uplate,userid,valuta,bank_uplatioc,bank_datum,bank_racun,bank_uplatnica,log,bank_drzava) VALUES 
					('$kusur', '".time()."', '1', 'bank', '$_SESSION[userid]','EUR','Hosting', '".time()."', 'Ostatak uplate','img/logo.png','[".date("d.m.Y - G:i")."] Iznos je ostatak novca prilikom plaćanja.<br />','AH')
					") or die(mysql_error());
				}
			
				if($info['status'] != '0'){
					mysql_query("UPDATE servers SET status='1', datum_isteka=datum_isteka+2592000 WHERE id='$id'");
					echo "ok";
				}
			echo "<script>window.location='/gp/billing';</script>";
			
			
			}  else {
					echo "ok 4";
					}
		} else {
					echo "ok 5";
					}
		
	}
?>