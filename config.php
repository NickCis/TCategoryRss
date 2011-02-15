<?php
/* TCategoryRss V2
by NickCis 
Licensed under the gpl v3 license. http://www.gnu.org/licenses/gpl-3.0.html
https://github.com/NickCis/TCategoryRss/tree/v2
http://www.taringa.net/posts/taringa/7878730/Rss-por-Categorias-de-Taringa_.html
*/
#Info Base de datos
unset($config) ;
$config[1] = '********' ; # Host Puede ser "localhost" aunque también una URL o una IP
$config[2] = '********' ; # Usuario de la base de datos
$config[3] = '********' ; # Contraseña de la base de datos
$config[4] = '********' ; # Nombre de la base de datos
$conectar = @mysql_connect($config[1],$config[2],$config[3]) or exit('Datos de conexión incorrectos.') ;
mysql_select_db($config[4],$conectar) or exit('No existe la base de datos.') ;
?>
