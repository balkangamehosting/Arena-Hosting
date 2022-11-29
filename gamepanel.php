<?php
ob_start();

if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
}

?>
<style>
.nav {
	height:50px;
}

	.fancybox-skin {
		background: rgba(0,0,0,0.85);
		border: solid 1px rgba(48,99,105,0.85);
		font-family:calibri;
		color:white;
	}

</style>
<div id="header_div" >
	<div style="padding:5px;padding-top:9px;">
		<ul>
			<li><a href="/gp/pocetna"><img src="/img/home.png" />Vjesti</a></li>
			<li><a href="/gp/serveri"><img src="/img/server.png" />Serveri</a></li>
			<li><a href="/gp/billing"><img src="/img/billing.png" />Billing</a></li>
			<li><a href="/gp/podrska"><img src="/img/support.png" />Podrška</a></li>
			<li><img src="/img/warning.png" /><?php echo $obavjestenje; ?></li>
		</ul>
	</div>
</div>
<br />
<br style="clear:both" />
<div class="admin_bg" >
<?php

 include("gp$_GET[pa].php"); ?>
</div>

<div class="footer_height_add"></div>
<br />