<head>
	<link rel="icon"
      type="image/gif"
      href="img/favicon.gif">
</head>
<?php

session_start();

if (isset($_COOKIE['c_user'])){
	header('Location: ./menu.php');
}
?>
<!--******JQuery******-->
<script src="./jquery/jquery-1.11.1.min.js"></script>
<script src="./jquery/jquery-ui.js"></script>
<!--******JQuery******-->
<link rel="stylesheet" type="text/css" href="./css/loginStyle.css" />
<section class="login">
	<div class="titulo">SAT DIRECT SYSTEM</div>
	<form action="#" id="form" method="post" enctype="application/x-www-form-urlencoded">
    	<input type="text" id="user" required title="Username required" placeholder="Username" data-icon="U" autofocus>
        <input type="password" id="pass" required title="Password required" placeholder="Password" data-icon="x">
        <!--
		<div class="olvido">
        	<div class="col"><a href="#" title="Ver Caracteres">Register</a></div>
            <div class="col"><a href="#" title="Recuperar Password">Fotgot Password?</a></div>
        </div>
		-->
		<div class="olvido">
		<div class="col"><a href="mailto:adan.conde@lge.com;bruno.urban@lge.com" title="Contactar con el administrador">Contactar con el administrador</a></div>
		</div>
        <a href="#" class="enviar" id="enviar">Enviar</a>
    </form>
</section>

<!--<div id="LGindex"><img src="./img/LG_new_logo.png" width="500"></div>-->

<script>
$(document).ready(function() {
	 $("#enviar").click(function () {
		$.ajax({
			type: "POST",
			url: "login.php",
			data: {
				user: $('#user').val(),
				pass: $('#pass').val()
			},
			success: function(data)
            {
                if (data != 'NoCorrect') {
					alert("Bienvenido/a " + data);
					window.location.replace('menu.php');
                }
                else {
                    alert("Username o password incorrectos");
                }
            },
		})
	});
});
</script>

<script>
function callkeydownhandler(evnt) {
   var ev = (evnt) ? evnt : event;
   var code=(ev.which) ? ev.which : event.keyCode;
   if(code == 13)
		document.getElementById("enviar").click(); //Al pulsar Intro se clica virtualmente el botón enviar
}
if (window.document.addEventListener) {
   window.document.addEventListener("keydown", callkeydownhandler, false);
} else {
   window.document.attachEvent("onkeydown", callkeydownhandler);
}
</script>
