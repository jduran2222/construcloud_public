<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		
$id_obra=$_GET["id_obra"];
$nombre_pof= isset($_GET["nombre_pof"]) ?  $_GET["nombre_pof"] : 'pof_nueva' ;

if ($nombre_pof<>'null')
{    
$fecha=date('Y-m-d');

$numero= Dfirst("MAX(NUMERO)","POF_lista" ,"ID_OBRA=$id_obra" )+1 ;

$sql="INSERT INTO `PETICION DE OFERTAS` ( ID_OBRA,NUMERO,NOMBRE_POF,`user` )    VALUES (  '$id_obra','$numero', '$nombre_pof' , '{$_SESSION["user"]}' );" ;
// echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado la obra
             { 	$id_pof=Dfirst( "MAX(ID_POF)", "POF_lista", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "POF creada satisfactoriamente." ;
//		echo  "Ir a POF <a href=\"../pof/pof.php?id_pof=$id_pof\" title='ver pof'> $id_pof</a>" ;
//                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../pof/pof.php?id_pof=$id_pof'>" ;
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../pof/pof.php?id_pof=$id_pof'>" ;

	     }
	       else
	     {
		echo "ERROR al crear pof inténtelo de nuevo " ;
		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       
}
?>