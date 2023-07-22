<ul>
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
if($cbl=='srv' and $id_frn) {
	if(substr(upnoac($txt->opn->$id_lng),0,strlen($src))==$src) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_frn'.$id_bss.'" style="background-color: Chocolate;"';} ?> onClick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $id_frn; ?>');"><?php echo $txt->opn->$id_lng; ?></li>
<?php
		$flg_enter = false;
	}
	if(substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_frn'.$id_bss.'" style="background-color: Chocolate;"';} ?> onClick="updateData('cat_srv_trf_bss','id_frn','0',<?php echo $id_bss.','.$id ?>);"><?php echo $txt->nodef->$id_lng; ?></li>
<?php
		$flg_enter = false;
	}
}
elseif($cbl=='hbr' and $id_frn) {
	if(substr(upnoac($txt->opn->$id_lng),0,strlen($src))==$src) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_frn" style="background-color: Chocolate;"';} ?> onClick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $id_frn; ?>');"><?php echo $txt->opn->$id_lng; ?></li>
<?php
		$flg_enter = false;
	}
	if(substr(upnoac($txt->unique->$id_lng),0,strlen($src))==$src) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_frn" style="background-color: Chocolate;"';} ?> onClick="updateData('cat_hbr','id_frn','0',<?php echo $id ?>)"><?php echo $txt->unique->$id_lng; ?></li>
<?php
	$flg_enter = false;
	}
}
if($cbl=='srv') {$rq_frn = sel_whe("cat_frn.id,nom,info","cat_frn_vll INNER JOIN (cat_frn INNER JOIN cat_frn_ctg_srv ON cat_frn_ctg_srv.id_frn = cat_frn.id) ON cat_frn_vll.id_frn = cat_frn.id","cat_frn.id != ".$id_frn." AND ctg_srv = ".$id_ctg." AND id_vll = ".$id_vll." AND lstrg = 0 AND ferme = 0","nom");}
elseif($cbl=='hbr') {$rq_frn = sel_whe("cat_frn.id,nom","cat_frn_vll INNER JOIN (cat_frn INNER JOIN cat_frn_ctg_srv ON cat_frn_ctg_srv.id_frn = cat_frn.id) ON cat_frn_vll.id_frn = cat_frn.id","cat_frn.id != ".$id_frn." AND ctg_srv = 1 AND id_vll = ".$id_vll." AND lstrg = 0 AND ferme = 0","nom");}
while($dt_frn = ftc_ass($rq_frn)) {
	if(substr(upnoac($dt_frn['nom']),0,strlen($src))==$src) {
		if($cbl=='srv') {
?>
	<li <?php if($flg_enter) {echo 'id="enter_frn'.$id_bss.'" style="background-color: Chocolate;"';} ?> onClick="updateData('cat_srv_trf_bss','id_frn',<?php echo $dt_frn['id'].','.$id_bss.','.$id ?>);"><?php echo $dt_frn['nom']; ?></li>
<?php
			$flg_enter = false;
		}
		elseif($cbl=='hbr') {
?>
	<li <?php if($flg_enter) {echo 'id="enter_frn" style="background-color: Chocolate;"';} ?> onClick="updateData('cat_hbr','id_frn',<?php echo $dt_frn['id'].','.$id ?>)"><?php echo $dt_frn['nom']; ?></li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
