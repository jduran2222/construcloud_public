<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;   // AND $where_c_coste 
?>
<HTML>
<HEAD>
        <title>FRAS.CLIENTE</title>

	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
        <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"> </script>-->
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>

    <BR><BR><BR>


<?php 

//require_once("../../conexion.php"); 
//require_once("../include/funciones.php"); 
require_once("../menu/topbar.php");


$iniciar_form=(!isset($_POST["agrupar"])) ;  // determinamos si debemos de inicializar el FORM con valores vacíos

if ($iniciar_form)    
    {
        $obra = isset($_GET["obra"]) ?  $_GET["obra"] :   "" ;
        $n_fra = isset($_GET["n_fra"]) ?  $_GET["n_fra"] :   ""  ;
        $fecha1 = isset($_GET["fecha1"]) ?  $_GET["fecha1"] :   ""  ;  
        $fecha2 = isset($_GET["fecha2"]) ?  $_GET["fecha2"] :   ""  ;  
        $MES = isset($_GET["MES"]) ?  $_GET["MES"] :   ""  ;
        $Trimestre = isset($_GET["Trimestre"]) ?  $_GET["Trimestre"] :   ""  ;
        $anno = isset($_GET["anno"]) ?  $_GET["anno"] :   ""  ;
        $importe1 = isset($_GET["importe1"]) ?  $_GET["importe1"] :   ""  ;
        $importe2 = isset($_GET["importe2"]) ?  $_GET["importe2"] :   ""  ;
        $negociada = isset($_GET["negociada"]) ?  $_GET["negociada"] :   ""  ;
        $cobrada = isset($_GET["cobrada"]) ?  $_GET["cobrada"] :   ""  ;
        $agrupar = isset($_GET["agrupar"]) ?  $_GET["agrupar"] : 'ultimas_fras_reg' ;     
    }
    else
    {
        $obra=$_POST["obra"] ;
        $n_fra=$_POST["n_fra"] ;
        $fecha1=$_POST["fecha1"] ;  
        $fecha2=$_POST["fecha2"] ;  
        $MES=$_POST["MES"] ;
        $Trimestre=$_POST["Trimestre"] ;
        $anno=$_POST["anno"] ;
        $importe1=$_POST["importe1"] ;
        $importe2=$_POST["importe2"] ;
        $negociada=$_POST["negociada"] ;
        $cobrada=$_POST["cobrada"] ;
        $agrupar =$_POST["agrupar"] ;     
    }   
  

// Comprobamos si es el listado de un único proveedor o un listado global

$listado_global= (!isset($_GET["id_cliente"])) ;

if (!$listado_global)                
  { 
    $id_cliente=$_GET["id_cliente"];         // Estamos viendo las Facturas de un único proveedor
    $cliente=Dfirst("CLIENTE", "Clientes", "ID_CLIENTE=$id_cliente AND $where_c_coste" )  ;
   
    require("../cliente/clientes_menutop_r.php");          // añadimos el Menu de clientes
   if ($iniciar_form) { $agrupar = 'facturas' ;}                  // si no es Global, mejor agrupar por facturas del proveedor seleccionado
    
  }
  else
  { // si es listado_global añadimos  la variable del form 'cliente'
    require("../bancos/bancos_menutop_r.php");          // añadimos el Menu de Bancos  
    if ($iniciar_form)    
    {  $cliente="" ;}
    else
    { $cliente=$_POST["cliente"] ; }
  } 

  // inicializamos las variables o cogemos su valor del _POST

  ?>

<div style="overflow:visible">	   
 
<div id="main" class="mainc_100" style="background-color:#fff">

<a class='btn btn-link' href='../clientes/factura_cliente_anadir.php' target='_blank' ><i class='fas fa-plus-circle'></i> factura nueva</a>
    

<?php 

    

if ($listado_global)                // Estamos en pantalla de LISTADO GLOBALES (es decir, en toda la empres)
{ 
    echo "<h1>FACTURAS DE CLIENTES</h1>"  ;

echo "<div class='row' style='border-style: solid ; border-color:grey; margin-bottom: 25px; padding:10px'>" ;
echo "<div class='col-lg-4'> " ;   

echo "<form action='facturas_clientes.php' method='post' id='form1' name='form1'>"    ;
    
echo "<TABLE >"  ;
   
echo "<TR><TD>Cliente o Cif</TD><TD><INPUT type='text' id='cliente' name='cliente' value='$cliente'><button type='button' onclick=\"document.getElementById('cliente').value='' \" >*</button></TD></TR>" ;
//    echo "<TR><TD>OBRA       </TD><TD><INPUT type='text' id='N_OBRA' name='N_OBRA' value='$N_OBRA'><button type='button' onclick=\"document.getElementById('N_OBRA').value='' \" >*</button></TD></TR>" ;
}
 else
{
    echo "<a class='btn btn-primary' href= 'facturas_clientes.php' >Facturas clientes global</a><br>" ;
    
    echo "<h1>FACTURAS DE <B>$cliente</B></h1>"  ;
    echo "<div class='row' style='border-style: solid ; border-color:grey; margin-bottom: 25px; padding:10px'>" ;
    echo "<div class='col-lg-4'> " ;   
 
    echo "<form action='facturas_clientes.php?id_cliente=$id_cliente' method='post' id='form1' name='form1'>"    ;
    
    echo "<TABLE>"  ;
}    

echo "<TR><TD>Núm. Factura   </TD><TD><INPUT type='text' id='n_fra'   name='n_fra'  value='$n_fra'><button type='button' onclick=\"document.getElementById('n_fra').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Obra   </TD><TD><INPUT type='text' id='obra'   name='obra'  value='$obra'><button type='button' onclick=\"document.getElementById('obra').value='' \" >*</button></TD></TR>" ;

echo "</TABLE></div><div class='col-lg-4'><TABLE> " ;   

echo "<TR><TD>Fecha mín.     </TD><TD><INPUT type='date' id='fecha1'     name='fecha1'    value='$fecha1'><button type='button' onclick=\"document.getElementById('fecha1').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Fecha máx.     </TD><TD><INPUT type='date' id='fecha2'     name='fecha2'    value='$fecha2'><button type='button' onclick=\"document.getElementById('fecha2').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>MES     </TD><TD><INPUT type='text' id='MES'     name='MES'    value='$MES'><button type='button' onclick=\"document.getElementById('MES').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Trimestre     </TD><TD><INPUT type='text' id='Trimestre'     name='Trimestre'    value='$Trimestre'><button type='button' onclick=\"document.getElementById('Trimestre').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Año     </TD><TD><INPUT type='text' id='anno'     name='anno'    value='$anno'><button type='button' onclick=\"document.getElementById('anno').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>importe min     </TD><TD><INPUT type='text' id='importe1'     name='importe1'    value='$importe1'><button type='button' onclick=\"document.getElementById('importe1').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>importe máx     </TD><TD><INPUT type='text' id='importe2'     name='importe2'    value='$importe2'><button type='button' onclick=\"document.getElementById('importe2').value='' \" >*</button></TD></TR>" ;

echo "</TABLE></div><div class='col-lg-4'><TABLE> " ;   

// RADIO BUTTON CHK
//Datos
$radio=$negociada ;
$radio_name='negociada' ;
$radio_options=["todas","negociadas","sin negociar"];
// código
$chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
//echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
$radio_html= "<div class='btn-group btn-group-toggle' data-toggle='buttons'>"
     . "<label class='btn btn-default {$chk_todos[0]}'><input type='radio' id='{$radio_name}' name='$radio_name' value='' {$chk_todos[1]} />{$radio_options[0]}</label> "
     . "<label class='btn btn-default {$chk_on[0]}'><input type='radio' id='{$radio_name}1' name='$radio_name' value='1'  {$chk_on[1]} />{$radio_options[1]} </label>"
     . "<label class='btn btn-default {$chk_off[0]}'><input type='radio' id='{$radio_name}0' name='$radio_name' value='0' {$chk_off[1]}  />{$radio_options[2]}</label>"
     . "</div>"
     . "" ;
// FIN PADIO BUTTON CHK


echo "<TR><TD>Negociada </TD><TD>$radio_html</TD></TR>" ;


// RADIO BUTTON CHK
//Datos
$radio=$cobrada ;
$radio_name='cobrada' ;
$radio_options=["todas","cobradas","pdte cobro"];
// código
$chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
//echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
$radio_html= "<div class='btn-group btn-group-toggle' data-toggle='buttons'>"
     . "<label class='btn btn-default {$chk_todos[0]}'><input type='radio' id='{$radio_name}' name='$radio_name' value='' {$chk_todos[1]} />{$radio_options[0]}</label> "
     . "<label class='btn btn-default {$chk_on[0]}'><input type='radio' id='{$radio_name}1' name='$radio_name' value='1'  {$chk_on[1]} />{$radio_options[1]} </label>"
     . "<label class='btn btn-default {$chk_off[0]}'><input type='radio' id='{$radio_name}0' name='$radio_name' value='0' {$chk_off[1]}  />{$radio_options[2]}</label>"
     . "</div>"
     . "" ;
// FIN PADIO BUTTON CHK



//echo "<TR><TD>Cobrada    </TD><TD><INPUT type='text' id='cobrada'    name='cobrada'   value='$cobrada'><button type='button' onclick=\"document.getElementById('cobrada').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Cobrada    </TD><TD>$radio_html</TD></TR>" ;

echo "<TR><TD colspan=2 align='center' ><INPUT type='submit' class='btn btn-success btn-xl' value='Actualizar' id='submit' name='submit'></TD></TR>" ;

echo "</TABLE></div></div>"  ;


echo "<input type='hidden'  id='agrupar'  name='agrupar' value='$agrupar'>" ;


echo "<div id='myDIV'>" ; 

$btnt['ultimas_fras_reg']=['ultimas registradas','muestra las últimas facturas registradas'] ;
$btnt['facturas']=['facturas','Listado de todas las facturas según el filtro'] ;
$btnt['vacio3']=['',''] ;
$btnt['obras']=['obras','Agrupa las facturas por Obra'] ;
$btnt['clientes']=['clientes',''] ;
$btnt['clientes_fras']=['clientes-fras',''] ;
$btnt['vacio']=['',''] ;
$btnt['meses']=['meses',''] ;
//$btnt['semanas']=['semanas',''] ;
$btnt['trimestres']=['trimestres',''] ;
$btnt['annos']=['años',''] ;
$btnt['vacio2']=['',''] ;
$btnt['annos_obras']=['años-obras',''] ;

foreach ( $btnt as $clave => $valor)
{
  $active= ($clave==$agrupar) ? " cc_active" : "" ;  
  echo (substr($clave,0,5)=='vacio') ? "   " : "<button class='cc_btnt$active' title='{$valor[1]}' onclick=\"getElementById('agrupar').value = '$clave'; document.getElementById('form1').submit(); \">{$valor[0]}</button>" ;  
}  

echo "</div>"  ;

$where=$where_c_coste;

if ($listado_global)                // Estamos en pantalla de LISTADO GLOBAL (toda la empresa no solo en un proveedor concreto)
{    
// adaptamos todos los filtros, quitando espacios a ambos lados con trim() y sustituyendo espacios por '%' para el LIKE 
$where=$cliente==""? $where : $where . " AND CONCAT(CLIENTE,COALESCE(CIF,'')) LIKE '%".str_replace(" ","%",trim($cliente))."%'" ;
}
else
{
$where= $where . " AND ID_CLIENTE=$id_cliente " ;    // Estamos en gastos de una Obra o Maquinaria específica
}    

$select_trimestre="CONCAT(YEAR(FECHA_EMISION), '-', QUARTER(FECHA_EMISION),'T')"  ;

$where=$obra==""? $where : $where . " AND NOMBRE_OBRA LIKE '%".str_replace(" ","%",trim($_POST["obra"]))."%'" ;
$where=$n_fra==""? $where : $where . " AND N_FRA LIKE '%".str_replace(" ","%",trim($_POST["n_fra"]))."%'" ;
$where=$fecha1==""? $where : $where . " AND FECHA_EMISION >= '$fecha1' " ;
$where=$fecha2==""? $where : $where . " AND FECHA_EMISION <= '$fecha2' " ;
$where=$MES==""? $where : $where . " AND DATE_FORMAT(FECHA_EMISION, '%Y-%m') = '$MES' " ;
$where=$Trimestre==""? $where : $where . " AND $select_trimestre = '$Trimestre' " ;
$where=$anno==""? $where : $where . " AND YEAR(FECHA_EMISION) = '$anno' " ;
$where=$importe1==""? $where : $where . " AND IMPORTE_IVA > $importe1" ;
$where=$importe2==""? $where : $where . " AND IMPORTE_IVA < $importe2" ;
$where=$negociada==""? $where : $where . " AND Negociada=$negociada " ;
$where=$cobrada==""? $where : $where . " AND  Cobrada=$cobrada" ;

//$where=$FECHA2==""? $where : $where . " AND FECHA <= STR_TO_DATE('$FECHA2','%Y-%m-%d') " ;

//$tabla_group=0 ;             // usaremos TABLA_GROUP.PHP 


 switch ($agrupar) {
    case "ultimas_fras_reg":
     $sql="SELECT ID_FRA,ID_FRA AS nID_FRA,ID_OBRA, ID_CLIENTE,N_FRA,CLIENTE,NOMBRE_OBRA,FECHA_EMISION,CONCEPTO, Base_Imponible, iva, IMPORTE_IVA,Negociada,Banco_Neg,Cobrada,Pdte_Cobro,Observaciones  FROM Facturas_View WHERE $where  ORDER BY ID_FRA DESC LIMIT 50 " ;
     //$sql_T="SELECT '' " ;
    break;
    case "facturas":
     $sql="SELECT ID_FRA,ID_OBRA,ID_CLIENTE,N_FRA,CLIENTE,NOMBRE_OBRA,FECHA_EMISION,CONCEPTO, Base_Imponible, iva, IMPORTE_IVA,Negociada,Banco_Neg,Cobrada,Pdte_Cobro,Observaciones  FROM Facturas_View WHERE $where  ORDER BY FECHA_EMISION DESC " ;
     $sql_T="SELECT '' AS a,'' AS a8,'' AS b,'' AS c,'' AS d,SUM(Base_Imponible) AS Base_Imponible,'' AS f, SUM(IMPORTE_IVA) AS IMPORTE_IVA,'' AS a1,'' AS b1,'' AS c1,SUM(Pdte_Cobro) AS Pdte_Cobro,'' AS c3  FROM Facturas_View WHERE $where  " ;   
     //$sql_T="SELECT '','Suma' , SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where    " ;
    break;
    case "clientes":
     $sql="SELECT ID_CLIENTE,ID_OBRA,NOMBRE_OBRA, SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where GROUP BY ID_CLIENTE,ID_OBRA ORDER BY  CLIENTE,NOMBRE_OBRA  " ;      
     //$sql="SELECT ID_PROVEEDORES,PROVEEDOR,CIF,SUM(Base_Imponible) AS Base_Imponible,SUM(IMPORTE_IVA) AS IMPORTE_IVA, SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where GROUP BY ID_PROVEEDORES  ORDER BY PROVEEDOR " ;
     $sql_T="SELECT '' AS d,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where  " ;   
     $sql="SELECT ID_CLIENTE,CLIENTE, SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where  GROUP BY ID_CLIENTE ORDER BY CLIENTE  " ;      
//     $id_agrupamiento="ID_CLIENTE" ;
     break;
     case "clientes_fras":
     $sql="SELECT ID_CLIENTE,ID_OBRA,NOMBRE_OBRA, SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where GROUP BY ID_CLIENTE,ID_OBRA ORDER BY  CLIENTE,NOMBRE_OBRA  " ;      
     //$sql="SELECT ID_PROVEEDORES,PROVEEDOR,CIF,SUM(Base_Imponible) AS Base_Imponible,SUM(IMPORTE_IVA) AS IMPORTE_IVA, SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where GROUP BY ID_PROVEEDORES  ORDER BY PROVEEDOR " ;
     $sql_T="SELECT '' AS d,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where  " ;   
     $sql_S="SELECT ID_CLIENTE,CLIENTE, SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where  GROUP BY ID_CLIENTE ORDER BY CLIENTE  " ;      
     $id_agrupamiento="ID_CLIENTE" ;
     $anchos_ppal=[30,20,20,20,20] ;
    
//     $tabla_update="Udos" ;
//     $id_update="ID_UDO" ;
//     $id_clave="ID_UDO" ;
     $tabla_group=1 ;             // usaremos TABLA_GROUP.PHP 
     
     break;
   
    case "obras":
     $sql="SELECT ID_OBRA,NOMBRE_OBRA,COUNT(ID_FRA) AS Fras, SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where  GROUP BY ID_OBRA ORDER BY NOMBRE_OBRA  " ;      
     //$sql="SELECT ID_PROVEEDORES,PROVEEDOR,CIF,SUM(Base_Imponible) AS Base_Imponible,SUM(IMPORTE_IVA) AS IMPORTE_IVA, SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where GROUP BY ID_PROVEEDORES  ORDER BY PROVEEDOR " ;
     $sql_T="SELECT '' AS d,COUNT(ID_FRA) AS Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where  " ;   
     break;
//    case "semanas":
//    $sql="SELECT  DATE_FORMAT(FECHA_EMISION, '%Y-semana %u') as Semana,SUM(Base_Imponible) AS Base_Imponible,SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro "
//            . "  FROM Facturas_View WHERE $where  GROUP BY Semana  ORDER BY Semana  " ;
//    $sql_T="SELECT '' AS D,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where   " ;
//    break;
    case "meses":
    $sql="SELECT  DATE_FORMAT(FECHA_EMISION, '%Y-%m') as MES,COUNT(ID_FRA) AS Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_devengado,SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where  GROUP BY MES  ORDER BY MES  " ;
    $sql_T="SELECT '' AS D,COUNT(ID_FRA) AS Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_devengado, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where   " ;
    break;
    case "trimestres":
//    $sql="SELECT  DATE_FORMAT(FECHA_EMISION, '%Y-%q') as Trimestre,SUM(Base_Imponible) AS Base_Imponible "
    $sql="SELECT  $select_trimestre as Trimestre,COUNT(ID_FRA) AS Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_devengado "
            . " ,SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where  GROUP BY Trimestre  ORDER BY Trimestre  " ;
    $sql_T="SELECT '' AS D,COUNT(ID_FRA) AS Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_devengado, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where   " ;
    break; 
    case "annos": 
    $sql="SELECT  DATE_FORMAT(FECHA_EMISION, '%Y') as anno,COUNT(ID_FRA) AS Fras, SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_devengado,SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where  GROUP BY anno  ORDER BY anno  " ;
    $sql_T="SELECT '' AS D,COUNT(ID_FRA) AS Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_devengado, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where  " ;
    
    // google chart
    $cols_chart['anno']=["Años","string"] ;  // columnas con las que realizar el gráfico
    $cols_chart['Base_Imponible']=["Facturacion","number"] ;  // columnas con las que realizar el gráfico
    
    break;
    case "annos_obras":
     $sql="SELECT ID_OBRA,anno,NOMBRE_OBRA, SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where GROUP BY anno,ID_OBRA ORDER BY  anno,NOMBRE_OBRA  " ;      
     //$sql="SELECT ID_PROVEEDORES,PROVEEDOR,CIF,SUM(Base_Imponible) AS Base_Imponible,SUM(IMPORTE_IVA) AS IMPORTE_IVA, SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where GROUP BY ID_PROVEEDORES  ORDER BY PROVEEDOR " ;
     $sql_T="SELECT '' AS d,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where  " ;   
     $sql_S="SELECT anno, SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM Facturas_View WHERE $where  GROUP BY anno ORDER BY anno  " ;      
     $id_agrupamiento="anno" ;
     $anchos_ppal=[30,20,20,20,20] ;
    
//     $tabla_update="Udos" ;
//     $id_update="ID_UDO" ;
//     $id_clave="ID_UDO" ;
     $tabla_group=1 ;             // usaremos TABLA_GROUP.PHP 
     
     break;
   
 }

 
 
//echo $sql ;
$result=$Conn->query($sql) ;
if (isset($sql_T)) {$result_T=$Conn->query($sql_T) ; }    // consulta para los TOTALES
if (isset($sql_S)) {$result_S=$Conn->query($sql_S) ; }     // consulta para los SUBGRUPOS , agrupación de filas (Ej. CLIENTES o CAPITULOS en listado de udos)


//echo "<font size=2 color=grey>Agrupar por : $agrupar <br> {$result->num_rows} filas </font> " ;
echo "<font size=2 color=grey><br> {$result->num_rows} filas </font> " ;

// AÑADE BOTON DE 'BORRAR' PARTE . SOLO BORRARÁ SI ESTÁ VACÍO DE PERSONAL 
 $updates=[]  ;
//  $tabla_update="FRAS_CLI" ;
//  $id_update="ID_FRA" ;
//    $actions_row=[];
//    $actions_row["id"]="ID_FRA";
////    $actions_row["delete_link"]="1";



$dblclicks=[];
$dblclicks["NOMBRE_OBRA"]="obra" ;
$dblclicks["CLIENTE"]="cliente" ;
//$dblclicks["CIF"]="proveedor" ;
$dblclicks["N_FRA"]="n_fra" ;
$dblclicks["MES"]="MES" ;
$dblclicks["Trimestre"]="Trimestre" ;
$dblclicks["anno"]="anno" ;
//$dblclicks["CONCEPTO"]="CONCEPTO" ;
//$dblclicks["TIPO_GASTO"]="TIPO_GASTO" ;

//$links["NOMBRE_OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
$links["CLIENTE"] = ["../clientes/clientes_ficha.php?id_cliente=", "ID_CLIENTE"] ;
$links["N_FRA"] = ["../clientes/factura_cliente.php?id_fra=", "ID_FRA", "ver factura cliente", "formato_sub"] ;
$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

$formats["iva_devengado"] = "moneda" ;

$formats["Observaciones"] = "textarea" ;
$formats["CONCEPTO"] = "textarea" ;
$formats["Base_Imponible"] = "moneda" ;
$formats["iva"] = "porcentaje0" ;
$formats["IMPORTE_IVA"] = "moneda" ;
$formats["Pdte_Cobro"] = "moneda" ;
//$formats["ingreso_conc"] = "moneda" ;
//$formats["ingreso"] = "moneda" ;
//$formats["f_vto"] = "fecha" ;
$formats["Negociada"] = "semaforo_not" ;
$formats["Cobrada"] = "semaforo_OK" ;
//$aligns["Pagada"] = "center" ;
$tooltips["Negociada"] = "factura cliente negociada, descontada o anticipada en entidad financiera" ;
$tooltips["Cobrada"] = "factura cliente cobrada completamente" ;


$titulo="";
$msg_tabla_vacia="No hay.";
$tabla_expandible=0;

if (isset($tabla_group))
{ require("../include/tabla_group.php"); }
else
{ require("../include/tabla.php"); echo $TABLE ; }
 
 echo "</form>" ;

 
 ?>

</div>

<!--************ FIN  *************  -->
	
	

<?php  

$Conn->close();

?>
	 

</div>

	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:30px;">
	
	
	</div>
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

