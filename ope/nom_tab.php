<?
$cnf = $_POST['cnf'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../prm/aut.php");
include("../cfg/lng.php");
$nom_tab = $txt->ope->$id_lng.': ';
if($cnf==1){$nom_tab .= $txt->encours->$id_lng;}
else{$nom_tab .= $txt->archives->$id_lng;}
echo $nom_tab;
?>
