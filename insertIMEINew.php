<?php
include_once(".htconnection.php");

?>
<!--******JQuery******-->
<script src="./jquery/jquery-1.11.1.min.js"></script>
<script src="./jquery/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./jquery/jquery-ui.css" />
<!--******JQuery******-->

<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="./css/wh_style.css" />
<link rel="stylesheet" href="./warehouse/bootstrap337/css/bootstrap.min.css"/> <!--Bootstrap css 3.3.7-->
<link rel="stylesheet" href="./warehouse/bootstrap337/font-awesome.css"/> <!--Font awesome-->

<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<body>
	<div class="container-fluid">
		<div class="well">
			<div class="row">
				<div class="col-xs-3">
					<h4 align="left">COMENTARIO GLOBAL: </h4>
				</div>
				<div class="col-xs-9">
					<input type="text" id="comentarioglobal" size="150px" placeholder="M&aacute;ximo de 255 caracteres permitidos" maxlength="255" autofocus/>
				</div>
			</div>
		</div>
		<div class="well">
			<div class="row">
				<div class="col-xs-3">
					<h4 align="left">IMEI</h4>
				</div>
				<div class="col-xs-3">
					<h4 align="left">RMA</h4>
				</div>
				<div class="col-xs-3">
					<h4 align="left">Status</h4>
				</div>
				<div class="col-xs-3">
					<h4 align="left">Reason</h4>
				</div>
			</div>
		</div>
		<div id="list">
		</div>
	</body>
	</html>

	<script>
	$(document).on("click","input[type='text']", function () { //Seleccionar todo el contenido del input solo con un click
		$(this).select();
	});
	var rowindex = -1;
	$(document).on('change', '.imei', function(){
		var currentItem =$(this).attr("id").substring(4); //Se utiliza el número tras la palabra "imei" como índice del elemento actual
		this.value = this.value.toLocaleUpperCase(); //Uppercase
		var currentImei = this.value;
		if(currentImei.length==15 || currentImei.substr(0,2)=="LG"){ //Solo se realiza la lógica en caso de que el tamaño cumpla el estándar del IMEI
			var globalComments = $("#comentarioglobal").val();
			if(currentImei.length>0){
				$("#status"+currentItem).html("<div class='text-warning'><i class='fa fa-spinner fa-spin'></i> LOADING</div>");
				$.ajax({
					url: './ajaxInsertImeiGetRMA.php',
					dataType: 'json',
					type: 'POST',
					data: {
						IMEI: currentImei,
						COMMENTS: globalComments,
					},
					success: function(data){
						var showDetail = false;
						if(data[0].status=="OK"){
							$("#rma"+currentItem).css("background-color", "");

							if(data[0].rma == null && data[0].id == null){
								$("#rma"+currentItem).val("NO HAY DR");
								$("#rma"+currentItem).css("background-color", "red");
								$("#status"+currentItem).html("<i class='fa fa-exclamation-circle'></i><b> APARTAR EQUIPO</b>");
							}else if(data[0].rma == null && data[0].id != null){
								$("#rma"+currentItem).val("Pendiente");
								$("#rma"+currentItem).css("background-color", "red");
								$("#status"+currentItem).html("<i class='fa fa-exclamation-circle'></i><b> APARTAR EQUIPO</b>");
							}else{
								$("#rma"+currentItem).val(data[0].rma);
								showDetail = true;
								showDetail2 = true;
							}
							if(showDetail){
								if(data[0].f_recibido=="0000-00-00"){
									$("#status"+currentItem).html("<i class='fa fa-check-circle'</i><b> ¡INSERTADO!</b>");
								}else{
									$("#status"+currentItem).html("<i class='fa fa-exclamation-circle'></i><b> WARNING: YA RECIBIDO A FECHA "+data[0].f_recibido+"</b>");
								}
								if(data[0].reason=="DO2" || data[0].reason=="DA1"){
									$("#reason"+currentItem).html("<i class='fa fa-check-circle'</i><b> DOA <i class='fa fa-arrow-right' aria-hidden='true'></i> UNITDMG-SV</b>");
								}else{
									$("#reason"+currentItem).html("Otros <i class='fa fa-arrow-right' aria-hidden='true'></i> GRADE-C-SV");
								}
							}
						}else{//En realidad no se da este caso porque el SELECT MAX(ID) devuelve ID=null si no hay DR y saldría la línea 80
							$("#status"+currentItem).html("<i class='fa fa-exclamation-circle'></i><b> NO SE ENCUENTRA IMEI EN DB</b>");
							$("#rma"+currentItem).css("background-color", "red");
						}
						addrow();
					}
				});
			}else{
				$("#status"+currentItem).html("");
				$("#rma"+currentItem).val("");
			}
		} else{
			$("#status"+currentItem).html("<i class='fa fa-exclamation-circle'></i><b> EL TAMA&Ntilde;O DEL IMEI NO COINCIDE</b>");
			$("#rma"+currentItem).css("background-color", "red");
			//En realidad no se establece timeout, pero con esta función me aseguro de que se ejecute tras la cola de acciones, y no antes
			//Sin esta función no se seleccionaba el campo, probablemente por ejecutarse la selección antes de otra acción que cambiaba el focus
			setTimeout(function(){
				$("#imei"+currentItem).select();
			});
		}
	});

	function addrow(){
		rowindex++;
		var newRow = "<div class='well'><div class='row'><div class='col-xs-3'><input id='imei"+rowindex+"' class='imei' type='text'/></div><div class='col-xs-3'><input id='rma"+rowindex+"' type='text' readonly='yes'/></div><div class='col-xs-3'><div id='status"+rowindex+"'></div></div><div class='col-xs-3'><div id='reason"+rowindex+"'></div></div></div></div>";
		$("#list").append($(newRow));
		
		$("#imei"+rowindex).focus();
	}

	$(document).ready(function(){
		//addrow();
	});

	$("#comentarioglobal").on('change', function(){
		$("#comentarioglobal").attr('readonly', 'yes');
		addrow();
	});

	//UpperCase tras salir del input
	$("input[type='text']").on("change", function () {
		this.value = this.value.toLocaleUpperCase();
	});
	</script>
