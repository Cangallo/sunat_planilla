<?php
//*******************************************************************//
require_once('../view/ide.php');
//*******************************************************************//
require_once '../controller/ideController.php';

//echo "ID_EMPLEADOR_MAESTRO = ".ID_EMPLEADOR_MAESTRO;
// -- Carga de COMBOS
require_once('../dao/ComboCategoriaDao.php');
require_once('../controller/ComboCategoriaController.php');

//Combo 01
$cbo_tipo_empleador = comboTipoEmpleador();

$data = $_SESSION['sunat_empleador'];

$PERIODO = ($_REQUEST['periodo']) ? $_REQUEST['periodo'] : "00/0000";
$ID_DECLARACION = $_REQUEST['id_declaracion'];

//echo "<pre>";
//print_r($data);
//echo "</pre>";

//require_once('../controller/ideController.php');


?>

<script type="text/javascript">
//VARIABLES GLOBALES:

var PERIODO = '<?php echo $PERIODO; ?>';
var ID_DECLARACION = '<?php echo $ID_DECLARACION; ?>';

    $(document).ready(function(){
                  
        $( "#tabs").tabs();
		
		//$( "#tabs2").tabs();
		
	});
//---------------------------------

	cargar_pagina('sunat_planilla/view-plame/edit_declaracion_tab2.php?periodo='+PERIODO ,'#tabs-2');
	cargar_pagina('sunat_planilla/view-plame/edit_declaracion_tab3.php?periodo='+PERIODO ,'#tabs-3');



//functiones GRID
	
</script>


<div align="left">


    <div id="tabs">
    
    
        <ul>
            <li><a href="#tabs-1">Informacion General</a></li>	
            <li><a href="#tabs-2">Detalle de Declaraci&oacute;n</a></li>
            <li><a href="#tabs-3">Determinacion de Deuda</a></li>	            		

        </ul>
        
        
        <div id="tabs-1">


          <h2>Datos Basicos de la Declaracion:</h2>

          <form id="frmNuevaDeclaracion" name="frmNuevaDeclaracion" method="post" action="">
          
		    <p>id_declaracion		      
		      <input type="text" name="id_declaracion" id="id_declaracion"
              value="<?php echo $ID_DECLARACION; ?>" />
		    </p>
		    <p>RUC:
              <label for="ruc"></label>
            <input type="text" name="ruc" id="ruc"  readonly="readonly"
            value="<?php  echo $data['ruc']; ?>" />
            <br />
          Nombre/Razon Social:	
          <label for="razon_social"></label>
          <input type="text" name="razon_social" id="razon_social"   readonly="readonly"
          value="<?php echo $data['razon_social_concatenado']; ?>" />
          <br />
          Periodo Tributario (mm/aaaa)          
      <input type="text" name="txt_periodo_tributario" id="txt_periodo_tributario"  readonly="readonly"
      value="<?php echo $PERIODO; ?>" />
		    </p>
		    <div class="ocultar"> 
              <p>Declaracion Sustitutoria o Rectificadora
                 <input name="rbtn_declaracionRectificadora" type="radio" id="rbtn_declaracionRectificadora" value="1" checked="checked" />
                 Si
                 <input type="radio" name="rbtn_declaracionRectificadora" id="rbtn_declaracionRectificadora" value="0" />
No </p>
               <p>Limpia datos Edit</p>
            </div>
             </p>
             Sincronizar datos: Actualizar Prestadores de Servicios: 
            <input type="checkbox" name="chk_actualizar_declaracion" id="chk_actualizar_declaracion" />		      
	        <input type="button" name="btnEjecutar" id="btnEjecutar" value="Actualizar Declaracion" 
            onclick="registrarDeclaracion()" />
		    <p>La declaracion se ebabor&oacute; 'Ultima actualizacion'
		      <input type="text" name="dfcreacion" id="dfcreacion" />
		    </p>
		    <p>&nbsp;</p>
		    <p>&nbsp;</p>
            
            
            		    
          </form>
        
      </div><!-- tabs-1 -->
        
        
        <div id="tabs-2">
          <p>&nbsp;</p>
          <p>ass2 </p>
</div>
        
        
        <div id="tabs-3">
        ass
        
        3</div>
        
        
</div>