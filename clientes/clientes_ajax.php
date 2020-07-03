<?php 
require_once("../include/session.php");

$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;


 //echo "El filtro es:{$_GET["filtro"]}";

$filtro=$_GET["filtro"]  ;

if (strlen($filtro)>=3)
{
 require_once("../../conexion.php");

 $sql="Select id_cliente,cliente FROM Clientes WHERE cliente LIKE '%$filtro%' AND $where_c_coste ORDER BY cliente LIMIT 5" ;
 $result = $Conn->query($sql);
	
 if ($result->num_rows > 0) 
  { echo "<ul >" ;
    while($rs = $result->fetch_array())
  {
	 $id_cliente=$rs["id_cliente"];
	 $filtro=strtoupper($_GET["filtro"] ) ;
	 $cliente=str_replace($filtro ,"<b>$filtro</b>", $rs["cliente"]);  // Negrita el filtro en MAYUSCULA
	 $filtro=strtolower($filtro ) ;
	 $cliente=str_replace($filtro ,"<b>$filtro</b>", $cliente);	     // idem minuscula
	 echo "<li><a href=# onClick=\"selectCountry('{$id_cliente}')\">$cliente</a></li>";
	 
  }
   echo "</ul>" ;
   
 }	  
 $Conn->close();
}

?>