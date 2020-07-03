<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 require_once("../../conexion.php");
 require_once("../include/funciones.php");

$titulo_pagina="Fra_Cliente " . Dfirst("NOMBRE_OBRA","Fras_Cli_Listado", "ID_FRA={$_GET["id_fra"]} AND $where_c_coste"  ) ;

//$titulo_pagina_ARRAY= Dfirst("NOMBRE_OBRA,N_FRA","Fras_Cli_Listado", "ID_FRA={$_GET["id_fra"]} AND $where_c_coste"  ) ;
//$titulo_pagina=$titulo_pagina_ARRAY["NOMBRE_OBRA"] ;


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



<?php 


$id_fra=$_GET["id_fra"];

 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 require_once("../include/funciones_js.php");
 require_once("../menu/topbar.php");
 //require("../proveedores/proveedores_menutop_r.php");
$sql="SELECT ID_FRA,N_FRA,FECHA_EMISION,ID_OBRA,ID_CLIENTE,CONCEPTO,Base_Imponible,iva,IMPORTE_IVA,Observaciones"
        . ",'SEGUIMIENTO' as EXPAND_SEGUIMIENTO,provisionada,pdte_provision,Cobrada,Cobrado,Pdte_Cobro,Negociada,Banco_Neg,'' as FIN_EXPAND2 "
        . ",'DATOS FACe' as EXPAND_DATOS_FACe,FACe_cod_contable,FACe_nombre_contable,FACe_cod_gestor,"
        . "FACe_nombre_gestor,FACe_cod_tramitador,FACe_nombre_tramitador,Calle,Cod_postal,Municipio,Provincia, '' as FIN_EXPAND "
        . "FROM Facturas_View WHERE id_fra=$id_fra AND $where_c_coste";

$result=$Conn->query($sql);
$rs = $result->fetch_array(MYSQLI_ASSOC);

$iva_factor=(1+$rs["iva"]) ;   // lo usaré para el total del detalle de la factura
$pdte_provision=$rs["pdte_provision"] ;

$titulo="FACTURA DE CLIENTE {$rs["N_FRA"]} " ;
$updates=['ID_CLIENTE' ,'ID_OBRA' , 'N_FRA','FECHA_EMISION','CONCEPTO','iva','Forma_de _Envio','Negociada','Banco_Neg','Observaciones']  ;

$selects["ID_CLIENTE"]=["ID_CLIENTE","CLIENTE","Clientes","../clientes/clientes_anadir_form.php","../clientes/clientes_ficha.php?id_cliente=","ID_CLIENTE"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
$selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS","../obras/obras_anadir_form.php","../obras/obras_ficha.php?id_obra=","ID_OBRA"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

$links["CLIENTE"] = ["../clientes/clientes_ficha.php?id_cliente=", "ID_CLIENTE"] ;
$links["OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

$formats["provisionada"]="semaforo_txt_PROVISIONADO COBRO";
$formats["pdte_provision"]="moneda";
$formats["Cobrado"]="moneda";
$formats["Pdte_Cobro"]="moneda";
$formats["Cobrada"]="semaforo_txt_COBRADA";
$formats["Negociada"]="semaforo_not"; 


$id_fra=$rs["ID_FRA"] ;
$tabla_update="FRAS_CLI" ;
$id_update="ID_FRA" ;
$id_valor=$id_fra ;

$delete_boton=1;

  
 // poner siguiente numero de factura oficial
$n_fra_nuevo=siguiente_n_fra($id_fra) ;
$sql_siguiente_N_FRA=encrypt2("UPDATE `FRAS_CLI` SET `N_FRA` = '$n_fra_nuevo' WHERE  ID_FRA=$id_fra ; ") ;
$spans_html['N_FRA'] = "<a class='btn btn-xs btn-link noprint transparente'  href='#'  onclick=\"js_href('../include/sql.php?code=1&sql=$sql_siguiente_N_FRA')\" "
        . " title='Calcula el siguiente numero de Factura' >nuevo numero</a>" ;

 
  ?>
	
<div style="overflow:visible">	   
  <div id="main" class="mainc"> 
  <!--<img src="../img/construcloud64.svg" >-->	  
   

	 <?php require("../include/ficha.php"); ?>
   
  <!--// FIN     **********    FICHA.PHP-->
  
 </div>

    <div class="right2">
        <a class="btn btn-primary" target="_blank" href="../clientes/factura_cliente_PDF.php?id_fra=<?php echo $id_fra ?>&ext=&tipo=" title="ver factura de papel en pantalla">ver factura</a>
	<a class="btn btn-primary" target="_blank" href="../clientes/factura_cliente_PDF.php?id_fra=<?php echo $id_fra ?>&ext=&tipo=prt" title="imprimir factura "><i class="fas fa-print"></i> Imprimir</a>
<!--	<a class="btn btn-primary" target="_blank" href="../clientes/factura_cliente_PDF.php?id_fra=<?php echo $id_fra ?>&ext=.pdf&tipo=pdf" title="ver descargar factura en PDF">pdf(error)</a>-->
        <a class="btn btn-primary" target="_blank" href="../clientes/factura_cliente_PDF.php?id_fra=<?php echo $id_fra ?>&ext=.doc&tipo=word" title="ver descargar factura en Word">doc</a>
        <a class="btn btn-primary" target="_blank" href="../clientes/factura_cliente_PDF.php?id_fra=<?php echo $id_fra ?>&ext=.xls&tipo=excel" title="ver descargar factura en Excel">xls</a>
        <a class="btn btn-primary" target="_blank" href="../clientes/factura_cliente_FACe.php?id_fra=<?php echo $id_fra ?>" title="ver descargar factura electrónica firmada .xsig">Factura-e</a>
        <!--<p>Ultima factura oficial: <b><?php echo $num_fra_ultima ?></b> </p>-->
</div>
    
<div class="right2">
	
<?php 

//  WIDGET DOCUMENTOS 
$tipo_entidad='fra_cli' ;
$id_entidad=$id_fra ;
//$id_subdir=$id_cliente ;
$id_subdir=0 ;
$size='200px' ;
$size_sec='100px' ;
require("../include/widget_documentos.php");

 ?>
	 
</div>		
	
<?php            // ----- div COBROS  tabla.php   -----

//$sql="SELECT * FROM Fras_Cli_PagosV3  WHERE id_fra=$id_fra  AND $where_c_coste ORDER BY f_vto   ";
$sql="SELECT * FROM Fras_Cli_PagosV3  WHERE id_fra=$id_fra AND $where_c_coste  ORDER BY f_vto   ";
//echo $sql;
$result=$Conn->query($sql );

$sql_T="SELECT '', sum(ingreso) as ingreso , sum(cobrado) as cobrado, '' as a, '' as aa FROM Fras_Cli_PagosV3  WHERE ID_FRA=$id_fra  AND $where_c_coste ";
//echo $sql;
$result_T=$Conn->query($sql_T );

$updates=["ingreso"] ;

$formats["f_vto"]="fecha";
$formats["ingreso"]="moneda";
$formats["cobrado"]="fijo";

$tooltips["ingreso"] = "Ingreso o cobro previsto" ;
$tooltips["cobrado"] = "Importe realmente cobrado en banco" ;

$links["f_vto"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago", "", "formato_sub"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

//$aligns["importe"] = "right" ;
//$aligns["Pdte_conciliar"] = "right" ;
//$aligns["Importe_ejecutado"] = "right" ;

//  $id_pago=$rs["id_pago"] ;
  $tabla_update="PAGOS" ;
  $id_update="id_pago" ;
//  $id_valor=$id_pago ;
  $actions_row["id"]="id_pago";

  $actions_row["delete_link"]="1";

// GESTION DE COBROS

   // creamos el <SELECT> para conciliar con MOV_BANCO si existe 
//    $gestionar_collapse = (!$pagada) ?  'collapse in' : 'collapse' ;   // si NO PAGADA -> EXPANDIDA
    $gestionar_collapse =  'collapse in'  ;   // si NO PAGADA -> EXPANDIDA
    $pdte_provision_txt=cc_format($pdte_provision,'moneda') ;
    
    // inicio el div con EXPAND
    $link_conciliar="<div class='div_boton_expand'><button data-toggle='collapse' class='btn btn-link  noprint' data-target='#div_gestionar'>"
            . "Gestionar cobros </button></div>"
            . "<div id='div_gestionar' class='$gestionar_collapse'>" ;
    
    //    añadir a REMESA 
    
    $link_conciliar.="<div class='noprint' style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>"
        . "Añadir a remesa de cobros"
         ."<select class='noprint'  id='id_remesa' style='width: 20%;'>"
            ."<OPTION value='0' selected>*crear remesa nueva*</OPTION>"
        . DOptions_sql("SELECT id_remesa,CONCAT(remesa,' (' ,FORMAT(IFNULL(importe,0),2),'€ en ' ,IFNULL(num_pagos,0),' pagos)') "
                                          . " FROM Remesas_View WHERE activa=1 AND tipo_remesa='C' AND firmada=0 AND $where_c_coste ORDER BY remesa ")
        ."</select>"
        ."<a class='btn btn-link noprint' href='#' onclick=\"window.open('../bancos/remesa_anadir_selection.php?tipo_remesa=C&array_str=$id_fra&id_remesa='+document.getElementById('id_remesa').value )\" "
                                . " title='Añade/Genera remesa con la factura' ><i class='fas fa-plus-circle'></i>R<i class='fas fa-link'></i> Añadir a remesa</a>"
        ."<a class='btn btn-link btn-xs noprint' style='opacity:0.3;' href='#' onclick=\"window.open('../bancos/remesa_ficha.php?id_remesa='+document.getElementById('id_remesa').value ) \" "
                                   . " title='abre la remesa seleccionada' >Ver remesa</a>"
        ."</div>" ;

//  CONCILIAR MOV. EXISTENTE
    $link_conciliar.="<div  class='noprint'  style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>" ;
    $link_conciliar.="Conciliar con mov.banco existente:" ;
    $link_conciliar.="<select  class='noprint'  id='id_mov_banco' style='width: 40%; '>" ;
    $link_conciliar.=DOptions_sql("SELECT id_mov_banco,CONCAT(DATE_FORMAT(fecha_banco, '%d-%m-%Y'),'- ', Banco, '-', Concepto,' ',cargo,'€') FROM MOV_BANCOS_View "
                        . "WHERE $where_c_coste  AND NOT conc AND ingreso=$pdte_provision ORDER BY fecha_banco DESC ") ;
    $link_conciliar.="  </select>" ;
    $link_conciliar.=" <a class='btn btn-link noprint' href='#'  onclick=\"js_href('../clientes/fra_cliente_generar_cobro_ajax.php?id_fra=$id_fra&id_mov_banco='+document.getElementById('id_mov_banco').value); \" "
                       . " title='Ej. Cuando ya se ha pagado previamente. Ej. pagos con tarjeta'  >"
                       . "<i class='fas fa-plus-circle'></i>M<i class='fas fa-link'></i> Crea Pago y lo concilia con el mov.banco</a>"
                       ." <a class='btn btn-link btn-xs noprint' style='opacity:0.3;'  href='#' onclick=\"window.open('../bancos/pago_ficha.php?id_mov_banco='+document.getElementById('id_mov_banco').value ) \"    "
                       ." title='Ver Movimiento bancario' >Ver mov banco</a>" ;

    $link_conciliar.="</div>" ;


    
    // pago con cuenta a seleccionar
    $link_conciliar.="<div   class='noprint' style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>" ;
    $link_conciliar.="Pagar y anotar en cuenta: <select  class='noprint'  id='id_cta_banco' style='width: 40%; '>" ;
    $link_conciliar.=DOptions_sql("SELECT id_cta_banco, Banco FROM ctas_bancos WHERE Activo AND $where_c_coste ORDER BY Banco") ; //por defecto CAJA METALICO
    $link_conciliar.="  </select>" ;    
    $link_conciliar.=" <a class='btn btn-link noprint' href='#'  onclick=\"js_href('../clientes/fra_cliente_generar_cobro_ajax.php?id_fra=$id_fra&id_cta_banco='+document.getElementById('id_cta_banco').value); \"       "
                    . " title='Crea Pago nuevo, crea un mov. bancario en la cta.banco seleccionada y los concilia \n Ej. Cuando se paga con Caja Metálico, pagos hechos a cargo de Notas de Gastos de empleados, cuando hay compensaciones de facturas o abonos...' >"
                    . "<i class='fas fa-plus-circle'></i><i class='fas fa-plus-circle'></i>M<i class='fas fa-link'></i> Crear Pago, crea mov.banco y concilia ($pdte_provision_txt)</a>" 
                    .""
                     . " <a class='btn btn-link btn-xs noprint' style='opacity:0.3;'  href='#' onclick=\"window.open('../bancos/bancos_mov_bancarios.php?id_cta_banco='+document.getElementById('id_cta_banco').value ) \"    "
                    ." title='Ver cuenta bancaria' >ver cta bancaria</a>" ;

    $link_conciliar.="</div>" ;
    
    // crea pago nuevo 
    $link_conciliar.="<div  class='noprint' style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>" ;
    $link_conciliar.=" <a class='btn btn-link noprint' href='#'  onclick=\"js_href('../clientes/fra_cliente_generar_cobro_ajax.php?id_fra=$id_fra'); \" "
            . " title='Crea un Cobro nuevo en la cta banco por defecto. Se usa cuando vamos a esperar el Cobro del Cliente. \n Ej. por transferencia '><i class='fas fa-plus-circle'></i> Crear Cobro nuevo ($pdte_provision_txt)</a>" ;    
    $link_conciliar.="</div>" ;

    //
    $sql=encrypt2("INSERT INTO FRAS_CLI_PAGOS ( id_fra,id_pago ) VALUES ( '$id_fra'  ,'_VARIABLE1_'  );") ;
//    $actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs noprint' target='_blank' title='Desconcilia el Pago de la factura' "
//                                   . " href=\"../include/sql.php?code=1&sql=$sql&variable1=_VARIABLE1_ \" >desconciliar</a> ";
    $href="../include/sql.php?code=1&sql=$sql&variable1=_VARIABLE1_ " ;
    $link_conciliar.="<div  class='noprint' style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>" ;
    $link_conciliar.=" <a class='btn btn-link noprint' href='#'  onclick=\"js_href('$href',1,'','PROMPT_Indica el ID_PAGO del cobro a conciliar'); \" "
            . " title='concilia la factura con un ID_PAGO existente del mismo Cliente.\n Ej. Un Cobro para varias facturas'>"
            . "<i class='fas fa-link'></i> Conciliar ID_PAGO ya existente a esta fra_cliente</a>" ;    
    $link_conciliar.="</div>" ;
    $link_conciliar.="</div>" ;   // fin expand

 
    $add_link_html=$link_conciliar;
 

// FIN GESTION COBROS  
  
  


//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="Cobros ($result->num_rows)" ;
$msg_tabla_vacia="No hay ";

?>
	
<!--  <div class="right2"> -->
 <div class="right2">

<a class="btn btn-link" href=# target="_blank" title="crea una provisión de cobro de la factura cliente" 
   onclick="js_href('../clientes/fra_cliente_generar_cobro_ajax.php?id_fra=<?php echo $id_fra ?>')">+ añadir provisión cobro (<?php echo cc_format($pdte_provision,'moneda') ?>)</a>
	
<?php require("../include/tabla.php"); echo $TABLE ; ?>
     
	 
</div>
	
<!--              FIN cobros   -->
 
	
<?php            //  div FRA_CLI DETALLES  tabla.php  **********************************************



//$sql="SELECT * , Cantidad*Precio as importe  FROM Fra_Cli_Detalles  WHERE id_fra=$id_fra  AND $where_c_coste ORDER BY id   ";
$sql="SELECT * FROM Fra_Cli_DetallesV WHERE ID_FRA=$id_fra  AND $where_c_coste ORDER BY n_linea,id ";

//echo $sql;
$result=$Conn->query($sql );

$sql_T="SELECT '' as a19,'' as a1,'Suma' as a2,'' as a3, SUM(cantidad*precio) as importe FROM Fra_Cli_DetallesV  WHERE ID_FRA=$id_fra  AND $where_c_coste ";
$sql_T2="SELECT '' as a19,'' as a1,'Total Iva incluido' as a2,'' as a3, SUM(cantidad*precio*$iva_factor) as importe_iva FROM Fra_Cli_DetallesV  WHERE ID_FRA=$id_fra  AND $where_c_coste ";
//echo $sql;
$result_T=$Conn->query($sql_T );
$result_T2=$Conn->query($sql_T2 );


// n_linea es el número de orden en que se pondrá en pantalla y luego se utilizará a la hora de imprimirla. Editando su valor , ordena los detalles de factura
$updates=['n_linea',  'Cantidad','Detalle','Precio']  ;
$tabla_update="Fra_Cli_Detalles" ;
$id_update="id" ;
$id_clave="id" ;
//$add_link="../include/add_row.php?tabla=Fra_Cli_Detalles&campo1=id_fra&valor1=$id_fra" ;
$add_link['field_parent']='ID_FRA'  ;
$add_link['id_parent']=$id_fra  ;       


$links=[];
//$links["Detalle"] = ["factura_cliente_detalle.php?id=", "id"] ;
//$links["abonado"]=["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco"] ;

$format=[];
//$formats["Cantidad"]="text_edit";
$formats["Detalle"]="text_edit";
$formats["importe"]="moneda";
$formats["importe_iva"]="moneda";
$formats["Precio"]="text_moneda";


//$format_style=[] ;                          // inicializo el array para no heredar formatos de tablas anteriores
//$aligns["importe"] = "right" ;
//$aligns["Precio"] = "right" ;
//$aligns["Cantidad"] = "right" ;
////$aligns["Importe_ejecutado"] = "right" ;

$actions_row=[];
$actions_row["id"]="id";
$actions_row["update_link"]="../include/update_row.php?tabla=Fra_Cli_Detalles&where=id=";
$actions_row["delete_link"]="../include/delete_row.php?tabla=Fra_Cli_Detalles&where=id=";

$tooltip=[] ; 
//$tooltips["abonado"] = "Pago abonado. Clickar para ver el movimiento bancario" ;
//$tooltips["P_multiple"] = "Pago múltiple. Pago para varias facturas" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="Detalles facturados" ;
$msg_tabla_vacia="No hay Pagos emitidos en esta factura";

?>
	

<div  style="background-color:#ccffcc;float:left;width:60%;padding:0 20px;" >
    <!--<div class="mainc">-->
	
<?php require("../include/tabla.php"); echo $TABLE ; ?>

<br><br><br><br>
</div>	 
<!--              FIN FRA_CLI_DETALLES   -->	
	
<?php  

$Conn->close();

?>
    

</div>
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

<script>       

 function fra_cli_conciliar_a_pago(sql) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
    var id_pago=window.prompt("Introduzca el ID_PAGO o nid_pago a conciliar: " );
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
//   var id_obra=document.getElementById("id_obra").value ;
//   var d= new Date() ;
//   var date_str=d.toISOString();
   if (id_pago)
   {
       window.open('../bancos/conciliar_fra_prov_pago.php?id_fra_prov='+id_fra_prov+'&id_pago='+id_pago);
       location.reload();     
   }
//   window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra, '_blank');
 //echo "<a class='btn btn-primary' href= '../obras/obras_anadir_parte.php?id_obra=$id_obra' >Añadir parte</a><br>" ;
        

    
    return ;
 }
 
 
 </script>