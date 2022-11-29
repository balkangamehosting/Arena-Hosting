function getPassword(serverid){
	var pin = $("#pin_code").val();
	 $.ajax({
            type: "GET",
            url: "/ajax.php?page=getftp&pin="+pin+"&server="+serverid,
            success: function(ftp){
            	if(ftp == '0'){
					alert('Pogrešan PIN.');
				} else {
					$.fancybox.close(); 
					$(".ftppass").html(ftp);
					$("#pin_code").val(' ');
				}
            },
            error: function(){
                alert('fail');
            }
        });
}
function reinstallCheck(serverid){
	var pin = $("#pin_code2").val();
	 $.ajax({
            type: "GET",
            url: "/ajax.php?page=reinstal&pin="+pin+"&server="+serverid,
            success: function(ftp){
            	if(ftp == '0'){
					alert('Pogrešan PIN.');
				} else {
					$.fancybox.close(); 
					mrak();
					window.location='/server_process.php?task=reinstall&server='+serverid+'&pin='+pin;
				}
            },
            error: function(){
                alert('fail');
            }
        });
}
function prikazi(div){
	$("#"+div).slideToggle();
}
function setMap(name){
	var mapa = name.split("-");

	$("#mapa").val(mapa[1]);
}

function checkPort(){

			  var game1 = $("#game").val();
			  var port = $("#port").val();
			  var game2 = game1.split("-");
			  var game = game2[0];
				if(game != ''){
				$.ajax({
						type: "GET",
						url: "/ajax.php?page=check_port&game="+game+"&port="+port,
						success: function(ftp){	
							
								$(".provjera").html(ftp);
						},
						error: function(){
							alert('fail');
						}
					});
					}
			 
}
function mrak(){
	$('html, body').animate({ scrollTop: 0 }, 'slow');
	$(".loading").fadeIn('fast');
	
}
function obrisi(id){
    var r = confirm("Jeste li sigurni da zelite obrisati server!?");
    if (r == true) {
		window.location='/server_process.php?task=remove&id='+id;
		mrak();
    } else {
      
    }
}
function installmod(serverid, modid){
    var r = confirm("Jeste li sigurni da zelite instalirati ovaj mod!?");
    if (r == true) {
		window.location='/server_process.php?task=modinstal&server='+serverid+'&modid='+modid;
		mrak();
    } else {
      
    }
}
function sendTo(){
   var type = $("#type").val();
   window.location='/gp/billing/add/'+type;
}
function price_calculate(){
	var box = $("#location").val();
	var slots = $("#slots").val();
	var period = $("#period").val();
	var kupon = $("#kupon").val();
	var gameo = $("#gameo").val();
	
	if(kupon != ''){
				$.ajax({
						type: "GET",
						url: "/ajax.php?page=kupon_check&kupon="+kupon,
						success: function(ftp){	
							
								$(".provjera").html(ftp);
						},
						error: function(){
							alert('fail');
						}
					});
	}
	
					$.ajax({
						type: "GET",
						url: "/ajax.php?page=calculate&box="+box+"&slots="+slots+"&period="+period+"&gameo="+gameo,
						success: function(ftp){	
							
								$("#pricely").html(ftp);
						},
						error: function(){
							alert('fail');
						}
					});
}
function calculator(serverid){

				if(serverid != ''){
				$.ajax({
						type: "GET",
						url: "/ajax.php?page=pay_calculator&serverid="+serverid,
						success: function(ftp){	
							
								$(".calculate_info").html(ftp);
						},
						error: function(){
							alert('fail');
						}
					});
					} else {
						$(".calculate_info").html('Odaberite server.');
					}
}