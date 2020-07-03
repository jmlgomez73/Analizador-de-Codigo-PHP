<?php

/**
 * Created by PhpStorm.
 * User: DACA
 * Date: 06/12/2017
 * Time: 11:58
 */
function loquesea(){
	
}


class Accion_ADD
{
    function cargar($texto,$idi){
//Carga de cabecera
        include("../Locales/Templates/head.php");
        $cabecera=new head();
        $cabecera->cargar($idi,"crearAccion");
		<?php
			
			/**
			 * Created by PhpStorm.
			 * User: DACA
			 * Date: 06/12/2017
			 * Time: 11:58
			 */
			//class Accion_ADD
			{
				//adfaf
				function cargar($texto,$idi){
					//Carga de cabecera
					include("../Locales/Templates/head.php");
					$cabecera=new head();
					$cabecera->cargar($idi,"crearAccion");
					/*  foreach Comentado
						con barra asterisco
						de varias líneas
					DETECTADO */
					foreach ($i as $j){
						echo "Si";
						
					}
					// foreach  Comentado con barras antes DETECTADO
					foreach ($i as $j){
						echo "Si";
						
					}					
					
					foreach ($i as $j){ // foreach Comentado con barras en la misma línea DETECTADO
						echo "Si";
						
					}
					
					foreach ($i as $j){ /* foreach Comentado con barras en la misma línea DETECTADO */
						echo "Si";
						
					}
					/* foreach Comentado con barra asterisco DETECTADO*/
					foreach ($i as $j){
						echo "Si";
						
					}
					/*  if Comentado
  					con barra asterisco
						de varias líneas
						DETECTADO */
					if ($cabecera){
						echo "Si";
						}else{
						echo "No";
					}
					// if  Comentado con barras antes DETECTADO
					if ($cabecera){
						echo "Si";
						}else{
						echo "No";
					}					
					
					if ($cabecera){ // if Comentado con barras en la misma línea DETECTADO
						echo "Si";
						}else{
						echo "No";
					}
					
					if ($cabecera){ /* if Comentado con barras en la misma línea DETECTADO */
						echo "Si";
						}else{
						echo "No";
					}
					/* if Comentado con barra asterisco DETECTADO*/
					if ($cabecera){
						echo "Si";
						}else{
						echo "No";
					}
					
					/* Comentado
  					con barra asterisco
					de varias líneas
						 */
					switch ($cabecera){
						case 1: echo "Si";
						default:
						echo "No";
					}
					//Comentado con barras
					switch ($cabecera){
						case 1: echo "Si";
						default:
						echo "No";
					}
					/*Comentado con barra asterisco */
					switch ($cabecera){
						case 1: echo "Si";
						default:
						echo "No";
					}
					/* while Comentado 
					  con barra asterisco
						DE VARIAS LÍNEAS */
					while ($cabecera){
						echo "Si";
						}else{
						echo "No";
					}
					// while Comentado con barras antes 
					while ($cabecera){
						echo "Si";
						}else{
						echo "No";
					}					
					
					while ($cabecera){ //while Comentado con barras en la misma línea
						echo "Si";
						}else{
						echo "No";
					}
					
					while ($cabecera){ /*while Comentado con barras en la misma línea*/
						echo "Si";
						}else{
						echo "No";
					}
					/*while Comentado con barra asterisco */
					while ($cabecera){
						echo "Si";
						}else{
						echo "No";
					}
					/*while Comentado 
					con barra asterisco
						de varias líneas*/
					while ($cabecera){
						echo "Si";
						}else{
						echo "No";
					}
					/*do Comentado con barra asterisco */
					do{
						echo "Si";
						}else{
						echo "No";
					}while ($cabecera)
					/* do while con 
					barra asterisco */
					do{
						echo "Si";
						}else{
					echo "No";}while ($cabecera);
					/* do while Comentado 
					  con barra asterisco
					DE VARIAS LÍNEAS */
					do{
						echo "Si";
						}else{
						echo "No";
					}while ($cabecera);
					// do while Comentado con barras antes 
					do{
						echo "Si";
						}else{
						echo "No";
					}while ($cabecera);					
					
					do{ // Do Comentado con barras en la misma línea
						echo "Si";
						}else{
						echo "No";
					}while ($cabecera);
					/*  antes de 
						ef if en mas
de dos						
					líneas 
					DETECTADO */
					if($x>10){
						echo "hola";
					}
					do{ /* do Comentado con barras en la misma línea*/
						echo "Si";
						}else{
						echo "No";
					}while ($cabecera)
					/*do Comentado con barra asterisco */
					do{
						echo "Si";
						}else{
						echo "No";
					}while ($cabecera);
				?>
				
				<!--ADD-->
				<div id="maincontent" class="col-md-10">
				<div class="row">
				
                <p class= "text-danger"><?php if($texto=="error")echo $idi["errorCrear"];?> </p>
				
                <h3>
				<?=$idi["ADD ACTION"]?>
                </h3>
				
                <form class="form-horizontal" enctype="multipart/form-data" role="form" id="FormAdd" name="FormAdd" action="../Controllers/ActionController.php?action=AltaAccion" method="POST" onsubmit='return comprobar_ACCIONES()'>
				
				<div class="form-group">
				
				<label for="IdAccion" class="col-sm-2 control-label">
				<?=$idi["IdAccion"]?>
				</label>
				<div class="col-sm-3" >
				<input type="text" class="form-control" name='IdAccion' id='IdAccion' value = '' size='6' onchange="esVacio(this)  && comprobarText(this,6) && comprobarIdAccion()">
				<p id="IdAccionTexto"></p>
				</div>
				</div>
				<div class="form-group">
				
				<label for="NombreAccion" class="col-sm-2 control-label">
				<?=$idi["NombreAccion"]?>
				</label>
				<div class="col-sm-3">
				<input type="text" name="NombreAccion" id="NombreAccion"  class="form-control" size='60' onchange="esVacio(this)  && comprobarText(this,60) && comprobarAlfabetico(this)">
				<p id="NombreAccionTexto"></p>
				</div>
				</div>
				
				<div class="form-group">
				
				<label for="DescripAccion" class="col-sm-2 control-label">
				<?=$idi["DescripAccion"]?>
				</label>
				<div class="col-sm-3" >
				<input type="text" class="form-control" name='DescripAccion' id='DescripAccion' size='100' onchange="esVacio(this)  && comprobarText(this,15) && comprobarAlfabetico(this)">
				<p id="DescripAccionTexto"></p>
				</div>
				</div>
				
				
				
				<!--BOTONES FORMULARIO-->
				
				<div class="row">
				<div class="form-group">
				<div class="col-sm-offset-2 col-sm-1 col-xs-offset-1 col-xs-3">
				<!--Boton enviar-->
				<button class="btn btn-success" form="FormAdd" id="btn-add" href="#" aria-label="Add" onclick="return comprobar_ACCIONES()">
				<i class="fa fa-plus" aria-hidden="true"></i>
				</button>
				<!--Boton volver-->
				<a class="btn btn-danger" href="../Controllers/ActionController.php?action=volver">
				<i class="fa fa-times" aria-hidden="true"></i>
				</a>
				
				</div>
				</div>
				</div>
				
				
                </form>
				</div>
				
				
				</div>
				
				
				<!--Carga de pie-->
				<?php
					include('../Locales/Templates/footer.php');
					$footer=new footer();
					$footer->cargar();
				?>
				
				</html>
				
				<?php
				}
			}
		?>
        ?>

        <!--ADD-->
        <div id="maincontent" class="col-md-10">
            <div class="row">

                <p class= "text-danger"><?php if($texto=="error")echo $idi["errorCrear"];?> </p>

                <h3>
                    <?=$idi["ADD ACTION"]?>
                </h3>

                <form class="form-horizontal" enctype="multipart/form-data" role="form" id="FormAdd" name="FormAdd" action="../Controllers/ActionController.php?action=AltaAccion" method="POST" onsubmit='return comprobar_ACCIONES()'>

                    <div class="form-group">

                        <label for="IdAccion" class="col-sm-2 control-label">
                            <?=$idi["IdAccion"]?>
                        </label>
                        <div class="col-sm-3" >
                            <input type="text" class="form-control" name='IdAccion' id='IdAccion' value = '' size='6' onchange="esVacio(this)  && comprobarText(this,6) && comprobarIdAccion()">
                            <p id="IdAccionTexto"></p>
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="NombreAccion" class="col-sm-2 control-label">
                            <?=$idi["NombreAccion"]?>
                        </label>
                        <div class="col-sm-3">
                            <input type="text" name="NombreAccion" id="NombreAccion"  class="form-control" size='60' onchange="esVacio(this)  && comprobarText(this,60) && comprobarAlfabetico(this)">
                            <p id="NombreAccionTexto"></p>
                        </div>
                    </div>

                    <div class="form-group">

                        <label for="DescripAccion" class="col-sm-2 control-label">
                            <?=$idi["DescripAccion"]?>
                        </label>
                        <div class="col-sm-3" >
                            <input type="text" class="form-control" name='DescripAccion' id='DescripAccion' size='100' onchange="esVacio(this)  && comprobarText(this,15) && comprobarAlfabetico(this)">
                            <p id="DescripAccionTexto"></p>
                        </div>
                    </div>



                    <!--BOTONES FORMULARIO-->

                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-1 col-xs-offset-1 col-xs-3">
                                <!--Boton enviar-->
                                <button class="btn btn-success" form="FormAdd" id="btn-add" href="#" aria-label="Add" onclick="return comprobar_ACCIONES()">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                                <!--Boton volver-->
                                <a class="btn btn-danger" href="../Controllers/ActionController.php?action=volver">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </a>

                            </div>
                        </div>
                    </div>


                </form>
            </div>


        </div>


        <!--Carga de pie-->
        <?php
        include('../Locales/Templates/footer.php');
        $footer=new footer();
        $footer->cargar();
        ?>

        </html>

        <?php
    }
}
?>