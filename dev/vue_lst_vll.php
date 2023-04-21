<ul onclick="document.getElementById('sel_vll_<?php if($cbl=='jrn_mdl'){echo 'mdl'.$id_dev_mdl;} elseif($cbl=='jrn'){echo 'jrn'.$id_dev_jrn;} elseif($cbl=='jrn_rpl'){echo 'jrn_rpl'.$id_sel_jrn;}  elseif($cbl=='prs'){echo 'prs'.$id_dev_prs;} elseif($cbl=='srv'){echo 'srv'.$id_dev_srv;} elseif($cbl=='hbr'){echo 'hbr'.$id_dev_hbr;} ?>').style.display='none';">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
if(!isset($id_vll)){$id_vll=0;}
if($id_vll!=0 and empty($src)){
	if($cbl=='jrn_mdl'){$event = "vue_elem('mdl_vll".$id_dev_mdl."','0')";}
	elseif($cbl=='jrn'){$event = "vue_elem('jrn_vll_ctg".$id_dev_jrn."','0_".$id_ctg_prs."')";}
	elseif($cbl=='jrn_rpl'){$event = "vue_elem('jrn_rpl_vll".$id_sel_jrn."','0')";}
	elseif($cbl=='prs'){$event = "vue_elem('prs_vll_ctg".$id_dev_prs."','0_".$id_ctg_srv."_".$id_rgm."_0')";}
	elseif($cbl=='srv'){$event = "maj('dev_srv','id_vll','0',".$id_dev_srv.")";}
	elseif($cbl=='hbr'){$event = "maj('dev_hbr','id_vll','0',".$id_dev_hbr.")";}
?>
	<li onClick="<?php echo $event; ?>"><?php if($cbl=='jrn_mdl'){echo $txt->vll->$id_lng;}else{echo $txt->vll->$id_lng;} ?></li>
<?php
}
$uid = "id='enter_";
if($cbl=='jrn_mdl'){
	$uid .= "mdl_vll".$id_dev_mdl;
	$elem = "mdl_vll".$id_dev_mdl;
}
elseif($cbl=='jrn'){
	$uid .= "jrn_vll".$id_dev_jrn;
	$elem = "jrn_vll_ctg".$id_dev_jrn;
}
elseif($cbl=='jrn_rpl'){
	$uid .= "vll_jrn_rpl".$id_sel_jrn;
	$elem = "vll_jrn_rpl".$id_sel_jrn;
}
elseif($cbl=='prs'){
	$uid .= "prs_vll".$id_dev_prs;
	$elem = "prs_vll_ctg".$id_dev_prs;
}
elseif($cbl=='srv'){
	$uid .= "srv_vll".$id_dev_srv;
	$elem = "srv_vll".$id_dev_srv;
}
elseif($cbl=='hbr'){
	$uid .= "hbr_vll".$id_dev_hbr;
	$elem = "hbr_vll".$id_dev_hbr;
}
$uid .= "'";
foreach($vll as $vll_id => $nom){
	if(substr(upnoac($nom),0,strlen($src))==$src){
		if($vll_id!=$id_vll){
			if($cbl=='jrn_mdl' or $cbl=='jrn' or $cbl=='prs'){
				$event = "vue_elem('".$elem."','".$vll_id;
				if($cbl=='jrn'){$event .= "_".$id_ctg_prs;}
				elseif($cbl=='prs'){$event .= "_".$id_ctg_srv."_".$id_rgm."_0";}
				$event .= "');";
			}
			elseif($cbl=='jrn_rpl'){
				$event = "vue_elem('".$elem."','".$vll_id.'__';
				if(isset($jrn_rpl_id_cat)){$event .= implode("_",$jrn_rpl_id_cat);}
				else{$event .= 0;}
				$event .= "');";
			}
			elseif($cbl=='srv'){$event = "maj('dev_srv','id_vll','".$vll_id."',".$id_dev_srv.")";}
			elseif($cbl=='hbr'){$event = "maj('dev_hbr','id_vll','".$vll_id."',".$id_dev_hbr.")";}
?>
	<li <?php if($flg_enter){echo $uid." style='background-color: Chocolate;'";} ?> onClick="<?php echo $event; ?>"><?php echo stripslashes($nom); ?></li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
