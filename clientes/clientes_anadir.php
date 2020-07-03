<?php
require_once("../include/session.php");
?>
<?php


$cliente=strtoupper(ltrim(rtrim($_POST["cliente"]))) ;
//$id_cliente=$_POST["id_cliente"]  ;
//$email=$_POST["email"]  ;


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		

$sql="INSERT INTO `Clientes` ( `id_c_coste`,cliente, `user` )    VALUES ( {$_SESSION["id_c_coste"]} , '$cliente', '{$_SESSION["user"]}' );" ;
 //echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado el cliente
         { 	$id_cliente=Dfirst( "MAX(id_cliente)", "Clientes", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	             // TODO OK-> Entramos a clientes_ficha.php
	       echo "Cliente creado satisfactoriamente." ;
		   echo  "Ir a cliente <a href=\"clientes_ficha.php?id_cliente=$id_cliente\" title='ver cliente'> cliente</a>" ;
	     }
		  else
		  {
			echo "Error al crear cliente, inténtelo de nuevo " ;
			echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       

?>