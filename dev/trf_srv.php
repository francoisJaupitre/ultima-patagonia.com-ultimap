<?php
$rq_srv = select("id,crr,frs,taux,sup,opt,dt_min,dt_max","dev_srv","id_prs",$id_dev_prs);
if(num_rows($rq_srv)>0){
?>
<input id="jrn_dev_srv<?php echo $id_dev_jrn ?>" type="hidden" value="true" />
<?php
	while($dt_srv = ftc_ass($rq_srv)){
		$frs = $frs_crc + $dt_srv['frs'];
		if($dt_srv['opt']==1){
			if(isset($bss)){
				foreach($bss as $id_bss => $base){
					if(isset($mrq_crc)){$tx_mrq = $mrq_crc[$id_bss];}
					if(!isset($cst_srv[$id_bss])){$cst_srv[$id_bss] = $trf_srv[$id_bss] = $est_trf[$id_bss] = 0;}
					$flg_srv = true;
					$rq_srv_trf = select("*","dev_srv_trf","id_srv",$dt_srv['id']);
					while($dt_srv_trf = ftc_ass($rq_srv_trf)){
						if($dt_srv_trf['base'] == $base){
							$cur = $dt_srv['crr'];
							$taux = $dt_srv['taux'];
							$sup = $dt_srv['sup'];
							if($cur>0){
								$net = $dt_srv_trf['trf_net'];
								$rck = $dt_srv_trf['trf_rck'];
								include("../fct/clc_mrq.php");
								$cst_srv[$id_bss] += $cst;
								$trf_srv[$id_bss] += $trf;
							}
							if($dt_srv_trf['est']==-1){$est_trf[$id_bss] = -1;}
							if($dt_srv_trf['est']==1 and $est_trf[$id_bss] != -1){$est_trf[$id_bss] = 1;}
							elseif($dt_srv_trf['est']==0 and $est_trf[$id_bss] != -1 and $est_trf[$id_bss] != 1){$est_trf[$id_bss] = 0;}
						}
					}
				}
			}
		}
		if(!isset($dt_min_srv) or ($dt_min_srv != '0000-00-00' and ($dt_srv['dt_min'] == '0000-00-00' or strtotime($dt_min_srv) < strtotime($dt_srv['dt_min'])))){$dt_min_srv = $dt_srv['dt_min'];}
		if(!isset($dt_max_srv) or ($dt_max_srv != '0000-00-00' and strtotime($dt_max_srv) > strtotime($dt_srv['dt_max']))){$dt_max_srv = $dt_srv['dt_max'];}
	}
}
?>
