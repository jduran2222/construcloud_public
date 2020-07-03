<?php
require_once("../include/session.php");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
<title>ConstruCloud</title></head>


<body >
 
<center>
<div >
	<p align=center style='text-align:center'>
		<img width="200" src="../img/construcloud64.svg">
	</p>
   
</div>
	
<?php 
require_once("../include/funciones.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


?>
      	

<form action="clientes_anadir.php" method="post" name="form1"  >

  <table width="40%"  border="0" align="center" cellpadding="1" cellspacing="2">
	<tr><td colspan="2" align="center" ><span class="encabezadopagina2">Cliente nuevo</span></td></tr>	
	    
	
	  
    <tr>
      <td><div align="center"><span class="encabezadopagina2">Cliente</span></div></td>
      <td><span class="encabezadopagina2">
        <input name="cliente" required type="text"  style="background-color: #C8C8C8" tabindex=""  >
		  
      </span></td>
    </tr>
    <tr>
    
	
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="center">
        <input type="submit" name="Submit" value="Aceptar"  >
      </div></td>
      <td align="center"><input name="Cancelar" type="reset" value="Cancelar"></td>
    </tr>
  </table>


  </form>
</center>
  
</div>
<?php require '../include/footer.php'; ?>
</BODY>
</html>

