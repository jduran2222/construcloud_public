<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		
//$id_pof=$_GET["id_pof"];
IF ($id_pof=Dfirst("ID_POF","POF_lista" ,"$where_c_coste AND  ID_POF={$_GET["id_pof"]}" ))
{
$nombre= isset($_GET["nombre"]) ? $_GET["nombre"] : '' ;

//$numero= Dfirst("MAX(NUM)","POF_DETALLE" ,"ID_POF=$id_pof" )+1 ;

//$fecha=date('Y-m-d');

//$numero= Dfirst("MAX(NUMERO)","`PETICION DE OFERTAS`" ,"ID_OBRA=$id_obra" )+1 ;

$sql="INSERT INTO `POF_CONCEPTOS` ( ID_POF , CONCEPTO ,`user` )  VALUES (  '$id_pof' , '$nombre' , '{$_SESSION["user"]}' );" ;
//$sql="INSERT INTO POF_CONCEPTOS ( ID_POF , `user` )  VALUES (  '$id_pof' , '{$_SESSION["user"]}' );" ;
// echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado la obra
             { 	//$id_pof=Dfirst( "MAX(ID_POF)", "POF_lista", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "concepto POF creada satisfactoriamente." ;
//		echo  "Ir a POF <a href=\"../pof/pof.php?id_pof=$id_pof\" title='ver pof'> $id_pof</a>" ;
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../pof/pof.php?id_pof=$id_pof'>" ;

	     }
	       else
	     {
		echo "ERROR: Error al crear concepto, inténtelo de nuevo " ;
		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       
}
 else
{
         echo "ERROR: id_pof incoherente " ;
     
}
?>