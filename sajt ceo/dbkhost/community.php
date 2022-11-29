<?php
if($_SESSION['userid'] == ""){
 $_SESSION['error'] = "Niste ulogovani";
 header("location:/index.php");
 die(); 
}

$info = mysql_query("SELECT * FROM community WHERE owner='$_SESSION[username]'");
$es = mysql_fetch_array($info);
$broj = mysql_num_rows($info);
if($broj > 0){
   die("<script> alert('Molimo vas pritisnite potvrdi da vas prebacimo na vasu zajednicu'); document.location.href='/community_info/$es[id]'; </script>");
} else {
?>

<div class="admin_bg">

<h3>Napravi zajednicu</h3>

<form class="test_class" action="/process.php?task=add_community" method="POST">

<label>Ime zajednice:</label> <input type="text" name="naziv" placeholder="Ime zajednice" required="required"> <br /><div class="space_contact1"></div>
<label>Sajt/forum:</label> <input type="text" name="forum" placeholder="www.primer.com" required="required"> <br /><div class="space_contact1"></div> 
<label>O zajednici:</label> <textarea name="opis" placeholder="Napisite nesto o zajednici" required="required"></textarea> <br /><div class="space_contact1"></div> 

<button class="edit_server">Dodaj zajednicu</button>					

</form>

</div>


<div class="footer_height_add"></div><br />

<?php } ?>