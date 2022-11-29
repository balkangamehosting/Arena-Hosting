<div class="main-content">

 <div class="contact_form"></div>

 <div class="informations">INFORMATION #1:</div>
 <div class="informations-text">> Ako ste nas trenutni klijent,a treba vam pomoc oko vaseg servera  <div class="space"></div>
 najlakse je kontaktirati nas preko suport tiketa u vasem Game Panel-u.</div>
 

 <div class="informations2">INFORMATION #2:</div>
 <div class="informations-text2">> Kada saljete poruku, precizno i konkretno pisite poruku. <div class="space"></div>
 </div>
 
 
 <div class="informations3">INFORMATION #3:</div>
 <div class="informations-text3">> Vecinu pitanja imate na nasem forumu: forum.dbk-hosting.biz</div>
 
 <div class="form_contact">
 <form action="/process.php?task=contact" method="POST">
  <?php
   if($_SESSION['userid'] == ""){
  ?>
   <label>Name:</label> <input type="text" name="firstname" placeholder="Type your name">  <div class="space_contact"></div>
   
	<label>Email:</label> <input type="text" name="email" placeholder="Type your email"> <div class="space_contact"></div>
  <?php
	}
   ?>
   <label>5+5?:</label> <input type="text" name="answer" placeholder="Type your answer"> <div class="space_contact"></div>
   <label>Vasa poruka: </label> <textarea style="margin-left:0px;margin-top:15px;" name="question"></textarea> <div class="space_contact"></div>
   <button class="send_button"></button>
  
 </form>
 </div>
 
 
 <div class="promo1">PROMO #1</div>
 <div class="promo1-text"></div>
 
 <div class="statistic-new">
 <div class="statistic">
	  <div class="first_height"></div><div class="statistic_first"></div><div class="statistic_first_text">0<span style="color:#039ba5;">39</span></div>
	  <div class="statistic_second"></div><div class="statistic_second_text">00<span style="color:#039ba5;">2</span></div>
	  <div class="statistic_third"></div><div class="statistic_third_text">0<span style="color:#039ba5;">46</span></div>
 </div>
 </div>
 
 <div class="email-contact">
 <div class="hosting-email">itszensei@gmail.com</div>
 <div class="owner-email"><span style="color:#23f401;">Facebook</span> fb.com/dbkhosting <div class="space_contact"></div> <span style="color:#23f401;">E-mail</span> itszensei@gmail.com </div>
 </div>
 
 <div class="hosting-info">
 <div class="hosting-info-text">
 <span style="color:#23f401;">Name:</span> DBK Hosting Game Service Provider L.T.D <div class="space_contact"></div>
 <span style="color:#23f401;">Owner:</span> Bojan Apostolovski <div class="space_contact"></div>
 <span style="color:#23f401;">Adress:</span> 221 / 16 - Kumanovo (Macedonia) <div class="space_contact"></div>
 <span style="color:#23f401;">Mobile:</span> +0038978283795 <div class="space_contact"></div>
 </div>
 </div>
 
 <div class="all">
 <!-- Video -->
	<div class="video_height"></div>
	<div class="video">
	<iframe width="290" height="195" style="margin-left:7px;margin-top:6px;" src="http://www.youtube.com/embed/mv2wWfvuZd4" frameborder="0" allowfullscreen></iframe>
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
      <div class="avatar"><img style="width:35px;height:35px;margin-top:60px;margin-left:5px;" src="/img/no_avatar.png"></div>
	  <div class="quote_name"><?php echo $row['name']; ?></div>
	  <div class="quote_date">At <?php echo $row['time']; ?></div>
	  <div class="quote_site"><a target="_blank" href="<?php echo $row['website']; ?>"><?php echo $row['website']; ?></a></div>
    </div>
	<?php } ?>
    </div>
	<a href="#add_comment" name="modal"><div class="add_comment"></div></a>
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
 
</div>