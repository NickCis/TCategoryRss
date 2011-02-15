<?php
/* TCategoryRss V1
by NickCis 
Licensed under the gpl v3 license. http://www.gnu.org/licenses/gpl-3.0.html
https://github.com/NickCis/TCategoryRss
http://www.taringa.net/posts/taringa/7878730/Rss-por-Categorias-de-Taringa_.html
*/
$apikey = "********"; #Api key de taringa
$link = 'http://' . $_SERVER['SERVER_NAME'] . '/' . basename(dirname(__FILE__)) ;
$cat = $_GET['cat'];
$opts = array(
 'http'=> array(
 'method' => "GET",
 'user_agent' => $_SERVER['HTTP_USER_AGENT']
 )
);
$opts = stream_context_create($opts);

function infopost($id) {
 global $opts;
 $urlcat = "http://www.taringa.net/api/" . $apikey . "/json/Posts-GetCategories";
 $contentscat = file_get_contents($urlcat, false, $opts);
 $rsscat = json_decode($contentscat);
}

if ($_GET['tipo' ] == 'rss'|| isset($cat) ) {
 print("<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0"
 xmlns:content="http://purl.org/rss/1.0/modules/content/"
 xmlns:wfw="http://wellformedweb.org/CommentAPI/"
 xmlns:dc="http://purl.org/dc/elements/1.1/"
>
<channel>
");

 $urlcat = "http://www.taringa.net/api/" . $apikey . "/json/Posts-GetCategories";
 $contentscat = file_get_contents($urlcat, false, $opts);
 $rsscat = json_decode($contentscat);
 $catcat = "cat-" . $_GET['cat'];
 $nombrecat = $rsscat->$catcat->name ;

 print("<title>Taringa.net - Últimos posts en " . $nombrecat . "</title>
<description>Últimos posts de Taringa.net</description>
<image><title>Taringa.net</title><link>http://www.taringa.net/</link><url>http://i.t.net.ar/images/logo-rss.gif</url></image>
<generator>" . $link . "</generator>
<language>es</language>
<link>http://www.taringa.net/</link>
");

 $url = "http://www.taringa.net/api/" . $apikey . "/json/Posts-GetPostList/" . $cat . "/0";
 $contents = file_get_contents($url, false, $opts);
 $rss = json_decode($contents);
 foreach ($rss as $post) {
 $postt = $post->title;
 $postl = $post->url ;
 print("<item>
 <title>" . $postt . "</title>
 <link>" . $postl . "</link>
 <description>&lt;a href=&quot;". $postl .  "&quot;&gt;Post" . "&lt;/a&gt; &lt;a  href=&quot;" . $postl .  "#comentarios&quot;&gt;Comentarios&lt;/a&gt;</description>
 </item>
");
 }
 print("</channel>
 </rss>");
}
elseif ($_GET['tipo'] == 'cat') {
 $url = "http://www.taringa.net/api/" . $apikey . "/json/Posts-GetCategories";
 $contents = file_get_contents($url, false, $opts);
 $cats = json_decode($contents);
 print("<html><body>");
 foreach ($cats as $cat) {
 $catn = $cat->name;
 $catid = $cat->id;
 print("<p>Categoria:" . $catn . " ID:" . $catid . "</p>");
 }
 print("</body></html>");
}
?> 
