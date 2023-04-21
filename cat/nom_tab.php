<?php
$id = $_POST['id'];
$cbl = $_POST['cbl'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../cfg/lng.php");
if(isset($_POST['id']) and isset($_POST['cbl'])) {
	if($cbl!='pic') {
		$dt = ftc_ass(select("nom","cat_".$cbl,"id",$id));
		$nom_tab = $txt->$cbl->$id_lng.': '.$dt['nom'];
	}
	else{
		$dt = ftc_ass(select("pic","cat_".$cbl,"id",$id));
		$nom_tab = $txt->$cbl->$id_lng.': '.$dt['pic'];
		}
	echo mb_substr(stripslashes($nom_tab),0,30,'UTF-8');
	if(mb_strlen($nom_tab,'UTF-8')>30) {echo '...';}
}
?>
