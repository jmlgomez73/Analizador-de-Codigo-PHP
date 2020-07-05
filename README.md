
# Analizador de código PHP

*Este programa analiza diversos ficheros (codificados en PHP) que se especifiquen en el archivo de "directories", posteriormente analizara los códigos y detectara errores en *comentarios, bucles, estructuras de control, variables, falta de ficheros, etc...
*Además indicara donde esta el fallo.

## Situaciones que analiza el programa

*1 Existen los directorios especificados en el fichero Directories.conf y no hay ningun fichero mas en el directorio principal que el index.php

*2 Los ficheros de vista, controlador y modelo tienen el nombre indicado en la especificacion en el fichero Files.conf

*3 Los ficheros del directorio CodigoAExaminar tiene todos al principio del fichero comentada su funcion, autor y fecha (para todos los ficheros que no son propietarios de tipo *.pdf, .jpg, etc)

*4 Las funciones y metodos en el codigo del directorio CodigoAExaminar tienen comentarios con una descripcion antes de su comienzo

*5 En el codigo estan todas las variables definidas antes de su uso y tienen un comentario en la linea anterior o en la misma linea

*6 En el codigo estan comentadas todas las estructuras de control en la linea anterior a su uso o en la misma linea

*7 Todos los ficheros dentro del directorio Model son definiciones de clases

*8 Todos los ficheros dentro del directorio Controller son scripts php.

*9 Todos los ficheros dentro del directorio View son definiciones de clases


## Despliegue 📦

*Para ejecutar el código hay que utilizar un servidor web Apache, el cual puede ser proporcionado por programas como * [XAMPP](https://www.apachefriends.org/es/index.html).


## Futuras aplicaciones o reutilizaciones

Se pueden utilizar los patrones y bloques de código para crear otras funcionalidades.


## Autores ✒️

* **Jorge Manuel Lozano Gómez**


## Preview de la Aplicacion Web:

<p align="center">
  <img src="https://https://github.com/jmlgomez73/Analizador_de_Codigo_PHP/master/Previews/1.png" width="500" title="hover text">
</p>
<p align="center">
  <img src="https://https://github.com/jmlgomez73/Analizador_de_Codigo_PHP/master/Previews/2.png" title="hover text">
</p>

