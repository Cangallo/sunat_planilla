<div id="dialog-form-nuevoTerreno" class="crud" title="Nuevo Terreno" style="display:display">

<form action="" method="post" enctype="multipart/form-data" name="formT" class="formulario"  id="formT" style="width:200px;" >

<table width="500" border="0" >
    <tr >
      <td width="91">Codigo</td>
      <td width="158"><input name="txt_codigo" type="text" id="txt_codigo" readonly="readonly" /></td>
      <td width="92">id_terreno</td>
      <td width="144"><input type="text" name="txt_id_terreno" id="txt_id_terreno" /></td>
    </tr>
    <tr >
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr >
      <td>Area</td>
      <td><input type="text" name="txt_area2" id="txt_area4" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
<tr >
  <td>Area Const</td>
  <td><input type="text" name="txt_area_construida" id="txt_area_construida" /></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr >
  <td>habitaciones</td>
  <td><label>
    <input type="text" name="txt_habitacion" id="txt_habitacion" />
  </label></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr >
  <td>ba&ntilde;os</td>
  <td><label>
    <input type="text" name="txt_habitacion2" id="txt_habitacion2" />
  </label></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr >
  <td>garaje</td>
  <td><label>
    <input type="text" name="txt_garaje" id="txt_garaje" />
  </label></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr >
  <td>a&ntilde;o de construcion</td>
  <td><label>
    <input type="text" name="txt_anio_construccion" id="txt_anio_construccion" />
  </label></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr >
  <td>ubicacion/pisos</td>
  <td><label>
    <input type="text" name="txt_ubicacion_piso" id="txt_ubicacion_piso" />
  </label></td>
  <td>1/3</td>
  <td>&nbsp;</td>
</tr>
<tr >
  <td>amoblado</td>
  <td><label>
    <input type="radio" name="rbt_amoblado"  value="SI" />
    SI
    <input type="radio" name="rbt_amoblado" value="NO" />
  NO</label></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr >
  <td>precio venta</td>
  <td><input type="text" name="txt_precio_venta" id="txt_precio_venta" /></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr >
  <td>precio alquiler</td>
  <td><input type="text" name="txt_precio_alquiler" id="txt_precio_alquiler" /></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr >
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr >
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
<tr >
      <td colspan="4">GEO LOCALIZACION 
        <label>
          <select name="cbo_pais" id="cbo_pais">
            <option>pais</option>
          </select>
        </label></td>
      </tr>
    <tr >
      <td>Pais PERU</td>
      <td colspan="3"><select name="cbo_distrito3" id="cbo_distrito5">
          <option>Departamento</option>
        </select>
          <select name="cbo_provincia2" id="cbo_provincia3">
            <option>provincia</option>
          </select>
          <select name="cbo_distrito3" id="cbo_distrito6">
            <option>distrito</option>
          </select>
          <label for="cbo_distrito5"></label></td>
    </tr>
    <tr >
      <td>Direccion</td>
      <td colspan="2"><input type="text" name="txt_direccion2" id="txt_direccion2" /></td>
      <td><label for="txt_direccion2"></label></td>
    </tr>
<tr >
  <td>&nbsp;</td>
  <td><a href="#">localizacion en mapa</a></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr >
  <td>Latitud</td>
  <td><input type="text" name="geo_latitud2" id="geo_latitud2" /></td>
  <td>Longitud</td>
  <td><label for="geo_latitud2">
    <input type="text" name="geo_longitud2" id="geo_longitud2" />
  </label></td>
</tr>
<tr >
      <td>IMAGENES</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr >
      <td colspan="4">
      
      <div class="" id="add_images" style="background-color:#F00;">
      <input type="file" name="file_imagen" id="file_imagen" />
      </div>      </td>
</tr>
    <tr >
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>     
</table>
</form>


</div>