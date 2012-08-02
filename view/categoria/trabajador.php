<?php
//session_start();
//*******************************************************************//
require_once('../ide2.php');
//*******************************************************************//
//require_once('../../dao/AbstractDao.php');
//--------------combo CATEGORIAS

require_once('../../util/funciones.php');
require_once('../../dao/ComboCategoriaDao.php');
require_once('../../controller/ComboCategoriaController.php');

//-- INCLUDES 02
require_once('../../dao/EmpleadorDao.php');

//---------------trabajador
require_once('../../model/Trabajador.php');
require_once('../../dao/TrabajadorDao.php');
require_once('../../controller/CategoriaTrabajadorController.php');

//--------------- sub detalle_1
require_once('../../model/DetallePeriodoLaboral.php');
require_once('../../dao/DetallePeriodoLaboralDao.php');
require_once('../../controller/DetallePeriodoLaboralController.php');

//--------------- sub detalle_2
require_once('../../model/DetalleTipoTrabajador.php');
require_once('../../dao/DetalleTipoTrabajadorDao.php');
require_once('../../controller/DetalleTipoTrabajadorController.php');

//--------------- sub detalle_3
require_once('../../model/DetalleEstablecimiento.php');
require_once('../../dao/DetalleEstablecimientoDao.php');
require_once('../../controller/DetalleEstablecimientoController.php');

//--------------- sub detalle_3 -> sub detalle_4buscar Empleador Seleeccionado
require_once '../../controller/EmpleadorDestaqueController.php';
require_once '../../dao/EmpleadorMaestroDao.php';
require_once '../../dao/EmpleadorDestaqueDao.php';

//--------------- sub detalle_4
require_once('../../model/DetalleRegimenSalud.php');
require_once('../../dao/DetalleRegimenSaludDao.php');
require_once('../../controller/DetalleRegimenSaludController.php');

//--------------- sub detalle_5
require_once('../../model/DetalleRegimenPensionario.php');
require_once('../../dao/DetalleRegimenPensionarioDao.php');
require_once('../../controller/DetalleRegimenPensionarioController.php');


//############################################################################
/**
********* BUSQUEDA 01 EDIT = TRA-bajador por ID importante
*/
$ID_PERSONA = $_REQUEST['id_persona'];
// ---- Busqueda Trabajador
$objTRA = new Trabajador();
//-- funcion Controlador Trabajador
$objTRA = buscarTrabajadorPorIdPersona($ID_PERSONA);

//--- sub 1 Periodo Laboral
$objTRADetalle_1 = new DetallePeriodoLaboral();
$objTRADetalle_1 = buscarDetallePeriodoLaboral( $objTRA->getId_trabajador() );

//--- sub 2 Tipo Trabajador
$objTRADetalle_2 = new DetalleTipoTrabajador();
$objTRADetalle_2 = buscarDetalleTipoTrabajador( $objTRA->getId_trabajador() );

//--- sub 3 Detalle Establecimiento
$objTRADetalle_3 = new DetalleEstablecimiento();
$objTRADetalle_3 = buscarDetalleEstablecimiento( $objTRA->getId_trabajador() );

//--- sub 4 Regimen Salud
$objTRADetalle_4 = new DetalleRegimenSalud();
$objTRADetalle_4 = buscarDetalleRegimenSalud( $objTRA->getId_trabajador() );

//--- sub 5 Regimen Pensionario
$objTRADetalle_5 = new DetalleRegimenPensionario();
$objTRADetalle_5 = buscarDetalleRegimenPensionario ( $objTRA->getId_trabajador() );


//---descripcion
$a_jornada_laboral = preg_split( "/,/",$objTRA->getJornada_laboral() );
$situacion_especial = $objTRA->getSituacion_especial();
$discapacitado = $objTRA->getDiscapacitado();
$sindicalizado = $objTRA->getSindicalizado();

/**
********* BUSQUEDA 01 EDIT = TRAD1 here
*/

////############################################################################

/*
* Listado De Empleador Destaques () y empleador maestro
* IMPORTANTE ALERT = usa Recurso SESSION
*/
// RUTA :: EmpleadorDestaqueController.php

// ## (01)-> Listar Empleadores
$lista_empleador_destaque = listarEmpleadorDestaque();

// ## (02)-> 
$id_empleador_select = buscarID_EMP_EmpleadorDestaquePorTrabajador( $objTRADetalle_3->getId_trabajador(), $objTRADetalle_3->getId_detalle_establecimiento() );

/*
echo "<pre>id_empleador_select";
print_r($id_empleador_select);
echo "<hr>";
echo "objTRADetalle_3<br>";
print_r($objTRADetalle_3);
echo "<pre>";
*/
// ## (03)->
$lista_establecimientos = listarEstablecimientoDestaque($id_empleador_select);


$COD_LOCAL = 0;
$arreglo3 = array();		  
foreach ($lista_establecimientos as $indice) {	
	$arreglo3 = preg_split("/[|]/",$indice['id']);	
	//	$arreglo[0 - 2] =  // id_establecimiento
	if( $arreglo3[0] == $objTRADetalle_3->getId_establecimiento()){
		$COD_LOCAL = $arreglo3[2];
		break; 		
	}
}

//############################################################################

//echo "<pre>xd"; //$objTRADetalle_5
//print_r($objTRA);
//echo "</pre>";

//$comboEmpleadores_EstableTrabajo = ListaEmpleadores_EstablecimientosLaborales($_SESSION['sunat_empleador']['id_empleador']);
 ?>
   <!--  CATEGORIAS  -->
   
<?php  
  
//---------------------------- EDITAR PERSONA CATEGORIA --------------------------------- //
// *-*-* ! IMPORTANT  id_tipo_empleador = 01->privado 02->publico 03->otros
$id_tipo_empleador = $_SESSION['sunat_empleador']['id_tipo_empleador'];

$remype = $_SESSION['sunat_empleador']['remype'];

//combo 01x
$cbo_motivo_baja_registro_cat_trabajador = comboMotivoBajaRegistroCatTrabajador();

//combo 03x
$cbo_tipo_trabajador = comboTipoTrabajadorPorIdTipoEmpleador($id_tipo_empleador); 
//combo 04x
$cbo_regimen_laboral = comboRegimenLaboralPorTipoEmpleador($id_tipo_empleador,$remype);
//combo 05x
$cbo_categoria_ocupacional = comboCategoriaOcupacionalPorTipoEmpleador($id_tipo_empleador,$remype);
//COMBO 06x
$cbo_tipo_contrato = comboTiposContrato($id_tipo_empleador);
//COMBO 07x --> Combo Ajax Dependinte $id_categoria_ocupacional = 01->ejecutivo,02->obrero,03->empleado
$cbo_ocupaciones = comboOcupacionPorIdCategoriaOcupacional($objTRA->getCod_categorias_ocupacionales()); /*'02'*/
//COMBO 08
$cbo_tipo_pago = comboTipoPago();
//COMBO 09
$cbo_periodo_remuneracion = comboPeriodoRemuneracion();
//COMBO 10
$cbo_monto_remuneracion = comboMontoRemuneracion();



//echo "<pre>ocupacion";
//echo "cod_ ocupacion =". $objTRA->getCod_ocupacion();
//var_dump($cbo_ocupaciones);
//echo "</pre>";
 
 //COMBO 06x
$combo_nivel_educativo = comboNivelEducativo();

//COMBO 07
$combo_regimen_salud = comboRegimenSalud();
//COMBO 07.1
$combo_eps = comboeps();

// COMBO 08
$combo_regimen_pensionario = comboRegimenPensionario();
//COMBO 09
$combo_convenio = comboConvenio();  

//combo 10
$estado = ($objTRA->getCod_situacion()==2) ? 0 : $objTRA->getCod_situacion();
$combo_situacion = comboSituacion($estado);

//-------------------------ESTADO
$COD_ESTADO = $_REQUEST['cod_situacion'];


  ?>

	<script>
	(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var input,
					self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "",
					wrapper = $( "<span>" )
						.addClass( "ui-combobox" )
						.insertAfter( select );

				input = $( "<input>" )
					.appendTo( wrapper )
					.val( value )
					.addClass( "ui-state-default" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									select.val( "" );
									input.data( "autocomplete" ).term = "";
									return false;
								}
							}
						}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.appendTo( wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-corner-right ui-button-icon" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							return;
						}

						// work around a bug (likely same cause as #5265)
						$( this ).blur();

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();
					});
			},

			destroy: function() {
				this.wrapper.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

	$(function() {
		$( "#cboOcupacion" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#cboOcupacion" ).toggle();
		});
	});
	</script>




 <script type="text/javascript">
 
 //VARIABLES GLOBALES
 
 var cod_situacion = <?php echo $COD_ESTADO; ?>
 
 
 
 
 
 $(document).ready(function(){ 
	$( "#accordion" ).accordion({
		autoHeight: false,
		navigation: true
		}
	);
	
	havilitarConvenio();
	havilitarEps(document.getElementById('cbo_regimen_salud_base'));
	havilitarCUSPP(document.getElementById('cbo_regimen_pensionario_base'));
	
	//-------------------------------------
	//Desabilita Formulario si cod_situacion = 0
	if(cod_situacion == '0'){
		disableForm('form_trabajador');
	}
//----------------------------
        $("#form_trabajador").validate({
            rules: {
                txt_plaboral_fecha_inicio_base: {
                    required: true                    
                }				
				
            },
			submitHandler: function(data) { 
				alert("submitHandler");				
			//-----------------------------------------------------------------------				
				var from_data =  $("#form_trabajador").serialize();
				$.getJSON('sunat_planilla/controller/CategoriaTrabajadorController.php?'+from_data,
					function(data){
					//funcion.js index.php
					
						if(data){
						//document.getElementById('id_persona').value = data.id_persona;						
						//disableForm('form_new_personal');
						alert ('Se Guardo Correctamente.\nAhora registre su Direccion');
				

						}else{
							//alert("El Num de Documento:"+$("#txt_num_documento").val()+"Ya se encuentra registrado!\n no se puede registrar nuevamente");
							alert("Ocurrio un error, intente nuevamente no hay datos JSON");
						}
					}); 
			//-----------------------------------------------------------------------
				//return false;
			//alert("final");	
			   		
			}			
			
        });
//-----------------------------
	
	
	
	
 });
 //-----------------------------
 //-----------------------------
 /*
 * Carga Principal de Empleadores
 **/
 //cargarEmpleadoresBase();
 //cargarEstablecimientosBase();
 
function havilitarEps(cbo){ //cbo_regimen_salud_base
	var valor = cbo.value;
	var div = document.getElementById('EPS');
	var combohijo = document.getElementById('cbo_eps_servicios_propios');
		
	if(valor == '01' || valor == '04'){		
		div.style.display = 'block';
	}else{
		div.style.display = 'none';		
		combohijo.options[0].selected = true;
	}
}


//----
function havilitarCUSPP(cbo){ //cbo_regimen_salud_base
	var valor = cbo.value;
	var div = document.getElementById('cuspp');
	var combohijo = document.getElementById('txt_CUSPP');
		
	if(valor == '02' || valor == '0' || valor == null ){		
		div.style.display = 'none';
		combohijo.value="";
	}else{
		div.style.display = 'block';		
		//combohijo.value="";
	}
} 
 
function havilitarConvenio(){
 var obj = document.form_trabajador.rbtn_aplica_convenio_doble_inposicion;
 
 	var counteo = obj.length
	var bandera = false;
	for(var i =0; i<counteo; i++){
		if(obj[i].checked){
			bandera = obj[i].value;
		}
	}
	
var cbo = document.getElementById('cbo_convenio');
	if( bandera == 1){
		
		cbo.disabled = false;
	}else{
		cbo.disabled = true;
	}

}

// -----------------------------------------------------------------------------
//--------------------------------------------------------------------------------








/*******************************************************************************************************
** ----------------------------- DETALLE 01 ------------------------------------------------------------
 [trabajador.php]= Periodos Laborales
********************************************************************************************************/

	var motivos_baja = new Array(
	<?php 
	//echo "<pre>";
	//print_r($new_motivo_baja);
	//echo "</pre>";
	$new_motivo_baja = array();
	$new_motivo_baja = $cbo_motivo_baja_registro_cat_trabajador;
	
	$counteo = count($new_motivo_baja);	
	for($i=0;$i<$counteo;$i++): ?>	
	<?php
		if($i == $counteo-1){ 
			echo "{id:'".$new_motivo_baja[$i]['cod_motivo_baja_registro']."', descripcion:'".$new_motivo_baja[$i]['descripcion_abreviada']."' }"; 
		}else{
			echo "{id:'".$new_motivo_baja[$i]['cod_motivo_baja_registro']."', descripcion:'".$new_motivo_baja[$i]['descripcion_abreviada']."' },"; 
		}
	?>
	<?php endfor; ?>
	);	
//----------------------------------
function llenarComboDetalle_1(objCombo){

	var test = new Array();
	test = motivos_baja;
	var counteo = 	test.length;
	//objCombo.options[0] = new Option('-', '');
	for(var i=0;i<counteo;i++){
		objCombo.options[i] = new Option(test[i].descripcion, test[i].id);
	}
}//ENDFN

























function nuevoFilaPeridoLaboral(){
	alert("holaaaaa");
	
	//Capa Contenedora
	var tabla = document.getElementById("tb_periodolaboral");	
	
	var num_fila_tabla = contarTablaFila(tabla);
	
	num_fila_tabla = num_fila_tabla - 2;
	
	var COD_DETALLE_CONCEPTO =  num_fila_tabla + 1;
	
	//var id_check = idCheckConcepto1000EM( COD_DETALLE_CONCEPTO );

	//INICIO div
	var div = document.createElement('tr');
	//div.setAttribute('id','establecimiento-'+id);
	//
	tabla.appendChild(div); //PRINCIPAL	
	

	
	

//-------------------------------------------------------------
//---- CODIGO
var id = '<input type="text" size="4" id="id-'+ COD_DETALLE_CONCEPTO +'" name="id_detalle_plaboral[]" value ="" >';
var estado = '<input type="text" size="4" id="plaboral_estado-'+ COD_DETALLE_CONCEPTO +'" name="plaboral_estado[]" value ="0" >';
//var codigo = '<input type="text" size="4" id="cod_detalle_concepto_" name="cod_detalle_concepto[]" value = '+ COD_DETALLE_CONCEPTO +'>';

//-----input Descripcion
var input_finicio;
var input_ffin;
input_finicio = '<input type="text" id="plaboral_finicio-'+ COD_DETALLE_CONCEPTO +'" name="plaboral_finicio[]"  size="12" >';

input_ffin = '<input type="text" id="plaboral_ffin-'+ COD_DETALLE_CONCEPTO +'" name="plaboral_ffin[]"  size="12" >';

var combo = "";
combo +='     <select name="cbo_plaboral_motivo_baja[]" id="cbo_plaboral_motivo_baja-'+COD_DETALLE_CONCEPTO+'"  ';
combo +='	  style="width:150px;"  onchange="" >';
combo +='     </select>';


	//inicio html	
var html ='';
var cerrarTD = '<\/td>';


html +='<td>';
html += id;
html += estado;
//html += codigo;
html += cerrarTD;


html +='<td>';	
html += input_finicio;
html += cerrarTD;

html +='<td>';	
html += input_ffin;
html += cerrarTD;

html +='<td>';	
html += combo;
html += cerrarTD;


////---
div.innerHTML=html;

//-------   - - --  -cargar combo
cbo = document.getElementById('cbo_plaboral_motivo_baja-'+COD_DETALLE_CONCEPTO);
//alert()
//console.dir(cbo);
llenarComboDetalle_1(cbo);	
	
//	console.dir(tabla);
//	console.log("-----------------");
//	console.dir(tabla.rows[0]);
//	console.log("-----------------");

}

 </script>
 <style type="text/css">

.cesta-productos{
	text-align:center;
	width:700px;
/*	display:inline-block;*/
	display:block;
	
}
.celda{
	float:left;
	min-height:22px;
	padding:5px 0 5px 0;
	margin-right:1px;
}
.negrita .celda{
	min-height:45px;
	background-color:#6FF;
	font: 14px/12px inherit;
}


.eliminar{
	width:50px;
	background-color:#fcac36;
}

.producto{
	width:130px;
	background-color:#fcac36;
}


.cantidad{
	width:270px;
	background-color:#fcac36;
}
.precio,.sub-total{
	width:100px;
	background-color:#fcac36;

}
.dialog_detalle_1{
/*	display:inline-block;*/
	display:inline;
	
}


</style>
 
<div id="categoria-tabs-2">
<form action="validar.php" method="post" name="form_trabajador" id="form_trabajador">
<div class="demoo">

<div id="accordion">
	<h3><a href="#">Section 1  Datos Laborales Form Trabajador
	  <label for="tab"></label>
	</a></h3>
	<div>
	  <div style=" width:550px; background-color:#D9FFFD; margin-right:5px;" >
<div class="ocultar">id_trabajador
  <label for="id_trabajador"></label>
  <input type="text" name="id_trabajador_categoria" id="id_trabajador_categoria" 
value="<?php echo $objTRA->getId_trabajador(); ?>"/>
  <br />
  id_persona
  <label for="id_persona"></label>
  <input type="text" name="id_persona_categoria" id="id_persona_categoria"
value="<?php echo $objTRA->getId_persona(); ?>" />
  <br />
  
oper
  <input type="text" name="oper" value="edit" />
</div>
<table id="tb_periodolaboral" width="auto" border="1" CELLPADDING=0 cellspacing="0">
  <tr>
    <td width="162" class="style2"><div class="ocultar">detalle_periodos_laborales</div></td>
    <td width="85"><em>Fecha de Inicio</em> </td>
    <td width="79"><em>Fecha de Fin </em></td>
    <td width="150"><em>Motivo de baja del registro</em></td>
    <td width="62">&nbsp;</td>
  </tr>
  <tr>
    <td>Periodo Laboral 
      <label for="id_detalle_periodo_laboral"></label>
      <input name="id_detalle_periodo_laboral[]" type="hidden" id="id_detalle_periodo_laboral" size="3" 
      value="<?php echo $objTRADetalle_1->getId_detalle_periodo_laboral();  ?>"
      /></td>
    <td>
        <input name="plaboral_finicio[]" type="text" id="plaboral_finicio"
         
               value="<?php echo getFechaPatron( $objTRADetalle_1->getFecha_inicio() ,"d/m/Y" ); ?>"
         
         size="12" onkeyup="getFechaActualEnter(event,this)" class="required">    </td>
    <td><input  name="plaboral_ffin[]" type="text" id="plaboral_ffin" size="12" onkeyup="getFechaActualEnter(event,this)"
     value ="<?php echo getFechaPatron( $objTRADetalle_1->getFecha_fin() ,"d/m/Y");?>"
     ></td>
    <td><select name="cbo_plaboral_motivo_baja[]" id="cbo_plaboral_motivo_baja" style="width:150px;"  >
    
      <?php 

foreach ($cbo_motivo_baja_registro_cat_trabajador as $indice) {
	if($indice['cod_motivo_baja_registro'] =="0" ){
		
		$html = '<option value="0"  >-</option>';
	
	}else if( $indice['cod_motivo_baja_registro'] ==  $objTRADetalle_1->getCod_motivo_baja_registro()){

		$html = '<option value="'. $indice['cod_motivo_baja_registro'] .'" selected="selected" >' . $indice['descripcion_abreviada'] . '</option>';

	}else {
		$html = '<option value="'. $indice['cod_motivo_baja_registro'] .'" >' . $indice['descripcion_abreviada'] . '</option>';
	}
	echo $html;
} 
?>
    </select>
    </td>
    <td><div class="ocultar">
    <a href="javascript:editarDialogoDetalle_1()">detalle</a>
    <a href="javascript:nuevoFilaPeridoLaboral()">add</a><br />
      <a href="#">view</a> </div></td>
  </tr>
</table>
<br />
<table width="auto" border="1" cellpadding="0" cellspacing="0" >
  <tr>
            <td width="160" class="style2"><div class="ocultar">detalle_tipos_trabajadores</div></td>
            <td width="150">Ocupacion </td>
            <td width="99"><em>Fecha de Inicio</em></td>
            <td width="85"><em>Fecha de Fin</em></td>
            <td width="44">&nbsp;</td>
          </tr>
          <tr>
		  
            <td><strong>Tipo de Trabajador</strong>              <input name="id_detalle_tipo_trabajador" type="hidden" id="id_detalle_tipo_trabajador" size="3"
              value="<?php  echo $objTRADetalle_2->getId_detalle_tipo_trabajador(); ?>"
               /></td>
            <td>
                <select name="cbo_ttrabajador_base" id="cbo_ttrabajador_base" style="width:150px;" onchange="comboVinculadosTipoTrabajadorConCategoriaOcupacional(this)" >
				
				<!--<option value="0" >-</option>-->
<?php 

foreach ($cbo_tipo_trabajador as $indice) {
	/*
	if ($indice['cod_tipo_trabajador'] == 0 ) {		
		$html = '<option value="'. $indice['cod_tipo_trabajador'] .'" >' . $indice['descripcion'] . '</option>';	
	
	}else if($indice['cod_tipo_trabajador'] == $objTRADetalle_2->getCod_tipo_trabajador() ){
		$html = '<option value="'. $indice['cod_tipo_trabajador'] .'" selected="selected" >' . $indice['descripcion'] . '</option>';

	}else{
		$html = '<option value="'. $indice['cod_tipo_trabajador'] .'" >' . $indice['descripcion'] . '</option>';		
	}
	*/
	//----
	if($indice['cod_tipo_trabajador'] =="0" ){
		
		$html = '<option value="0"  >-</option>';
	
	}else if( $indice['cod_tipo_trabajador'] ==  $objTRADetalle_2->getCod_tipo_trabajador()){

		$html = '<option value="'. $indice['cod_tipo_trabajador'] .'" selected="selected" >' . $indice['descripcion'] . '</option>';

	}else {
		$html = '<option value="'. $indice['cod_tipo_trabajador'] .'" >' . $indice['descripcion'] . '</option>';
	}
	echo $html;
	

} 
?>
				
				
				
                </select>
            </td>
            <td>
                <input name="txt_ttrabajador_fecha_inicio_base"  id="txt_ttrabajador_fecha_inicio_base" type="text"  size="12"
                onkeyup="getFechaActualEnter(event,this)"
                value="<?php echo getFechaPatron( $objTRADetalle_2->getFecha_inicio(), "d/m/Y"); ?>" >
            </td>
            <td><input name="txt_ttrabajador_fecha_fin_base" type="text" id="txt_ttrabajador_fecha_fin_base" size="12" 
            onkeyup="getFechaActualEnter(event,this)"
            value="<?php echo getFechaPatron( $objTRADetalle_2->getFecha_fin() ,"d/m/Y"); ?>"></td>
            <td><div class="ocultar"><a href="javascript:editarDialogoDetalle_2()">detalle</a></div></td>
          </tr>
</table>
        <br>
        <table width="auto" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td width="195"><strong>Regimen Laboral </strong></td>
            <td colspan="2">
                <select name="cbo_regimen_laboral" id="cbo_regimen_laboral" style="width:300px;" >
				<option value="0">-</option>
<?php 
foreach ($cbo_regimen_laboral as $indice) {
	
	if ($indice['cod_regimen_laboral']== 0 ) {
		
		$html = '<option value="0" >' . $indice['descripcion'] . '</option>';
		
	}else if($indice['cod_regimen_laboral']==$objTRA->getCod_regimen_laboral() ){
		
		$html = '<option value="'. $indice['cod_regimen_laboral'] .'" selected="selected" >' . $indice['descripcion'] . '</option>';		
	
	}else {
		
		$html = '<option value="'. $indice['cod_regimen_laboral'] .'" >' . $indice['descripcion'] . '</option>';
	}
	echo $html;
} 
?>
              </select>            </td>
          </tr>
          <tr>
            <td><strong>Categoria Ocupacional</strong></td>
            <td colspan="2">
<select name="cbo_categoria_ocupacional"  id="cbo_categoria_ocupacional" style="width:230px;" onchange="combosVinculados(this)" 
>
  <option value="0">-</option>
  <?php 
foreach ($cbo_categoria_ocupacional as $indice) {
	
	if ($indice['cod_categorias_ocupacionales'] == $objTRA->getCod_categorias_ocupacionales() ){
		
		$html = '<option value="'. $indice['cod_categorias_ocupacionales'] .'" selected="selected" >' . $indice['descripcion'] . '</option>';		
	}else {
		$html = '<option value="'. $indice['cod_categorias_ocupacionales'] .'" >' . $indice['descripcion'] . '</option>';
	}
	echo $html;
} 
?>
</select></td>
          </tr>
          <tr>
            <td><strong>Nivel Educativo </strong></td>
            <td colspan="2">
			<select name="cbo_nivel_educativo" id="cbo_nivel_educativo" style="width:300px;">
<!--             <option value="0">-</option>-->
<?php 
foreach ($combo_nivel_educativo as $indice) {
	
	if($indice['cod_nivel_educativo'] == $objTRA->getCod_nivel_educativo() ){
		
		$html = '<option value="'. $indice['cod_nivel_educativo'] .'" selected="selected" >' . $indice['descripcion'] . '</option>';		
	}else {
		$html = '<option value="'. $indice['cod_nivel_educativo'] .'" >' . $indice['descripcion'] . '</option>';
	}
	echo $html;
}
?>
			</select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="125"><em>Codigo</em></td>
            <td width="200"><em>Nombre</em></td>
          </tr>
          <tr>
            <td><strong>Ocupacion</strong></td>
            <td><input name="txt_ocupacion_codigo" id="txt_ocupacion_codigo" type="text" size="12" 
            onkeyup="return seleccionarOcupacionComboPorInput(event,this)" 
            onblur="seleccionarOcupacionComboPorInputTab(this)" 
            value="<?php echo $objTRA->getCod_ocupacion(); ?>"          
             >
              <input type="button" name="toggle" id="toggle" value="Button" />
            </td>
            <td><select name="cboOcupacion" id="cboOcupacion" style="width:200px " onchange="seleccionarOcupacionInputPorCombo(this)">
			<option value="0"></option>
		<option value="<?php echo $objTRA->getCod_ocupacion(); ?>" selected="selected">-</option>
<!--  Combo dependiente JOJOJOJO foreach temporal -->
<?php 
foreach ($cbo_ocupaciones as $indice) {
	
	if ($indice['cod_ocupacion_p']==0 ) {
		$html = '<option value="0" >-</option>';
	
	}else if($indice['cod_ocupacion_p'] == $objTRA->getCod_ocupacion()){
		
		$html = '<option value="'. $indice['cod_ocupacion_p'] .'" selected="selected" >' . $indice['nombre'] . '</option>';
	} else {
		$html = '<option value="'. $indice['cod_ocupacion_p'] .'" >' . $indice['nombre'] . '</option>';
	}
	echo $html;
}
?>			
            </select></td>
          </tr>
          <tr>
            <td><strong>Tipo de Contrato</strong></td>
            <td colspan="2"><select name="cbo_tipo_contrato" style="width:180px" >
              <option value="0">-</option>
  <?php 
foreach ($cbo_tipo_contrato as $indice) {
	
	if ($indice['cod_tipo_contrato']==0 ) {
		
		//$html = '<option value="0" selected="selected" >' . $indice['descripcion'] . '</option>';
	}else if($indice['cod_tipo_contrato'] == $objTRA->getCod_tipo_contrato() ){
		
		$html = '<option value="'. $indice['cod_tipo_contrato'] .'" selected="selected" >' . $indice['descripcion'] . '</option>';		
	}else {
		$html = '<option value="'. $indice['cod_tipo_contrato'] .'" >' . $indice['descripcion'] . '</option>';
	}
	echo $html;
}
?>
              
            </select>&nbsp;</td>
            </tr>
          <tr>
            <td> Tipo de pago y periodicidad de ingreso: </td>
            <td>
			<select name="cbo_tipo_pago" style="width:120px">
			<!-- <option value="">-</option>-->
<?php 
foreach ($cbo_tipo_pago as $indice) {
	
	if ($indice['cod_tipo_pago']==0 ) {
		
		$html = '<option value="0" >-</option>';
	}else if($indice['cod_tipo_pago'] == $objTRA->getCod_tipo_pago() ){
		
		$html = '<option value="'. $indice['cod_tipo_pago'] .'" selected="selected" >' . $indice['descripcion'] . '</option>';		
	}else {
		$html = '<option value="'. $indice['cod_tipo_pago'] .'" >' . $indice['descripcion'] . '</option>';
	}
	echo $html;
}
?>			
			</select></td>
            <td><select name="cbo_periodo_pago" style="width:150px">
             <!--<option value="">-</option>-->
<?php 
foreach ($cbo_periodo_remuneracion as $indice) {
	
	if ($indice['cod_periodo_remuneracion']==0 ) {
		
		//$html = '<option value="" selected="selected" >' . $indice['descripcion'] . '</option>';
	}else if($indice['cod_tipo_pago'] == $objTRA->getCod_periodo_remuneracion() ){
		
		$html = '<option value="'. $indice['cod_periodo_remuneracion'] .'" selected="selected" >' . $indice['descripcion'] . '</option>';		
	}else {
		$html = '<option value="'. $indice['cod_periodo_remuneracion'] .'" >' . $indice['descripcion'] . '</option>';
	}
	echo $html;
}
?>				
			</select>&nbsp;</td>
          </tr>
          <tr>
            <td> Monto de remuneraci&oacute;n b&aacute;sica inicial:</td>
            <td>&nbsp;
              <input name="txt_monto_remuneracion_basica_inicial" type="text" size="15"
              value="<?php echo $objTRA->getMonto_remuneracion(); ?>" /></td>
            <td><div class="ocultar">
              <select name="cbo_monto_remuneracion" >
                <option>-</option>
                <?php 
foreach ($cbo_monto_remuneracion as $indice) {
	
	if ($indice['id_monto_remuneracion']==0 ) {
		
		//$html = '<option value="" selected="selected" >' . $indice['descripcion'] . '</option>';
	} else {
		$html = '<option value="'. $indice['id_monto_remuneracion'] .'" >' . $indice['cantidad'] . '</option>';
	}
	echo $html;
}
?>
              </select>
            </div></td>
          </tr>
        </table>
	  </div>
      



<div style="width:350px; margin:0 0 0 5px; background-color:#FFBBBD ">
<table width="305" border="1" cellpadding="0" cellspacing="0">
            <tr>
              <td width="98"> Establecimiento donde labora: 
                <label for="id_detalle_establecimiento"></label>
                <input name="id_detalle_establecimiento" type="hidden" id="id_detalle_establecimiento" value="0" size="3" /></td>
              <td width="101">
              <select name="cbo_establecimiento" id="cbo_establecimiento" style="width:100px"
              onchange="cargarEstablecimientoLocales(this)">
               <option value="0">-</option>
               
<?php
			  
foreach ($lista_empleador_destaque as $indice) {

 if($indice['id'] == $id_empleador_select/*$objTRADetalle_3->getid*/ ){		
		$html = '<option value="'. $indice['id'] .'" selected="selected" >' . $indice['descripcion'] . '</option>';
	} else {
		$html = '<option value="'. $indice['id'] .'" >' . $indice['descripcion'] . '</option>';
	}
	echo $html;
}

?>
               
                
              </select>              </td>
              <td width="98"><div class="ocultar"><a href="#">detalle</a></div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>cod Local </td>
              <td>Local</td>
            </tr>
            <tr>
              <td>
                <input name="txt_id_establecimiento" type="hidden" id="txt_id_establecimiento" size="15"
                value="<?php echo $objTRADetalle_3->getId_establecimiento(); ?>"
                 /></td>
              <td><input name="txt_codigo_local" type="text" id="txt_codigo_local" size="6" value="<?php echo $COD_LOCAL; ?>" ></td>
              <td>
                <select name="cbo_establecimiento_local" id="cbo_establecimiento_local" style="width:100px"
              onchange="seleccionarLocalDinamico(this)">
                    <!--<option value="">-</option>-->
                    <?php
//$COD_LOCAL = 0;                    
							  
foreach ($lista_establecimientos as $indice) {
	$arreglo3 = preg_split("/[|]/",$indice['id']);	
	//	$arreglo[0 - 2] =  // id_establecimiento
 if(/*$indice['id']*/  $arreglo3[0] == $objTRADetalle_3->getId_establecimiento() ){
	 	//$COD_LOCAL = $arreglo3[2];	
		$html = '<option value="'. $indice['id'] .'" selected="selected" >' . $indice['descripcion'] . '</option>';
		
	} else {
		
		$html = '<option value="'. $indice['id'] .'" >' . $indice['descripcion'] . '</option>';
		
	}
	echo $html;
}
?>
                  </select>
                  <label for="tipo_establecimiento"></label>
                  <input type="hidden" name="tipo_establecimiento" id="tipo_establecimiento" />
                </p>
              </td>
            </tr>
        </table>
		  <br>
		  <table width="199" border="1" cellpadding="0" cellspacing="0">
            <tr>
              <td width="52">Jornada Laboral </td>
              <td width="20"><input type="checkbox" name="jlaboral[]"
               value="j-trabajo-maximo" 
               <?php
               $counteo = count($a_jornada_laboral);
			   for($i=0; $i<$counteo;$i++){
				if($a_jornada_laboral[$i]=='j-trabajo-maximo'){
					echo 'checked="checked"';
				}
			   }			   
			   ?>
                ></td>
              <td width="119">Jornada de Trabajao máxima </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input type="checkbox" name="jlaboral[]" value="j-atipica-acumulativa"
               <?php
               $counteo = count($a_jornada_laboral);
			   for($i=0; $i<$counteo;$i++){
				if($a_jornada_laboral[$i]=='j-atipica-acumulativa'){
					echo 'checked="checked"';
				}
			   }			   
			   ?>
              
              ></td>
              <td>Jornada Atipica Acumulativa </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input type="checkbox" name="jlaboral[]" value="trabajo-horario-nocturno"
               <?php
               $counteo = count($a_jornada_laboral);
			   for($i=0; $i<$counteo;$i++){
				if($a_jornada_laboral[$i]=='trabajo-horario-nocturno'){
					echo 'checked="checked"';
				}
			   }			   
			   ?>
              ></td>
              <td>Trabajo en Horario Nocturno </td>
            </tr>
          </table>
		  <br>
		  <table width="197" border="1" cellpadding="0" cellspacing="0">
            <tr>
              <td width="59"> Situación especial: </td>
              <td width="20"><input name="rbtn_situacion_especial" type="radio" value="1" 
              <?php
              if ($situacion_especial == "1"){ echo 'checked="checked"'; } ?>
              ></td>
              <td width="110"> Trabajador de dirección </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input name="rbtn_situacion_especial" type="radio" value="2"
              
              <?php
              if ($situacion_especial == "2"){echo 'checked="checked"'; } ?>
              
              ></td>
              <td>  Trabajador de confianza </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input name="rbtn_situacion_especial" type="radio" value="0"
              <?php if ($situacion_especial == "0"){ echo 'checked="checked"'; } ?>

              ></td>
              <td> Ninguna </td>
            </tr>
          </table>
		  <table width="217" border="1" cellpadding="0" cellspacing="0">
            <tr>
              <td width="104"> ¿Discapacitado? </td>
              <td width="45">
                <input name="rbtn_discapacitado" type="radio" value="1"
                <?php if ($objTRA->getDiscapacitado()=="1"){ echo ' checked="checked"';} ?>
                >Si </td>
              <td width="46">
              <input name="rbtn_discapacitado" type="radio" value="0"  
				<?php if ($objTRA->getDiscapacitado()=="0"){ echo ' checked="checked"'; }?>
              >No</td>
            </tr>
            <tr>
              <td> ¿Sindicalizado? </td>
              <td><input name="rbtn_sindicalizado" type="radio" value="1"
                <?php
              	if ($objTRA->getSindicalizado()=="1"){echo ' checked="checked"'; } ?>  
              >
              Si</td>
              <td><input name="rbtn_sindicalizado" type="radio" value="0"
				<?php if ($objTRA->getSindicalizado()=="0"){echo ' checked="checked"';} ?>
              >
              No</td>
            </tr>
            <tr>
              <td height="45"> Situación: </td>
              <td colspan="2">
              <select name="cbo_situacion" id="cbo_situacion" style="width:160px" 
              <?php //echo ($objTRA->getCod_situacion()==1) ? ' disabled="disabled"' : ''; ?>
               >
            <!--<option value="" >-</option>-->
            <?php              
            foreach ($combo_situacion as $indice) {
            
            if($indice['cod_situacion']=== $objTRA->getCod_situacion()){
            
            $html = '<option value="'.$indice['cod_situacion'].'" selected="selected" >' . $indice['descripcion_abreviada'] . '</option>';	
            
            } else {
				
            $html = '<option value="'. $indice['cod_situacion'] .'" >' . $indice['descripcion_abreviada'] . '</option>';
            
			}
            echo $html;
            }
            ?>
              </select>
                  
                  <input name="estado_trabajador" type="hidden" id="estado_trabajador" size="14"
                 value="<?php echo $objTRA->getEstado(); ?>"
                  /></td>
            </tr>
          </table>
</div>

      
        
        
        <div class="clear"></div>
	</div>
	<h3><a href="#">Section 2  Datos de Seguridad Social</a></h3>
	<div>

        <table width="343" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td width="56" height="67"> <label>Régimen de salud:</label></td>
            <td colspan="2"><?php
				/* echo "ddd ".$objTRADetalle_4->getCod_regimen_aseguramiento_salud();
				echo "<pre>";
				print_r($objTRADetalle_4);
				echo "</pre>";
				*/
			 ?>
              <div class="ocultar"><span class="style2">&nbsp;detalle_regimenes_salud</span></div>
              <select name="cbo_regimen_salud_base" id="cbo_regimen_salud_base" style="width:210px;"
            onchange="havilitarEps(this)" >
                <!--<option value="" >-</option>-->
                <?php              
foreach ($combo_regimen_salud as $indice) {
	
	if($indice['cod_regimen_aseguramiento_salud']=== $objTRADetalle_4->getCod_regimen_aseguramiento_salud()){
		
		$html = '<option value="'.$indice['cod_regimen_aseguramiento_salud'].'" selected="selected" >' . $indice['descripcion'] . '</option>';	
		
	} else {
		$html = '<option value="'. $indice['cod_regimen_aseguramiento_salud'] .'" >' . $indice['descripcion'] . '</option>';
	}
	echo $html;
}
?>
                
                
              </select>
              <br />
              <br />
            <div  id="EPS"  <?php  echo ($objTRADetalle_4->getCod_regimen_aseguramiento_salud() == '0') ? ' class="ocultar"' : '' ?>  >
              
              
              <strong>Entidad prestadora de salud</strong><br />
<label for="cbo_eps_servicios_propios"></label>
                <select name="cbo_eps_servicios_propios" id="cbo_eps_servicios_propios" style="width:180px"
                 >
            <!--<option value="0" >-</option>-->
              <?php              
foreach ($combo_eps as $indice) {
	
	if($indice['cod_eps']== $objTRADetalle_4->getCod_eps() ){
		
		$html = '<option value="'.$indice['cod_eps'].'" selected="selected" >' . $indice['descripcion'] . '</option>';	
		
	} else {
		$html = '<option value="'. $indice['cod_eps'] .'" >' . $indice['descripcion'] . '</option>';
	}
	echo $html;
}
?>

                </select>
              
  </div></td>
            <td width="37">&nbsp;</td>
          </tr>
          <tr>
            <td><input name="id_detalle_regimen_salud" type="hidden" id="id_detalle_regimen_salud" 
              value="<?php echo $objTRADetalle_4->getId_detalle_regimen_salud();  ?>" size="4" /></td>
            <td width="120"><em>Fecha de Inicio <br>
            dd/mm/aaaa</em></td>
            <td width="120"><em>Fecha de Fin<br>
            dd/mm/aaaa</em></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="txt_rsalud_fecha_inicio_base" type="text" id="txt_rsalud_fecha_inicio_base" size="14"
             onkeyup="getFechaActualEnter(event,this)"
            value="<?php echo getFechaPatron( $objTRADetalle_4->getFecha_inicio() ,"d/m/Y" );  ?>" ></td>
            <td><input name="txt_rsalud_fecha_fin_base" type="text" id="txt_rsalud_fecha_fin_base" size="14"
             onkeyup="getFechaActualEnter(event,this)"
            value="<?php echo  getFechaPatron($objTRADetalle_4->getFecha_fin(), "d/m/Y");  ?>"></td>
            <td><div class="ocultar"><a href="#">detalle</a></div></td>
          </tr>
        </table>
        <br>
        <table width="367" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td width="70"><label>Regimen Pensionario</label> <input name="id_regimen_pensionario" type="hidden" id="id_regimen_pensionario" size="4"
              value="<?php echo $objTRADetalle_5->getId_detalle_regimen_pensionario(); ?>"
               /></td>
            <td colspan="2">
              <select name="cbo_regimen_pensionario_base" id="cbo_regimen_pensionario_base" style="width:180px" onchange="havilitarCUSPP(this)">
                <!--<option value="">-</option>-->
                <?php 
foreach ($combo_regimen_pensionario  as $indice) {
	
	if ($indice['cod_regimen_pensionario']==0 ) {		
		$html = '<option value="0" >-</option>';
		
	}else if($indice['cod_regimen_pensionario'] == $objTRADetalle_5->getCod_regimen_pensionario() ){
		
		$html = '<option value="'. $indice['cod_regimen_pensionario'] .'" selected="selected" >' . $indice['descripcion'] . '</option>';

	} else {
		
		$html = '<option value="'. $indice['cod_regimen_pensionario'] .'" >' . $indice['descripcion'] . '</option>';

	}
	echo $html;
}
?>
</select>
              
               <div class="ocultar">detalle_regimenes_pensionarios</div>
              <div id="cuspp"  class="ocultar" 
              style=" <?php echo ($objTRADetalle_5->getCod_regimen_pensionario()=='02' ) ? ' display:none' : ''; ?>">
              <em>Obtenga el CUSPP accediendo a la página <a href="http://www.sbs.gob.pe/0/modulos/JER/JER_Interna.aspx?ARE=0&amp;PFL=1&amp;JER=281">SBS</a></em><br />
                <input name="txt_CUSPP" type="text" id="txt_CUSPP"
            value="<?php echo $objTRADetalle_5->getCUSPP(); ?>" />
              cadena (12)</div>
              <br /></td>
            <td width="58">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="119">Fecha de Inicio <br>
              dd/mm/aaaa</td>
            <td width="110">Fecha de Fin <br>
              dd/mm/aaaa</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="txt_rpensionario_fecha_inicio_base" type="text" id="txt_rpensionario_fecha_inicio_base" size="14" 
             onkeyup="getFechaActualEnter(event,this)"
            value="<?php echo getFechaPatron( $objTRADetalle_5->getFecha_inicio(), "d/m/Y" ); ?>"
            ></td>
            <td><input name="txt_rpensionario_fecha_fin_base" type="text" id="txt_rpensionario_fecha_fin_base" size="14"
             onkeyup="getFechaActualEnter(event,this)"
            value="<?php echo getFechaPatron( $objTRADetalle_5->getFecha_fin(), "d/m/Y" ); ?>" ></td>
            <td><div class="ocultar"><a href="#">detalle</a></div></td>
          </tr>
        </table>
	</div>
	<h3><a href="#">Section 3  Datos Tributarios</a></h3>
	<div>
	  <table width="258" border="1" cellpadding="0" cellspacing="0">
	    <tr>
            <td width="169"><p>¿Percibe rentas de 5ta exoneradas (Inc. e) Art. 19 de la LIR?</p></td>
            <td width="41"><input name="rbtn_percibe_renta_5ta_exoneradas" type="radio" value="1"
            <?php if($objTRA->getPercibe_renta_5ta_exonerada()=="1"){ echo ' checked="checked"'; } ?>
            >
            Si</td>
            <td width="40"><input name="rbtn_percibe_renta_5ta_exoneradas" type="radio" value="0" 
            <?php if($objTRA->getPercibe_renta_5ta_exonerada()=="0"){ echo ' checked="checked"'; } ?>
            >
            No</td>
          </tr>
          <tr>
            <td> ¿Aplica convenio para evitar doble imposición? </td>
            <td><input name="rbtn_aplica_convenio_doble_inposicion" type="radio" value="1"
            onclick="havilitarConvenio()" 
            <?php if($objTRA->getAplicar_convenio_doble_inposicion()=="1"){ echo ' checked="checked"'; }?>
            >
            Si</td>
            <td><input name="rbtn_aplica_convenio_doble_inposicion" type="radio" value="0" 
            onclick="havilitarConvenio()"
            <?php if($objTRA->getAplicar_convenio_doble_inposicion()=="0"){ echo ' checked="checked"'; }?>
            >              No</td>
          </tr>
          <tr>
            <td>Convenio:</td>
            <td><select name="cbo_convenio" id="cbo_convenio">
             <!--<option value="">-</option>-->
              <?php 
foreach ($combo_convenio  as $indice) {
	
	if ($indice['cod_convenio']== $objTRA->getCod_convenio() ) {
		
		$html = '<option value="'. $indice['cod_convenio'] .'" selected="selected" >' . $indice['descripcion'] . '</option>';
	} else {
		$html = '<option value="'. $indice['cod_convenio'] .'" >' . $indice['descripcion'] . '</option>';
	}
	echo $html;
}
?>
             
             
             
              </select>
            </td>
            <td class="style2">&nbsp;</td>
          </tr>
    </table>
     
        
		
        
        <div class="clear"></div>
        
	</div>
</div>

</div><!-- End demoo -->  




        <p><!--validarFormularioTrabajador()-->
          <input name="btn_aceptar" type="button" id="btn_aceptar" value="Aceptar(Validar)" 
          onclick="validarFormtrabajadorPrincipal()" />
      </p>   
        
        		
	  </form>






<?php require_once('../categoria-detalle/detalle_periodo_laboral.php'); ?>


<?php require_once('../categoria-detalle/detalle_tipo_trabajador.php'); ?>
</div>



    