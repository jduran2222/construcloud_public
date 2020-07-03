<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		
$id_pof=$_GET["id_pof"];
$nombre= isset($_GET["nombre"]) ? $_GET["nombre"] : '' ;
$fecha=date('Y-m-d');

$numero= Dfirst("MAX(NUM)","POF_DETALLE" ,"ID_POF=$id_pof" )+1 ;

$sql="INSERT INTO POF_DETALLE ( ID_POF,NUM,PROVEEDOR,`user` )    VALUES (  '$id_pof','$numero', '$nombre' , '{$_SESSION["user"]}' );" ;
// echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado la obra
             {  // 	$id_pof=Dfirst( "MAX(ID_POF)", "POF_lista", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "POF creada satisfactoriamente." ;
//		echo  "Ir a POF <a href=\"../pof/pof.php?id_pof=$id_pof\" title='ver pof'> $id_pof</a>" ;
//                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../pof/pof.php?id_pof=$id_pof'>" ;

	     }
	       else
	     {
		echo "ERROR: Error al  crear proveedor inténtelo de nuevo " ;
//		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       

?>