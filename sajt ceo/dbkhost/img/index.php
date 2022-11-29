<?php
session_start();
if(!isset($_SESSION['valuta'])){
	$_SESSION['valuta'] = "eur"; 
}
$start = microtime();
include_once("connect_db.php");

$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));

$infoba = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));



$avatar = $infoba['avatar'];
	if(empty($avatar)){
		$infoba_avatar = "/img/userno.png";
	}else {
		$infoba_avatar = "/avatars/$infoba[avatar]";
	}
if($info['banned'] == "1"){
	exit("
	<div style='background:whitesmoke;border:solid lightgrey 1px;font-family:calibri;padding:10px;width:300px;margin:50 auto;color:red;'>
		Banovani ste! <br />
		Kliknite <a href='/logout.php'>ovdje</a> da se izlogujete.
	</div>
	
	");
}
?>
<!doctype html>
<head>
    <meta charset="UTF-8" />
    <title><?php echo $title; ?></title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="DBK Hosting">

    <link href="/css/style.css" media="screen" rel="stylesheet" type="text/css">
	 <link href="/css/fatlist.css" media="screen" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="img/favicon.ico">

	
	<!-- Add jQuery library -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

<link rel="stylesheet" href="/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
	 <link rel="stylesheet" href="/css/jquery-ui.css">
	 <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	 <script>
 $(function() {
$( document ).tooltip({
track: true
});
});
</script>
		<style type="text/css" media="screen">
			@import "css/simpletabs.css";
		</style>
	

	
	
	<script type="text/javascript" src="/js/simpletabs_1.3.js"></script>
	<script>
		$(function() {
		
			$("#slideshow > div:gt(0)").hide();
	
			setInterval(function() { 
			  $('#slideshow > div:first')
			    .fadeOut(1000)
			    .next()
			    .fadeIn(1000)
			    .end()
			    .appendTo('#slideshow');
			},  8000);
			
		});
	</script>
	<script>
		$(function() {
		
			$("#slideshow2 > div:gt(0)").hide();
	
			setInterval(function() { 
			  $('#slideshow2 > div:first')
			    .fadeOut(1000)
			    .next()
			    .fadeIn(1000)
			    .end()
			    .appendTo('#slideshow2');
			},  8000);
			
		});
		function sljedeca(id){
			$("#slideshow2 > div:gt(0)").hide();
	
			
			  $('#slideshow2 > div:first')
			    .fadeOut(1000)
			    .next()
			    .fadeIn(1000)
			    .end()
			    .appendTo('#slideshow2');
			
		}
		function sljedecaba(id){
			$("#slideshow > div:gt(0)").hide();
	
			
			  $('#slideshow > div:first')
			    .fadeOut(1000)
			    .next()
			    .fadeIn(1000)
			    .end()
			    .appendTo('#slideshow');
			
		}
	</script>
	

    	

		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-16375363-5']);
		  _gaq.push(['_setDomainName', '.nuevvo.com']);
		  _gaq.push(['_trackPageview']);

		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
		
<script>

$(document).ready(function() {	

	//select all the a tag with name equal to modal
	$('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
		var id = $(this).attr('href');
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000); 
	
	});
	
	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});			
	

	$(window).resize(function () {
	 
 		var box = $('#boxes .window');
 
        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
      
        //Set height and width to mask to fill up the whole screen
        $('#mask').css({'width':maskWidth,'height':maskHeight});
               
        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();

        //Set the popup window to center
        box.css('top',  winH/2 - box.height()/2);
        box.css('left', winW/2 - box.width()/2);
	 
	});	
	
});

</script>
<script type="text/javascript">
$('#iform').submit(function(e) {   
  $('#slider').anythingSlider($("#input1").val());
  e.preventDefault(); 
});
</script>

	<script>
	$(document).ready(function(){
		if(document.getElementById("error") !== null)
			{
			setTimeout(function(){$("#error").fadeOut();}, 5000);
			}
			if(document.getElementById("ok") !== null)
			{
			setTimeout(function(){$("#ok").fadeOut();}, 5000);
			}
	});
	</script>
</head>
<div class="loading" style="display:none;background:rgba(0,0,0,0.65);position:absolute;width:100%;height:100%;color:white;float:left;z-index:100000000;font-family:calibri;">
<br /><br /><br /><br /><br /><br /><center><span style="font-size:30px;">Momenat...</span>
<div style="font-size:55px;width:100px"><marquee>. . . . . </marquee></div></center>
</div>
 <!-- SESSION -->
   <?php
     if(isset($_SESSION['ok'])){
	 $ok = $_SESSION['ok'];
	 echo "<center><div id=\"ok\"><span style=\"color:#522d05;\">NOTICE:</span> $ok</div></center>";
	 unset($_SESSION['ok']);
     } else if(isset($_SESSION['error'])){
  	 $greske = $_SESSION['error'];
	 echo "<center><div id=\"error\"><span style=\"color:#522d05;\">NOTICE:</span> $greske</div></center>";
	 unset($_SESSION['error']);
     } else {
   ?>
   <?php } ?>
   <!-- STOP Session -->
<div style="right:0;position:absolute;">
	<img src="/img/slauf.png" width="128" />
</div>

<div class="topline">
   <div class="topline_width">
  
   <!-------
   
   ----->
   <?php
   if($_SESSION['userid'] != ""){ 
   
   $notif = mysql_num_rows(mysql_query("SELECT id FROM notifications WHERE userid='$_SESSION[userid]' and `read` = '0'"));
   if($notif != 0) { $notif = "(".$notif.")"; } else {$notif = '';}
   
   $notifikacije_n = mysql_num_rows(mysql_query("SELECT id FROM servers WHERE `viewed` = '0'"));
   $new_tickets = mysql_num_rows(mysql_query("SELECT id FROM tickets WHERE `read` = '0'"));
   
   $notifikacije_uk = $notifikacije_n+$new_tickets;
   
   if($notifikacije_n != 0) { $notifikacije_n = "(".$notifikacije_uk.")"; } else {$notifikacije_n = '';}
   ?>
   <style>.asd div {margin-right:20px;float:left;} .asd a {color: #02E933;}</style>
   <div class="asd" style="color:green !important;font-size:14px;">
   
		<?php echo "<div><a href='/user/$_SESSION[username]'>$_SESSION[username]</a></div>"; ?> 
		
		
		<?php if($info['rank'] == "1"){ ?><div ><a style="color:#FF0000;" href="/admin">Admin <?php echo $notifikacije_n; ?></a></div><?php } else if($info['rank'] == "2") {?> <div ><a style="color:orange;" href="/admin">Support <?php echo $notifikacije_n; ?></a></div><?php } ?>
		
		<div><a href="/notifications">Notifikacije <?php echo $notif; ?></a></div>
		
		<div><a href="/server_orders">Moj panel (<?php
		$num = mysql_num_rows(mysql_query("SELECT id FROM servers WHERE userid='$_SESSION[userid]'"));
		echo $num;
		
		?>)</a></div>
		
		
		<div><a href="/order/1">Naruci</a></div>
		
		<div><a href="/logout.php">Logout</a></div>
		
		<br style="clear:both" />
	</div>
   <?php } else { ?>
   <span style="color:#00b8b1;">News:</span> <span style="color:white;">DBK Hosting published its new website! More detailes <a href="">here</a></span>.
   <?php } ?>
   <!-- Lang -->
		  <div class="lang_bg">
		  <div class="space"></div><a href="/srb"><div class="srb"><img src="/img/srb_normal.png"></div></a>
		  </div>
   <!-- Lang STOP -->
   
   </div>
</div>



<div id="content">


  <img class="logo" style="" src="/img/logo.png">
  
  <!-- Login -->
  <div class="login">
    <div class="form"><div class="space_login"></div>
	<?php
	if($_SESSION['userid'] == ""){
	?>
    <form action="/process.php?task=login" method="POST">
    <span class="id">ID</span><input type="text" placeholder="Username" name="username"><br /><div class="space"></div>
	<span class="pw">PW</span><input type="password" placeholder="Password" name="password">
	<button class="go_button"></button> <br />
	<input type="checkbox" checked="checked" id="first"> <span class="remember">Remember me?</span>
	</form>
	
	<div class="register"><a href="/register" name="modals"><img src="/img/register.png"></a> <div class="forgot">Forgot <a href="/forgot" name="modals">PW?</a></div> </div>

	<?php } else { 
		$get_q = mysql_fetch_array(mysql_query("SELECT userid FROM users WHERE username='$_SESSION[username]'"));
		$get_q2 = mysql_num_rows(mysql_query("SELECT id FROM points WHERE userid='$get_q[userid]'"));
		$get_q3 = mysql_num_rows(mysql_query("SELECT id FROM servers WHERE userid='$get_q[userid]'"));
	?>
	<style>
	 .mali_box {
		-webkit-border-radius: 2px;
-moz-border-radius: 2px;
border-radius: 2px;
margin-right:10px;
border:solid #02a0a2 1px;
padding:5px;
float:left;
text-align:center;
font-size:21px;
	 }
	 .mali_box span{
		font-size:9px;
	 }
	</style>
	- Welcome back [ <?php echo "<span style=\"color:#00ff18;\">$_SESSION[username]</span>"; ?> ] <br /><br />
	<a href="/user/<?php echo $_SESSION['username']; ?>">
		<div class="mali_box">
			<img src="<?php echo $infoba_avatar; ?>" width="47" />
		</div>
	</a>
	<a href="/referal">
		<div class="mali_box">
		<?php echo $get_q2; ?><br /><span>REFERALS</span>
		</div>
	</a>
	<a href="/community">
		<div class="mali_box">
		<span>COMMUNITY</span><br />
		<a href="/logout.php"><span><font color=red>LOGOUT</font></span></a>
		</div>
	</a>
	<?php /*
	<a href="/referal"><span style="color:#FF0000;">- Referal</span></a><br />
	<a href="/server_orders"><span style="color:#FF0000;">- Server orders</span></a><br />
	<?php if($info['rank'] == "1"){ ?><a href="/admin"><span style="color:#FF0000;">- Admin Panel</span></a><br /><?php } else {} ?>
	<a href="/community"><span style="color:green;">- Moja zajednica</span></a><br />
	<a href="/logout.php">- Logout</a>*/ ?>
	<?php } ?> 
    </div>
		
  </div>
  <!-- STOP Login -->
  
  
  <!-- Menu -->
  <div class="nav">
    <ul>
	   <li><a href="/index.php">HOME PAGE</a></li>
	   <li><a  href="/gp/pocetna">GAME PANEL</a></li>
        <li>
        <a href="#" class="main">GAMETRACKER</a>
        <div class="sub-nav-wrapper"><ul class="sub-nav"><div class="space_menu"></div>
            <li><a href="/servers">LISTA SVIH SERVERA</a></li>
			<li><a href="/communities">LISTA SVIH ZAJEDNICA</a></li>
        </ul></div>
        </li>
  	   <li>
        <a href="#" class="main">SERVICE&nbsp;&nbsp;&nbsp;</a>
        <div class="sub-nav-wrapper"><ul class="sub-nav"><div class="space_menu"></div>
            <li><a href="/order/1">ORDER A COUNTER-STRIKE</a></li>
			<li><a href="/order/2">ORDER A SANANDREAS-MP</a></li>
            <li><a href="/order/3">ORDER A VOICE SERVER</a></li>
        </ul></div>
        </li>
	   <li style="background-position:30px 30px"><a href="/top">TOP 20&nbsp;&nbsp;</a></li>
	   <li style="background-position:30px 30px"><a target="_blank" href="">FORUM&nbsp;&nbsp;</a></li>
	   <li style="background-position:30px 30px"><a href="/contact">CONTACT</a></li>
	</ul>
  </div>
  <!-- Menu STOP -->
  
    <?php
	if($_GET['page'] == "contact"){
	  include("contact.php");
	} else if($_GET['page'] == "order"){
	  include("order.php");
	} else if($_GET['page'] == "admin"){
	  include("admin.php");
	} else if($_GET['page'] == "server_review"){
	  include("server_review.php");
	} else if($_GET['page'] == "server_orders"){
	  include("server_orders.php");
	} else if($_GET['page'] == "review"){
	  include("review.php");
	} else if($_GET['page'] == "referal"){
	  include("referal.php");
	} else if($_GET['page'] == "give_point"){
	  include("give_point.php");
	} else if($_GET['page'] == "servers"){
	  include("servers.php");
	} else if($_GET['page'] == "tickets"){
	  include("tickets.php");
	} else if($_GET['page'] == "user"){
	  include("user.php");
	
	
	############# GAME PANEL ############
	} else if($_GET['page'] == "gamepanel"){
	  $_GET['pg'] = $_GET['pa']; include("gamepanel.php");
	############# GAME PANEL ############
	} else if($_GET['page'] == "activate"){
	  include("activate.php");
	} else if($_GET['page'] == "useredit"){
	  include("useredit.php");
	} else if($_GET['page'] == "ticket"){
	  include("ticket.php");
	} else if($_GET['page'] == "server_info"){
	  include("server_info.php");
	} else if($_GET['page'] == "server_banner"){
	  include("server_banner.php");
	} else if($_GET['page'] == "community"){
	  include("community.php");
	} else if($_GET['page'] == "community_info"){
	  include("community_info.php");
	} else if($_GET['page'] == "communities"){
	  include("communities.php");
	} else if($_GET['page'] == "forgot"){
	  include("forgot.php");
	} else if($_GET['page'] == "top"){
	  include("top.php");
	} else if($_GET['page'] == "notifications"){
	  include("notifications.php");
	} else if($_GET['page'] == "register"){
	  include("register.php");

	} else {
	  include("content.php");
	}
	?>
	
	</div>

	<?php
	$end = microtime();
    $creationtime = ($end - $start) / 1000;
	?>
	
    <!-- Footer -->
	<br>
	<div class="footer">
	<div class="footer_width"><a href="http://dbk-hosting.biz/">DBK-HOSTING.BIZ</a> <div class="metkovi"></div> <span style="float:right;margin-top:-40px;">Copyright &copy; 2016-2018 <a href="http://dbk-hosting.biz/">DBK Hosting d.o.o</a> - All rights reserved <?php printf("%.5f", $creationtime) ?></span> </div>
	</div>
	<!-- STOP FOOTER -->
	
	
	
	<!-- Modals -->
	<div id="boxes">
	
	<div id="register" class="window">
    <div class="modal-register1">
    <div class="close"><a href="#"class="close"/>X</a></div>
    <div class="modal-title">
    REGISTER <hr /> <br />
    <form action="/process.php?task=register" method="POST">
    <input type="text" name="username" placeholder="Your username" required="required"/>
	<div class="space"></div>
	
	<input type="text" name="ime" placeholder="Your firstname"  required="required"/>
	<div class="space"></div>
	
	<input type="text" name="prezime" placeholder="Your lastname" required="required"/>
    <div class="space"></div>
	
	<input type="email" name="email" placeholder="Your email" required="required"/>
	<div class="space"></div>
	
	<input type="password" name="password" placeholder="Your password" required="required"/>
    <div class="space"></div>
	
	<input type="password" name="password2" placeholder="Repeat password" required="required"/>
	<div class="space"></div>
   
    <button class="register_button">REGISTER</button><br />
    </form>
    </div>
    <div>
    </div>
	</div>
	</div>
	
	
	<div id="reset_password" class="window">
    <div class="modal-reset">
    <div class="modal-title">
    RESET PASSWORD <hr /> <br />
    <form action="/process.php?task=reset_password" method="POST">
    
	<input type="text" placeholder="Your email" name="email" required="required">
	<div class="space"></div>
	
    <button class="">RESET</button><br />
    </form>
	<div class="close"><a href="#"class="close"/>X</a></div>
    </div>
    </div>
    </div> 
	
	
    <div id="add_comment" class="window">
    <div class="modal-add">
    <div class="modal-title">
    ADD COMMENT <hr /> <br />
    <form action="/process.php?task=add_comment" method="POST">
    
	<input type="text" placeholder="Your name" name="name" required="required">
	<div class="space"></div>
	
	<input type="text" placeholder="Your website" name="website" required="required">
	<div class="space"></div>

	<textarea name="message" placeholder="Your message" required="required"></textarea>
	<div class="space"></div>	
	
    <button class="">SEND</button><br />
    </form>
	<div class="close"><a href="#"class="close"/>X</a></div>
    </div>
    </div>
    </div> 	
	<div id="mask"></div>
    </div>