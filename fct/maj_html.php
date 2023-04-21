<?php
include("../prm/fct.php");
include("../prm/aut.php");
$ttr = rawurldecode($_POST['ttr']);
$val = urldecode($_POST['val']);
$id = $_POST['id'];
$file = "../tmp/".$dir."/".$ttr.".html";
$html = file_get_contents($file);
echo $file;
$dom = new DOMDocument;
$dom->loadHTML('<?xml encoding="utf-8" ?>'.$html);
$dom->getElementById($id)->nodeValue = $val;
$html = $dom->saveHTML();
file_put_contents($file, $html);
?>
