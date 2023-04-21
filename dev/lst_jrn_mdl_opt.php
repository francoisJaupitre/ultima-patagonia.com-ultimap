<?php
$ord_jrn_ant = 0;
$rq_mdl_jrn = select("id_jrn,ord,opt,nom,info","cat_mdl_jrn INNER JOIN cat_jrn ON cat_jrn.id = cat_mdl_jrn.id_jrn","id_mdl",$id_cat_mdl,"ord,opt DESC");
if(num_rows($rq_mdl_jrn)>0){
	while($dt_mdl_jrn = ftc_ass($rq_mdl_jrn)){
		if($ord_jrn_ant != $dt_mdl_jrn['ord']){
			$flg_opt = true;
			$ord_jrn_ant = $dt_mdl_jrn['ord'];
		}
		if($dt_mdl_jrn['opt']==1){$flg_opt = false;}
		if($flg_opt){
			$rq_ord_mdl_jrn = select("id_jrn","cat_mdl_jrn","ord =".$dt_mdl_jrn['ord']." AND id_mdl",$id_cat_mdl);
			while($dt_ord_mdl_jrn = ftc_ass($rq_ord_mdl_jrn)){$mdl_jrn_ord_id[] = $dt_ord_mdl_jrn['id_jrn'];}
			$rq_jrn = select("id_cat","dev_jrn","id_mdl",$id_dev_mdl,"ord");
			while($dt_jrn = ftc_ass($rq_jrn)){
				if(in_array($dt_jrn['id_cat'],$mdl_jrn_ord_id)) {$flg_opt = false;}
			}
			if($flg_opt){$lst_jrn_mdl_opt[$dt_mdl_jrn['id_jrn']] = $dt_mdl_jrn['nom'].' ['.$dt_mdl_jrn['info'].']';}
			unset($mdl_jrn_ord_id);
		}
	}
}
?>
