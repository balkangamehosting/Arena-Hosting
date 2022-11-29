<?php
if($_SESSION['userid'] != ""){
 $_SESSION['error'] = "Ulogovani ste";
 header("location:/index.php");
 die(); 
}

?>

<div class="admin_bg">
<form class="test_class" style="margin-left:30px;" action="/process.php?task=register" method="POST">
<div style="float:right;margin-top:40px;font-size:26px;font-family:Tahoma;margin-right:30px;opacity:0.8;width:430px;">
	<label>Your firstname:</label> <input type="text" name="ime" placeholder="Name" required="required"> <br /><div class="space_contact1"></div> 
<label>Your lastname:</label> <input type="text" name="prezime" placeholder="Last name" required="required"> <br /><div class="space_contact1"></div> 
<label>Your email:</label> <input type="email" name="email" placeholder="your@email.com" required="required"> <br /><div class="space_contact1"></div> 
</div>


  <h3>Register</h3> 
    
    
	
   <label>Username:</label> <input type="text" name="username" placeholder="Your username..." required="required"> <br /><div class="space_contact1"></div>

<label>Password:</label> <input type="password" name="password" placeholder="********" required="required"> <br /><div class="space_contact1"></div> 
<label>Password (repeat):</label> <input type="password" name="password2" placeholder="********" required="required"> <br /><div class="space_contact1"></div> 

    <button class="edit_server">Registruj se!</button>		<br />
	<br /><small>* All fields are required.</small>
    </form>

</div>


<div class="footer_height_add"></div><br />

