<?php if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
}

$id = mysql_real_escape_string(strip_tags($_GET['id']));

$select = mysql_query("SELECT * FROM igre WHERE id='$id'");
$select_fetch = mysql_fetch_array($select);
if(mysql_num_rows($select) == 0){exit;}
?>
<script src="/js/custom.js" ></script>

<style>
.nav {
	height:50px;
}
body {
	color:white;
}
.grid_11 {
    width: 430px;
}
label {width:120px !important;}
ul {
    list-style: none outside none;
}
li {margin-bottom:10px;}
a {text-decoration:none;color:white;}
</style>
<br />
<br style="clear:both" />
<div class="admin_bg" >

<div class="grid_24">
	<div class="content_block">
		<div class="blokba"><?php echo $select_fetch['name']; ?></div>
	</div>
	<!-- end .content_block -->
	<div class="clear"></div>
</div>
<!-- end .grid_24 -->

<br style="clear:both" />

	<div style="width: 230px;float:left;font-transform:uppercase;">
		<center>
		<img width="150" src="/img/gamecover/<?php echo $select_fetch['protocol']; ?>.png" /><br />
			<b><small><?php echo $select_fetch['name']; ?></small></b>
		</center>
		<!-- end .content_block -->
		<br style="clear:both" />
	</div>
	<!-- end .grid_6 -->

<script>
	function change_slots(loc){
		if(loc == 'premium'){
			
		} else {
			
		}
	}
</script>
	<div style="float:left;">
		<div class="content_block">
			<form class="test_class" method="POST" action="/process.php?task=order">
			<input type="hidden" name="gameo" id="gameo" value="<?php echo $id; ?>">
				<p>
					<label for="location">Lokacija</label>
					<select name="box" id="location" onChange="javascript:price_calculate();change_slots(this.value);">
						<option value="lite">Frankfurt, Germany</option>
						<option value="lite">Roubaix, France</option>
						<option value="premium">Sofia, Bulgaria</option>
					</select>
				</p>
				<p>
					<label for="slots">Broj slotova</label>
					<select name="slots" class="lite" id="slots" onChange="javascript:price_calculate();">
						<?php
							$slots = mysql_query("SELECT * FROM slots WHERE game='$id' and type='lite'");
							while($game_slots_array = mysql_fetch_array($slots)){
								echo '<option value="'.$game_slots_array['slots'].'">'.$game_slots_array['slots'].'</option>';
							}
						?>
					</select>
					
				</p>
				
				<p>
					<label for="period">Period</label>
					<select name="period" id="period" onChange="javascript:price_calculate();">
						<option value="1">1 mjesec</option>
						<option value="2">2 mjeseca (5% popust)</option>
						<option value="3">3 mjeseca (10% popust)</option>
						<option value="6">6 mjeseci (20% popust)</option>
					</select>
				</p>

				<p>
					<label for="server_name">Ime Servera</label>
					<input type="text" name="server_name" id="server_name" />
				</p>
				<p>
				<script src="http://lab.narf.pl/jquery-typing/jquery.typing-0.2.0.min.js"></script>
		<script>
		$( document ).ready(function() {
			
			$("#kupon").typing({
              start: function () {$(".provjera").html('<font color=orange>Provjeravam...</font>');},
              stop: function () {
			  
				price_calculate();
			  },
              delay: 400
            });
		});
		</script>
					<label for="kupon">Kupon</label>
					<input type="text" name="kupon" id="kupon" /> 
				</p>
				<p>
					<label for="ksubmit_game_orderupon">&nbsp;</label>
							<small><span class="provjera"></span></small>
						
				</p>
				<p>
					<label for="ksubmit_game_orderupon">&nbsp;</label>
							<button class="edit_server" >Naruči!</button>
						
				</p>
			</form>
		</div>
		<!-- end .content_block -->
		<br style="clear:both" />
	</div>
	<!-- end .grid_11 -->


	<div style="width:340px;float:right;" class="grid_7">
		<div class="content_block">
		<div class="blokba">Kalkulator cijene</div>
		<center>
			<div style="border:#358F50 1px solid;text-align:center;float:none;" class="mali_box"><div id="pricely">2.6 €</div>  </div>
		</center>
		<br style="clear:both" />
		<br style="clear:both" />
			<div class="blokba">Trenutno u ponudi</div>
			<ul id="sidebar_games">
				<?php
				$gamelist2_query = mysql_query("SELECT * FROM igre WHERE id!='$id'");
				while($gamelist2_row = mysql_fetch_assoc($gamelist2_query)){
					$gamelist2_title		= $gamelist2_row['name'];
					$gamelist2_icon			= $gamelist2_row['protocol'];

					echo '<li><img style="padding-right:8px;" src="/img/gameicons/'.$gamelist2_icon.'.png" alt="" /><a  href="/order/'.$gamelist2_row['id'].''.$gamelist2_title_safe.'">'.$gamelist2_title.'</a></li>';
				}
				?>
			</ul>
		</div>
		<!-- end .content_block -->
		<br style="clear:both" />
		

	</div>
	<!-- end .grid_7 -->


<br style="clear:both" />
</div>
<br style="clear:both" />
