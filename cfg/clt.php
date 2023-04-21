<?php
$clt = array();
$rq_clt = sel_quo("*","cat_clt","","","nom");
if(num_rows($rq_clt)==0){
	insert("cat_clt",array("id_ctg","nom","crr"),array(1,"Direct",1));
	$clt[1] = 'Direct';
	insert("cfg_ctg_clt","ty_mrq","1");
}
while($dt_clt = ftc_ass($rq_clt)){
	$clt[$dt_clt['id']] = $dt_clt['nom'];
	$clt_ctg[$dt_clt['id']] = $dt_clt['id_ctg'];
	$clt_tmpl[$dt_clt['id']] = $dt_clt['tmpl'];
}
?>
