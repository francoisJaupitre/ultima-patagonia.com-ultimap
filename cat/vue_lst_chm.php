<ul>
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
if((($cbl=='vll' and $id_chm!=0) or $cbl!='vll') and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src) {
	if($cbl=='vll') {
		$event = "maj_vll_hbr(".$id_rgm.",".$id_hbr_def.",".$id_hbr.",0)";
		$uid = "enter_chm".$id_hbr_def.'_'.$id_rgm;
		}
	else{
		$event = "ajt_hbr(".$id_vll.",".$id_rgm.",".$id_hbr.",-1);";
		$uid = "enter_chm";
		}
?>
	<li id="<?php echo $uid ?>" style="background-color: Chocolate;" onClick="<?php echo $event ?>"><?php echo $txt->nodef->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
$dt_rgm = ftc_ass(select("id","cat_hbr_rgm","id_hbr=".$id_hbr." AND rgm",$id_rgm));
if(!empty($dt_rgm['id'])) {$rq_chm  = select("id,nom","cat_hbr_chm","id_hbr",$id_hbr,"nom");}
else{$rq_chm = select("id,nom","cat_hbr_chm","rgm=".$id_rgm." AND id_hbr",$id_hbr,"nom");}
$uid = "enter_chm";
if($cbl=='vll') {$uid .= $id_hbr_def.'_'.$id_rgm;}
while($dt_chm = ftc_ass($rq_chm)) {
	if(substr(upnoac($dt_chm['nom']),0,strlen($src))==$src and ($cbl!='vll' or $id_chm != $dt_chm['id'])) {
		if($cbl=='vll') {$event = "maj_vll_hbr(".$id_rgm.",".$id_hbr_def.",".$id_hbr.",".$dt_chm['id'].")";}
		else{$event = "ajt_hbr(".$id_vll.",".$id_rgm.",".$id_hbr.",".$dt_chm['id'].")";}
?>
	<li <?php if($flg_enter) {echo 'id="'.$uid.'" style="background-color: Chocolate;"';} ?> onClick="<?php echo $event ?>"><?php echo $dt_chm['nom']; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
