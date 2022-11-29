<?php
if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
}
?>
<div class="blokba">Monitoring servera u protekla 24 sata</div>
<style>
a {
color:orange;
text-decoration:none;
}
a:hover {color:yellow}
</style>
<div style="float:right;width:500px;"><br />Grafik se ne prikazuje? Dodajte server na naš <a href="/servers" >gametracker</a>.</div>
<img src="/chart/<?php echo $box_name['ip']; ?>:<?php echo $select_fetch['port']; ?>" />