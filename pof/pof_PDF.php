<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
?>
<HTML>
<HEAD>
     <title>Peticion Oferta</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>
<style>
        @media print 
{
  a[href]:after { content: none !important; }
  img[src]:after { content: none !important; }
}


.footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: black;
  color: grey;
  text-align: center;
}

</style>

<?php

$id_pof=$_GET["id_pof"];


require_once("../../conexion.php"); 
//require("../menu/topbar.php");
require_once("../menu/topbar.php");


?>

<div style="overflow:visible">	   

    
	<!--************ INICIO ficha POF *************  -->

			
<?php   // Iniciamos variables para ficha.php  background-color:#B4045


// LOGO
if (!$path_logo_empresa = Dfirst("path_logo", "Empresas_Listado", "$where_c_coste"))
  {   $path_logo_empresa = "../img/no_image.jpg";}

 echo "<br><a class='btn btn-link noprint' title='imprimir' href=#  onclick='window.print();'>"
  . "<i class='fas fa-print'></i> Imprimir</a>" ; 

//echo "<div ><img width='300' src='{$path_logo_empresa}_large.jpg' > </div>" ;   

// DATOS GENERALES

$result=$Conn->query("SELECT * FROM POF_lista WHERE ID_POF=$id_pof AND $where_c_coste " ); 
$rs1 = $result->fetch_array(MYSQLI_ASSOC) ;


$html= file_get_contents( '../plantillas/pof.html' ) ;
//$html= file_get_contents( '../plantillas/p.html' ) ;

$rs1['LOGO_EMPRESA']=$path_logo_empresa ;



 
//  $updates=['NUMERO','NOMBRE_POF','F_Cierre','Importe_aprox',  'Observaciones', 'Terminada','Adjudicatario', 'Condiciones', 'f_adjudicacion']  ;
// // $id_proveedor=$rs["ID_PROVEEDORES"] ;
//  $tabla_update="PETICION DE OFERTAS" ;
//  $id_update="ID_POF" ;
//  $id_valor=$id_pof ;
// 
//  $formats["Terminada"]="boolean" ;
//
//$titulo="PETICION DE OFERTA (POF)";
//$msg_tabla_vacia="No hay.";
 
$id_obra=$rs1["ID_OBRA"] ;



     
//require("../include/ficha.php");
?>


<div  >
<?php   // Iniciamos variables para tabla.php  

$espacios_en_blanco='&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' ;

$sql="SELECT id,CANTIDAD, CONCAT('<b>',CONCEPTO,'</b><br><small>',IFNULL(DESCRIPCION,''),'</small>') AS CONCEPTO,"
        . " '$espacios_en_blanco' as _PRECIO ,"
        . " '$espacios_en_blanco' AS _IMPORTE "
        . " FROM POF_CONCEPTOS WHERE ID_POF=$id_pof AND Ocultar=0 ORDER BY id" ;

//echo $sql ;


$result=$Conn->query( $sql );

$titulo='';
$msg_tabla_vacia="No hay";

//$updates=['CANTIDAD','CONCEPTO', 'Precio_Cobro', 'Precio_Compra','P1','P2','P3','P4','P5','P6','P7','P8','P9']  ;
 
require("../include/tabla.php"); 

//echo $TABLE ;
$rs1["HTML_TABLA1"] = $TABLE ;



foreach ($rs1 as $clave => $valor)
{
$localizador='@@'.strtoupper($clave).'@@'  ;
$html= str_replace($localizador, $valor, $html)  ;          // sustituyo cada posible localizador del HTML por su valor en la base de datos
//$html= str_replace('@@CIUDAD@@', 'Málaga', $html)  ;
//$html= str_replace('@@FECHA_LARGA@@', '26 de Febrero de 2.019', $html)  ;
} 

echo $html ;




?>



</div>

<!-- ************ FIN POF_CONCEPTOS (Unidades de Obra) *************  -->

<?php  

$Conn->close();

?>
	 

</div> 

<!--<div class="footer">
    <p>power by <a href='http://www.construcloud.es'>www.construcloud.es  &nbsp;&nbsp;&nbsp;   <img width="16" height="16" src="../img/construcloud32.svg"></a></p>
</div>-->


    

</BODY>
</HTML>

