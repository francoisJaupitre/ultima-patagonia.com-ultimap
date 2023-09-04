<ul class="lst_ul">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
if(substr(upnoac($txt->creer->$id_lng),0,strlen($src))==$src){
	if($cbl == 'jrn_mdl'){$event = "ajt_jrn(0,".$id_dev_mdl.",0,".$id_cat_mdl.",0);";}
	elseif($cbl == 'jrn_rpl'){$event = "ajt_jrn(0,".$id_dev_mdl.",".$ord_jrn.",".$id_cat_mdl.",".$id_sel_jrn.");";}
	else{$event = "ajt_jrn(0,".$id_dev_mdl.",".$ord_jrn.",0,".$id_sel_jrn.");";}
?>
	<li id="enter_<?php echo $cbl.$id ?>" style="background-color: Chocolate;" onClick="<?php echo $event ?>"><?php echo $txt->creer->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if(($cbl == 'jrn_mdl' or !in_array('-1',$jrn_rpl_id_cat)) and substr(upnoac($txt->nosrv->$id_lng),0,strlen($src))==$src){
	if($cbl == 'jrn_mdl'){$event = "addJrnNoSrv(".$id_dev_mdl.",0);";}
	else{$event = "addJrnNoSrv(".$id_dev_mdl.",".$ord_jrn.");";}
?>
	<li <?php if($flg_enter){echo 'id="enter_'.$cbl.$id.'" style="background-color: Chocolate;"';} ?> onClick="<?php echo $event ?>"><?php echo $txt->nosrv->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if(isset($id_vll) and $id_vll>0){
	$rq_lst_jrn = sel_quo("cat_jrn.id,nom,info","cat_jrn LEFT JOIN cat_jrn_vll ON cat_jrn_vll.id_jrn = cat_jrn.id","id_vll",$id_vll,"nom","DISTINCT");
	while($dt_lst_jrn = ftc_ass($rq_lst_jrn)){
		if(($cbl == 'jrn_mdl' or !in_array($dt_lst_jrn['id'],$jrn_rpl_id_cat)) and substr(upnoac($dt_lst_jrn['nom']),0,strlen($src))==$src){
			if($cbl == 'jrn_mdl'){$event = "ajt_jrn(".$dt_lst_jrn['id'].",".$id_dev_mdl.",0,".$id_cat_mdl.",0)";}
			elseif($cbl == 'jrn_rpl'){$event = "ajt_jrn(".$dt_lst_jrn['id'].",".$id_dev_mdl.",".$ord_jrn.",".$id_cat_mdl.",".$id_sel_jrn.");";}
			else{$event = "ajt_jrn(".$dt_lst_jrn['id'].",".$id_dev_mdl.",".$ord_jrn.",0,".$id_sel_jrn.");";}
?>
	<li <?php if($flg_enter){echo 'id="enter_'.$cbl.$id.'" style="background-color: Chocolate;"';} ?>>
		<span class="dib" onClick="vue_cmd_ul('ul_<?php echo $cbl.$dt_lst_jrn['id'].'_'.$id ?>','cmd_<?php echo $cbl.$id ?>');"><?php echo stripslashes($dt_lst_jrn['nom']); if(!empty($dt_lst_jrn['info'])){echo stripslashes(' ['.$dt_lst_jrn['info'].']');} ?></span>
		<ul id="ul_<?php echo $cbl.$dt_lst_jrn['id'].'_'.$id ?>" class="cmd_<?php echo $cbl.$id ?>" style="display: none">
			<li onClick="<?php echo $event ?>"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=jrn&id=<?php echo $dt_lst_jrn['id'] ?>');"><?php echo $txt->cat->$id_lng ?></li>
		</ul>
	</li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
