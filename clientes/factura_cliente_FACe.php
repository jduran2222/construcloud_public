<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

require_once("../../conexion.php");
require_once("../include/funciones.php");

//
/////////// registramos estas funciones a PELO por que nos da error el hacer 7 require
//function Dfirst($field, $select, $where = 1, $order_by = 0)
//{        // devuelvo valor o 0 si no encuentro nada
//    if (!isset($GLOBALS["Conn"]))
//    {                          // si no hay conexion abierta la abro yo
//        require_once("../../conexion.php");
//        $nueva_conn = true;
//    } else
//    {
//        $Conn = $GLOBALS["Conn"];
//        $nueva_conn = false;
//    }
//
//    $order_by = $order_by ? "ORDER BY $order_by" : "";  //  configuro $order_by
//    $sql2 = "SELECT $field FROM `$select` WHERE $where  $order_by";
////     echo "<br>Primera: $sql2" ;  
//  
////    $sql2 = "SELECT valor FROM c_coste_vars WHERE variable='id_proveedor_mo' AND  id_c_coste=1 ;"; 
////    $sql2 = "SELECT valor FROM c_coste_vars WHERE variable='id_proveedor_mo' AND  id_c_coste=1 ;";
////    $sql2 = "SELECT valor FROM c_coste_vars WHERE variable='id_proveedor_mo' AND  id_c_coste=1 ;";
////    $sql2 = "SELECT valor FROM c_coste_vars WHERE variable='id_proveedor_mo' AND  id_c_coste=1 ;"; 
//    
////    echo "<br>Debug Dfirst() sql: $sql2" ;                            //debug  
//    $result2 = $Conn->query($sql2); 
//    if ($result2->num_rows > 0)
//    {
//        $rs2 = $result2->fetch_array();   // cogemos el primer valor
//        $return = $rs2[0];
//    } else
//    {
////        echo "<br>VALOR NO ENCONTRADO" ;                            //debug  
//        $return = 0;           // devuelvo 0 si no encuentro nada
//    }
//
//    if ($nueva_conn)
//    {
//      //  $Conn->close();     // cierro Conn si lo he abierto aquí
//    }
//    return $return;
//}

//function decrypt ($string) {
//    $key = "Construcloud.es ERP DE CONSTRUCCION. MALAGA. ESPAÑA";
//    return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
//}





//
//
//include "../include/funciones.php";

// require("../menu/topbar.php");

////use josemmo\Facturae\Facturae;
//use josemmo\Facturae\FacturaeItem;
//use josemmo\Facturae\FacturaeParty;
//use PHPUnit\Framework\TestCase;
require_once "../include/face/Facturae.php";
require_once "../include/face/FacturaeParty.php";
require_once "../include/face/FacturaeCentre.php";
require_once "../include/face/FacturaeItem.php";



$id_fra=$_GET["id_fra"];


$result_fra=$Conn->query("SELECT * FROM Facturas_View WHERE id_fra=$id_fra AND $where_c_coste");
$rs_fra = $result_fra->fetch_array(MYSQLI_ASSOC);

$id_cliente=$rs_fra["ID_CLIENTE"] ;

$result_cli=$Conn->query("SELECT * FROM Clientes WHERE id_cliente=$id_cliente AND $where_c_coste");
$rs_cli = $result_cli->fetch_array(MYSQLI_ASSOC);

$result_emp=$Conn->query("SELECT * FROM C_COSTES WHERE  $where_c_coste");
$rs_emp = $result_emp->fetch_array(MYSQLI_ASSOC);


// Creamos la factura
$fac = new Facturae();

// Asignamos el número EMP2017120003 a la factura
// Nótese que Facturae debe recibir el lote y el
// número separados
$fac->setNumber('', $rs_fra["N_FRA"]);

// Asignamos el 01/12/2017 como fecha de la facturasetIssueDate
$fac->setIssueDate($rs_fra["FECHA_EMISION"]);

// Incluimos los datos del vendedor
$fac->setSeller(new FacturaeParty([
    "taxNumber" => $rs_emp["cif"],
    "name"      => $rs_emp["nombre_centro_coste"],
    "address"   => $rs_emp["domicilio"],
    "postCode"  => $rs_emp["cod_postal"],
    "town"      => $rs_emp["Municipio"],
    "province"  => $rs_emp["Provincia"]
]))  ;

// Incluimos los datos del comprador
// Con finos demostrativos el comprador será
// una persona física en vez de una empresa

$ayto = new FacturaeParty([
    "taxNumber" => $rs_cli["CIF"],
    "name"      => $rs_cli["NOMBRE_FISCAL"],
    "address"   => $rs_cli["Calle"],
    "postCode"  => $rs_cli["Cod_postal"],
    "town"      => $rs_cli["Municipio"],
    "province"  => $rs_cli["Provincia"],
    "centres"   => [
        new FacturaeCentre([
            "role"     => FacturaeCentre::ROLE_GESTOR,
            "code"     => $rs_cli["FACe_cod_gestor"],
            "name"     => $rs_cli["FACe_nombre_gestor"],
            "address"   => $rs_cli["Calle"],
            "postCode"  => $rs_cli["Cod_postal"],
            "town"      => $rs_cli["Municipio"],
            "province"  => $rs_cli["Provincia"]
        ]),
        new FacturaeCentre([
            "role"     => FacturaeCentre::ROLE_TRAMITADOR,
            "code"     => $rs_cli["FACe_cod_tramitador"],
            "name"     => $rs_cli["FACe_nombre_tramitador"],
            "address"   => $rs_cli["Calle"],
            "postCode"  => $rs_cli["Cod_postal"],
            "town"      => $rs_cli["Municipio"],
            "province"  => $rs_cli["Provincia"]
        ]),
        new FacturaeCentre([
            "role"     => FacturaeCentre::ROLE_CONTABLE,
           "code"     => $rs_cli["FACe_cod_contable"],
            "name"     => $rs_cli["FACe_nombre_gestor"],
            "address"   => $rs_cli["Calle"],
            "postCode"  => $rs_cli["Cod_postal"],
            "town"      => $rs_cli["Municipio"],
            "province"  => $rs_cli["Provincia"]
        ])
    ]
]);

$fac->setBuyer($ayto) ;

//$fac->setBuyer(new FacturaeParty([
//    "isLegalEntity" => false,       // Importante!
//    "taxNumber"     => "00000000A",
//    "name"          => "Antonio",
//    "firstSurname"  => "García",
//    "lastSurname"   => "Pérez",
//    "address"       => "Avda. Mayor, 7",
//    "postCode"      => "654321",
//    "town"          => "Madrid",
//    "province"      => "Madrid"
//]));

// Añadimos los productos a incluir en la factura
// En este caso, probaremos con tres lámpara por
// precio unitario de 20,14€ con 21% de IVA ya incluído

$result_det=$Conn->query("SELECT * FROM Fra_Cli_Detalles WHERE id_fra=$id_fra ");
$iva=(int)($rs_fra["iva"]*100);
if ($result_det->num_rows > 0)     // añado los detalles de la fra_cli
  {  
   while($rs_det = $result_det->fetch_array(MYSQLI_ASSOC)) 
   {
    $fac->addItem($rs_det["Detalle"]." (Exp.:".$rs_fra["EXPEDIENTE"].")  Obra: ".$rs_fra["NOMBRE_COMPLETO"] , $rs_det["Precio"]*(1+$iva/100), $rs_det["Cantidad"], Facturae::TAX_IVA, $iva,$rs_fra["EXPEDIENTE"]);
   }
  }
  
// Ya solo queda firmar la factura ...
//$fac->sign(
//    "clave_publica.pem",
//    "clave_privada.pem",
//    "put_here_your_password"
//);

//require_once("../include/funciones.php");

if ($id_doc_clave_privada=Dfirst("id_doc_clave_privada","C_COSTES", $where_c_coste))
{
   $id_doc_clave_publica=Dfirst("id_doc_clave_publica","C_COSTES", $where_c_coste) ;
//   $clave_certificado=decrypt(Dfirst("clave_certificado","C_COSTES", $where_c_coste)) ;         // NO HACE FALTA NINGUNA CLAVE del certificado
   
   $file_clave_privada=Dfirst("path_archivo","Documentos", " id_documento='$id_doc_clave_privada' AND  $where_c_coste ") ;
   $file_clave_publica=Dfirst("path_archivo","Documentos", " id_documento='$id_doc_clave_publica' AND  $where_c_coste ") ;
   
//   echo $clave_certificado ;

   $fac->sign(
    $file_clave_publica,
    $file_clave_privada,
    ""
    );
   
//    Ya solo queda firmar la factura ...
//$fac->sign(
//    "clave_publica.pem",
//    "clave_privada.pem",
//    "UTE_LLANETE1"
//);


   // este formato falla
   //$fac->sign(
//    "ingenop2017.pfx",
//    NULL,
//    "xxxxxxxxx"
//);


// ... y exportarlo a un archivo
$file_xsig="{$rs_fra["N_FRA"]}.xsig" ;            // nombre de la facturae

$fac->export($file_xsig);


header ("Content-Disposition: attachment; filename=$file_xsig");
////////////////header ("Content-Type: application/force-download");         
//////////////header ("Content-Type: application/xml");         
header ("Content-Type: application/octet-stream");
header("Content-Transfer-Encoding: binary"); 
///////////////header ("Content-Length: ".filesize($file_xsig));
readfile($file_xsig);

    
}else
{
  echo  "ERROR. NO EXISTEN LOS FICHEROS .PEM DE CLAVE PRIVADA Y CLAVE PUBLICA" ;
}




?>