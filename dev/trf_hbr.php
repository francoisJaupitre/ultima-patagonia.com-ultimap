<?php
$tx_mrq = $mrq_hbr;
$rq_hbr = select("*","dev_hbr","id_prs",$id_dev_prs);
if(num_rows($rq_hbr)>0){
?>
<input id="jrn_dev_hbr<?php echo $id_dev_jrn ?>" type="hidden" value="true" />
<?php
	while($dt_hbr = ftc_ass($rq_hbr)){
		$frs = $frs_crc + $dt_hbr['frs'];
		$flg_hbr = true;
		if($dt_hbr['opt']==1){
			$cur = $dt_hbr['crr_chm'];
			$taux = $dt_hbr['taux_chm'];
			$sup = $dt_hbr['sup_chm'];
			if($cur>0){
				$net = $dt_hbr['db_net_chm'];
				$rck = $dt_hbr['db_rck_chm'];
				include("../fct/clc_mrq.php");
				$cst_db_sel_hbr = $cst;
				$trf_db_sel_hbr = $trf;
				if($vue_sgl==1){
					$net = $dt_hbr['sg_net_chm'];
					$rck = $dt_hbr['sg_rck_chm'];
					include("../fct/clc_mrq.php");
					$cst_sg_sel_hbr = $cst;
					$trf_sg_sel_hbr = $trf;
				}
				if($vue_tpl==1){
					$net = $dt_hbr['tp_net_chm'];
					$rck = $dt_hbr['tp_rck_chm'];
					include("../fct/clc_mrq.php");
					$cst_tp_sel_hbr = $cst;
					$trf_tp_sel_hbr = $trf;
				}
				if($vue_qdp==1){
					$net = $dt_hbr['qd_net_chm'];
					$rck = $dt_hbr['qd_rck_chm'];
					include("../fct/clc_mrq.php");
					$cst_qd_sel_hbr = $cst;
					$trf_qd_sel_hbr = $trf;
				}
			}
			if($dt_hbr['est_chm']==1 and (!isset($est_hbr) or $est_hbr != -1)){$est_hbr = 1;}
			elseif($dt_hbr['est_chm']==-1){$est_hbr = -1;}
			elseif($dt_hbr['est_chm']==0 and !isset($est_hbr) or ($est_hbr !=-1 and $est_hbr !=1)){$est_hbr = 0;}
			$cur = $dt_hbr['crr_rgm'];
			$taux = $dt_hbr['taux_rgm'];
			$sup = $dt_hbr['sup_rgm'];
			if($cur>0){
				$net = $dt_hbr['db_net_rgm'];
				$rck = $dt_hbr['db_rck_rgm'];
				include("../fct/clc_mrq.php");
				$cst_db_sel_hbr += $cst;
				$trf_db_sel_hbr += $trf;
				if($vue_sgl==1){
					$net = $dt_hbr['sg_net_rgm'];
					$rck = $dt_hbr['sg_rck_rgm'];
					include("../fct/clc_mrq.php");
					$cst_sg_sel_hbr += $cst;
					$trf_sg_sel_hbr += $trf;
				}
				if($vue_tpl==1){
					$net = $dt_hbr['tp_net_rgm'];
					$rck = $dt_hbr['tp_rck_rgm'];
					include("../fct/clc_mrq.php");
					$cst_tp_sel_hbr += $cst;
					$trf_tp_sel_hbr += $trf;
				}
				if($vue_qdp==1){
					$net = $dt_hbr['qd_net_rgm'];
					$rck = $dt_hbr['qd_rck_rgm'];
					include("../fct/clc_mrq.php");
					$cst_qd_sel_hbr += $cst;
					$trf_qd_sel_hbr += $trf;
				}
			}
			if($dt_hbr['est_rgm']==1 and $est_hbr !=-1){$est_hbr = 1;}
			elseif($dt_hbr['est_rgm']==-1){$est_hbr = -1;}
			elseif($dt_hbr['est_rgm']==0 and $est_hbr !=-1 and $est_hbr !=1){$est_hbr = 0;}
		}
		if(!isset($dt_min_hbr) or ($dt_min_hbr != '0000-00-00' and ($dt_hbr['dt_min_chm'] == '0000-00-00' or strtotime($dt_min_hbr) < strtotime($dt_hbr['dt_min_chm'])))){$dt_min_hbr = $dt_hbr['dt_min_chm'];}
		if($dt_hbr['dt_min_rgm']!='0000-00-00' and $dt_min_hbr != '0000-00-00' and ($dt_hbr['dt_min_rgm'] == '0000-00-00' or strtotime($dt_min_hbr) < strtotime($dt_hbr['dt_min_rgm']))){$dt_min_hbr = $dt_hbr['dt_min_rgm'];}
		if(!isset($dt_max_hbr) or ($dt_max_hbr != '0000-00-00' and strtotime($dt_max_hbr) > strtotime($dt_hbr['dt_max_chm']))){$dt_max_hbr = $dt_hbr['dt_max_chm'];}
		if($dt_hbr['dt_max_rgm']!='0000-00-00' and $dt_max_hbr != '0000-00-00' and strtotime($dt_max_hbr) > strtotime($dt_hbr['dt_max_rgm'])){$dt_max_hbr = $dt_hbr['dt_max_rgm'];}
	}
}
?>
