<?php
/* TCategoryRss V2
by NickCis 
Licensed under the gpl v3 license. http://www.gnu.org/licenses/gpl-3.0.html
https://github.com/NickCis/TCategoryRss/tree/v2
http://www.taringa.net/posts/taringa/7878730/Rss-por-Categorias-de-Taringa_.html
*/
require_once("../../config.php");
if (! isset($_GET['cat'] ) ) {
    exit('Categoria no seteada');
}
$cat = $_GET['cat'];
$template = file_get_contents('xml');
if ($cat == "all") {
    #$cat = "*";
    header ("Location: http://taringa.net/rss/ultimos-post");
}
$sql = "select * from taringarss where `category` = '" . $cat  . "' order by id desc limit 0,30";
if ($query = mysql_query($sql)) {
    while ( $post = mysql_fetch_array($query) ) {
        unset($nombs, $vals);
        foreach ( $post as $nom=>$val) {
            $nombs[] = "{" . $nom . "}";
            $vals[] = htmlspecialchars_decode($val, ENT_QUOTES);
        }
        #print_r($nombs);
        #print_r($vals);
        #$item[] = str_replace($nombs, $vals, $template);
        #print(str_replace($nombs, $vals, $template)) ;
        #$nombs['description'] = "hola";
        $postitem[]= str_replace($nombs, $vals, $template) . "\n";
    }
}
#print_r($postitem);
if (is_array($postitem)) {
    $rss = join("\n", $postitem);
}
$head = <<<EOD
<?xml version="1.0" encoding="UTF-8"?><rss version="2.0" 
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:wfw="http://wellformedweb.org/CommentAPI/"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
 >
<channel>	
<title>Taringa.net - Últimos posts</title>
<description>Últimos posts de Taringa.net</description>
<image><title>Taringa.net</title><link>http://taringa.net/</link><url>http://o1.t26.net/images/logo-rss.gif</url></image>
<generator>http://taringa.net/</generator>
<language>es</language>
<link>http://taringa.net/</link>\n
EOD;
$foot = "\n</channel>\n</rss>";
print($head . $rss . $foot);
#print($head . $foot);
?>
