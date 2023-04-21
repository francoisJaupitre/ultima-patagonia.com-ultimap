<ul class="lst_ul">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
$uid = "id='enter_".$cbl."_hbr";
if($cbl=='prs' or $cbl=='hbr_opt'){$uid .= $id_dev_prs;}
elseif($cbl=='hbr'){$uid .= $id_dev_hbr;}
$uid .= "'";
if($id_hbr>0 and substr(upnoac($txt->opn->$id_lng),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo $uid.' style="background-color: Chocolate;"';} ?> onClick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $id_hbr; ?>');"><?php echo $txt->opn->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if(substr(upnoac($txt->creer->$id_lng),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo $uid.' style="background-color: Chocolate;"';} ?> onClick="ajt_hbr(0,0,<?php echo $id_vll.','.$id_rgm.','.$id_dev_hbr.','.$id_dev_prs ?>,1);"><?php echo $txt->creer->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if(($cbl=='prs' or ($cbl=='hbr' and $id_hbr!=-1)) and $id_vll>0 and $id_rgm >0 and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src){
	if($cbl=='prs'){
		$event = "ajt_hbr(-1,-1,".$id_vll.",".$id_rgm.",".$id_dev_hbr.",".$id_dev_prs.",1);";/*
		$event ="vue_elem('prs_vll_ctg".$id_dev_prs."','".$id_vll."_".$id_ctg_srv."_".$id_rgm."_-1');";*/}
	elseif($cbl=='hbr_opt'){$event ="vue_elem('prs_hbr".$id_dev_prs."','".$id_vll."_".$id_rgm."_-1');";}
	else{$event ="vue_elem('hbr_hbr".$id_dev_hbr."','-1');vue_elem('hbr_chm".$id_dev_hbr."','-1');";}
	$event2 = "vue_trf_hbr(".$id_dev_prs.",0,0);";
?>
	<li <?php if($flg_enter){echo $uid.' style="background-color: Chocolate;"';} ?> onClick="<?php echo $event.$event2 ?>"><?php echo $txt->nodef->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if($id_vll>0 and $id_rgm >0 and $id_dev_hbr >0 and substr(upnoac($txt->libre->$id_lng),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo $uid.' style="background-color: Chocolate;"';} ?> onClick="ajt_hbr(-2,0,<?php echo $id_vll.','.$id_rgm.','.$id_dev_hbr.','.$id_dev_prs ?>,1);"><?php echo $txt->libre->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if(isset($id_vll) and $id_vll>0){
	$rq_lst_hbr = select("id,nom,info","cat_hbr","id!=".$id_hbr." AND id_vll",$id_vll,"nom","DISTINCT");
	while($dt_lst_hbr = ftc_ass($rq_lst_hbr)){
		if(substr(upnoac($dt_lst_hbr['nom']),0,strlen($src))==$src){
				if($cbl=='prs'){$event ="vue_elem('prs_vll_ctg".$id_dev_prs."','".$id_vll."_".$id_ctg_srv."_".$id_rgm."_".$dt_lst_hbr['id']."');";}
				elseif($cbl=='hbr_opt'){$event ="vue_elem('prs_hbr".$id_dev_prs."','".$id_vll."_".$id_rgm."_".$dt_lst_hbr['id']."');";}
				else{$event ="vue_elem('hbr_hbr".$id_dev_hbr."','".$dt_lst_hbr['id']."');vue_elem('hbr_chm".$id_dev_hbr."','".$dt_lst_hbr['id']."');";}
				if($cbl!='prs'){$event2 = "chk_vue_trf_hbr(".$id_dev_prs.",0,".$dt_lst_hbr['id'].");";}
				else{$event2 = "chk_vue_trf_hbr(".$id_dev_prs.",0,0);";}
?>
	<li <?php if($flg_enter){echo $uid.' style="background-color: Chocolate;"';} ?>>
		<span class="dib" onClick="vue_cmd_ul('ul_<?php echo $cbl ?>_hbr<?php echo $dt_lst_hbr['id'].'_'; if($cbl=='prs' or $cbl=='hbr_opt'){echo $id_dev_prs;} elseif($cbl=='hbr'){echo $id_dev_hbr;} ?>','cmd_<?php echo $cbl ?>_hbr<?php if($cbl=='prs' or $cbl=='hbr_opt'){echo $id_dev_prs;} elseif($cbl=='hbr'){echo $id_dev_hbr;} ?>');"><?php echo stripslashes($dt_lst_hbr['nom']); if(!empty($dt_lst_hbr['info'])){echo stripslashes(' ['.$dt_lst_hbr['info'].']');} ?></span>
		<ul id="ul_<?php echo $cbl ?>_hbr<?php echo $dt_lst_hbr['id'].'_'; if($cbl=='prs' or $cbl=='hbr_opt'){echo $id_dev_prs;} elseif($cbl=='hbr'){echo $id_dev_hbr;} ?>" class="cmd_<?php echo $cbl ?>_hbr<?php if($cbl=='prs' or $cbl=='hbr_opt'){echo $id_dev_prs;} elseif($cbl=='hbr'){echo $id_dev_hbr;} ?>" style="display: none">
			<li onClick="<?php echo $event.$event2; ?>"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $dt_lst_hbr['id'] ?>');"><?php echo $txt->cat->$id_lng ?></li>
		</ul>
	</li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
