<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;



$id_fra=$_GET["id_fra"];


 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 
 
$result_emp=$Conn->query("SELECT * FROM C_COSTES WHERE  $where_c_coste");
$rs_emp = $result_emp->fetch_array(MYSQLI_ASSOC) ;

$result_fra=$Conn->query("SELECT * FROM Facturas_View WHERE id_fra=$id_fra AND $where_c_coste");
$rs_fra = $result_fra->fetch_array(MYSQLI_ASSOC) ;

$n_fra=$rs_fra["N_FRA"] ;
$id_fra=$rs_fra["ID_FRA"] ;      // SEGURIDAD. confirmamos que el id_fra sea del where_c_coste

$ext=$_GET["ext"];
$tipo=$_GET["tipo"];

if ($ext<>"" )         
{
 
header("Content-type: application/vnd.ms-$tipo; name='$tipo'"); /* Indica que tipo de archivo es que va a descargar */
header("Content-Disposition: attachment;filename=factura_cliente_{$rs_fra["N_FRA"]}$ext"); /* El nombre del archivo y la extensiòn */
header("Pragma: no-cache");
header("Expires: 0");
//header('Content-Type: text/html; charset=utf-8');
}
elseif ($tipo=="prt" )          // imprimimos directamente con un window.print(); 
{
echo "<script>window.print();</script>" ;     
}



?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
     <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <title>factura_<?php echo $_SESSION["empresa"] ?>_<?php echo $n_fra ?></title>

	<style type="text/css">
		@page { margin: 2cm }
		p { margin-bottom: 0cm; margin-top: 0cm; padding: 0cm; so-language: zxx }
		td p { margin-bottom: 0cm; so-language: zxx }
		a:link { so-language: zxx }
	</style>
</head>
<body dir="ltr">
  <?php     if (!$path_logo_empresa=Dfirst("path_archivo", "Documentos", "tipo_entidad='empresa' AND $where_c_coste")) $path_logo_empresa="../img/no_logo.jpg" ; ?>

    <p lang="zxx" align="left" style="margin-bottom: 0cm"><img width="300" src="<?php echo $path_logo_empresa; ?>" ></p>
            <p lang="zxx" align="right">
		<font face="Arial, serif"><font size="2" style="font-size: 9pt"><i><b><?php echo $rs_emp["nombre_centro_coste"] ;?></b></i></font></font></p>
<p lang="zxx" align="right" style="margin-bottom: 0cm"><font face="Arial, serif">
        <font size="2" style="font-size: 9pt"><i><span style="font-weight: normal"><?php echo $rs_emp["domicilio"] ;?></span></i></font></font></p>
<p lang="zxx" align="right" style="margin-bottom: 0cm"><font face="Arial, serif">
        <font size="2" style="font-size: 9pt"><i><span style="font-weight: normal"><?php echo $rs_emp["cod_postal"] ;?>  
<?php echo $rs_emp["Municipio"] ;?><br><?php echo $rs_emp["Provincia"] ;?></span></i></font></font></p>
<p lang="zxx" align="right" style="margin-bottom: 0cm"><font face="Arial, serif"><font size="2" style="font-size: 9pt"><i><span style="font-weight: normal">TELF:
<?php echo $rs_emp["tels"] ;?></span></i></font></font></p>
<p lang="zxx" align="right" style="margin-bottom: 0cm"><font face="Arial, serif"><font size="2" style="font-size: 9pt"><i><b>CIF:
<?php echo $rs_emp["cif"] ;?></b></i></font></font></p>

<p lang="zxx" style="margin-bottom: 0cm"><font face="Arial Black, sans-serif"><font size="6" style="font-size: 22pt">FACTURA
</font></font>
</p>
<p lang="zxx" align="left" style="margin-left: 11.3cm; margin-bottom: 0cm; border: none; padding: 0cm; background: transparent; page-break-before: auto">
<font face="Arial Black, sans-serif"><font size="3" style="font-size: 12pt"><span style="font-style: normal"><span style="font-weight: normal">CLIENTE</span></span></font></font></p>
<p lang="zxx" align="right" style="margin-left: 11.3cm; margin-bottom: 0cm; border: none; padding: 0cm; background: transparent">


</p>
<p lang="zxx" align="left" style="margin-left: 11.3cm; margin-bottom: 0cm; border: none; padding: 0cm; background: transparent">
 <font face="Arial, serif"><font size="2" style="font-size: 10pt"><span style="font-style: normal"><b><?php echo $rs_fra["NOMBRE_FISCAL"] ;?>
             </b></span></font></font><font face="Arial, serif">.</font></p>
<p lang="zxx" align="left" style="margin-left: 11.3cm; margin-bottom: 0cm; border: none; padding: 0cm; background: transparent">
 <font face="Arial, serif"><font size="3" style="font-size: 9pt"><span style="font-style: normal"><span style="font-weight: normal">
     <?php echo $rs_fra["DOMICILIO_FACTURAS"] ;?></span></span></font></font></p>
<p lang="zxx" align="left" style="margin-left: 11.3cm; margin-bottom: 0cm; border: none; padding: 0cm; background: transparent">
 <font face="Arial, serif"><font size="3" style="font-size: 9pt"><span style="font-style: normal"><span style="font-weight: normal"></span></span></font></font></p>

<p lang="zxx" align="left" style="margin-left: 11.3cm; margin-bottom: 0cm; border: none; padding: 0cm; background: transparent">
 <font face="Arial, serif"><font size="3" style="font-size: 12pt"><span style="font-style: normal"><span style="font-weight: normal">CIF:
<?php echo $rs_fra["CIF"] ;?></span></span></font></font></p>
<p lang="zxx" style="margin-bottom: 0cm"><font face="Arial, sans-serif"><font size="3" style="font-size: 13pt">N&ordm;
            factura : <b> <?php echo $rs_fra["N_FRA"] ;?> </b></font></font></p>
<p lang="zxx" style="margin-bottom: 0cm"><font face="Arial, sans-serif"><font size="3" style="font-size: 13pt">Fecha : <b> <?php echo cc_format($rs_fra["FECHA_EMISION"],'fecha_es') ;?></b>
</font></font>
</p>
<p lang="zxx" style="margin-bottom: 0cm"><br/>

</p>
<p lang="zxx" style="margin-bottom: 0cm"><font face="Arial, sans-serif"><font size="3" style="font-size: 13pt">Obra/Servicio:
            <b><?php echo $rs_fra["NOMBRE_COMPLETO"] ;?></b></font></font></p>
<p lang="zxx" style="margin-bottom: 0cm"><font face="Arial, sans-serif"><font size="3" style="font-size: 13pt">Expediente:  <b><?php echo $rs_fra["EXPEDIENTE"] ;?></b></font></font></p>

<p lang="zxx" style="margin-bottom: 0cm"><br/>

</p>
<table width="643" cellpadding="2" cellspacing="0">
	<col width="90">
	<col width="352">
	<col width="75">
	<col width="110">
	<tbody>
		<tr valign="top">
			<td width="90" bgcolor="#cccccc" style="background: #cccccc" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding: 0cm" sdnum="3082;3082;@">
				<p lang="zxx" align="center" style="text-decoration: none"><font color="#000000"><font face="Thorndale, serif"><font size="3" style="font-size: 12pt"><i><b>
                                                        <span style="background: transparent"><span style="text-decoration: none">Cantidad</span></span></b></i></font></font></font></p>
			</td>
			<td width="352" bgcolor="#cccccc" style="background: #cccccc" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding: 0cm" sdnum="3082;3082;@">
				<p lang="zxx" align="center" style="text-decoration: none"><font color="#000000"><font face="Thorndale, serif"><font size="3" style="font-size: 12pt"><i><b>
                                                        <span style="background: transparent"><span style="text-decoration: none">Detalle</span></span></b></i></font></font></font></p>
			</td>
			<td width="75" bgcolor="#cccccc" style="background: #cccccc" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding: 0cm" sdnum="3082;3082;@">
				<p lang="zxx" align="center" style="text-decoration: none"><font color="#000000"><font face="Thorndale, serif"><font size="3" style="font-size: 12pt"><i><b><span style="background: transparent">
                                                            <span style="text-decoration: none">Precio</span></span></b></i></font></font></font></p>
			</td>
			<td width="110" bgcolor="#cccccc" style="background: #cccccc" style="border: 1px solid #000000; padding: 0cm" sdnum="3082;3082;@">
				<p lang="zxx" align="center" style="text-decoration: none"><font color="#000000"><font face="Thorndale, serif"><font size="3" style="font-size: 12pt"><i><b>
                                                        <span style="background: transparent"><span style="text-decoration: none">Importe</span></span></b></i></font></font></font></p>
			</td>
		</tr>
	</tbody>
	<tbody>
            
          <?php 
          
            $sql_detalle="SELECT * FROM Fra_Cli_DetallesV WHERE ID_FRA=$id_fra AND $where_c_coste ORDER BY n_linea";

            // echo "<br><br><br><br><br>$sql" ;

             $result_detalle=$Conn->query($sql_detalle) ;
              
            while ($rs_detalle = $result_detalle->fetch_array(MYSQLI_ASSOC)) {

 
          ?>
		<tr valign="top">
			<td width="90" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding: 0cm" sdnum="3082;3082;@">
				<p lang="zxx" align="center" style="font-style: normal; font-weight: normal; text-decoration: none">
				<font color="#000000"><font face="Arial, sans-serif"><font size="2" style="font-size: 9pt"><span style="text-decoration: none"><?php echo $rs_detalle["Cantidad"] ;?></span></font></font></font></p>
			</td>
			<td width="352" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding: 0cm">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<font color="#000000"><font face="Arial, sans-serif"><font size="2" style="font-size: 9pt">
                                            <span style="text-decoration: none"><?php echo $rs_detalle["Detalle"] ;?></span></font></font></font></p>
			</td>
			<td width="75" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding: 0cm"  sdnum="3082;3082;Estandar">
				<p lang="zxx" align="center" style="font-style: normal; font-weight: normal; text-decoration: none">
				<font color="#000000"><font face="Arial, sans-serif"><font size="2" style="font-size: 9pt">
                                            <span style="text-decoration: none"><?php echo cc_format($rs_detalle["Precio"],'moneda') ;?></span></font></font></font></p>
			</td>
			<td width="110" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding: 0cm">
				<p lang="zxx" align="right" style="font-style: normal; font-weight: normal; text-decoration: none">
				<font color="#000000"><font face="Arial, sans-serif"><font size="2" style="font-size: 9pt">
                                            <span style="text-decoration: none"><?php echo cc_format($rs_detalle["importe"],'moneda') ;?>
				</span></font></font></font></p>
			</td>
		</tr>
          <?php 
          
          }    
                    
          ?>  
                
	</tbody>
	<tbody>
		<tr valign="top">
			<td width="90" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding: 0cm" sdnum="3082;3082;@">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<br/>

				</p>
			</td>
			<td width="352" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding: 0cm" sdnum="3082;3082;Estandar">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<br/>

				</p>
			</td>
			<td width="75" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding: 0cm" sdnum="3082;3082;Estandar">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<br/>

				</p>
			</td>
			<td width="110" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding: 0cm" sdnum="3082;3082;Estandar">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<br/>

				</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="90" valign="top" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding: 0cm" sdnum="3082;3082;@">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<br/>

				</p>
			</td>
			<td width="352" valign="top" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding: 0cm" sdnum="3082;3082;Estandar">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<br/>

				</p>
			</td>
			<td width="75" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding: 0cm" sdnum="3082;3082;Estandar">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<br/>

				</p>
			</td>
			<td width="110" valign="top" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding: 0cm" sdnum="3082;3082;Estandar">
				<p lang="zxx" align="right" style="font-style: normal; font-weight: normal; text-decoration: none">
				<br/>

				</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="90" valign="top" bgcolor="#ffffff" style="background: #ffffff" style="border: none; padding: 0cm" sdnum="3082;3082;@">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<br/>

				</p>
			</td>
			<td width="352" valign="top" bgcolor="#ffffff" style="background: #ffffff" style="border: none; padding: 0cm" sdnum="3082;3082;Estandar">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<br/>

				</p>
			</td>
			<td width="75" bgcolor="#ffffff" style="background: #ffffff" style="border: none; padding: 0cm">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<font color="#000000"><font face="Arial, sans-serif"><font size="2" style="font-size: 9pt">
                                            <span style="text-decoration: none">SUMA</span></font></font></font></p>
			</td>
			<td width="110" valign="top" bgcolor="#ffffff" style="background: #ffffff" style="border: none; padding: 0cm">
				<p lang="zxx" align="right" style="font-style: normal; font-weight: normal; text-decoration: none">
				<font color="#000000"><font face="Arial, sans-serif"><font size="2" style="font-size: 9pt">
                                            <span style="text-decoration: none"><?php echo cc_format($rs_fra["Base_Imponible"],'moneda') ;?></span></font></font></font></p>
			</td>
		</tr>
		<tr>
			<td width="90" valign="top" bgcolor="#ffffff" style="background: #ffffff" style="border: none; padding: 0cm" sdnum="3082;3082;@">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<br/>

				</p>
			</td>
			<td width="352" valign="top" bgcolor="#ffffff" style="background: #ffffff" style="border: none; padding: 0cm" sdnum="3082;3082;Estandar">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<br/>

				</p>
			</td>
			<td width="75" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: 1px solid #000000; border-left: none; border-right: none; padding-top: 0cm; padding-bottom: 0.05cm; padding-left: 0cm; padding-right: 0cm">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<font color="#000000"><font face="Arial, sans-serif"><font size="2" style="font-size: 9pt"><span style="text-decoration: none">IVA
				<?php echo cc_format($rs_fra["iva"],'porcentaje0') ;?></span></font></font></font></p>
			</td>
			<td width="110" valign="top" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: 1px solid #000000; border-left: none; border-right: none; padding-top: 0cm; padding-bottom: 0.05cm; padding-left: 0cm; padding-right: 0cm">
				<p lang="zxx" align="right" style="font-style: normal; font-weight: normal; text-decoration: none">
				<font color="#000000"><font face="Arial, sans-serif"><font size="2" style="font-size: 9pt">
                                            <span style="text-decoration: none"><?php echo (cc_format($rs_fra["Base_Imponible"]*$rs_fra["iva"],'moneda')) ;?></span></font></font></font></p>
			</td>
		</tr>
		<tr>
			<td width="90" valign="top" bgcolor="#ffffff" style="background: #ffffff" style="border: none; padding: 0cm" sdnum="3082;3082;@">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<br/>

				</p>
			</td>
			<td width="352" valign="top" bgcolor="#ffffff" style="background: #ffffff" style="border: none; padding: 0cm" sdnum="3082;3082;Estandar">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<br/>

				</p>
			</td>
			<td width="75" bgcolor="#ffffff" style="background: #ffffff" style="border: none; padding: 0cm">
				<p lang="zxx" align="left" style="font-style: normal; font-weight: normal; text-decoration: none">
				<font color="#000000"><font face="Arial, sans-serif"><font size="2" style="font-size: 9pt"><span style="text-decoration: none">TOTAL</span></font></font></font></p>
			</td>
			<td width="110" valign="top" bgcolor="#ffffff" style="background: #ffffff" style="border: none; padding: 0cm">
				<p lang="zxx" align="right" style="font-style: normal; text-decoration: none">
				<font color="#000000"><font face="Arial, sans-serif"><font size="2" style="font-size: 9pt"><b>
                                <span style="text-decoration: none"><?php echo (cc_format($rs_fra["IMPORTE_IVA"],'moneda')) ;?></span></b></font></font></font></p>
			</td>
		</tr>
	</tbody>
</table>
<p lang="zxx" style="margin-bottom: 0cm"><br/>

</p>
<p lang="zxx" align="left" style="margin-bottom: 0cm"><font face="Arial, sans-serif"><font size="2" style="font-size: 9pt">Entidad
Bancaria:</font></font></p>
<p lang="zxx" align="left" style="margin-bottom: 0cm"><font face="Arial, sans-serif"><font size="2" style="font-size: 9pt"><?php echo $rs_emp["Banco_fras"] ;?></font></font></p>
<p lang="zxx" align="left" style="margin-bottom: 0cm"><font face="Arial, sans-serif"><font size="2" style="font-size: 10pt">IBAN:
<?php echo $rs_emp["IBAN_fras"] ;?> </font></font>
</p>
<p lang="zxx" align="left" style="margin-bottom: 0cm"><font face="Arial, sans-serif"><font size="2" style="font-size: 10pt">BIC:
<?php echo $rs_emp["BIC_fras"] ;?> </font></font>
</p>
<p lang="zxx" align="left" style="margin-bottom: 0cm"><br/>

</p>
<p lang="zxx" align="left" style="margin-bottom: 0cm"><br/>

</p>
<div title="footer">
	<p lang="zxx" align="center" style="margin-top: 0.5cm; margin-bottom: 0cm">
	<font face="Arial, sans-serif"><font size="1" style="font-size: 7pt"><i><?php echo $rs_emp["reg_mercantil"] ;?></i></font></font></p>
        
        
</div>



	
<?php  




$Conn->close();

?>
 


</body>
</html>