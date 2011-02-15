<?php
/* TCategoryRss V2
by NickCis 
Licensed under the gpl v3 license. http://www.gnu.org/licenses/gpl-3.0.html
https://github.com/NickCis/TCategoryRss/tree/v2
http://www.taringa.net/posts/taringa/7878730/Rss-por-Categorias-de-Taringa_.html
*/
require("config.php");
require("xml2array.php");
$rsst = file_get_contents('http://taringa.net/rss/ultimos-post');
$rssta = xml2array($rsst);
$posts = $rssta['rss']['channel']['item'];
$sql = "select title from taringarss order by id desc limit 1";
if ($query = mysql_query($sql)) {
    $lasttitle = mysql_result($query,0);
}
#print($lasttitle);

foreach ($posts as $post) {
    if ($lasttitle == $post['title']['value']) {
        break;
    }
    $newposts[] = Array('title' => $post['title']['value'], 'link' => $post['link']['value'],'pubdate' => $post['pubDate']['value'], 'category' => $post['category']['value'], 'comments' => $post['comments']['value'], 'description' => $post['description']['value']);
    #print($post['title']['value']);
    #print_r($post);
}
if (!is_array($newposts)) {
    $newpost = Array($newposts);
}
$newposts = array_reverse($newposts);
foreach ($newposts as $newpost) {
    unset($nombres, $valores);
    foreach ($newpost as $nombre=>$valor) {
        $nombres[] = '`' . htmlspecialchars($nombre, ENT_QUOTES) . '`';
        $valores[] = "'" . htmlspecialchars($valor, ENT_QUOTES) . "'";
    }
    $nomlist = join(',', $nombres);
    $vallist = join(',', $valores);
    #print($nomlist . "<br />" . $vallist . "<br />");
    $sqli = "insert into taringarss (" . $nomlist . ") values (" . $vallist . ")" ;
    $add = mysql_query($sqli);
}
#print_r($posts);
#$sqlp = "insert into " . $liga . "_partidos (fecha,ganador,perdedor,golesG,golesP,empate,creador) values ('$fecha','$ganadorj','$perdedorj','$golesG','$golesP','$empa','$user_id')" ;
#print_r($posts);
?>
