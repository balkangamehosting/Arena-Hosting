   <!-- Content -->
  <div class="main-content">
  <style>
	.c {
	    -moz-border-radius: 50%; 
    -webkit-border-radius: 50%; 
    border-radius: 50%;
	text-align:center;
	width:10px;
background:black;
border:solid #292929 1px;
padding:2px;
color:white;
font-family:calibri;
font-size:11px;
float:left;margin-right:5px;
	}
	.c:hover {
		background:#016717;
		border:solid 1px #00b505;
	}
	.c a {
		color:white;
		text-decoration:none;
	}
	.pagination {
	margin-top:150px;
	margin-left:130px;
	float:left;
	}
	</style>
    <!-- NEWS -->
    <div class="news_space"></div>
	<div class="news">
	
    <div id="slideshow">
	<span style="margin-top:120px;float:left;color:white;margin-left:60px;z-index:10000;position:absolute;" >
		<div class="c"><a href="javascript:;" onClick="sljedecaba(1);"><</a></div>
		<div class="c"><a href="javascript:;" onClick="sljedecaba(1);">1</a></div>
		<div class="c"><a href="javascript:;" onClick="sljedecaba(1);">2</a></div>
		<div class="c"><a href="javascript:;" onClick="sljedecaba(1);">3</a></div>
		<div class="c"><a href="javascript:;" onClick="sljedecaba(1);">></a></div>
	</span>
    <div>
     <img style="width:240px;height:150px;z-index:1;" src="/img/slide1.png">
	 <p>Gpanel <span class="date">27.12.2013</span></p>
	 <p class="text"><span style="color:#00b8b1;">News:</span> 23.09.2018 pusten je u rad novi GamePanel v2.Nadamo se da smo vam olaksali i uprostili rukovanje vasim serverom. DBK Hosting Team.  Read more</p>
    </div>
    <div>
     <img style="width:240px;height:150px;" src="/img/slide2.png">
	 <p>GameTracker <span class="date">23.09.2018</span></p>
	 <p class="text"><span style="color:#00b8b1;">News:</span> 23.09.2018 pusten je u rad Gametracker. Dodajte vas server na nas GameTracker i uzivajte u pracenju vaseg server rank-a..</p>  </div>
    </div>
	
	<div class="buy_space"></div><a href="/buy"><div class="buy_button"></div></a>
	<a href="/test"><div class="test_button"></div></a>
	
    </div>
    <!-- STOP -->
	
	
	<!-- NEWS SLIDER -->
	<div id="news-container">
	<ul>
		<li>
			<div>
			<?php
			$k_q = mysql_query("SELECT * FROM kuponi ORDER BY home DESC LIMIT 1");
			while($r = mysql_fetch_array($k_q)){
				?>
				<br>
				
				
					
				</tr>
				<?php
			}
			   
			?>
				
				
			</div>
		</li> 
	</ul>
    </div>
	<!-- STOP NEWS -->
	
	
	<!-- GameBOX -->
	<div class="gameboxbg">
	 <div class="gamebg_height"></div>
	 
	  <div class="gameboxbg_test">

	 <div class="gamebg">
	 <div class="game-image"><img style="margin-left:1px;margin-top:1px;" src="/img/cs-slider.png"></div>
	 <div class="game-title">COUNTER-STRIKE 1.6</div>
	 <div class="game-content">
	 <span style="color:#00b8b1;">Premium Location Serbia:</span><br />
	 Latency: Ping 5-20ms <br />
	 Price: Already from $5/month <br />
	 <span style="color:#00b8b1;">Lite Location Germany:</span><br />
	 Latency: Ping 20-50ms <br />
	 Price: Already from $3/month
	 </div>
	 <div class="game-button"><a href="/order/1">BUY IT</a> <a href="/try">TRY IT</a></div>
	 </div>
	 
	 <div class="gamebg-second">
	 <div class="game-image"><img style="margin-left:1px;margin-top:1px;" src="/img/samp.png"></div>
	 <div class="game-title">SAN ANDREAS MULTIPLAYER</div>
	 <div class="game-content">
	 <span style="color:#00b8b1;">Premium Location Serbia:</span><br />
	 Latency: Ping 5-20ms <br />
	 Price: Already from $5/month <br />
	 <span style="color:#00b8b1;">Lite Location Germany:</span><br />
	 Latency: Ping 20-50ms <br />
	 Price: Already from $3/month
	 </div>
	 <div class="game-button"><a href="/order/2">BUY IT</a> <a href="/try">TRY IT</a></div>
	 </div>
	 
	 <div class="gamebg-third">
	 <div class="game-image"><img style="margin-left:1px;margin-top:1px;" src="/img/ts.png"></div>
	 <div class="game-title">TEAMSPEAK 3</div>
	 <div class="game-content">
	 <span style="color:#00b8b1;">Premium Location Serbia:</span><br />
	 Latency: Ping 5-20ms <br />
	 Price: Already from $5/month <br />
	 <span style="color:#00b8b1;">Lite Location Germany:</span><br />
	 Latency: Ping 20-50ms <br />
	 Price: Already from $3/month
	 </div>
	 <div class="game-button"><a href="/buy">BUY IT</a> <a href="/try">TRY IT</a></div>
	 </div>
	 
	 <div class="scroll_height"></div>
	 
	 </div>
	
	</div>
	<!-- GAMEBOX STOP -->
	
	<div class="line_new"></div>
	
	<!-- Calc -->
	
	<div class="calculator">
	
	<?php
	
	if($_GET['value']){
		$val = $_GET['value'];
		switch($val){
			case 'km':
				$_SESSION['valuta'] = "km"; 
			break;
			case 'eur':
				$_SESSION['valuta'] = "eur"; 
			break;
			case 'din':
				$_SESSION['valuta'] = "din"; 
			break;
			case 'mkd':
				$_SESSION['valuta'] = "mkd"; 
			break;
			case 'kn':
				$_SESSION['valuta'] = "kn"; 
			break;
		}
	}
	$valuta = $_SESSION['valuta'];
	if(!isset($_SESSION['valuta'])){$_SESSION['valuta']=='eur';}else{}
	switch($valuta){
			case 'km':
				$val = "<small>KM</small>";
			break;
			case 'eur':
				$val = "&#8364;";
			break;
			case 'din':
				$val = "<small>DIN</small>"; 
			break;
			case 'mkd':
				$val = "<small>MKD</small>"; 
			break;
			case 'kn':
				$val = "<small>KN</small>"; 
			break;
		}
	
	
	
	$slots = addslashes($_GET['slots']);
	$months = addslashes($_GET['months']);
	
	switch($valuta){
	case 'eur':
		if($slots == "12"){ $price = "4.8"; }
		if($slots == "14"){ $price = "5.6"; } 
		if($slots == "16"){ $price = "6.4"; } 
		if($slots == "18"){ $price = "7.1"; } 
		if($slots == "20"){ $price = "8"; }
		if($slots == "22"){ $price = "8.8"; }
		if($slots == "24"){ $price = "9.6"; }
		if($slots == "26"){ $price = "10.4"; } 
		if($slots == "28"){ $price = "11.2"; }
		if($slots == "30"){ $price = "12"; } 
		if($slots == "32"){ $price = "12.8"; }
	break;
	case 'km':
		if($slots == "12"){ $price = "9.4"; }
		if($slots == "14"){ $price = "11.2"; } 
		if($slots == "16"){ $price = "12.8"; } 
		if($slots == "18"){ $price = "14.4"; } 
		if($slots == "20"){ $price = "16"; }
		if($slots == "22"){ $price = "17.6"; }
		if($slots == "24"){ $price = "19.2"; }
		if($slots == "26"){ $price = "20.8"; } 
		if($slots == "28"){ $price = "22.4"; }
		if($slots == "30"){ $price = "24"; } 
		if($slots == "32"){ $price = "25.6"; }
	break;
	case 'din':
		if($slots == "12"){ $price = "576"; }
		if($slots == "14"){ $price = "672"; } 
		if($slots == "16"){ $price = "768"; } 
		if($slots == "18"){ $price = "864"; } 
		if($slots == "20"){ $price = "960"; }
		if($slots == "22"){ $price = "1056"; }
		if($slots == "24"){ $price = "1152"; }
		if($slots == "26"){ $price = "1248"; } 
		if($slots == "28"){ $price = "1344"; }
		if($slots == "30"){ $price = "1440"; } 
		if($slots == "32"){ $price = "1536"; }
	break;
	case 'mkd':
		if($slots == "12"){ $price = "288"; }
		if($slots == "14"){ $price = "336"; } 
		if($slots == "16"){ $price = "384"; } 
		if($slots == "18"){ $price = "432"; } 
		if($slots == "20"){ $price = "480"; }
		if($slots == "22"){ $price = "528"; }
		if($slots == "24"){ $price = "576"; }
		if($slots == "26"){ $price = "624"; } 
		if($slots == "28"){ $price = "672"; }
		if($slots == "30"){ $price = "720"; } 
		if($slots == "32"){ $price = "768"; }
	break;

	}
	switch($months){
	case '2':
		$price = $price*2;
	break;
	case '3':
		$price = $price*3;
	break;
	}
	?>
	
	<div class="simpleTabs">
		    <ul class="simpleTabsNavigation">
		      <li><a href="#"><span style="margin-left:-8px;">LITE</span></a></li>
		      <li><a href="#"><span style="margin-left:-20px;">PREMIUM</span></a></li>
			  <li><a href="#"><span style="margin-left:-20px;">VALUTA</span></a></li>
		    </ul>
		    <div class="simpleTabsContent">
			<form method="get" action="">
			 <div style="height:1px;"></div>
		     <label>Choose Location:</label><select name="mod"><option value="pub">Public</option><option value="dm">Deathmatch</option><option value="dr">Deathrun</option><option value="hns">Hide n Seek</option><option value="zm">Zombie</option><option value="gg">Gungame</option><option value="cod">COD</option><option value="kz">Kreedz</option><option value="surf">Surf</option><option value="cw">ClanWar</option></select> <br /><br />
			 <label>Choose slots: </label>
			 <select name="slots" onchange="this.form.submit()" id="slots">
             <option value="12" <?php if($_GET['slots'] == '12'){echo "selected";}else{echo"";} ?> name="slots" id="slots">12 SLOTS</option>
             <option value="14" <?php if($_GET['slots'] == '14'){echo "selected";}else{echo"";} ?> name="slots" id="slots">14 SLOTS</option>
             <option value="16" <?php if($_GET['slots'] == '16'){echo "selected";}else{echo"";} ?> name="slots" id="slots">16 SLOTS</option>
             <option value="18" <?php if($_GET['slots'] == '18'){echo "selected";}else{echo"";} ?> name="slots" id="slots">18 SLOTS</option>
             <option value="20" <?php if($_GET['slots'] == '20'){echo "selected";}else{echo"";} ?> name="slots" id="slots">20 SLOTS</option>
             <option value="22" <?php if($_GET['slots'] == '22'){echo "selected";}else{echo"";} ?> name="slots" id="slots">22 SLOTS</option>
             <option value="24" <?php if($_GET['slots'] == '24'){echo "selected";}else{echo"";} ?> name="slots" id="slots">24 SLOTS</option>
             <option value="26" <?php if($_GET['slots'] == '26'){echo "selected";}else{echo"";} ?> name="slots" id="slots">26 SLOTS</option>
             <option value="28" <?php if($_GET['slots'] == '28'){echo "selected";}else{echo"";} ?> name="slots" id="slots">28 SLOTS</option>
             <option value="30" <?php if($_GET['slots'] == '30'){echo "selected";}else{echo"";} ?> name="slots" id="slots">30 SLOTS</option>
             <option value="32" <?php if($_GET['slots'] == '32'){echo "selected";}else{echo"";} ?> name="slots" id="slots">32 SLOTS</option>
			 </select> <br /><br />

			 <label>Choose months: <label><select name="months"><option value="1">1 months</option>
			 <option value="2">2 months</option>
			 <option value="3">3 months</option>
			 </select> <br /><br />
			 <div class="price"> <?php if($price == ""){ echo "0 $val"; } else { echo "".$price." $val"; } ?> <br /> <br /> </div>
			</form>
			
				<div class="notice"><span style="color:#522d05;">Notice:</span> Select a game from the list, in order to count the price of the Server.</div>

			</div>
		    <div class="simpleTabsContent">
		      <div>
		        <div>
		          <div>
		            <div>
                        <div class="soon"><br /><div class="space"></div>COMING SOON!</div>		           
				   </div>
		          </div>
		        </div>
		      </div>
		    </div>
			<div class="simpleTabsContent">
		      <div>
		        <div>
		          <div>
		            <div>
					<style>
					.soon a {
					text-decoration:none;
					}
					</style>
                        <div class="soon" ><br /><div class="space"></div>
						<a style="color:white;" href="/index.php?value=km">[KM]</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
						<a style="color:white;" href="/index.php?value=eur">[EUR]</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
						<a style="color:white;" href="/index.php?value=din">[DIN]</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a style="color:white;" href="/index.php?value=mkd">[MKD]</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
						</div>		           
				   </div>
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>
		  	
	</div>
	<!-- STOP Calc -->
	
	<!-- Statistic -->
	<div class="statistic">
	  <div class="first_height"></div><div class="statistic_first"></div><div class="statistic_first_text">0<span style="color:#039ba5;">39</span></div>
	  <div class="statistic_second"></div><div class="statistic_second_text">00<span style="color:#039ba5;">2</span></div>
	  <div class="statistic_third"></div><div class="statistic_third_text">0<span style="color:#039ba5;">46</span></div>
	
	</div>
	<!-- STOP STATISTIC -->
	
	
	<!-- Video -->
	<div class="video_height"></div>
	<div class="video">
	<iframe width="290" height="195" style="margin-left:7px;margin-top:6px;" src="http://www.youtube.com/embed/5Cjrp23lBSM" frameborder="0" allowfullscreen></iframe>
	</div>
	<!-- STOP VIDEO -->
	
	
	<!-- Quotes -->
    <div class="quotes">
	<div id="slideshow2">
	<?php
	$query = mysql_query("SELECT * FROM site_comments WHERE status='1'");
	while($row = mysql_fetch_array($query)){
	?>
    <div>
      <div class="avatar"><img style="width:35px;height:35px;margin-top:60px;margin-left:5px;" src="<?php echo $row['avatar']; ?>"></div>
	  <div style="width:60px;text-align:center;">
	  <div class="quote_name"><?php echo $row['name']; ?></div>
	  <div class="quote_date">At <?php echo $row['time']; ?></div>
	  <div class="quote_site"><a target="_blank" href="<?php echo $row['website']; ?>"><?php echo substr($row['website'],0,15); ?></a></div>
	  </div>
	  <div style="width:100px;" class="quote_content"><?php echo substr($row['message'],0,150); ?></div>
    </div>
	<?php } ?>
    </div>
	
	<div class="pagination">
	
	<div class="c"><a href="javascript:;" onClick="sljedeca(1);"><</a></div>
	<div class="c"><a href="javascript:;" onClick="sljedeca(1);">1</a></div>
	<div class="c"><a href="javascript:;" onClick="sljedeca(1);">2</a></div>
	<div class="c"><a href="javascript:;" onClick="sljedeca(1);">3</a></div>
	<div class="c"><a href="javascript:;" onClick="sljedeca(1);">></a></div>
	
	</div>
	<a href="#add_comment" name="modal"><br /><div class="add_comment"></div></a>
	</div>
	
    <!-- STOP QUOTES -->
	
	
	<!-- LINKS -->
	<div class="links">
	
	<div class="quick_height"></div>
	<div class="quick_menu">
	<ul>
	<li><a href="/index.php">HOME PAGE</a></li>
	<li><a target="_blank" href="http://gpanel.dbk-hosting.biz">GAME PANEL</a></li>
	<li><a href="">GAMEHOSTING</a></li>
	<li><a href="/servers">GAME TRACKER</a></li>
	<li><a href="">STORE</a></li>
	<li><a href="">ASSET BASE</a></li>
	<li><a target="_blank" href="">FORUM</a></li>
	<li><a href="/contact">CONTACT</a></li>
	</ul>
	</div>
	
	<div class="social">
	<br>
	<a href="http://dbk-hosting.biz/">DBK Hosting</a><br />
	<a href="">FACEBOOK</a><br />
	<a href="">TWITTER</a><br />
	<a href="">GOOGLE+</a>
	</div>
	
	<div class="contact">
    itszensei@gmail.com <br />
    milan.slavkovic@gmx.ch
	</div>
	
	</div>
	<!-- STOP LINKS -->
  
  </div>
  <!-- Content STOP -->
  
</div>