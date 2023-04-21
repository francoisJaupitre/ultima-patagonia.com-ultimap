<?php
include("../prm/fct.php");
include("../prm/aut.php");
$obj = $_POST['obj'];
$dat = $_POST['dat'];
$nom_rai = $_POST['nom_rai'];
$nom_imp = $_POST['nom_imp'];
$id_vnt = $_POST['id_vnt'];
$id_ctr = $_POST['id_ctr'];
$id_itm = $_POST['id_itm'];
$id_grp = $_POST['id_grp'];
$dt = explode('/',$dat);
$date = $dt[2].'-'.$dt[1].'-'.$dt[0];
if($nom_rai == '*'){$nom_rai = '';}
if($nom_imp == '*'){$nom_imp = '';}
if($id_vnt == -1){$id_vnt = 0;}
if($id_ctr == -1){$id_ctr = 0;}
if($id_itm == -1){$id_itm = 0;}
if($id_grp == -2){$id_grp = 0;}
if($obj == 'fac'){
  $id_fac = insert("cmp_fac",array("date","nom","imp","vnt","ctr"),array($date,$nom_rai,$nom_imp,$id_vnt,$id_ctr));
  insert("cmp_itm",array("id_fac","id_itm","id_grp"),array($id_fac,$id_itm,$id_grp));
}
elseif($obj=='itm'){insert("cmp_itm",array("id_fac","id_itm","id_grp"),array($_POST['id_sup'],$id_itm,$id_grp));}
?>
