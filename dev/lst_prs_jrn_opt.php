<?php
$ord_prs_ant = 0;
$rq_jrn_prs = select("id_prs,ord,opt,nom,info","cat_jrn_prs INNER JOIN cat_prs ON cat_prs.id = cat_jrn_prs.id_prs","id_jrn",$id_cat_jrn,"ord,opt DESC");
if(num_rows($rq_jrn_prs)>0){
	while($dt_jrn_prs = ftc_ass($rq_jrn_prs)){
		if($ord_prs_ant != $dt_jrn_prs['ord']){
			$flg_opt = true;
			$ord_prs_ant = $dt_jrn_prs['ord'];
		}
		if($dt_jrn_prs['opt']==1){$flg_opt = false;}
		if($flg_opt){
			$rq_ord_jrn_prs = select("id_prs","cat_jrn_prs","ord =".$dt_jrn_prs['ord']." AND id_jrn",$id_cat_jrn);
			while($dt_ord_jrn_prs = ftc_ass($rq_ord_jrn_prs)){$jrn_prs_ord_id[] = $dt_ord_jrn_prs['id_prs'];}
			$rq_prs = select("id_cat","dev_prs","id_jrn",$id_dev_jrn,"ord");
			while($dt_prs = ftc_ass($rq_prs)){
				if(in_array($dt_prs['id_cat'],$jrn_prs_ord_id)) {$flg_opt = false;}
			}
			if($flg_opt){$lst_prs_jrn_opt[$dt_jrn_prs['id_prs']] = $dt_jrn_prs['nom'].' ['.$dt_jrn_prs['info'].']';}
			unset($jrn_prs_ord_id);
		}
	}
}
?>
