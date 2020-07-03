<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
?>

<HTML>
<HEAD>
     <title>Prof</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>

<?php 


$id=$_GET["id"];

// require_once("../../conexion.php");
// require_once("../include/funciones.php");
 require_once("../menu/topbar.php");
// require_once("../menu/menu_migas.php");
 
           // DATOS   FICHA . PHP
 //echo "<pre>";
// $result=$Conn->query($sql="SELECT *  FROM POF_DETALLE WHERE id=$id AND $where_c_coste");
// $result=$Conn->query($sql="SELECT * FROM POF_DETALLE WHERE id=$id ");
 $result=$Conn->query($sql="SELECT id,ID_POF,NUM,NOMBRE_POF,PROVEEDOR,id_proveedor,email,Enviado,Respondido,Importe,Observaciones "
         . ",ID_OBRA,NOMBRE_OBRA FROM POF_prov_View WHERE id=$id AND $where_c_coste ");
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
 
 // actualización de EMAIL
 if (!($rs["email"]) AND $rs["id_proveedor"])
 {
      if ($email=Dfirst("email","Proveedores","ID_PROVEEDORES={$rs["id_proveedor"]}" ))
     {
         $result_UPDATE=$Conn->query("UPDATE `POF_DETALLE` SET `email` = '$email' WHERE id={$rs['id']}" );
         echo $result_UPDATE ;
     }
 }
  
 
 $id_pof=$rs["ID_POF"] ;
 
 $id=$rs["id"] ;
 $id_num_prov=$rs["NUM"];
 
 
 $nombre_pof=$rs["NOMBRE_POF"] ;
 $id_obra=$rs["ID_OBRA"] ;
 $nombre_obra=$rs["NOMBRE_OBRA"]  ;
 $oferta=$rs["PROVEEDOR"]  ;
 
 require_once("../obras/obras_menutop_r.php");   // metemos el menu OBRAS despues de declarar la variables $id_obra
 
  $titulo="POF: $nombre_pof<br> Oferta: <b> {$rs["PROVEEDOR"]} </b> " ;
  
//  $links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
//  $links["RAZON_SOCIAL"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
 
//  $selects["ID_PROVEEDORES"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores"] ;   // datos para clave foránea

  $updates=[ 'email',  'id_proveedor','NUM','PROVEEDOR','Enviado','Respondido', 'Importe' , 'Observaciones']  ; 

//$links["nnn_emaul"] = [ "mailto:{$rs["email"]}?Subject=Solicitud de presupuesto", "", "", "formato_sub"] ;
//$etiquetas["email"]="<i class='far fa-envelope'></i> email"  ; 

//$formats["email"]="textarea_20" ;

  
  
  $links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA",'ver Obra', 'formato_sub'] ;
//   $links["MOMBRE_POF"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA",'ver Obra', 'formato_sub'] ;
//   $links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA",'ver Obra', 'formato_sub'] ;
  $formats["Enviado"] = 'semaforo' ;
  $formats["Respondido"] = 'semaforo' ;
  
  $links["NOMBRE_POF"] = ["../pof/pof.php?id_pof=", "ID_POF",'abrir Peticion de Oferta' ,'formato_sub'] ;


  $selects["id_proveedor"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores"
      ,"../proveedores/proveedores_anadir.php?proveedor=$oferta&id_pof_proveedor=$id" 
      ,"../proveedores/proveedores_ficha.php?id_proveedor=","id_proveedor"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
  $etiquetas["NUM"]='Número proveedor' ;
  $tooltips["NUM"]='Número de oferta o proveedor de la POF' ;
  
  $etiquetas["PROVEEDOR"]='Oferta' ;
  $tooltips["PROVEEDOR"]='Nombre de la Oferta o del proveedor' ;
  
  $etiquetas["id_proveedor"]='Proveedor' ;
  $tooltips["id_proveedor"]='Permite vincular la oferta a un Proveedor existente ya registrado en la base de datos o crear un proveedor nuevo con el nombre de la Oferta' ;
  
  $tabla_update="POF_DETALLE" ;
//  $tabla_update="POF_prov_View" ;
  $id_update="id" ;
  $id_valor=$id ;
  $delete_boton=1;
  
  
  ?>
  
                  
                    
  <div style="overflow:scroll">	   
  <div id="main" class="mainc_40"> 
      <br><br><br>    
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
      
	<!-- WIDGET CREAR SUBCONTRATO  -->
<br><br><br><br>	

<div class="right2">
	
<?php 

$tipo_entidad='pof_prov' ;
$id_entidad=$id;
$id_subdir=$id_pof ;
$size='400px' ;
require_once("../include/widget_documentos.php");

 ?>
	 
</div>	

<div class="right2">

    
<?php 
$disabled = ($id_num_prov<=9)? "" : "disabled"  ;
echo "<a class='btn btn-primary' href='../proveedores/subcontrato_anadir_desde_pof.php?id_pof_proveedor=$id' target='_blank' $disabled > CREAR SUBCONTRATO </a><br>" ;   

 ?>
	 
</div>	
        
        
        
<div class="right2_50">
		
<?php            // ----- div VALES  tabla.php   -----


if ($id_num_prov<=9)
{    

    
//$sql="SELECT ,,,, FROM POF_CONCEPTOS  WHERE ID_POF=$id_pof  AND $where_c_coste ";
$sql="SELECT id,CANTIDAD,CONCEPTO,Precio_Cobro,Precio_Cobro*CANTIDAD AS Importe_Cobro,P{$id_num_prov} ,P{$id_num_prov}*CANTIDAD AS Importe FROM POF_CONCEPTOS  WHERE ID_POF=$id_pof  ";
//echo $sql;
$result=$Conn->query($sql );

$sql_T="SELECT '' as a,'Total' as b,'' as c,Precio_Cobro*CANTIDAD AS Importe_Cobro,'' as c2,SUM(P{$id_num_prov}*CANTIDAD) as Importe FROM POF_CONCEPTOS  WHERE ID_POF=$id_pof  ";
//$sql="SELECT '' as a,'' as b,'' as c, SUM(importe) as importe FROM Vales_view  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ";
//echo $sql;
$result_T=$Conn->query($sql_T );


 $updates=["P{$id_num_prov}" , 'CANTIDAD']  ;
  
  $tabla_update="POF_CONCEPTOS" ;
  $id_update="id" ;
  $id_clave="id" ;
  
$formats["FECHA"]='fecha';
$formats["Importe"]='moneda';
$formats["DESCRIPCION"]='textarea';
$formats["P{$id_num_prov}"]='text_moneda';

$etiquetas["P{$id_num_prov}"]='Precio' ;


$links["CONCEPTO"] = ["../pof/pof_concepto_ficha.php?id=", "id", 'ver ficha','ppal'] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

//$aligns["importe"] = "right" ;
//$aligns["Pdte_conciliar"] = "right" ;
//$aligns["Importe_ejecutado"] = "right" ;

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="Conceptos presupuestados" ;
$msg_tabla_vacia="No hay conceptos";

?>
	
<!--  <div class="right2"> -->
 
<?php 

require("../include/tabla.php"); echo $TABLE ;

}else
{
    echo "ATENCION: <b> OFERTA Nº $id_num_prov </b> : PRECIOS SOLO PARA LAS NUEVE PRIMERAS OFERTAS";
}    


?>
	 
</div>
	

<?php  

$Conn->close();

?>
	 

</div>

	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:12px;">FOOTER</div>
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

