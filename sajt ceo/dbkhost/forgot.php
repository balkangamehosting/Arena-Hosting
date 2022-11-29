<?php
if($_SESSION['userid'] != ""){
 $_SESSION['error'] = "Ulogovani ste";
 header("location:/index.php");
 die(); 
}

?>

<div class="admin_bg">
<div style="float:right;margin-top:90px;font-size:26px;font-family:Tahoma;margin-right:30px;opacity:0.8">
	Forgot <br /><br />Your <br /><br /> Password?
</div>


  <h3>Reset password</h3> 
    <form class="test_class" style="margin-left:30px;" action="/process.php?task=reset_password" method="POST">
    

<label>Your email:</label> <input type="email" name="email" placeholder="your@email.com" required="required"> <br /><div class="space_contact1"></div> 

    <button class="edit_server">RESET!</button>		<br /><br /><br /><br /><br /><br />
	<br /><small>* All fields are required.</small>
    </form>

</div>


<div class="footer_height_add"></div><br />

