<!--   
    Autor: Jorge Manuel Lozano Gomez
    Fecha: 20/04/2018
!-->

<html>
<head>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" type="text/css" href="Conf/style.css">
</head>
 
<body>

 <?php 

//tabulador
$tab="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
//titulos
$titulos=array("1"=>"1 Existen los directorios especificados en el fichero Directories.conf y no hay ningun
fichero mas en el directorio principal que el index.php","2"=>"2 Los ficheros de vista, controlador y modelo tienen el nombre indicado en la
especificacion en el fichero Files.conf","3"=>"3 Los ficheros del directorio CodigoAExaminar tiene todos al principio del fichero
comentada su funcion, autor y fecha (para todos los ficheros que no son propietarios de
tipo .pdf, .jpg, etc)
","4"=>"4 Las funciones y metodos en el codigo del directorio CodigoAExaminar tienen
comentarios con una descripcion antes de su comienzo
","5"=>"5 En el codigo estan todas las variables definidas antes de su uso y tienen un comentario
en la linea anterior o en la misma linea
","6"=>"6 En el codigo estan comentadas todas las estructuras de control en la linea anterior a su
uso o en la misma linea
","7"=>"7 Todos los ficheros dentro del directorio Model son definiciones de clases","8"=>"8 Todos los ficheros dentro del directorio Controller son scripts php.","9"=>"9 Todos los ficheros dentro del directorio View son definiciones de clases");
//resumen
$resumen=array();
//detalle
$detalle=array();

//1




analizar_directorios();
function analizar_directorios() {
//le añadimos la barra final
	$cont=0;
	$detalle="";
	//nombre del archivo
	$ar = 'directories.conf';
		//abrir archivo
	$fp = @fopen($ar,'r');
//leemos el archivo
	$directorios= @fread($fp, @filesize($ar));

	
	@fclose($fp);
	//hacemos split para meter cada 1 en una linea
	$leercarpeta = preg_split("/[\s]+/", "$directorios");
	//contador
	$i=0;
	//obetnermos carpeta raiz
	$carpeta_raiz=explode("/",$leercarpeta[0])[0];
		//leemos la raiz
	$ficheros =@scandir($carpeta_raiz);
		//contamos los archivo
	$num=@count($leercarpeta);


if(@count($leercarpeta)>1){
	$detalle.="<table>";

	while ( $i< count($leercarpeta)) {//mientras haya elementos

		$leercarpeta[$i] = $leercarpeta[$i] . "/";


		if(is_dir($leercarpeta[$i])){//Comprueba si es dir
		
		
		if($dir = opendir($leercarpeta[$i])){//abre el directorio
			
			
			$detalle.="<tr><td>" .$leercarpeta[$i]. "</td><td> OK </td></tr>";
		
			closedir($dir);
			
			}else{
				
				$cont++;

			}
		}else{//No existe el directorio en la carpeta
				
				$detalle.="<tr><td class='error'>" .$leercarpeta[$i]. "</td><td class='error'> ERROR:NO EXISTE EL DIRECTORIO</td></tr>";	
				$cont++;				
		}
		$i++;
	}


		for($i=0;$i<@count($ficheros);$i++){	//recorre
			if(strpos($ficheros[$i],".")>0 and !is_dir($ficheros[$i])){	//acorta por el .
				if($ficheros[$i]!="index.php"){//comprueba
					$detalle.="<tr><td class='error'>" . $carpeta_raiz . "/".$ficheros[$i]."</td><td class='error'> ERROR: FICHERO NO PERMITIDO </td></tr>";
					$cont++;
				}
			}
		}
	


$detalle.="</table>";
}else{
	$num=0;
}

	$GLOBALS["resumen"]["1"]= "<p class='error'>".$num. " Elementos analizados / Numero de errores: " . $cont."</p>";
	$GLOBALS["detalle"]["1"]="DETALLE"."<br>".$detalle."<br>";


} 

 nombres_Ficheros();
     function nombres_Ficheros(){
         $cont=0;
         $todos=0;
         $nombre_fichero="Files.conf";
         $detalle="";
         $gestor = @fopen($nombre_fichero, "r");
         $contenido = @fread($gestor, @filesize($nombre_fichero));

         @fclose($gestor);
         $espacios="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";


         $detalle.="<table>";
         $lineas=explode("\n", $contenido);
         $error=false;


if( @count($lineas)>1){
         for($i=0;$i<count($lineas);$i++){//recorre
             
             $aux=explode("/",$lineas[$i]);
             $nombres[0]=substr($lineas[$i],0,strrpos($lineas[$i],"/"));
             $nombres[1]=$aux[count($aux)-1];
             
             
             $directorio=explode("/",$nombres[0]);
             if(@count($nombres)>0){//comprueba
                 $recorrer=false;
                 
                 if(strpos($nombres[1],"%")!==false){
                     $recorrer=true;
					 $detalle.="<tr><td>" . $nombres[0] . "/" . $nombres[1] ."</td><td></td></tr>";
					 $original=$nombres[1];
                 }
							 
                 while(strpos($nombres[1],"%")!==false){//mientras se cumpla el patron
                     $nombres[1]=str_replace('%','[A-Za-z]+',$nombres[1]);
                 }
                if ($recorrer)
                    $patron="/" . trim($nombres[1]) . "/";
                 if(is_dir($nombres[0])){//comprueba

                     $esta=false;
                     $ficheros=scandir($nombres[0]);

                     for($j=0;$j<count($ficheros);$j++){//comprueba
                         
                         if(strpos($ficheros[$j],".") and !is_dir($ficheros[$j])){//comprueba si es
                             if($recorrer==true){
                                 
                                 $todos++;               
                               
                                 if(preg_match($patron,trim($ficheros[$j]))){//comprueba                       
                                     $detalle.="<tr><td>" .$espacios. $nombres[0] . "/" . $ficheros[$j] ."</td><td> OK</td></tr>";
                                      $error=true;


                                }else{                       
                                     $detalle.="<tr><td class='error'>" .$espacios. $nombres[0] . "/" . $ficheros[$j] . "</td><td class='error'> ERROR</td></tr>";
                                     $cont++;
                                 }
                             }else
                             {
                             
                                    if(trim($nombres[1])==trim($ficheros[$j])){
                                     $esta=true;
                                 }
                             } 


                         }
                     }

                     if($recorrer==false){
                          
                          $todos++;   
                         if($esta==true){
                             $detalle.= "<tr><td>" . $nombres[0] ."/". $nombres[1] . "</td><td> OK </td></tr><br>";
						

						 }else{
							 $detalle.= "<tr><td class='error'>" . $nombres[0]."/". $nombres[1] . "</td><td class='error'> ERROR </td></tr><br>";                       
							 $cont++;



                         }  
					}

                 }else{
				$detalle.= "<tr><td class='error'>" . $nombres[0]."/". $nombres[1] . "</td><td class='error'> ERROR </td></tr><br>";
				$cont++;
				$todos++;   
			 }
				 }else{
				 $detalle.= "<tr><td class='error'>" . $nombres[0]."/". $nombres[1] . "</td><td class='error'> ERROR </td></tr><br>";
				 $cont++;
				 $todos++;   
			 }
         }

            
         $detalle.="</table>";
  }	       
         
         $GLOBALS["resumen"]["2"]= "<p class='error'>".$todos. " Elementos analizados / Numero de errores: " . $cont."<br>"."</p>";
         $GLOBALS["detalle"]["2"]="DETALLE"."<br>".$detalle."<br>";
         
     }



//3
//Enlace para apartados 3 Comentario 
Buscar0();	
function Buscar0(){


	$patron1="/^\<\?(php)[[:space:]]*(\n)*\/\*/";

	$patron2="/^\<\?(php)[[:space:]]*(\n)*\/\//";

	//Sirve para ficheros html o php
	$patron3="/^[[:space:]]*\<!--/";


	$contTotal=0;
	$contError=0;

	$nombre_fichero="Directories.conf";
	$detalle="";
	$gestor = @fopen($nombre_fichero, "r");
	$contenido = @fread($gestor, @filesize($nombre_fichero));
	@fclose($gestor);

	$lineas=explode("\n", $contenido);
	//para el primer nivel

	$raiz=explode("/",$lineas[0]);
	
	$detalle.="<table>";

	if(is_dir($raiz[0])){//comprueba si es
	$ficheros  =@scandir($raiz[0]);


	for($i=0;$i<@count($ficheros);$i++){//recorre


		if($ficheros[$i]=="index.php"){//comprueba si es

		if(strpos($ficheros[$i],".") and !is_dir($ficheros[$i])){//comprueba si es
			$puntos=(explode('.',$ficheros[$i]));
			$ext = strtolower($puntos[count($puntos)-1]);

			
			if($ext=="php"){//comprueba si es
				$contTotal++;
				$texto=@file_get_contents(trim($raiz[0]) . "/" . trim($ficheros[$i]));
				$texto=trim($texto);
				if(preg_match("/^<\?php[[:space:]]*\/\//",$texto) || preg_match("/^<\?php[[:space:]]*\/\*/",$texto)){//comprueba si es
					 $detalle.="<tr><td>".$raiz[0]."/".$ficheros[$i] ."</td><td> OK</td></tr>";
					}
					else{
						$detalle.= "<tr><td class='error'>" .$raiz[0]."/".$ficheros[$i]  ."</td><td class='error'> ERROR:NO TIENE COMENTARIO </td></tr>";
						$contError++;
				}

				}
			
			}
		}
	}

}	

	
	//Resto de subcapertas a partir de raiz

	foreach ($lineas as $d => $listado) {//recorre
		$raiz=explode("/",$lineas[$d]);//raiz
		if(is_dir(trim($lineas[$d])."/")){//comprueba si es
		$ficheros =@scandir(trim($lineas[$d]));//leer

	for($i=0;$i<@count($ficheros);$i++){//recorre

		if(strpos($ficheros[$i],".") and !is_dir($ficheros[$i])){//comprueba si es
			$ext = strtolower((explode('.',$ficheros[$i])[1]));

			
			if($ext=="php"){//comprueba si es
				$contTotal++;
				$texto=@file_get_contents(trim($lineas[$d]) . "/" . trim($ficheros[$i]));		
				$texto=trim($texto);
				if(preg_match("/^<\?php[[:space:]]*\/\//",$texto) || preg_match("/^<\?php[[:space:]]*\/\*/",$texto)){//comprueba si es

				  $detalle.="<tr><td>".$lineas[$d]."/".$ficheros[$i] ."</td><td> OK</td></tr>";
					}
					else{
						$detalle.= "<tr><td class='error'>" .$lineas[$d]."/".$ficheros[$i]  ."</td><td class='error'> ERROR:NO TIENE COMENTARIO </td></tr>";
						$contError++;
				}
				
			}
			if($ext == "html" || $ext =="htm")  { //comprueba si es
				$contTotal++;
				$texto=@file_get_contents(trim($lineas[$d]) . "/" . trim($ficheros[$i]));
				$texto=trim($texto);
				if(preg_match("/^[[:space:]]*<!--/",$texto) || preg_match("/^<\?php[[:space:]]*<!--/",$texto)){//comprueba si es
					  $detalle.="<tr><td>".$raiz[0]."/".$ficheros[$i] ."</td><td> OK</td></tr>";
					}
					else{
						$detalle.= "<tr><td class='error'>" .$lineas[$d]."/".$ficheros[$i]  ."</td><td class='error'> ERROR:NO TIENE COMENTARIO </td></tr>";
						$contError++;
				}
				
				
			}
			if($ext == "css"){ //comprueba si es
				$contTotal++;
				$texto=@file_get_contents(trim($lineas[$d]) . "/" . trim($ficheros[$i]));
				$texto=trim($texto);
				if( preg_match("/^[[:space:]]*\/\*/",$texto)){//comprueba si es
					  $detalle.="<tr><td>".$raiz[0]."/".$ficheros[$i] ."</td><td> OK</td></tr>";
					}
					else{
						$detalle.= "<tr><td class='error'>" .$lineas[$d]."/".$ficheros[$i]  ."</td><td class='error'> ERROR:NO TIENE COMENTARIO </td></tr>";
						$contError++;

				}
			}
			if($ext == "js"){ //comprueba si es
				$contTotal++;
				$texto=@file_get_contents(trim($lineas[$d]). "/" . trim($ficheros[$i]));
				$texto=trim($texto);
				if(preg_match("/^[[:space:]]*\/\//",$texto) || preg_match("/^[[:space:]]*\/\*/",$texto)){//comprueba si es
 					$detalle.="<tr><td>".$raiz[0]."/".$ficheros[$i] ."</td><td> OK</td></tr>";					
 				}
					else{
						$detalle.= "<tr><td class='error'>" .$lineas[$d]."/".$ficheros[$i]  ."</td><td class='error'> ERROR:NO TIENE COMENTARIO </td></tr>";
						$contError++;
				}
	
					}
				}
			}
		}
	}
	$detalle.="</table>";


					$GLOBALS["resumen"]["3"]="<p class='error'>".$contTotal. " Elementos analizados / Numero de errores: " . $contError."</p>";
					$GLOBALS["detalle"]["3"]="DETALLE"."<br>".$detalle."<br>";

}


//3
//Enlace para apartados  4.    funciones
Buscar();
function Buscar(){


	$patron1="/^\<\?(php)[[:space:]]*(\n)*\/\*/";

	$patron2="/^\<\?(php)[[:space:]]*(\n)*\/\//";
	//Sirve para ficheros html o php
	$patron3="/^[[:space:]]*\<!--/";

	$nombre_fichero="Directories.conf";
	$det="";
	$gestor = @fopen($nombre_fichero, "r");
	$contenido = @fread($gestor, @filesize($nombre_fichero));
	@fclose($gestor);
	$total=0;/*Acumula las funciones evaluadas********************************/
	$error=0;/*Acumula las funciones con error********************************/
	$deta="";/*Acumula los detalles*******************************************/
	
	$lineas=explode("\n", $contenido);
	//para el primer nivel

	$raiz=explode("/",$lineas[0]);
	$info=array();
	
	if(is_dir($raiz[0])){//comprueba si es
	$ficheros  =@scandir($raiz[0]);

	for($i=0;$i<@count($ficheros);$i++){//recorre

		if($ficheros[$i]=="index.php"){//comprueba si es

		if(strpos($ficheros[$i],".") and !is_dir($ficheros[$i])){//comprueba si es
			$puntos=(explode('.',$ficheros[$i]));
			$ext = strtolower($puntos[count($puntos)-1]);

			
			if($ext=="php"){////comprueba si es
				$texto=@file_get_contents(trim($raiz[0]) . "/" . trim($ficheros[$i]));
				$texto=trim($texto);
				
				
				$info=comprobarFunciones(trim($raiz[0]) . "/" . trim($ficheros[$i]));
				

				$total+=$info[0];
				$error+=$info[1];
				$deta.=$info[2];

				
			}
			
			}
		}
	}

}	
	
	//Resto de subcapertas a partir de raiz

	foreach ($lineas as $d => $listado) {//recorre

		$raiz=explode("/",$lineas[$d]);
		if(is_dir(trim($lineas[$d])."/")){//comprueba si es
		$ficheros =@scandir(trim($lineas[$d]));

	for($i=0;$i<@count($ficheros);$i++){//recorre
		
		if(strpos($ficheros[$i],".") and !is_dir($ficheros[$i])){//comprueba si es
			$ext = (explode('.',$ficheros[$i])); 
			$ext = strtolower($ext[count($ext)-1]);
	
			
			if($ext=="php"){//comprueba si es
				$texto=@file_get_contents(trim($lineas[$d]) . "/" . trim($ficheros[$i]));		
				$texto=trim($texto);				
				$info=comprobarFunciones(trim($lineas[$d]). "/" .$ficheros[$i]);

				$total+=$info[0];
				$error+=$info[1];
				$deta.=$info[2];
				
			}
			if($ext == "html" || $ext =="htm")  { ///comprueba si es
				$texto=@file_get_contents(trim($lineas[$d]) . "/" . trim($ficheros[$i]));
				$texto=trim($texto);
		
			}
			if($ext == "css"){ //comprueba si es
				$texto=@file_get_contents(trim($lineas[$d]) . "/" . trim($ficheros[$i]));
				$texto=trim($texto);

			}
			if($ext == "js"){ //comprueba si es
				$texto=@file_get_contents(trim($lineas[$d]). "/" . trim($ficheros[$i]));
				$texto=trim($texto);
				$info=comprobarFunciones(trim($lineas[$d]) . "/" .$ficheros[$i]);

				$total+=$info[0];
				$error+=$info[1];
				$deta.=$info[2];
				

			}
			
				}
			}
		}
		$GLOBALS["resumen"]["4"]= "<p class='error'>".$total. " Elementos analizados / Numero de errores: " . $error."</p>";
			$GLOBALS["detalle"]["4"]="DETALLE<br><table>".$deta."</table>";
	}






}


//Enlace al apartado 5 variables js y php
Buscar1();
function Buscar1(){


	$patron1="/^\<\?(php)[[:space:]]*(\n)*\/\*/";

	$patron2="/^\<\?(php)[[:space:]]*(\n)*\/\//";
	//Sirve para ficheros html o php
	$patron3="/^[[:space:]]*\<!--/";

	$nombre_fichero="Directories.conf";
	$det="";
	$gestor = @fopen($nombre_fichero, "r");
	$contenido = @fread($gestor, @filesize($nombre_fichero));
	@fclose($gestor);
	$total=0;//Acumula las funciones evaluadas
	$error=0;//Acumula las funciones con error
	$deta="";//Acumula los detalles
	$totaltotal=0;
	$lineas=explode("\n", $contenido);
	//para el primer nivel
	$info=array();
	$raiz=explode("/",$lineas[0]);
	
	if(is_dir($raiz[0])){//comprueba si es
	$ficheros  =@scandir($raiz[0]);


	for($i=0;$i<@count($ficheros);$i++){//recorre


		if($ficheros[$i]=="index.php"){//comprueba si es

		if(strpos($ficheros[$i],".") and !is_dir($ficheros[$i])){//comprueba si es
			$puntos=(explode('.',$ficheros[$i]));
			$ext = strtolower($puntos[count($puntos)-1]);

			if($ext=="php"){//comprueba si es
				$texto=@file_get_contents(trim($raiz[0]) . "/" . trim($ficheros[$i]));
				$texto=trim($texto);

				$info=comprobar_variables_php(trim($raiz[0]) . "/" .$ficheros[$i]);
				
				//$total+=$info[0];
				$error+=$info[1];
				$deta.=$info[2];			
				$totaltotal++;
				}
			
			}
		}
	}

}	
	
	//Resto de subcapertas a partir de raiz

	foreach ($lineas as $d => $listado) {//recorre
		$raiz=explode("/",$lineas[$d]);
		if(is_dir(trim($lineas[$d])."/")){//comprueba si es
		$ficheros =@scandir(trim($lineas[$d]));

	for($i=0;$i<@count($ficheros);$i++){//recorre

		if(strpos($ficheros[$i],".") and !is_dir($ficheros[$i])){//comprueba si es

			$ext = (explode('.',$ficheros[$i])); 
			$ext = strtolower($ext[count($ext)-1]);
	

			
			if($ext=="php"){//comprueba si es
				$texto=@file_get_contents(trim($lineas[$d]) . "/" . trim($ficheros[$i]));		
				$texto=trim($texto);

				$info=comprobar_variables_php(trim($lineas[$d]). "/" .$ficheros[$i]);
				
				//$total+=$info[0];
				$error+=$info[1];
				$deta.=$info[2];
				$totaltotal++;
			}

			if($ext == "js"){ //comprueba si es
				$texto=@file_get_contents(trim($lineas[$d]). "/" . trim($ficheros[$i]));
				$texto=trim($texto);
				$info=comprobar_var_js(trim($lineas[$d]). "/" .$ficheros[$i]);
				
				//$total+=$info[0];
				$error+=$info[1];
				$deta.=$info[2];
				$totaltotal++;
						}
			
			
					
					}
				}
			}
		}
		$GLOBALS["resumen"]["5"]="<p class='error'>".$totaltotal. " Elementos analizados / Numero de errores: " . $error."</p>";
		$GLOBALS["detalle"]["5"]="DETALLE"."<table>".$deta."</table>";
	}


//Enlace al apartado 6 estructuras
Buscar2();
function Buscar2(){


	$patron1="/^\<\?(php)[[:space:]]*(\n)*\/\*/";

	$patron2="/^\<\?(php)[[:space:]]*(\n)*\/\//";
	//Sirve para ficheros html o php
	$patron3="/^[[:space:]]*\<!--/";

	$nombre_fichero="Directories.conf";
	$det="";
	$gestor = @fopen($nombre_fichero, "r");
	$contenido = @fread($gestor, @filesize($nombre_fichero));
	@fclose($gestor);
	$total=0;/*Acumula las funciones evaluadas********************************/
	$error=0;/* Acumula las funciones con error********************************/
	$deta="";/**Acumula los detalles*******************************************/
	$totaltotal=0;
	$lineas=explode("\n", $contenido);
	//para el primer nivel

	$raiz=explode("/",$lineas[0]);
	$info=array();
	if(is_dir($raiz[0])){//comprueba si es
	$ficheros  =@scandir($raiz[0]);




	for($i=0;$i<@count($ficheros);$i++){	//recorre

		if($ficheros[$i]=="index.php"){//comprueba si es

		if(strpos($ficheros[$i],".") and !is_dir($ficheros[$i])){//comprueba si es
			$puntos=(explode('.',$ficheros[$i]));
			$ext = strtolower($puntos[count($puntos)-1]);

	
			if($ext=="php"){//comprueba si es
				$texto=@file_get_contents(trim($raiz[0]) . "/" . trim($ficheros[$i]));
				$texto=trim($texto);
				$info=comprobar_estructuras(trim($raiz[0]) . "/" .$ficheros[$i]); 
				
				//$total+=$info[0];
				$error+=$info[1];
				$deta.=$info[2];
				$totaltotal++;
				}
					
			
			}
		}
	}

}	
	
	//Resto de subcapertas a partir de raiz

	foreach ($lineas as $d => $listado) {//recorre
		$raiz=explode("/",$lineas[$d]);
		if(is_dir(trim($lineas[$d])."/")){//comprueba si es
		$ficheros =@scandir(trim($lineas[$d]));

	for($i=0;$i<@count($ficheros);$i++){//recorre

		if(strpos($ficheros[$i],".") and !is_dir($ficheros[$i])){//comprueba si es

			$ext = (explode('.',$ficheros[$i])); 
			$ext = strtolower($ext[count($ext)-1]);
	
	
			if($ext=="php"){//comprueba si es

				$texto=@file_get_contents(trim($lineas[$d]) . "/" . trim($ficheros[$i]));		
				$texto=trim($texto);
				$info=comprobar_estructuras(trim($lineas[$d]). "/" .$ficheros[$i]); 
				
				//$total+=$info[0];
				$error+=$info[1];
				$deta.=$info[2];
				$totaltotal++;
			}
			if($ext == "js"){ //comprueba si es
				$texto=@file_get_contents(trim($lineas[$d]). "/" . trim($ficheros[$i]));
				$texto=trim($texto);
				$info=comprobar_estructuras(trim($lineas[$d]). "/" .$ficheros[$i]); 
	
				//$total+=$info[0];
				$error+=$info[1];
				$deta.=$info[2];
				$totaltotal++;
					}
				}
				
			}

		}
	}
	$GLOBALS["resumen"]["6"]="<p class='error'>".$totaltotal. " Elementos analizados / Numero de errores: " . $error."</p>";
	$GLOBALS["detalle"]["6"]="DETALLE"."<br><table>".$deta."</table><br>";
}


//Enlace al apartado 7 ---falta MODEL son clases 
Buscar3();
function Buscar3(){


	$patron1="/^\<\?(php)[[:space:]]*(\n)*\/\*/";

	$patron2="/^\<\?(php)[[:space:]]*(\n)*\/\//";
	//Sirve para ficheros html o php
	$patron3="/^[[:space:]]*\<!--/";

	$nombre_fichero="Directories.conf";
	$det="";
	$gestor = @fopen($nombre_fichero, "r");
	$contenido = @fread($gestor, @filesize($nombre_fichero));
	@fclose($gestor);
	$total=0;/* Acumula las funciones evaluadas********************************/
	$error=0;/* Acumula las funciones con error********************************/
	$deta="";/*Acumula los detalles*******************************************/
	
	$lineas=explode("\n", $contenido);
	//para el primer nivel

	$raiz=explode("/",$lineas[0]);
	$info=array();

	foreach ($lineas as $d => $listado) {//recorre
		$raiz=explode("/",$lineas[$d]);
		if(is_dir(trim($lineas[$d])."/")){//comprueba si es
		$ficheros =@scandir(trim($lineas[$d]));

	if(preg_match("/[A-Za-z]+\/Model/",$lineas[$d])){//comprueba si es 

	for($i=0;$i<@count($ficheros);$i++){//recorre

		if(strpos($ficheros[$i],".") and !is_dir($ficheros[$i])){//comprueba si es
	
			$ext = (explode('.',$ficheros[$i])); 
			$ext = strtolower($ext[count($ext)-1]);
	

			if($ext=="php"){//comprueba si es
				$texto=@file_get_contents(trim($lineas[$d]) . "/" . trim($ficheros[$i]));		
				$texto=trim($texto);
				$info=comprobar_clases(trim($lineas[$d]) . "/" .trim($ficheros[$i]));

				$total++;
				$error+=$info[0];
				$deta.=$info[1];
				
			}
			
					}
				}
			}
		}
	}
	$GLOBALS["resumen"]["7"]="<p class='error'>".$total. " Elementos analizados / Numero de errores: " . $error."</p>";
	$GLOBALS["detalle"]["7"]="DETALLE"."<br><table>".$deta."</table><br>";
}


//Enlace al apartado 8 Controller scripts php
Buscar4();
function Buscar4(){


	$patron1="/^\<\?(php)[[:space:]]*(\n)*\/\*/";

	$patron2="/^\<\?(php)[[:space:]]*(\n)*\/\//";
	//Sirve para ficheros html o php
	$patron3="/^[[:space:]]*\<!--/";

	$nombre_fichero="Directories.conf";
	$det="";
	$gestor = @fopen($nombre_fichero, "r");
	$contenido = @fread($gestor, @filesize($nombre_fichero));
	@fclose($gestor);
	$total=0;/* Acumula las funciones evaluadas********************************/
	$error=0;/*Acumula las funciones con error********************************/
	$deta="";/* Acumula los detalles*******************************************/
	
	$lineas=explode("\n", $contenido);
	//para el primer nivel
	$info=array();
	$raiz=explode("/",$lineas[0]);
	

	foreach ($lineas as $d => $listado) {//recorre
		$raiz=explode("/",$lineas[$d]);
		if(is_dir(trim($lineas[$d])."/")){//comprueba si es
		$ficheros =@scandir(trim($lineas[$d]));

	if(preg_match("/[A-Za-z]+\/Controller/",$lineas[$d])){

	for($i=0;$i<@count($ficheros);$i++){//recorre

		

		if(strpos($ficheros[$i],".") and !is_dir($ficheros[$i])){//comprueba si es
		
			$ext = (explode('.',$ficheros[$i])); 
			$ext = strtolower($ext[count($ext)-1]);
	

			if($ext=="php"){//comprueba si es

				$texto=@file_get_contents(trim($lineas[$d]) . "/" . trim($ficheros[$i]));		
				$texto=trim($texto);

				$info=comprobar_script_php(trim($lineas[$d]) . "/" .trim($ficheros[$i]));

				$total++;
				$error+=$info[0];
				$deta.=$info[1];
			}
							
						}
					}
				}
			}
		}
		$GLOBALS["resumen"]["8"]="<p class='error'>".$total. " Elementos analizados / Numero de errores: " . $error."</p>";
		$GLOBALS["detalle"]["8"]="DETALLE"."<br><table>".$deta."</table><br>";
	}


//Enlace al apartado 9 View clases js
Buscar5();
function Buscar5(){


	$patron1="/^\<\?(php)[[:space:]]*(\n)*\/\*/";

	$patron2="/^\<\?(php)[[:space:]]*(\n)*\/\//";
	//Sirve para ficheros html o php
	$patron3="/^[[:space:]]*\<!--/";

	$nombre_fichero="Directories.conf";
	$det="";
	$gestor = @fopen($nombre_fichero, "r");
	$contenido = @fread($gestor, @filesize($nombre_fichero));
	@fclose($gestor);
	$total=0;/**Acumula las funciones evaluadas********************************/
	$error=0;/*Acumula las funciones con error********************************/
	$deta="";/*Acumula los detalles*******************************************/
	
	$info=array();
	$info2=array();
	$lineas=explode("\n", $contenido);
	
//para el primer nivel
	$raiz=explode("/",$lineas[0]);

	foreach ($lineas as $d => $listado) {//recorre
		$raiz=explode("/",$lineas[$d]);
		if(is_dir(trim($lineas[$d])."/")){//comprueba si es
		$ficheros =@scandir(trim($lineas[$d]));


if(preg_match("/[A-Za-z]+\/View/",$lineas[$d])){//comprueba si es

	for($i=0;$i<@count($ficheros);$i++){//recorre

		
		if(strpos($ficheros[$i],".") and !is_dir($ficheros[$i])){//comprueba si es

			$ext = (explode('.',$ficheros[$i])); 
			$ext = strtolower($ext[count($ext)-1]);
	

			
			if($ext=="php"){//comprueba si es

				$texto=@file_get_contents(trim($lineas[$d]) . "/" . trim($ficheros[$i]));		
				$texto=trim($texto);

				$info=comprobar_clases(trim($lineas[$d]) . "/" . trim($ficheros[$i]));

					$total++;
					$error+=$info[0];
					$deta.=$info[1];
					}

				}


				}
			}
		}
	}

				$GLOBALS["resumen"]["9"]="<p class='error'>".$total. " Elementos analizados / Numero de errores: " . $error."</p>";
				$GLOBALS["detalle"]["9"]="DETALLE"."<br><table>".$deta."</table><br>";

}


//4
//comprobarFunciones("./CodigoAExaminar/View/js/validaciones.js");

function comprobarFunciones($nombre_fichero){



		$patron1='/(\n)[[:space:]]*\/\*[^\n]*\*\/[[:space:]]*[ \t]*function/'; //Comentario de forma /* ... */ justo antes de una funcion
		$patron2='/[[:space:]]*\/\/[^\n]*[ \t]*(\n)+[ \t]*function/'; //Comentario de la forma //... justo antes de la funcion
		$patron3='/[[:space:]]*\/\*[^\n]*(\n[^\n|^(\*\/)]*[[:space:]]*)+(\*\/)[[:space:]]*[ \t]*function/'; //Comentario de forma /* ... */ de varias linea justo antes de una funcion
		$patronFunciones='/\n[[:space:]]*function[ ]*[^(]*/'; //Patron para buscar todas las funciones del fichero
		
		$numTotal=0;
		$numComentadas=0;
		
		$texto_fichero=@file_get_contents($nombre_fichero); //Volcar contenido del fichero en una variable

		$detalle="";	
		

		$num_lineas_nombre=array();
		$num_lineas_nombre2=array();


		///General
		$num_lineas_nombre=(numero_linea_nombre($patronFunciones, $texto_fichero));			
		$numTotal=@count($num_lineas_nombre);		

		//si existe resta

		$num_lineas_nombre2=(numero_linea_nombre($patron1, $texto_fichero));			
		$numComentadas=$numComentadas+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)!=0)
		$num_lineas_nombre=array_diff_key($num_lineas_nombre,$num_lineas_nombre2);
		
		//2
		$num_lineas_nombre2=(numero_linea_nombre($patron2, $texto_fichero));			
		$numComentadas=$numComentadas+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)!=0)
		$num_lineas_nombre=array_diff_key($num_lineas_nombre,$num_lineas_nombre2);

		//3
		$num_lineas_nombre2=(numero_linea_nombre($patron3, $texto_fichero));			
		$numComentadas=$numComentadas+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)!=0)
		$num_lineas_nombre=array_diff_key($num_lineas_nombre,$num_lineas_nombre2);

		$cont=$numTotal-$numComentadas;



		if(@count($num_lineas_nombre)==0){//comprueba si es
						 $detalle.="<tr><td>".$nombre_fichero ."</td><td> OK</td></tr>";
					}
					else{
						$detalle.= "<tr><td class='error'>" .$nombre_fichero."</td><td class='error'> ERROR </td></tr>";

						$detalle.= "<blockquote>";
						
						foreach ($num_lineas_nombre as $linea => $nombre){//recorre
						
						$detalle.="<tr><td class='error'>".$GLOBALS["tab"] .$nombre." sin comentario de descripcion en la linea"."</td><td class='error'>". $linea ."</td></tr>";
						
						$detalle.= "</blockquote>";
					}
					}
	



				$info[0]=$numTotal;
				$info[1]= $cont;
				$info[2]=$detalle;
			
				return $info;

	}








//5
	
	//comprobar_var_js("CodigoAExaminar/View/js/Validaciones.js");
	function comprobar_var_js($nombre_fichero){

		
		//Comentario de forma /* ... */ justo antes de una variable
		$patron1="/^[[:space:]]*[^var ]*\/\*[^\n]*\*\/[[:space:]]*var /m"; 
		//Comentario de forma /* ... */ de varias lineas justo antes de una variable
		$patron1varias="/^[[:space:]]*[^var ]*([a-zA-Z0-9_ \t]*\/\*)[^\n]*\n[^\n]*\*\/[[:space:]]*var /m"; 
		//Comentario de la forma //... justo antes de la variable
		$patron2="/^[ \t]*\/\/.*\n[ \t]*var /m";
		//Comentario de la forma //... en la misma linea de la variable 
		$patron3="/^[ \t]*var [^\n]*\/\//m";
		//Comentario de la forma /*... */ en la misma linea de la variable 
		$patron4="/^[ \t]*var [^\n]*\/\*/m"; 
		
		 //Patron para buscar todas las variables del fichero
		$patronVariables="/var [^\n;]*/";




	//numero total de variables existentes
	$numTotal=0;

	//numero de variables comentadas
	$numComentadas=0;

	//Volcar el contenido del fichero en la variable texto_fichero
	$texto_fichero=@file_get_contents($nombre_fichero);

	$detalle="";

	//Cuenta todas
	$num_lineas_nombre=(numero_linea_nombre($patronVariables, $texto_fichero));
	$numTotal=@count($num_lineas_nombre);

	//Comrpueba y si existe resta
	$num_lineas_nombre2=(numero_linea_nombre($patron1, $texto_fichero));			
	$n=@count($num_lineas_nombre2);
	$numComentadas=$numComentadas + $n;

//comprueba si es
	if($n>0)
	$num_lineas_nombre=array_diff_key($num_lineas_nombre,$num_lineas_nombre2);


		//Comrpueba y si existe resta	
	$num_lineas_nombre2=(numero_linea_nombre($patron1varias, $texto_fichero));				
	$n=@count($num_lineas_nombre2);
	$numComentadas=$numComentadas + $n;
//comprueba si es
	if($n>0)
	$num_lineas_nombre=array_diff_key($num_lineas_nombre,$num_lineas_nombre2);


	
	//Comrpueba y si existe resta
	$num_lineas_nombre2=(numero_linea_nombre($patron2, $texto_fichero));				
	$n=@count($num_lineas_nombre2);
	$numComentadas=$numComentadas + $n;
	//comprueba si es	
	if($n>0)
	$num_lineas_nombre=array_diff_key($num_lineas_nombre,$num_lineas_nombre2);


	//Comrpueba y si existe resta
	$num_lineas_nombre2=(numero_linea_nombre($patron3, $texto_fichero));				
	$n=@count($num_lineas_nombre2);
	$numComentadas=$numComentadas + $n;
	//comprueba si es	
	if($n>0)
	$num_lineas_nombre=array_diff_key($num_lineas_nombre,$num_lineas_nombre2);

	//Comrpueba y si existe resta
	$num_lineas_nombre2=(numero_linea_nombre($patron4, $texto_fichero));				
	$n=@count($num_lineas_nombre2);
	$numComentadas=$numComentadas + $n;
	//comprueba si es	
	if($n>0)
	$num_lineas_nombre=array_diff_key($num_lineas_nombre,$num_lineas_nombre2);

	
		$cont=@count($num_lineas_nombre);


			if($numTotal==$cont){//comprueba si es
				
				 $detalle.="<tr><td>".$nombre_fichero ."</td><td> OK</td></tr>";
			}
			else{
				$detalle.= "<tr><td class='error'>" .$nombre_fichero."</td><td class='error'> ERROR </td></tr>";

						$detalle.= "<blockquote>";
						
						foreach ($num_lineas_nombre as $linea => $nombre){//recorre
						
						$detalle.="<tr><td class='error'>" .$GLOBALS["tab"].$nombre." sin comentario de descripcion en la linea"."</td><td class='error'>". $linea ."</td></tr>";
						
						$detalle.= "</blockquote>";
					}
			}


				$info=array();

				
				$info[0]=$numTotal;
				$info[1]= $cont;
				$info[2]=$detalle;
			
				return $info;
}



	//echo "======================================================================================<br>";
	//comprobar_variables_php("./prueba.php");//OKKKKKKK

	function comprobar_variables_php($nombre_fichero){


		//Comentario de forma /* ... */ justo antes de una variable
		$patron1='/^[[:space:]]*\/\*[^\n]*\*\/[[:space:]]*\$[_a-zA-Z][0-9a-zA-Z_]*/m'; 
		//Comentario de forma /* ... */ de varias lineas justo antes de una variable
		$patron1varias='/^[[:space:]]*\/\*[^\n]*[[:space:]]*\n[^\n]*\*\/[[:space:]]*\$[_a-zA-Z][0-9a-zA-Z_]*/m'; 
		//Comentario de la forma //... justo antes de la variable
		$patron2='/^[ \t]*\/\/[^\n]*[[:space:]]*\$[_a-zA-Z][0-9a-zA-Z_]*/m';
		//Comentario de la forma //... en la misma linea de la variable 
		$patron3='/^[[:space:]]*\$[_a-zA-Z][0-9a-zA-Z_]*[^\n]*\/\//m'; 
		//Comentario de la forma /*... */ en la misma linea de la variable 
		$patron4='/^[[:space:]]*\$[_a-zA-Z][0-9a-zA-Z_]*[^\n]*\/\*/m'; 
		
		//Patron para buscar todas las variables del fichero
		$patronVariables='/\$[_a-zA-Z][0-9a-zA-Z_]*/'; 


		$patron1var='/^[[:space:]]*\/\*[^\n]*\*\/[[:space:]]*var \$[_a-zA-Z][0-9a-zA-Z_]*/m'; //Comentario de forma /* ... */ de 1 linea justo antes de una variable
		$patron1private='/^[[:space:]]*\/\*[^\n]*\*\/[[:space:]]*private \$[_a-zA-Z][0-9a-zA-Z_]*/m'; //Comentario de forma /* ... */ de 1 linea justo antes de una variable
		$patron1public='/^[[:space:]]*\/\*[^\n]*\*\/[[:space:]]*public \$[_a-zA-Z][0-9a-zA-Z_]*/m'; //Comentario de forma /* ... */ de 1 linea justo antes de una variable
		$patron1protected='/^[[:space:]]*\/\*[^\n]*\*\/[[:space:]]*protected \$[_a-zA-Z][0-9a-zA-Z_]*/m'; //Comentario de forma /* ... */ de 1 linea justo antes de una variable

		$patronVariablesVar='/var \$[_a-zA-Z][0-9a-zA-Z_]*/'; //Patron para buscar todas las variables declaradas con var en el fichero
		$patronVariablesPrivate='/private \$[_a-zA-Z][0-9a-zA-Z_]*/'; //Patron para buscar todas las variables declaradas con private en el fichero	
		$patronVariablesProtected='/protected \$[_a-zA-Z][0-9a-zA-Z_]*/'; //Patron para buscar todas las variables declaradas con protected en el fichero	
		$patronVariablesPublic='/public \$[_a-zA-Z][0-9a-zA-Z_]*/'; //Patron para buscar todas las variables declaradas con public en el fichero	
	


		$excepciones=array('$GLOBALS','$_SERVER','$_GET','$_POST','$_FILES','$_COOKIE','$_SESSION','$_REQUEST','$_ENV');//excepciones
		
		//contador
		$numTotal=0;
		//contador
		$numComentadas=0;		
		
		//Volcar contenido de fich en una variable
		$texto_fichero=@file_get_contents($nombre_fichero); 
		
		//array para guardar los errores
		$numLineasFunc=array();
		//array para guardar los errores
		$numLineasFunc1=array();
		//array para guardar los errores
		$numLineasFunc2=array();
		//array para guardar los errores
		$numLineasFunc3=array();
		//array para guardar los errores
		$numLineasFunc4=array();
		//array para guardar temporalmente
		$numLineaCom=array();


		//patron Variables
		$numLineasFunc=(numero_linea_nombre($patronVariables, $texto_fichero));	

		$variables=array();//Array para variables sin repetir
		if($numLineasFunc){//comprueba si es
		foreach($numLineasFunc as $i => $valor){//recorre
			//comprueba si es
			if(!array_search($valor,$excepciones) && !array_search($valor,$variables))
			$variables[$i]=$valor;
		}	
		}		
		$numTotal=@count($variables);		
		$numLineasFunc=$variables;
			
		

		//patron1

		$numLineaCom=(numero_linea_nombre($patron1, $texto_fichero));		
		$distintas=array();
	
		if($numLineaCom){//comprueba si es
		foreach($numLineaCom as $j => $valor){//recorre
			//comprueba si es
			if(!array_search($valor,$excepciones) && !array_search($valor,$distintas))
				$distintas[$j]=$valor;			
		}
	}
		$n=@count($distintas);
		$numComentadas=$numComentadas + $n;
		$numLineaCom=$distintas;
		$numLineasFunc=array_diff_key($numLineasFunc,$numLineaCom);



		//patron 1 varias
		$numLineaCom=(numero_linea_nombre($patron1varias, $texto_fichero));		
		$distintas=array();
		if($numLineaCom){//comprueba si es
		foreach($numLineaCom as $j => $valor){//recorre
			//comprueba si es
			if(!array_search($valor,$excepciones) && !array_search($valor,$distintas))
				$distintas[$j]=$valor;			
		}
	}
		$n=@count($distintas);
		$numComentadas=$numComentadas + $n;
		$numLineaCom=$distintas;
		$numLineasFunc=array_diff_key($numLineasFunc,$numLineaCom);



		$numLineaCom=(numero_linea_nombre($patron2, $texto_fichero));		
		$distintas=array();
		if($numLineaCom){//comprueba si es
		foreach($numLineaCom as $j => $valor){//recorre
			//comprueba si es
			if(!array_search($valor,$excepciones) && !array_search($valor,$distintas))
				$distintas[$j]=$valor;			
		}
	}
		$n=@count($distintas);
		$numComentadas=$numComentadas + $n;
		$numLineaCom=$distintas;
		$numLineasFunc=array_diff_key($numLineasFunc,$numLineaCom);



		$numLineaCom=(numero_linea_nombre($patron3, $texto_fichero));		
		$distintas=array();
		if($numLineaCom){//comprueba si es
		foreach($numLineaCom as $j => $valor){//recorre
			//comprueba si es
			if(!array_search($valor,$excepciones) && !array_search($valor,$distintas))
				$distintas[$j]=$valor;			
		}
	}
		$n=@count($distintas);
		$numComentadas=$numComentadas + $n;
		$numLineaCom=$distintas;
		$numLineasFunc=array_diff_key($numLineasFunc,$numLineaCom);

		
		$numLineaCom=(numero_linea_nombre($patron4, $texto_fichero));		
		$distintas=array();
		if($numLineaCom){//comprueba si es
		foreach($numLineaCom as $j => $valor){//recorre
			//comprueba si es
			if(!array_search($valor,$excepciones) && !array_search($valor,$distintas))
				$distintas[$j]=$valor;			
		}
	}
		$n=@count($distintas);
		$numComentadas=$numComentadas + $n;
		$numLineaCom=$distintas;
		$numLineasFunc=array_diff_key($numLineasFunc,$numLineaCom);

		//--

		//patron general de var
		$numLineasFunc1=(numero_linea_nombre($patronVariablesVar, $texto_fichero));			
		$variables=array();//Array para variables sin repetir
		if($numLineasFunc1){//comprueba si es
		foreach($numLineasFunc1 as $i => $valor){//recorre
			//comprueba si es
			if(!array_search($valor,$excepciones) && !array_search($valor,$variables))
			$variables[$i]=$valor;
		}
	}			
		$numTotal=$numTotal+@count($variables);
			$numLineasFunc1=$variables;

		
		//patron1 de var

		$numLineaCom=(numero_linea_nombre($patron1var, $texto_fichero));		
		$distintas=array();
		if($numLineaCom){//comprueba si es
		foreach($numLineaCom as $j => $valor){//recorre
			//comprueba si es
			if(!array_search($valor,$excepciones) && !array_search($valor,$distintas))
				$distintas[$j]=$valor;			
		}
	}
		$n=@count($distintas);
		$numComentadas=$numComentadas + $n;
		$numLineaCom=$distintas;
		
		$numLineasFunc1=array_diff_key($numLineasFunc1,$numLineaCom);
		//para restar los var de la funciion que tiene los $ (por que siempre los va coger)
		$numLineasFunc=array_diff_key($numLineasFunc,$numLineaCom);



		//patron general de private
		$numLineasFunc2=(numero_linea_nombre($patronVariablesPrivate, $texto_fichero));			
		$variables=array();//Array para variables sin repetir
		if($numLineasFunc2){//comprueba si es
		foreach($numLineasFunc2 as $i => $valor){//recorre
			//comprueba si es
			if(!array_search($valor,$excepciones) && !array_search($valor,$variables))
			$variables[$i]=$valor;
		}	
	}		
		$numTotal=$numTotal+@count($variables);
		$numLineasFunc2=$variables;

		

		//patron1 de private

		$numLineaCom=(numero_linea_nombre($patron1private, $texto_fichero));		
		$distintas=array();
		if($numLineaCom){//comprueba si es
			
		foreach($numLineaCom as $j => $valor){//recorre
			//comprueba si es
			if(!array_search($valor,$excepciones) && !array_search($valor,$distintas))
				$distintas[$j]=$valor;			
		}
	}
		$n=@count($distintas);
		$numComentadas=$numComentadas + $n;
		$numLineaCom=$distintas;
		$numLineasFunc2=array_diff_key($numLineasFunc2,$numLineaCom);
		//para restar los var  de la funciion que tiene los $ (por que siempre los va coger)
		$numLineasFunc=array_diff_key($numLineasFunc,$numLineaCom);


		
		//patron general de protected
		$numLineasFunc3=(numero_linea_nombre($patronVariablesProtected, $texto_fichero));			
		$variables=array();//Array para variables sin repetir
		if($numLineasFunc3){//comprueba si es
		foreach($numLineasFunc3 as $i => $valor){//recorre
			//comprueba si es
			if(!array_search($valor,$excepciones) && !array_search($valor,$variables))
			$variables[$i]=$valor;
		}
	}			
		$numTotal=$numTotal+@count($variables);
		$numLineasFunc3=$variables;

	

		//patron1 de protected

		$numLineaCom=(numero_linea_nombre($patron1protected, $texto_fichero));		
		$distintas=array();
		if($numLineaCom){//comprueba si es
		foreach($numLineaCom as $j => $valor){//recorre
			//comprueba si es
			if(!array_search($valor,$excepciones) && !array_search($valor,$distintas))
				$distintas[$j]=$valor;			
		}
	}
		$n=@count($distintas);
		$numComentadas=$numComentadas + $n;
		$numLineaCom=$distintas;
		$numLineasFunc3=array_diff_key($numLineasFunc3,$numLineaCom);
		//para restar los var  de la funciion que tiene los $ (por que siempre los va coger)
		$numLineasFunc=array_diff_key($numLineasFunc,$numLineaCom);



		//patron general de public
		$numLineasFunc4=(numero_linea_nombre($patronVariablesPublic, $texto_fichero));			
		$variables=array();//Array para variables sin repetir
		if($numLineasFunc4){//comprueba si es
		foreach($numLineasFunc4 as $i => $valor){//recorre
			//comprueba si es
			if(!array_search($valor,$excepciones) && !array_search($valor,$variables))
			$variables[$i]=$valor;
		}
	}		
		$numTotal=$numTotal+@count($variables);
		$numLineasFunc4=$variables;



		//patron1 de public

		$numLineaCom=(numero_linea_nombre($patron1public, $texto_fichero));		
		$distintas=array();
		if($numLineaCom){//comprueba si es
		foreach($numLineaCom as $j => $valor){//recorre
			//comprueba si es
			if(!array_search($valor,$excepciones) && !array_search($valor,$distintas))
				$distintas[$j]=$valor;			
		}
	}
		$n=@count($distintas);
		$numComentadas=$numComentadas + $n;
		$numLineaCom=$distintas;
		$numLineasFunc4=array_diff_key($numLineasFunc4,$numLineaCom);
		//para restar los var  de la funciion que tiene los $ (por que siempre los va coger)
		$numLineasFunc=array_diff_key($numLineasFunc,$numLineaCom);


	
		$resumen="";
		$detalle="";
					

						foreach ($numLineasFunc1 as $numNom => $nombre) {//recorre
							$numLineasFunc[$numNom]=$nombre;		
						}	

						foreach ($numLineasFunc2 as $numNom => $nombre) {//recorre
							$numLineasFunc[$numNom]=$nombre;					
						}//recorre
						foreach ($numLineasFunc3 as $numNom => $nombre) {//recorre
							$numLineasFunc[$numNom]=$nombre;	
						}
						foreach ($numLineasFunc4 as $numNom => $nombre) {//recorre
							$numLineasFunc[$numNom]=$nombre;
						}		

					if(@count($numLineasFunc)==0){//comprueba si es
						 $detalle.="<tr><td>".$nombre_fichero ."</td><td> OK</td></tr>";
					}
					else{
						$detalle.= "<tr><td class='error'>" .$nombre_fichero."</td><td class='error'> ERROR </td></tr>";

						$detalle.= "<blockquote>";
						
						foreach ($numLineasFunc as $linea => $nombre){//recorre
						
						$detalle.="<tr><td class='error'>".$GLOBALS["tab"] .$nombre." sin comentario de descripcion en la linea"."</td><td class='error'>". $linea ."</td></tr>";
						$detalle.= "</blockquote>";
						 }
						
					}	


				$info=array();

				$info[0]=$numTotal;
				$info[1]= @count($numLineasFunc);
				$info[2]=$detalle;
			
				return $info;

	}


//6

//echo "======================================================<br>";
//comprobar_estructuras("index.php");

function comprobar_estructuras($nombre_fichero){

//PATRONES SEGUN ESTRUCTURA

		//IF**********************************************

		$patron_If_Comentado1='/(\n)[[:space:]]*\/\*[^\n]*\*\/[[:space:]]*[ \t]*if/'; //Comentario de forma /* ... */ de 1 linea justo antes de un if
		$patron_If_Comentado2='/[[:space:]]*\/\*[^\n]*(\n[^\n|^(\*\/)]*[[:space:]]*)+(\*\/)[[:space:]]*[ \t]*if/'; //Comentario de forma /* ... */ de varias linea justo antes de un if
		$patron_If_Comentado3='/[[:space:]]*\/\/[^\n]*[ \t]*(\n)+[ \t]*if/'; //Comentario de forma //  justo antes de un if
		$patron_If_Comentado4='/\n[ \t]*if[^\n]*\/\/[^\n]*/'; //Comentario de forma //  en la misma linea del if
		$patron_If_Comentado5='/\n[ \t]*if[^\n]*\/\*[^\n]*/'; //Comentario de forma /*  en la misma linea del if
		$patron_Ifs='/\n[[:space:]]*if[ (]/'; //If
		


		//SWITCH*****************************************************

		$patron_Switch_Comentado1='/(\n)[[:space:]]*\/\*[^\n]*\*\/[[:space:]]*[ \t]*switch/'; //Comentario de forma /* ... */ de 1 linea justo antes de un Switch
		$patron_Switch_Comentado2='/[[:space:]]*\/\*[^\n]*(\n[^\n|^(\*\/)]*[[:space:]]*)+\*\/[[:space:]]*[ \t]*switch/'; //Comentario de forma /* ... */ de varias linea justo antes de un switch	
		$patron_Switch_Comentado3='/[[:space:]]*\/\/[^\n]*[ \t]*(\n)+[ \t]*switch/'; //Comentario de forma // de 1 linea justo antes de un Switch	
		$patron_Switch_Comentado4='/\n[ \t]*switch[^\n]*\/\/[^\n]*/'; //Comentario de forma //  en la misma linea del switch
		$patron_Switch_Comentado5='/\n[ \t]*switch[^\n]*\/\*[^\n]*/'; //Comentario de forma /*  en la misma linea del switch		
		$patron_Switchs='/\n[[:space:]]*switch[ ]*\(/'; //Switch
		


		//FOR*********************************************************

		//Comentario de forma /* ... */ justo antes de un for
		$patron_For_Comentado1='/(\n)[[:space:]]*\/\*[^\n]*\*\/[[:space:]]*[ \t]*for[ (]/';
		//Comentario de forma /* ... */ de varias linea justo antes de un for
		$patron_For_Comentado2='/[[:space:]]*\/\*[^\n]*\n[^\n]*[[:space:]]*\*\/[[:space:]]*[ \t]*for[ (]/';
		//Comentario de forma // justo antes de un for
		$patron_For_Comentado3='/[[:space:]]*\/\/[^\n]*[ \t]*(\n)*[ \t]*for[ (]/'; 
		//Comentario de forma //  en la misma linea del for
		$patron_For_Comentado4='/\n[ \t]*for[ (][^\n]*\/\/[^\n]*/'; 
		//Comentario de forma /*  en la misma linea del for
		$patron_For_Comentado5='/\n[ \t]*for[ (][^\n]*\/\*[^\n]*/';

		$patron_For='/(\n)*[[:space:]]*for[ (]/'; //for

		//DO*********************************************************

		$patron_Do_Comentado1='/(\n)[[:space:]]*\/\*[^\n]*\*\/[[:space:]]*[ \t]*do\n{0,1}[[:space:]]*\{/'; //Comentario de forma /* ... */ de 1 linea justo antes de un Do
		$patron_Do_Comentado2='/[[:space:]]*\/\*[^\n]*(\n[^\n|^(\*\/)]*[[:space:]]*)+\*\/[[:space:]]*[ \t]*do\n{0,1}[[:space:]]*\{/'; //Comentario de forma /* ... */ de varias linea justo antes de un Do	
		$patron_Do_Comentado3='/[[:space:]]*\/\/[^\n]*[ \t]*(\n)+[ \t]*do\n{0,1}[[:space:]]*\{/'; //Comentario de forma // de 1 linea justo antes de un Do	
		$patron_Do_Comentado4='/\n[ \t]*do[^\n]*\/\/[^\n]*/'; //Comentario de forma //  en la misma linea del Do
		$patron_Do_Comentado5='/\n[ \t]*do[^\n]*\/\*[^\n]*/'; //Comentario de forma /*  en la misma linea del Do		
		$patron_Dos='/\n[ \t]*(do)[ ]*\n{0,1}[[:space:]]*\{/m'; //Do
		


		//WHILE******************************************************


		$patron_While_Comentado1='/(\n)[[:space:]]*\/\*[^\n]*\*\/[[:space:]]*[ \t]*while[ ]*\(/'; //Comentario de forma /* ... */ justo antes de un while
		$patron_While_Comentado2='/[[:space:]]*\/\*[^\n]*(\n[^\n|^(\*\/)]*[[:space:]]*)+\*\/[[:space:]]*[ \t]*while[ ]*\(/'; //Comentario de forma /* ... */ de varias linea justo antes de un while	
		$patron_While_Comentado3='/[[:space:]]*\/\/[^\n]*[ \t]*(\n)+[ \t]*while[ ]*\(/'; //Comentario de forma // justo antes de un while	
		$patron_While_Comentado4='/(\n)+[[:space:]]*while[ (][^\n]*\/\/[^\n]*/'; //Comentario de forma //  en la misma linea del while
		$patron_While_Comentado5='/(\n)+[[:space:]]*while[ (][^\n]*\/\*[^\n]*/'; //Comentario de forma /*  en la misma linea del while
		$patron_Whiles='/[^\}]{0,1}\n[^\}]{0,1}[[:space:]]*[^\}]{0,1}while[ ]*\(/'; //todos los while, incluidos los de los do (luego se restaran)
		


		//FOREACH*****************************************************
		$patron_Foreach_Comentado1='/(\n)[[:space:]]*\/\*[^\n]*\*\/[[:space:]]*[ \t]*foreach[ ]*\(/'; //Comentario de forma /* ... */ de 1 linea justo antes de un Foreach
		$patron_Foreach_Comentado2='/[[:space:]]*\/\*[^\n]*(\n[^\n|^(\*\/)]*[[:space:]]*)+\*\/[[:space:]]*[ \t]*foreach[ ]*\(/'; //Comentario de forma /* ... */ de varias linea justo antes de un Foreach	
		$patron_Foreach_Comentado3='/[[:space:]]*\/\/[^\n]*[ \t]*(\n)+[ \t]*foreach[ ]*\(/'; //Comentario de forma // de 1 linea justo antes de un Foreach	
		$patron_Foreach_Comentado4='/(\n)+[[:space:]]*foreach[ (][^\n]*\/\/[^\n]*/'; //Comentario de forma //  en la misma linea del Foreach
		$patron_Foreach_Comentado5='/(\n)+[[:space:]]*foreach[ (][^\n]*\/\*[^\n]*/'; //Comentario de forma /*  en la misma linea del Foreach		
		$patron_Foreachs='/\n[[:space:]]*[^\}]{0,1}foreach[ ]*\(/'; //todos los Foreach, incluidos los de los do (luego se restaran)
		
		


		
		$numTotalIF=0;//contador	
		$numIfComentados=0;		//contador	
		$numTotalSwitch=0;//contador
			$numSwitchComentados=0;//contador
		$numTotalFor=0;//contador
		 $numForComentados=0;//contador
		$numTotalDo=0;//contador
			$numDoComentados=0;//contador
		$numTotalWhile=0;//contador
		$numWhileComentados=0;//contador
		$numTotalForeach=0;//contador
		 $numForeachComentados=0;//contador

		//Volcar contenido de fich en una variable
		$texto_fichero=@file_get_contents($nombre_fichero); 

		$detalle="";//para el detalle

		$numLineasIf=array();//array para coincidencias
		
		$numLineasSwitch=array();//array para coincidencias
		
		$numLineasFor=array();//array para coincidencias
		
		$numLineasDo=array();//array para coincidencias
		
		$numLineasWhile=array();//array para coincidencias
		
		$numLineasForeach=array();//array para coincidencias
		

		$num_lineas_nombre2=array();//array para coincidencias

		//IFS**********************************************************************

		//patron general 1
		$numLineasIf=numero_linea($patron_Ifs, $texto_fichero);	
		$numTotalIF=@count($numLineasIf);

	
		//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_If_Comentado1, $texto_fichero));			
		$numIfComentados=$numIfComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasIf=array_diff_key($numLineasIf,$num_lineas_nombre2);



		//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_If_Comentado2, $texto_fichero));			
		$numIfComentados=$numIfComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasIf=array_diff_key($numLineasIf,$num_lineas_nombre2);


		//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_If_Comentado3, $texto_fichero));			
		$numIfComentados=$numIfComentados+@count($num_lineas_nombre2);
	//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasIf=array_diff_key($numLineasIf,$num_lineas_nombre2);


		//si existe resta no

		$num_lineas_nombre2=(numero_linea($patron_If_Comentado4, $texto_fichero));			
		$numIfComentados=$numIfComentados+@count($num_lineas_nombre2);
	//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasIf=array_diff_key($numLineasIf,$num_lineas_nombre2);


		//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_If_Comentado5, $texto_fichero));			
		$numIfComentados=$numIfComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasIf=array_diff_key($numLineasIf,$num_lineas_nombre2);

		

			
		
		//SWITCH**********************************************************************************************

		//patron general 1
		$numLineasSwitch=numero_linea($patron_Switchs, $texto_fichero);	
		$numTotalSwitch=@count($numLineasSwitch);

	
		//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_Switch_Comentado1, $texto_fichero));			
		$numSwitchComentados=$numSwitchComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasSwitch=array_diff_key($numLineasSwitch,$num_lineas_nombre2);



		//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_Switch_Comentado2, $texto_fichero));			
		$numSwitchComentados=$numSwitchComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasSwitch=array_diff_key($numLineasSwitch,$num_lineas_nombre2);


		//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_Switch_Comentado3, $texto_fichero));			
		$numSwitchComentados=$numSwitchComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasSwitch=array_diff_key($numLineasSwitch,$num_lineas_nombre2);



		//si existe resta no

		$num_lineas_nombre2=(numero_linea($patron_Switch_Comentado4, $texto_fichero));			
		$numSwitchComentados=$numSwitchComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasSwitch=array_diff_key($numLineasSwitch,$num_lineas_nombre2);



		//si existe resta
		$num_lineas_nombre2=(numero_linea($patron_Switch_Comentado5, $texto_fichero));			
		$numSwitchComentados=$numSwitchComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasSwitch=array_diff_key($numLineasSwitch,$num_lineas_nombre2);


		
		//FOR**********************************************************************************************



		//patron general 1
		$numLineasFor=numero_linea($patron_For, $texto_fichero);	
		$numTotalFor=@count($numLineasFor);

		//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_For_Comentado1, $texto_fichero));			
		$numForComentados=$numForComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasFor=array_diff_key($numLineasFor,$num_lineas_nombre2);

	

	//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_For_Comentado2, $texto_fichero));			
		$numForComentados=$numForComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasFor=array_diff_key($numLineasFor,$num_lineas_nombre2);

	
	//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_For_Comentado3, $texto_fichero));			
		$numForComentados=$numForComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasFor=array_diff_key($numLineasFor,$num_lineas_nombre2);

		
	//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_For_Comentado4, $texto_fichero));			
		$numForComentados=$numForComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasFor=array_diff_key($numLineasFor,$num_lineas_nombre2);

		
	//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_For_Comentado5, $texto_fichero));			
		$numForComentados=$numForComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasFor=array_diff_key($numLineasFor,$num_lineas_nombre2);

		
		
//DO**********************************************************************************************


		//patron general 1
		$numLineasDo=numero_linea($patron_Dos, $texto_fichero);	
		$numTotalDo=@count($numLineasDo);
		//si existe resta
		
		$num_lineas_nombre2=(numero_linea($patron_Do_Comentado1, $texto_fichero));			
		$numDoComentados=$numDoComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasDo=array_diff_key($numLineasDo,$num_lineas_nombre2);


//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_Do_Comentado2, $texto_fichero));			
		$numDoComentados=$numDoComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasDo=array_diff_key($numLineasDo,$num_lineas_nombre2);

	//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_Do_Comentado3, $texto_fichero));			
		$numDoComentados=$numDoComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasDo=array_diff_key($numLineasDo,$num_lineas_nombre2);
	
	//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_Do_Comentado4, $texto_fichero));			
		$numDoComentados=$numDoComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasDo=array_diff_key($numLineasDo,$num_lineas_nombre2);
	
	//si existe resta

		$num_lineas_nombre2=(numero_linea($patron_Do_Comentado5, $texto_fichero));			
		$numDoComentados=$numDoComentados+@count($num_lineas_nombre2);
		//comprueba si es
		if(@count($num_lineas_nombre2)>0)
		$numLineasDo=array_diff_key($numLineasDo,$num_lineas_nombre2);


//WHILE**********************************************************************************************

		//patron general 1
		$numLineasWhile=numero_linea($patron_Whiles, $texto_fichero);	
		$numTotalWhile=@count($numLineasWhile);


			//si existe resta

			$num_lineas_nombre2=(numero_linea($patron_While_Comentado1, $texto_fichero));			
			$numWhileComentados=$numWhileComentados+@count($num_lineas_nombre2);
			//comprueba si es
			if(@count($num_lineas_nombre2)>0)
			$numLineasWhile=array_diff_key($numLineasWhile,$num_lineas_nombre2);


		//si existe resta

			$num_lineas_nombre2=(numero_linea($patron_While_Comentado2, $texto_fichero));			
			$numWhileComentados=$numWhileComentados+@count($num_lineas_nombre2);
			//comprueba si es
			if(@count($num_lineas_nombre2)>0)
			$numLineasWhile=array_diff_key($numLineasWhile,$num_lineas_nombre2);

		//si existe resta

			$num_lineas_nombre2=(numero_linea($patron_While_Comentado3, $texto_fichero));			
			$numWhileComentados=$numWhileComentados+@count($num_lineas_nombre2);
			//comprueba si es
			if(@count($num_lineas_nombre2)>0)
			$numLineasWhile=array_diff_key($numLineasWhile,$num_lineas_nombre2);
	
		//si existe resta

			$num_lineas_nombre2=(numero_linea($patron_While_Comentado4, $texto_fichero));			
			$numWhileComentados=$numWhileComentados+@count($num_lineas_nombre2);
			//comprueba si es
			if(@count($num_lineas_nombre2)>0)
			$numLineasWhile=array_diff_key($numLineasWhile,$num_lineas_nombre2);
		
		//si existe resta

			$num_lineas_nombre2=(numero_linea($patron_While_Comentado5, $texto_fichero));			
			$numWhileComentados=$numWhileComentados+@count($num_lineas_nombre2);
			//comprueba si es
			if(@count($num_lineas_nombre2)>0)
			$numLineasWhile=array_diff_key($numLineasWhile,$num_lineas_nombre2);
	


	//FOREACHS**********************************************************************

			//patron general 1
			$numLineasForeach=numero_linea($patron_Foreachs, $texto_fichero);	
			$numTotalForeach=@count($numLineasForeach);


		
			//si existe resta

			$num_lineas_nombre2=(numero_linea($patron_Foreach_Comentado1, $texto_fichero));			
			$numForeachComentados=$numForeachComentados+@count($num_lineas_nombre2);
			//comprueba si es
			if(@count($num_lineas_nombre2)>0)
			$numLineasForeach=array_diff_key($numLineasForeach,$num_lineas_nombre2);

			//si existe resta

			$num_lineas_nombre2=(numero_linea($patron_Foreach_Comentado2, $texto_fichero));			
			$numForeachComentados=$numForeachComentados+@count($num_lineas_nombre2);
			//comprueba si es
			if(@count($num_lineas_nombre2)>0)
			$numLineasForeach=array_diff_key($numLineasForeach,$num_lineas_nombre2);

			//si existe resta

			$num_lineas_nombre2=(numero_linea($patron_Foreach_Comentado3, $texto_fichero));			
			$numForeachComentados=$numForeachComentados+@count($num_lineas_nombre2);
			//comprueba si es
			if(@count($num_lineas_nombre2)>0)
			$numLineasForeach=array_diff_key($numLineasForeach,$num_lineas_nombre2);

			//si existe resta

			$num_lineas_nombre2=(numero_linea($patron_Foreach_Comentado4, $texto_fichero));			
			$numForeachComentados=$numForeachComentados+@count($num_lineas_nombre2);
			//comprueba si es
			if(@count($num_lineas_nombre2)>0)
			$numLineasForeach=array_diff_key($numLineasForeach,$num_lineas_nombre2);

			//si existe resta

			$num_lineas_nombre2=(numero_linea($patron_Foreach_Comentado5, $texto_fichero));			
			$numForeachComentados=$numForeachComentados+@count($num_lineas_nombre2);
			//comprueba si es
			if(@count($num_lineas_nombre2)>0)
		$numLineasForeach=array_diff_key($numLineasForeach,$num_lineas_nombre2);




		$cont=$numTotalIF-$numIfComentados;
		$cont1=$numTotalSwitch-$numSwitchComentados;
		$cont2=$numTotalDo-$numDoComentados;
		$cont3=$numTotalWhile-$numWhileComentados;
		$cont4=$numTotalFor-$numForComentados;
		$cont5=$numTotalForeach-$numForeachComentados;

		$numTotalTotal=$numTotalIF+$numTotalSwitch+$numTotalFor+$numTotalDo+$numTotalWhile+$numTotalForeach;

		$contTotal= @count($numLineasIf)+@count($numLineasSwitch)+@count($numLineasDo)+@count($numLineasWhile)+@count($numLineasFor)+@count($numLineasForeach);
	





					if($contTotal==0){//comprueba si es
						$detalle.="<tr><td>".$nombre_fichero ."</td><td> OK</td></tr>";
					}else{

						$detalle.="<tr><td>".$nombre_fichero ."</td><td> ERROR</td></tr>";
					}
					if(@count($numLineasIf)>0){//comprueba si es
					
						
						$detalle.= "<blockquote>";
						
						foreach ($numLineasIf as $linea => $nombre){//recorre
						
						$detalle.="<tr><td class='error'>" .$GLOBALS["tab"]."IF "." sin comentario de descripcion en la linea ".$nombre."</td></tr>";
						
						$detalle.= "</blockquote>";
					}
					}


					if(@count($numLineasSwitch)>0){//comprueba si es
					

						$detalle.= "<blockquote>";
						
						foreach ($numLineasSwitch as $linea => $nombre){//recorre
						
						$detalle.="<tr><td class='error'>" .$GLOBALS["tab"]."Switch "." sin comentario de descripcion en la linea ".$nombre."</td></tr>";
						
						$detalle.= "</blockquote>";
					}
					}

					if(@count($numLineasDo)>0){//comprueba si es
					

						$detalle.= "<blockquote>";
						
						foreach ($numLineasDo as $linea => $nombre){//recorre
						
						$detalle.="<tr><td class='error'>" .$GLOBALS["tab"]."DO "." sin comentario de descripcion en la linea ".$nombre."</td></tr>";
						
						$detalle.= "</blockquote>";
					}
					}

					if(@count($numLineasWhile)>0){//comprueba si es
						

						$detalle.= "<blockquote>";
						
						foreach ($numLineasWhile as $linea => $nombre){//recorre
						
						$detalle.="<tr><td class='error'>" .$GLOBALS["tab"]."While "." sin comentario de descripcion en la linea ".$nombre."</td></tr>";
						
						$detalle.= "</blockquote>";
					}
					}

					if(@count($numLineasFor)>0){//comprueba si es


						$detalle.= "<blockquote>";
						
						foreach ($numLineasFor as $linea => $nombre){//recorre
						
						$detalle.="<tr><td class='error'>" .$GLOBALS["tab"]."For "." sin comentario de descripcion en la linea ".$nombre."</td></tr>";
						
						$detalle.= "</blockquote>";
					}
					}

					if(@count($numLineasForeach)>0){//comprueba si es
						

						$detalle.= "<blockquote>";
						
						foreach ($numLineasForeach as $linea => $nombre){//recorre
						
						$detalle.="<tr><td class='error'>" .$GLOBALS["tab"]."Foreach "." sin comentario de descripcion en la linea ".$nombre."</td></tr>";
						
						$detalle.= "</blockquote>";
					}
					}





					$info=array();

				
				$info[0]=$numTotalTotal;
				$info[1]= $contTotal;
				$info[2]=$detalle;
			
				return $info;

}	

//7

//comprobar_clases("CodigoAExaminar/Accion_ADD.php");

function comprobar_clases($nombre_fichero){

		$patron_fin_class='/}[[:space:]]*(\?\>)$/m';
		$patron_clase='/(\n)+[[:space:]]*(public)?class /m';
		
		
		$texto_fichero=@file_get_contents($nombre_fichero); //Volcar contenido de fich en vble
		
		
		$error=0;
		$matriz_coincidencias=0;
		$matriz_coincidencias1=0;
		$detalle="";

		if(preg_match_all($patron_clase,$texto_fichero,$matriz_coincidencias) && preg_match($patron_fin_class,$texto_fichero,$matriz_coincidencias1)){//comprueba si es
			if(@count($matriz_coincidencias[0])==1){//comprueba si es
				if(strpos($texto_fichero,"function")<strpos($texto_fichero,"class")){
					$detalle.= "<tr><td class='error'>" .$nombre_fichero."</td><td class='error'> ERROR: NO ES UNA CLASE</td></tr>";
					$error++;//*******************************************************************
					
				}else
				{
					$detalle.="<tr><td>".$nombre_fichero ."</td><td> OK</td></tr>";
				
				}
	
			}
		}else{
			$detalle.= "<tr><td class='error'>" .$nombre_fichero."</td><td class='error'> ERROR: NO ES UNA CLASE</td></tr>";
			$error++;//*******************************************************************
		}


				$info=array();

				$info[0]=$error;/***************************************************************/
				$info[1]=$detalle;

				return $info;

	}


//9

	//comprobar_script_php("./prueba.php");
	function comprobar_script_php($nombre_fichero){

		$detalle="";

		$patron1='/^(\<\?php)/m'; 
		$patron2='/(\?\>)$/m';
		$patron3='/^[[:space:]]*(\<\!\-\-).*\n*(\-\-\>)[[:space:]]*(\<\?php)/m';
		$cont=0;
		$texto_fichero=@file_get_contents($nombre_fichero); //Volcar contenido de fich en vble
		
		$matriz_coincidencias=0;
		


		if(preg_match($patron1,$texto_fichero,$matriz_coincidencias) && preg_match($patron2,$texto_fichero,$matriz_coincidencias) ||  preg_match($patron3,$texto_fichero,$matriz_coincidencias)){//comprueba si es
			 $detalle.="<tr><td>".$nombre_fichero ."</td><td> OK</td></tr>";
			 
		}else
		{
			$detalle.="<tr><td class='error'>" .$nombre_fichero."</td><td class='error'> ERROR: NO ES UN SCRIPT</td></tr>";
			$cont++;
		}


		$info=array();

				$info[0]=$cont;
				$info[1]=$detalle;
			
				return $info;

	}	
		

	function numero_linea($patronActual,$texto){
		$matriz_coincidencias=0;
		if(preg_match_all($patronActual,$texto,$matriz_coincidencias,PREG_OFFSET_CAPTURE)){//comprueba si es
			for ($coincidencia=0;$coincidencia<@count($matriz_coincidencias[0]);$coincidencia++){//recorre
				list($before) = str_split($texto, $matriz_coincidencias[0][$coincidencia][1]); // fetches all the text before the match
				$line_number2[(strlen($before) - strlen(str_replace("\n", "", $before)) + count(preg_split('/\n/',$matriz_coincidencias[0][$coincidencia][0])))]=(strlen($before) - strlen(str_replace("\n", "", $before)) + count(preg_split('/\n/',$matriz_coincidencias[0][$coincidencia][0]))); 
			}
			return $line_number2;
		}
	}

	function numero_linea_nombre($patronActual,$texto){
		$matriz_coincidencias=0;
		$numero_nombre=array();
		if(preg_match_all($patronActual,$texto,$matriz_coincidencias,PREG_OFFSET_CAPTURE)){//comprueba si es
			for ($coincidencia=0;$coincidencia<@count($matriz_coincidencias[0]);$coincidencia++){
				list($before) = str_split($texto, $matriz_coincidencias[0][$coincidencia][1]); 
				$num=(strlen($before) - strlen(str_replace("\n", "", $before)) + count(preg_split('/\n/',$matriz_coincidencias[0][$coincidencia][0]))); 
				//comprueba si es
				if(!array_search($matriz_coincidencias[0][$coincidencia][0],$numero_nombre))
					$numero_nombre[$num]=$matriz_coincidencias[0][$coincidencia][0];
			}
			return $numero_nombre;
		}
	}



echo "<p class='resumen'>". "RESUMEN"."<BR><BR>"."</p>";
//recorre
foreach ($resumen as $indice => $valor)
{
	echo $titulos[$indice]."<br>"."<blockquote>".$valor."</blockquote>"."<br>";
}
//************DETALLE CON RESUMEN*****************
echo "<p class='detalle'>". "DETALLE"."<BR><BR>"."</p>";
//recorre
foreach ($detalle as $indice => $valor)
{
	echo "<BR>".$titulos[$indice]."<br>"."<br>".$valor;
	echo "<BR>"."RESUMEN"."<BR>"."<blockquote>".$resumen[$indice]."</blockquote>";
}



  ?>

  </body>
</html>	