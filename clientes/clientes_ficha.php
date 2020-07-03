<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;


$titulo_pagina="Cliente " . Dfirst("CLIENTE","Clientes", "ID_CLIENTE={$_GET["id_cliente"]} AND $where_c_coste"  ) ;
?>

<HTML>
<HEAD>
     <title><?php echo $titulo_pagina ?></title> 
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>


<style type='text/css'>
 
/*tr:nth-child(odd) {
    background-color:#f2f2f2;
}
tr:nth-child(even) {
    background-color:#ffffff;
}
 
tr:hover {background-color: #ddd;}



.mainc {
  float:left;
  width:50%;
  padding:0 20px;
}
.right2 {
  background-color:lightblue;
  float:left;
  width:30%;
  padding:10px 15px;
  margin-top:7px;
}

@media only screen and (max-width:800px) {
   For tablets: 
  .mainc, .right2 {
    width:100%;
  }

}
@media only screen and (max-width:500px) {
   For mobile phones: 
   .mainc, .right2 {
    width:100%;
  }*/

 
</style>
	



<?php 

$id_cliente=$_GET["id_cliente"];

// require_once("../../conexion.php");
// require_once("../include/funciones.php");

 require_once("../menu/topbar.php");
 require_once("../clientes/clientes_menutop_r.php");
$result=$Conn->query($sql="SELECT * FROM Clientes WHERE id_cliente=$id_cliente AND $where_c_coste");
$rs = $result->fetch_array(MYSQLI_ASSOC);

if ($id_cliente!=$rs["ID_CLIENTE"]) die("ERROR EN DATOS. EL CLIENTE NO ES DE ESTA EMPRESA") ;

$sql_format_CIF=encrypt2("UPDATE `Clientes` SET `CIF` = REPLACE(REPLACE(REPLACE(CIF,' ',''),'-',''),'\n','')  "
        . " WHERE $where_c_coste AND ID_CLIENTE=$id_cliente ; ") ;
$spans_html['CIF'] = "<a  href='#'  onclick=\"js_href('../include/sql.php?code=1&sql=$sql_format_CIF')\"  "
        . "title='Da formato, quita espacios y simbolos' >formatear</a>" ;




 $titulo="CLIENTE {$rs["CLIENTE"]} " ;
  $updates=['*']  ;
  $id_cliente=$rs["ID_CLIENTE"] ;
  $tabla_update="Clientes" ;
  $id_update="ID_CLIENTE" ;
  $id_valor=$id_cliente ;

  $delete_boton=1 ;
  
  

?>


	
<div style="overflow:visible">	   
   

  <div id="main" class="mainc"> 
	  
 
 <?php require("../include/ficha.php"); ?>
   
  <!--// FIN     **********    FICHA.PHP-->

 
   
 </div>
<div class="right2">
    
<?php   // Iniciamos tabla_div  de ************ DOCUMENTOS *************
echo "<br><br>" ;
$tipo_entidad='cliente' ;
$id_entidad=$id_cliente;
$id_subdir=$id_cliente ;
$size='100px' ;

require("../include/widget_documentos.php");

?>

</div>

<div class="right2">
	
  <?php 
// PROCEDIMIENTOS
$tipo_entidad='cliente' ;
require("../agenda/widget_procedimientos.php");
 
 ?>
	 
  </div>
    

<?php   // Iniciamos tabla_div  de ************ obras *************

$result=$Conn->query($sql="SELECT ID_OBRA,NOMBRE_OBRA,IMPORTE from OBRAS WHERE id_cliente=$id_cliente AND $where_c_coste ORDER BY fecha_creacion DESC LIMIT 20" );

//$formats["IMPORTE"] = "moneda" ; 
$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA", "", "formato_sub"] ;


//$titulo="OBRAS";
$titulo= "Obras ({$result->num_rows})" ;
$msg_tabla_vacia="No hay obras";

?>
	
<!--  <div class="right2"> -->
 <div class="right2">
	
<?php require("../include/tabla.php"); echo $TABLE ; ?>
	
<!--  </div> -->
 </div>
<?php   // Iniciamos tabla_div  de ************ PRESUPUESTOS *************

$result=$Conn->query($sql="SELECT ID_OFERTA,NOMBRE_OFERTA,FECHA,Importe_iva,Aceptado,Rechazado from Ofertas_View WHERE ID_CLIENTE=$id_cliente AND $where_c_coste ORDER BY FECHA DESC LIMIT 20" );

//$formats["IMPORTE"] = "moneda" ; 
$links["NOMBRE_OFERTA"]=["../estudios/oferta_cliente.php?id_oferta=", "ID_OFERTA", "", "formato_sub"] ;


//$titulo="OBRAS";
$titulo= "Presupuestos ({$result->num_rows})" ;
$msg_tabla_vacia="No hay presupuestos";

?>
	
<!--  <div class="right2"> -->
 <div class="right2">
	
<?php require("../include/tabla.php"); echo $TABLE ; ?>
	
<!--  </div> -->
 </div>
	
	

<?php  

$Conn->close();

?>
	 

</div>

<!--	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:12px;">FOOTER</div>-->
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

