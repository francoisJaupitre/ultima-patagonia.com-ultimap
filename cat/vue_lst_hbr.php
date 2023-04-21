<ul class="lst_ul">
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
if($cbl!='vll' and $id_hbr!=0 and empty($src)) {
?>
	<li onClick="vue_elem('prs_vll_ctg','<?php echo $id_vll."_1_".$id_rgm."_0" ?>')"><?php echo $txt->hbr->$id_lng; ?></li>
<?php
}
if((($cbl=='vll' and $id_hbr!=0) or $cbl!='vll') and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src) {
	if($cbl=='vll') {
		$event = "maj_vll_hbr(".$id_rgm.",".$id_hbr_def.",0,0)";
		$uid = "enter_hbr".$id_hbr_def.'_'.$id_rgm;
		}
	else{
		$event = "ajt_hbr(".$id_vll.",".$id_rgm.",-1,0);";
		$uid = "enter_hbr";
		}
?>
	<li id="<?php echo $uid ?>" style="background-color: Chocolate;" onClick="<?php echo $event ?>"><?php echo $txt->nodef->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if($cbl=='vll') {
	unset($hbr);
	$rq_hbr = select("id,nom","cat_hbr","id_vll",$id);
	while($dt_hbr = ftc_ass($rq_hbr)) {
		$dt_rgm = ftc_ass(select("id","cat_hbr_rgm","id_hbr=".$dt_hbr['id']." AND rgm",$id_rgm));
		if(!empty($dt_rgm['id'])) {$hbr[$dt_hbr['id']]=$dt_hbr['nom'];}
		else{
			$dt_chm = ftc_ass(select("id","cat_hbr_chm","id_hbr=".$dt_hbr['id']." AND rgm",$id_rgm));
			if(!empty($dt_chm['id'])) {$hbr[$dt_hbr['id']]=$dt_hbr['nom'];}
		}
	}
	$uid = "enter_hbr".$id_hbr_def.'_'.$id_rgm;
}
else{
	$rq_rgm_hbr = select("cat_hbr.id, cat_hbr.nom", "cat_hbr INNER JOIN cat_hbr_rgm ON cat_hbr.id=cat_hbr_rgm.id_hbr", "id_vll='".$id_vll."' AND rgm",$id_rgm);
	while($dt_rgm_hbr = ftc_ass($rq_rgm_hbr)) {$hbr[$dt_rgm_hbr['id']] = $dt_rgm_hbr['nom'];}
	$rq_rgm_chm = select("cat_hbr.id, cat_hbr.nom", "cat_hbr INNER JOIN cat_hbr_chm ON cat_hbr.id=cat_hbr_chm.id_hbr", "id_vll='".$id_vll."' AND rgm",$id_rgm,"","DISTINCT");
	while($dt_rgm_chm = ftc_ass($rq_rgm_chm)) {$hbr[$dt_rgm_chm['id']] = $dt_rgm_chm['nom'];}
	$uid = "enter_hbr";
}
if(isset($hbr)) {
	asort($hbr);
	foreach($hbr as $hbr_id => $nom) {
		if(substr(upnoac($nom),0,strlen($src))==$src and $id_hbr!=$hbr_id) {
			if($cbl=='vll') {$event = "maj_vll_hbr(".$id_rgm.",".$id_hbr_def.",".$hbr_id.",0)";}
			else{$event = "vue_elem('prs_vll_ctg','".$id_vll."_1_".$id_rgm."_".$hbr_id."')";}
?>
	<li <?php if($flg_enter) {echo 'id="'.$uid.'" style="background-color: Chocolate;"';} ?>>
		<span class="dib" onClick="vue_cmd_ul('ul_hbr<?php echo $hbr_id; if($cbl=='vll') {echo '_'.$id_hbr_def.'_'.$id_rgm;} ?>','cmd_hbr<?php if($cbl=='vll') {echo $id_hbr_def.'_'.$id_rgm;} ?>');"><?php echo $nom; ?></span>
		<ul id="ul_hbr<?php echo $hbr_id; if($cbl=='vll') {echo '_'.$id_hbr_def.'_'.$id_rgm;} ?>" class="cmd_hbr<?php if($cbl=='vll') {echo $id_hbr_def.'_'.$id_rgm;} ?>" style="display: none">
			<li onClick="<?php echo $event ?>;"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $hbr_id ?>');"><?php echo $txt->opn->$id_lng ?></li>
		</ul>
	</li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
