<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 
		
$id_fra=$_GET["id_fra"]  ;
$id_mov_banco= isset($_GET["id_mov_banco"]) ? $_GET["id_mov_banco"] : 0 ;
$id_cta_banco= isset($_GET["id_cta_banco"]) ? $_GET["id_cta_banco"] : 0 ;



if ($id_pago=fra_cliente_generar_cobro($id_fra))          // genero el COBRO en la cuenta banco por defecto
   {  
    
    if ($id_mov_banco)
    {
      // comprobacion seguridad
      if (Dfirst('id_pago','Pagos_View', " $where_c_coste AND id_pago=$id_pago ") AND Dfirst('id_mov_banco','MOV_BANCOS_View', " $where_c_coste AND id_mov_banco=$id_mov_banco ") )   
              {$Conn->query("UPDATE `PAGOS` SET `id_mov_banco` = $id_mov_banco WHERE  id_pago=$id_pago" );
              }
      
    }elseif ($id_cta_banco)   
    {
//        logs('entramos en id_cta_banco');
      $guid =  guid(); 
      $concepto=Dfirst("CONCAT(CLIENTE,' ', N_FRA,' ',CONCEPTO)", "Fras_Cli_Listado"," $where_c_coste AND ID_FRA=$id_fra ") ;
      $ingreso=Dfirst("ingreso", "Pagos_View"," $where_c_coste AND id_pago=$id_pago ") ;
      $fecha=date('Y-m-d');

      $sql= "INSERT INTO `MOV_BANCOS` (`id_cta_banco`, `numero`, `fecha_banco`, `Concepto`, ingreso ,user,guid)" 
                                    ." VALUES ( '$id_cta_banco', '0', '$fecha', '$concepto' ,'$ingreso' , '{$_SESSION['user']}' , '$guid'  );"  ;    
//      logs("SQL_INSERT MOV_BANCOS: $sql") ;                                   
       $Conn->query($sql);
//      $Conn->query("UPDATE `PAGOS` AS P,(select id_mov_banco from MOV_BANCOS where guid='$guid' ) AS M "
//              . " SET P.id_mov_banco = M.id_mov_banco  WHERE  P.id_pago=$id_pago  ;") ;   

      $Conn->query("UPDATE `PAGOS`  "
              . " SET id_mov_banco = (select id_mov_banco from MOV_BANCOS where guid='$guid' )"
              . " , id_cta_banco = $id_cta_banco WHERE  id_pago=$id_pago  ;") ;   
      
    }
    
    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
//        echo "COBRO CREADO ID_FRA cliente: $id_fra"  ;

    }   //DEBUG 
   else 
   {  echo "ERROR EN CONCILACION ID_FRA cliente: $id_fra"  ; }   //DEBUG 


//      echo $array_id[0].' & '.$array_id[1].'<br>'; 
      
      //echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../bancos/conciliar_fra_prov_mov_banco.php?$values_mov_banco_fras'>" ;
              
      //echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../bancos/remesa_ficha.php?id_remesa=$id_remesa'>" ;
    

?>