<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 require_once("../../conexion.php");
 require_once("../include/funciones.php");

$titulo_pagina="Pof " . Dfirst("CONCAT(NUMERO,'-',NOMBRE_POF)","POF_lista", "ID_POF={$_GET["id_pof"]} AND $where_c_coste"  ) ;

//juan duran
?>

<HTML>
<HEAD>
     <title><?php echo $titulo_pagina ?></title> 
    
 	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>1" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>


<?php  

$id_pof=$_GET["id_pof"];

//<!-- CONEXION CON LA BBDD Y MENUS -->
//require_once("../../conexion.php"); 
//require_once("../include/funciones.php");

require_once("../menu/topbar.php");
//require_once("../obras/obras_menutop_r.php");
//require_once("../menu/menu_migas.php");

//require_once("../menu/topbar.php");

?>

<div style="overflow:scroll; ">	   
   
	<!--************ INICIO ficha POF *************  -->
       
        
<div id="main" class="mainc_30" >


			
<?php   // Iniciamos variables para ficha.php  background-color:#B4045


$sql="SELECT ID_POF,ID_OBRA,NOMBRE_OBRA,NUMERO,NOMBRE_POF,Condiciones,Observaciones,Importe_aprox,importe_cobro,activa,f_adjudicacion"
        . ",user,fecha_creacion,NOMBRE_COMPLETO,Situacion,URL_Google_Maps  FROM POF_lista WHERE ID_POF=$id_pof AND $where_c_coste " ;
//$sql="SELECT * FROM POF_lista WHERE ID_POF=$id_pof AND $where_c_coste " ;
$result=$Conn->query($sql );

$rs = $result->fetch_array(MYSQLI_ASSOC) ;
 
$id_pof = $rs["ID_POF"];   // por seguridad
$id_obra=$rs["ID_OBRA"] ;

$updates=['NUMERO','NOMBRE_POF','F_Cierre','Importe_aprox',  'Observaciones', 'activa','Adjudicatario', 'Condiciones', 'f_adjudicacion']  ;
$ocultos=['NOMBRE_OBRA','NOMBRE_COMPLETO' ,'Situacion','URL_Google_Maps'] ;

// $id_proveedor=$rs["ID_PROVEEDORES"] ;
$tabla_update="PETICION DE OFERTAS" ;
$id_update="ID_POF" ; 
$id_valor=$id_pof ;
$delete_boton=1;

$selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS","","../obras/obras_ficha.php?id_obra=","ID_OBRA"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
    
$formats["activa"]="boolean" ;
$formats["Condiciones"]="text_edit" ;
$tooltips["Condiciones"]="Condiciones de entrega, suministro... a mostrar al proveedor " ;
$tooltips["Importe_aprox"]="Importe Aproximado: Si el importe de cobro calculado no es representativo puede indicarse explícitamente cual es el Importe Aproximado de la POF" ;

$titulo="POF: {$rs["NUMERO"]}-{$rs["NOMBRE_POF"]}";
$msg_tabla_vacia="No hay.";
 
require_once("../obras/obras_menutop_r.php");   // menu obras despues de declarar $id_obra
  
echo "<br><br><br><br><br>" ;
echo "<a target='_blank' class='btn btn-link btn-lg' href='../pof/pof_PDF.php?id_pof=$id_pof' >ver Petición PDF</a>" ;


// relleno con espacios los elementos del array vacíos  futura ARRAY_QUITA_VACIOS
foreach ($rs as $key => $value)
{
   if (!$value) {$rs[$key]=' ';}
}
$array_plantilla = $rs ;      // copiamos array para datos para la Generación de Documentos con PLANTILLAS HTML

//echo $plantilla_get_url   ;

require("../include/ficha.php");

?>

</div>

<!--************ FIN FICHA POF *************  -->
<div class="right2">

<?php 
//  WIDGET FIRMAS 
$tipo_entidad='pof' ;
$id_entidad=$id_pof ;
$firma="POF de {$rs["NOMBRE_OBRA"]}  {$rs["NUMERO"]}-{$rs["NOMBRE_POF"]}(".cc_format($rs["Importe_aprox"], 'moneda').") " ;

//$id_subdir=$id_proveedor ;
//$size='400px' ;
require("../include/widget_firmas.php");          // FIRMAS

 ?>
</div>

<!--************ DOCUMENTOS POF *************  -->
<div class="right2">
	

<?php 

// preparamos la TABLA para Generar la pof_PDF
$sql="SELECT CANTIDAD, CONCAT('<b>',CONCEPTO,'</b><br><small>',IFNULL(DESCRIPCION,''),'</small>') AS CONCEPTO,"
        . " ' ' as _PRECIO ,"
        . " ' ' AS _IMPORTE "
        . " FROM POF_CONCEPTOS WHERE ID_POF=$id_pof AND Ocultar=0 ORDER BY id" ;
//echo $sql ;
$result=$Conn->query( $sql );
$titulo='';
$msg_tabla_vacia="No hay";
require("../include/tabla.php");
//echo $TABLE ;

$array_plantilla["HTML_TABLA1"]=urlencode($TABLE) ;
//$plantilla_get_url.= "&" . http_build_query($array) ;      // datos para la Generación de Documentos con PLANTILLAS HTML

//echo $plantilla_get_url   ;




$tipo_entidad='pof_doc' ;
$id_entidad=$id_pof;
$id_subdir=$id_obra ;
$size='100px' ;

require("../include/widget_documentos.php");
 ?>
	 
</div>

<!--************ INICIO POF_DETALLE (#SUBCONTRATOS ) *************  -->

<div  class="right2_50" >

<?php   // Iniciamos variables para tabla.php  
$sql="SELECT id_subcontrato,id_proveedor,PROVEEDOR, subcontrato,Importe_subcontrato,Porc_ej,Observaciones FROM Subcontratos_todos_View WHERE id_pof=$id_pof AND $where_c_coste ORDER BY id_subcontrato";
$result=$Conn->query($sql );
$result_T=$Conn->query($sql="SELECT '' as a,'' as a1,sum(Importe_subcontrato) as Importe_subcontrato,'' as a2,'' as a21  FROM Subcontratos_todos_View WHERE id_pof=$id_pof AND $where_c_coste " );

$titulo="SUBCONTRATOS ($result->num_rows)";
$msg_tabla_vacia="No hay subcontratos";

$links["PROVEEDOR"] = ["../proveedores/proveedores_ficha.php?id_proveedor=", "id_proveedor", "ver Proveedor",''] ;
$links["subcontrato"] = ["../obras/subcontrato.php?id_subcontrato=", "id_subcontrato", "ver subcontrato",'formato_sub'] ;
//$links["ver"] = [ '', 'path_archivo', "ver Pdf", 'ppal'] ;

//$formats["Enviado"]="semaforo" ;
//$formats["Respondido"]="semaforo" ;
//$formats["PDF"]="boolean" ;
//$formats["path_archivo"]="pdf_200_500" ;
//$formats["ver"]="boolean_PDF" ;

//$aligns["Num"] = "center" ;
//$aligns["Prov"] = "center" ;
////$aligns["Enviado"] = "center" ;
////$aligns["Respondido"] = "center" ;
//$aligns["Adj"] = "center" ;
//$aligns["Enviado"] = "center" ;
//$aligns["Respondido"] = "center" ;
//$tooltips["Prov"] = "Proveedores seleccionados para pedirles presupuesto" ;
//$tooltips["Enviado"] = "Proveedores a los que se ha enviado peticion de oferta" ;
//$tooltips["Respondido"] = "Proveedores que han respondido y presupuestado la POF" ;


 $updates=[ 'Observaciones']  ;
 // $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="Subcontratos" ;
  $id_update="id_subcontrato" ;
  $id_clave="id_subcontrato" ;
//  $id_valor=$id_pof ;
  
require("../include/tabla.php"); echo $TABLE ;?>

</div>	
<!--************ FIN POF_DETALLE (SUBCONTRATOS) *************  -->	
<!--************ INICIO POF_DETALLE (PROVEEDORES - #OFERTAS) *************  -->

<!--<div  class="mainc_100" >-->
<div  class="right2_60" >

<?php   // Iniciamos variables para tabla.php  



/// consulta para el listado de OFERTAS ordenadas de menor a mayor y las no respondidas al final
$sql=("SELECT id,ID_POF, NUM, PROVEEDOR, path_archivo,Enviado, Respondido,Importe_Prov,Importe_Cobro, Observaciones "
        . " FROM POF_prov_View WHERE ID_POF=$id_pof ORDER BY ((Importe_Prov<>0) AND NUM<=9) desc, Importe_prov, NUM" );



$result=$Conn->query($sql );
$result_T=$Conn->query($sql="SELECT  COUNT(id) as total , 'Totales',' ',  SUM(Enviado), SUM(Respondido)   FROM POF_DETALLE WHERE ID_POF=$id_pof " );

$titulo="OFERTAS";
$msg_tabla_vacia="No hay";


$etiquetas["PROVEEDOR"]='Oferta' ;
$tooltips["PROVEEDOR"]='Nombre de la Oferta o del proveedor' ;

$links["PROVEEDOR"] = ["../pof/pof_proveedor_ficha.php?id=", "id", "ver POF",'formato_sub'] ;
//$links["ver"] = [ '', 'path_archivo', "ver Pdf", 'ppal'] ;

$formats["Enviado"]="semaforo" ;
$formats["Respondido"]="semaforo" ;
$formats["PDF"]="boolean" ;
$formats["path_archivo"]="pdf_100_400" ;
//$formats["ver"]="boolean_PDF" ;

$aligns["Num"] = "center" ;
$aligns["Prov"] = "center" ;
//$aligns["Enviado"] = "center" ;
//$aligns["Respondido"] = "center" ;
$aligns["Adj"] = "center" ;
$aligns["Enviado"] = "center" ;
$aligns["Respondido"] = "center" ;
$tooltips["Prov"] = "Proveedores seleccionados para pedirles presupuesto" ;
$tooltips["Enviado"] = "Proveedores a los que se ha enviado peticion de oferta" ;
$tooltips["Respondido"] = "Proveedores que han respondido y presupuestado la POF" ;


 $updates=['NUM','','Enviado',  'Respondido', 'Observaciones']  ;
 // $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="POF_DETALLE" ;
  $id_update="id" ;
  $id_clave="id" ;
//  $delete_boton=1;
//  $id_valor=$id_pof ;
  $actions_row=[];
$actions_row["id"]="id";
  $actions_row["delete_link"]=1;
  
?>
    
<br>
<!--<a class='btn btn-link noprint' href='../pof/pof_proveedor_anadir.php?_m=$_m&id_pof=<?php echo $id_pof;?>'  ><i class="fas fa-plus-circle"></i> Añadir proveedor</a>-->
<a class='btn btn-link'  href=# <?php echo "onclick=\"add_pof_proveedor($id_pof)\" " ;?> ><i class="fas fa-plus-circle"></i> Añadir Oferta</a>



<?php 
$ocultos=[ 'Importe_Cobro']  ;
//$chart_ocultos=["NUM"] ;
$cols_string=["PROVEEDOR"] ;
$cols_number=["Importe_Prov","Importe_Cobro"] ;
$cols_line=["Importe_Cobro"] ;
$chart_ON=1;


require("../include/tabla.php"); echo $TABLE ;?>

</div>	
<!--************ FIN POF_DETALLE (PROVEEDORES) *************  -->	
	<!--************ INICIO POF_CONCEPTOS (Unidades de Obra). CUADRO COMPARATIVO *************  -->

<!--   <div id="main" class="mainc" style="background-color:red">    -->
<?php   // Iniciamos variables para tabla.php  




$prov1=substr((Dfirst("PROVEEDOR", "POF_DETALLE","ID_POF=$id_pof AND NUM='1'  ")),0,12)  ;
$prov2=substr((Dfirst("PROVEEDOR", "POF_DETALLE","ID_POF=$id_pof AND NUM='2'  ")),0,12)  ;
$prov3=substr((Dfirst("PROVEEDOR", "POF_DETALLE","ID_POF=$id_pof AND NUM='3'  ")),0,12)  ;
$prov4=substr((Dfirst("PROVEEDOR", "POF_DETALLE","ID_POF=$id_pof AND NUM='4'  ")),0,12)  ;
$prov5=substr((Dfirst("PROVEEDOR", "POF_DETALLE","ID_POF=$id_pof AND NUM='5'  ")),0,12)  ;
$prov6=substr((Dfirst("PROVEEDOR", "POF_DETALLE","ID_POF=$id_pof AND NUM='6'  ")),0,12)  ;
$prov7=substr((Dfirst("PROVEEDOR", "POF_DETALLE","ID_POF=$id_pof AND NUM='7'  ")),0,12)  ;
$prov8=substr((Dfirst("PROVEEDOR", "POF_DETALLE","ID_POF=$id_pof AND NUM='8'  ")),0,12)  ;
$prov9=substr((Dfirst("PROVEEDOR", "POF_DETALLE","ID_POF=$id_pof AND NUM='9'  ")),0,12)  ;

// CALCULAMOS EL ORDEN DEL cUADRO cOMPARATIVO
//$sql=("SELECT  NUM,(Importe_prov<>0) AS Importe_NN "
//        . " FROM POF_prov_View WHERE ID_POF=$id_pof  AND NUM<=9 ORDER BY Importe_NN desc, Importe_prov" );
//$result=$Conn->query($sql );


// calculamos el orden para la consulta del Cuadro Comparativo
$orden=DArray("NUM", "POF_prov_View", "ID_POF=$id_pof  AND NUM<=9" , "(Importe_prov<>0) desc, Importe_prov, NUM") ;


$select_P[1] =  $prov1 ? " ,P1 , P1*CANTIDAD*(NOT Ocultar)*(NOT Ocultar) AS Importe_1 , ' ' as ID_TH_COLOR1 " : ""  ;
$select_P[2] =  $prov2 ? " ,P2 , P2*CANTIDAD*(NOT Ocultar)*(NOT Ocultar) AS Importe_2 , ' ' as ID_TH_COLOR2 " : ""  ;
$select_P[3] =  $prov3 ? " ,P3 , P3*CANTIDAD*(NOT Ocultar)*(NOT Ocultar) AS Importe_3 , ' ' as ID_TH_COLOR3 " : ""  ;
$select_P[4] =  $prov4 ? " ,P4 , P4*CANTIDAD*(NOT Ocultar)*(NOT Ocultar) AS Importe_4 , ' ' as ID_TH_COLOR4 " : ""  ;
$select_P[5] =  $prov5 ? " ,P5 , P5*CANTIDAD*(NOT Ocultar)*(NOT Ocultar) AS Importe_5 , ' ' as ID_TH_COLOR5 " : ""  ;
$select_P[6] =  $prov6 ? " ,P6 , P6*CANTIDAD*(NOT Ocultar)*(NOT Ocultar) AS Importe_6 , ' ' as ID_TH_COLOR6 " : ""  ;
$select_P[7] =  $prov7 ? " ,P7 , P7*CANTIDAD*(NOT Ocultar)*(NOT Ocultar) AS Importe_7 , ' ' as ID_TH_COLOR7 " : ""  ;
$select_P[8] =  $prov8 ? " ,P8 , P8*CANTIDAD*(NOT Ocultar)*(NOT Ocultar) AS Importe_8 , ' ' as ID_TH_COLOR8 " : ""  ;
$select_P[9] =  $prov9 ? " ,P9 , P9*CANTIDAD*(NOT Ocultar)*(NOT Ocultar) AS Importe_9 , ' ' as ID_TH_COLOR9 " : ""  ;

$select_P_txt="" ;
$select_T_txt="" ;
foreach ($orden as $value) {
    $i=$value[0] ;
    $select_P_txt.= " , P$i, P$i*CANTIDAD*(NOT Ocultar)*(NOT Ocultar) AS Importe_$i , ' ' as ID_TH_COLOR$i " ;
    $select_T_txt.= " , '' AS a$i, SUM(P$i*CANTIDAD*(NOT Ocultar)) AS Importe_$i , ' ' as ID_TH_COLOR$i " ;
//    $select_P_txt.=$select_P[$value[0]] ;
}


// consulta de CUADRO COMPARATIVO
$sql="SELECT id,Ocultar,CANTIDAD,DESCRIPCION AS CONCEPTO_TOOLTIP,CONCEPTO,id_udo,Precio_Cobro, Precio_Cobro*CANTIDAD*(NOT Ocultar) AS Importe_Cobro, ' ' as ID_TH_COLOR "
        . " $select_P_txt  FROM POF_CONCEPTOS WHERE ID_POF=$id_pof ORDER BY id" ;
//echo $sql ;


//$sql_T="SELECT '' as a,'' as a7, '' as b, '' as c, 'Importe_Cobro', SUM(Precio_Cobro*CANTIDAD*(NOT Ocultar)) AS Importe_Cobro,  "
//        . " '' AS A1, SUM(P1*CANTIDAD*(NOT Ocultar)) AS Importe1,'' AS A2, SUM(P2*CANTIDAD*(NOT Ocultar)) AS Importe2, "
//        . " '' AS A3,  SUM(P3*CANTIDAD*(NOT Ocultar)) AS Importe3,'' AS A4,SUM( P4*CANTIDAD*(NOT Ocultar)) AS Importe4, "
//        . " '' AS A5, SUM(P5*CANTIDAD*(NOT Ocultar)) AS Importe5, '' AS A6,SUM( P6*CANTIDAD*(NOT Ocultar)) AS Importe6 , "
//        . " '' AS A7,SUM( P7*CANTIDAD*(NOT Ocultar)) AS Importe7 ,'' AS A8,SUM( P8*CANTIDAD*(NOT Ocultar)) AS Importe8 , "
//        . " '' AS A9,SUM( P9*CANTIDAD*(NOT Ocultar)) AS Importe9 "
//        . " FROM POF_CONCEPTOS WHERE ID_POF=$id_pof GROUP BY ID_POF" ;

$sql_T="SELECT '' as a,'' as aa, '' as b, '' as c, 'Importe_Cobro', SUM(Precio_Cobro*CANTIDAD*(NOT Ocultar)) AS Importe_Cobro , ' ' as ID_TH_COLOR  "
        . " $select_T_txt FROM POF_CONCEPTOS WHERE ID_POF=$id_pof GROUP BY ID_POF" ;

//echo $sql ;
//echo '<br>' ;
//echo $sql_T ;

$result=$Conn->query( $sql );
$result_T=$Conn->query( $sql_T );

$titulo='';
$msg_tabla_vacia="No hay";

//$updates=['CANTIDAD','CONCEPTO', 'Precio_Cobro', 'Precio_Compra','P1','P2','P3','P4','P5','P6','P7','P8','P9']  ;
$updates=[ 'CANTIDAD', 'Precio_Cobro', 'Ocultar','P1','P2','P3','P4','P5','P6','P7','P8','P9']  ;

 // $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="POF_CONCEPTOS" ;
  $id_update="id" ;
  $id_clave="id" ;
//  $delete_boton=1 ;
 
$links["CONCEPTO"] = ["../pof/pof_concepto_ficha.php?id=", "id", "ver POF CONCEPTO",'formato_sub'] ;

$formats["DESCRIPCION"]="textarea" ;
$formats["Ocultar"]="semaforo_not" ;
//$formats["Ocultar"]="boolean" ;

//$formats["Precio_Cobro"]="moneda" ;


$formats["CANTIDAD"]="fijo" ;

$formats["P1"]="text_moneda" ;
$formats["P2"]="text_moneda" ;
$formats["P3"]="text_moneda" ;
$formats["P4"]="text_moneda" ;
$formats["P5"]="text_moneda" ;
$formats["P6"]="text_moneda" ;
$formats["P7"]="text_moneda" ;
$formats["P8"]="text_moneda" ;
$formats["P9"]="text_moneda" ;

$etiquetas["Importe_1"] = "$prov1" ;
$etiquetas["Importe_2"] = "$prov2" ;
$etiquetas["Importe_3"] = "$prov3" ;
$etiquetas["Importe_4"] = "$prov4" ;
$etiquetas["Importe_5"] = "$prov5" ;
$etiquetas["Importe_6"] = "$prov6" ;
$etiquetas["Importe_7"] = "$prov7" ;
$etiquetas["Importe_8"] = "$prov8" ;
$etiquetas["Importe_9"] = "$prov9" ;

$etiquetas["P1"] = " 1" ;
$etiquetas["P2"] = " 2" ;
$etiquetas["P3"] = " 3" ;
$etiquetas["P4"] = " 4" ;
$etiquetas["P5"] = " 5" ;
$etiquetas["P6"] = " 6" ;
$etiquetas["P7"] = " 7" ;
$etiquetas["P8"] = " 8" ;
$etiquetas["P9"] = " 9" ;


  
$actions_row=[];
$actions_row["id"]="id";
//$actions_row["update_link"]="../include/update_row.php?tabla=Fra_Cli_Detalles&where=id=";
//$actions_row["delete_link"]="../include/tabla_delete_row.php?tabla=PARTES_PERSONAL&where=id=";
$actions_row["delete_link"]="1";


//  $id_valor=$id_pof ;
  
  
?>


<div style='background-color: white' class="mainc" >

<button type='button' class='btn btn-default noprint' id='exp_seleccion' data-toggle='collapse' data-target='#div_seleccion'><h3>Añadir Conceptos a la POF <span class="glyphicon glyphicon-chevron-down"></span></h3></button>
<div  id='div_seleccion' class='collapse'>
    
  <div class='border' style='background-color: white; border-color: grey'>    
   <p><b>Concepto vacio</b></p>

   <!--<a class='btn btn-link btn-lg' href='../pof/pof_concepto_anadir.php?id_pof=<?php // echo $id_pof;?>'  ><i class='fas fa-plus-circle'></i> Añadir concepto vacio</a>-->
   <a class='btn btn-link btn-lg'  href=# <?php echo "onclick=\"add_pof_concepto($id_pof)\" " ;?> ><i class="fas fa-plus-circle"></i> Añadir concepto vacio</a>

  </div>

    <div class='border' style='border-color: grey' >
      <!--<label for="id_personal">Selecciona personal:</label>-->
    

      <p><b>Unidad de Obra (UDO)</b></p>
      <input type="text" id="filtro" size="7" value="" style="text-align:right;" placeholder="busca Udo..." />
      <i class="fas fa-search"></i>
      <!--<select class="form-control" id="id_personal" style="width: 30%;">-->
      <select id="id_udo"  onblur='this.size=1;' onchange='this.size=1; this.blur();' style="font-size: 15px; width: 50%;" size="1">
  			
          
       <?php 
        
//        $id_concepto_auto=Dfirst("id_concepto_auto","Proveedores","ID_PROVEEDORES=$id_proveedor")   ;
       echo  "<option value='0' >Selecciona Capítulo...</option>"  ;
       echo DOptions_sql("SELECT ID_UDO,CONCAT('(',ID_UDO,') ' ,CAPITULO,':  ',MED_PROYECTO, ' ',ud,' ',UDO) FROM Udos_View "
               . "WHERE ID_OBRA=$id_obra AND $where_c_coste  ORDER BY CAPITULO, ID_UDO ") ;

        ?>
        
 	
      </select>
      <!--<input type="text" id="cantidad" size="3" value="0" style="text-align:right;" />-->
      <a id='anadir_concepto'  class='btn btn-link btn-lg' href='#'  onclick='pof_add_udo(<?php echo $id_pof ; ?>);'><i class='fas fa-plus-circle'></i> Añadir concepto de UDO</a>
      <a class='btn btn-link btn-xs' href='#'  onclick='ver_udo();'>ver Udo</a>
      <!--<a class='btn btn-link btn-xs' href='../proveedores/concepto_anadir.php?_m=$_m&id_proveedor=<?php // echo $id_proveedor  ; ?>&id_obra=<?php // echo $id_obra  ; ?>' target='_blank' ><i class='fas fa-plus-circle'></i> Nuevo concepto</a>-->

      
    </div>
    
<script>
    

// filtro del <SELECT>    
$(document).ready(function() {
  $('#filtro').change(function() {
    var filter = $(this).val();
    filter=filter.replace(/ /g,".*")  ;
//    alert(filter) ;
//    var re = new RegExp('rebu', 'gi');
    var re = new RegExp(filter, 'gi');

    $('option').each(function() {
//      if ($(this).text().includes('SADA')) {
      if ($(this).text().match(re)) {
        $(this).show();
//        alert($(this).text()) ;
      } else {
        $(this).hide();
      }
    })
        $("#id_udo").prop("size", 10);

  })
})


    
    
function ver_udo() {
    
var id_concepto=document.getElementById("id_udo").value ;
 
window.open('../obras/udo_prod.php?id_udo='+id_udo, '_blank');

return ;
 }



</script>
 

    <div class='border' style='border-color: grey'>
        <p><b>CAPITULO</b></p>
      <select  id="id_capitulo" style="font-size: 15px; width: 20%;">
       <?php echo DOptions_sql("SELECT ID_CAPITULO,CAPITULO FROM Capitulos WHERE ID_OBRA=$id_obra  ORDER BY CAPITULO ", "Selecciona Capítulo...") ?>
      </select>
<!--      <input type="text" id="cantidad_mq" size="3" value="0" style="font-size: 20px; text-align:right;" /> ud       
      <input type="text" id="observaciones_mq" size="10" value="" placeholder="Observaciones"  /> -->
      
      <a class='btn btn-link btn-lg' href='#'  onclick='pof_add_capitulo(<?php echo $id_pof ; ?>);'><i class='fas fa-plus-circle'></i> Añadir conceptos del Capítulo</a>
    </div>

    <div class='border' style='border-color: grey'>
        <p><b>SUBOBRA</b></p>
      <select  id="id_subobra" style="font-size: 15px; width: 20%;">
       <?php echo DOptions_sql("SELECT ID_SUBOBRA,SUBOBRA FROM Subobra_View WHERE ID_OBRA=$id_obra AND $where_c_coste ORDER BY SUBOBRA ", "Selecciona SubObra...") ?>
      </select>
<!--      <input type="text" id="cantidad_mq" size="3" value="0" style="font-size: 20px; text-align:right;" /> ud       
      <input type="text" id="observaciones_mq" size="10" value="" placeholder="Observaciones"  /> -->
      
      <a class='btn btn-link btn-lg' href='#' onclick='pof_add_subobra(<?php echo $id_pof ; ?>);'><i class='fas fa-plus-circle'></i> Añadir conceptos de la SubObra</a>
      <a class='btn btn-link btn-lg' href='#' onclick="window.open('../obras/subobra_ficha.php?id_subobra='+document.getElementById('id_subobra').value); "> ir a SubObra</a>
    </div>


  
 </div>
</div>


<div class='mainc_100' style="background-color:#E7F7E1; clear: left  ;padding:0 20px;" >
 <!--<h2>CUADRO COMPARATIVO</h2>-->

<?php 
$titulo="CUADRO COMPARATIVO" ;

//$ocultos=[ 'Importe_Cobro']  ;
//$chart_ocultos=["NUM"] ;
$cols_string=["CONCEPTO"] ;
$cols_number=["Importe_Cobro","Importe_1","Importe_2","Importe_3","Importe_4","Importe_5","Importe_6","Importe_7","Importe_8","Importe_9"] ;
$cols_line=["Importe_Cobro"] ;
//$chart_ON=1;


require("../include/tabla.php"); echo $TABLE ;?>
    
    <br><br><br><br> 

</div>

<!-- ************ FIN POF_CONCEPTOS (Unidades de Obra) *************  -->

<?php  

$Conn->close();

?>
	 

</div>



<script>
function pof_add_udo(id_pof) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
   var id_udo=document.getElementById("id_udo").value ;
//   var cantidad_mq=document.getElementById("cantidad_mq").value ;
//   var observaciones_mq=document.getElementById("observaciones_mq").value ;
//   var sql="INSERT INTO POF_CONCEPTOS (ID_POF,id_udo,CANTIDAD,CONCEPTO,DESCRIPCION,Precio_Cobro,user ) " + 
//           "VALUES ('"+id_parte+"','"+ id_obra_maq +"','"+ cantidad_mq +"','"+ observaciones_mq +"')"    ;   
//   var sql="INSERT INTO POF_CONCEPTOS " + 
//           " SELECT '" + id_pof +"' AS ID_POF,ID_UDO AS id_udo ,MED_PROYECTO AS CANTIDAD,UDO AS CONCEPTO,TEXTO_UDO AS DESCRIPCION, PRECIO AS Precio_Cobro " + 
//           "FROM Udos WHERE ID_CAPITULO=" + id_capitulo   ;   
   
   
   
 // FALLO SEGURIDAD  la consulta debe de venir encriptada salvo parametros
   var sql="INSERT INTO POF_CONCEPTOS (ID_POF, id_udo,CANTIDAD,CONCEPTO,DESCRIPCION,Precio_Cobro,user) " + 
           " SELECT '" + id_pof +"' AS ID_POF,ID_UDO AS id_udo ,MED_PROYECTO AS CANTIDAD,CONCAT(ud,' ',UDO) AS CONCEPTO "+
           ",TEXTO_UDO AS DESCRIPCION,  Precio_Cobro, '<?php echo $_SESSION["user"]; ?>' AS user " + 
           "FROM Udos_View WHERE ID_UDO=" + id_udo   ;   
   
   
   
//   alert(sql) ;


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                                        // hay un error y lo muestro en pantalla
        else
        { //document.getElementById(pcont).innerHTML = this.responseText ;   // "pinto" en la pantalla el campo devuelto por la BBDD tras el Update
//            alert(this.responseText) ;   //debug
              location.reload(true);  // refresco la pantalla tras edición
        }
      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
      
    }
    }
     xhttp.open("GET", "../include/insert_ajax.php?sql="+sql, true);
     xhttp.send();   
    
    
    return ;
 } 
 
 
    
   function pof_add_subobra(id_pof) {
    
  
   var id_subobra=document.getElementById("id_subobra").value ;
//
   
 // FALLO SEGURIDAD  la consulta debe de venir encriptada salvo parametros
   var sql="INSERT INTO POF_CONCEPTOS (ID_POF, id_udo,CANTIDAD,CONCEPTO,DESCRIPCION,Precio_Cobro,user) " + 
           " SELECT '" + id_pof +"' AS ID_POF,ID_UDO AS id_udo ,MED_PROYECTO AS CANTIDAD,CONCAT(ud,' ',UDO) AS CONCEPTO,"+
           "TEXTO_UDO AS DESCRIPCION,  Precio_Cobro , '<?php echo $_SESSION["user"]; ?>' AS user " + 
           "FROM Udos_View WHERE ID_SUBOBRA=" + id_subobra   ;   
   
   
   
//   alert(sql) ;


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                                        // hay un error y lo muestro en pantalla
        else
        { //document.getElementById(pcont).innerHTML = this.responseText ;   // "pinto" en la pantalla el campo devuelto por la BBDD tras el Update
//            alert(this.responseText) ;   //debug
              location.reload(true);  // refresco la pantalla tras edición
        }
      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
      
    }
    }
     xhttp.open("GET", "../include/insert_ajax.php?sql="+sql, true);
     xhttp.send();   
    
    
    return ;
    
 }    
 
 
    function pof_add_capitulo(id_pof) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
   var id_capitulo=document.getElementById("id_capitulo").value ;
//   var cantidad_mq=document.getElementById("cantidad_mq").value ;
//   var observaciones_mq=document.getElementById("observaciones_mq").value ;
//   var sql="INSERT INTO POF_CONCEPTOS (ID_POF,id_udo,CANTIDAD,CONCEPTO,DESCRIPCION,Precio_Cobro,user ) " + 
//           "VALUES ('"+id_parte+"','"+ id_obra_maq +"','"+ cantidad_mq +"','"+ observaciones_mq +"')"    ;   
//   var sql="INSERT INTO POF_CONCEPTOS " + 
//           " SELECT '" + id_pof +"' AS ID_POF,ID_UDO AS id_udo ,MED_PROYECTO AS CANTIDAD,UDO AS CONCEPTO,TEXTO_UDO AS DESCRIPCION, PRECIO AS Precio_Cobro " + 
//           "FROM Udos WHERE ID_CAPITULO=" + id_capitulo   ;   
   
   
 // FALLO SEGURIDAD  la consulta debe de venir encriptada salvo parametros
   var sql="INSERT INTO POF_CONCEPTOS (ID_POF, id_udo,CANTIDAD,CONCEPTO,DESCRIPCION,Precio_Cobro,user) " + 
           " SELECT '" + id_pof +"' AS ID_POF,ID_UDO AS id_udo ,MED_PROYECTO AS CANTIDAD,CONCAT(ud,' ',UDO) AS CONCEPTO"+
           ",TEXTO_UDO AS DESCRIPCION, Precio_Cobro , '<?php echo $_SESSION["user"]; ?>' AS user " + 
           "FROM Udos_View WHERE ID_CAPITULO=" + id_capitulo   ;   
   
   
   
//   alert(sql) ;


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                                        // hay un error y lo muestro en pantalla
        else
        { //document.getElementById(pcont).innerHTML = this.responseText ;   // "pinto" en la pantalla el campo devuelto por la BBDD tras el Update
//            alert(this.responseText) ;   //debug
              location.reload(true);  // refresco la pantalla tras edición
        }
      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
      
    }
    }
     xhttp.open("GET", "../include/insert_ajax.php?sql="+sql, true);
     xhttp.send();   
    
    
    return ;
 }    
 
function add_pof_proveedor(id_pof) {
    var nuevo_valor=window.prompt("Nombre del Proveedor: " );
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null || nuevo_valor === ""))
   { 
//    window.open("../pof/pof_proveedor_anadir.php?id_pof="+id_pof+"&nombre="+nuevo_valor, '_blank' )   ;  

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                                        // hay un error y lo muestro en pantalla
        else
        { //document.getElementById(pcont).innerHTML = this.responseText ;   // "pinto" en la pantalla el campo devuelto por la BBDD tras el Update
//            alert(this.responseText) ;   //debug
              location.reload(true);  // refresco la pantalla tras edición
        }
      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
      
    }
    }
     xhttp.open("GET", "../pof/pof_proveedor_anadir.php?id_pof="+id_pof+"&nombre="+nuevo_valor, true);
     xhttp.send();   



   }
   else
   {return;
   }
   
}
function add_pof_concepto(id_pof) {
    var nuevo_valor=window.prompt("Concepto: " );
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null || nuevo_valor === ""))
   { 
//    window.open("../pof/pof_proveedor_anadir.php?id_pof="+id_pof+"&nombre="+nuevo_valor, '_blank' )   ;  

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                                        // hay un error y lo muestro en pantalla
        else
        { //document.getElementById(pcont).innerHTML = this.responseText ;   // "pinto" en la pantalla el campo devuelto por la BBDD tras el Update
//            alert(this.responseText) ;   //debug
              location.reload(true);  // refresco la pantalla tras edición
        }
      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
      
    }
    }
     xhttp.open("GET", "../pof/pof_concepto_anadir.php?id_pof="+id_pof+"&nombre="+nuevo_valor, true);
     xhttp.send();   



   }
   else
   {return;
   }
   
}

 
</script>

    
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

