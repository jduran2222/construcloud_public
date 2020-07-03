<?php 
$active= isset($active)? $active : basename( $_SERVER['PHP_SELF'], ".php")  ;  // elemento a dejar activo
?>

<div class="topnav" id="myTopnav">
	
  <a href="javascript:void(0);" style="font-size:15px;cursor:pointer"  onclick="openNav()">Menu PPAL</a>  

  
  <a  <?php echo ($active=='clientes_ficha'? "class='cc_active'" : "" );?>  href="clientes_ficha.php?id_cliente=<?php echo $id_cliente;?>" >Datos</a>
  <a  <?php echo ($active=='clientes_obras'? "class='cc_active'" : "" );?>  href="clientes_obras.php?id_cliente=<?php echo $id_cliente;?>">Obras</a>
  <a  <?php echo ($active=='clientes_facturas'? "class='cc_active'" : "" );?>  href="clientes_facturas.php?id_cliente=<?php echo $id_cliente;?>">Facturas</a>
  <a  <?php echo ($active=='clientes_ofertas'? "class='cc_active'" : "" );?>  href="clientes_ofertas.php?id_cliente=<?php echo $id_cliente;?>">Ofertas</a>
  <a  <?php echo ($active=='clientes_estudios'? "class='cc_active'" : "" );?>  href="clientes_estudios.php?id_cliente=<?php echo $id_cliente;?>">Licitaciones</a>


  <a href="javascript:void(0);" style="font-size:45px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>



<script>
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
</script>

