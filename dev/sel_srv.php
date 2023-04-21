<?php
include("../prm/fct.php");
if($_POST['cbl']=='jrn'){
	$dt_prs = ftc_ass(select("id_jrn","dev_prs","id",$_POST['id']));
	echo $dt_prs['id_jrn'];
}
else{
	$dt_srv = ftc_ass(select("id_prs","dev_".$_POST['cbl'],"id",$_POST['id']));
	echo $dt_srv['id_prs'];
}
?>