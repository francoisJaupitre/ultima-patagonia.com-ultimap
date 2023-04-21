<ul>
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
if($cbl!='prs') {
	$elem1 = $cbl;
	if($cbl=='jrn_prs') {
		$elem1 .= '_vll';
		if($id_vll>0) {$elem2 = $id_vll.'_';}
		else{$elem2 = '0_';}
	}
	$elem1 .= '_ctg';
	if($id_ctg!=0 and empty($src)) {
?>
	<li onClick="vue_elem('<?php echo $elem1; ?>','<?php echo $elem2; ?>0');"><?php echo $txt->ctg->$id_lng; ?></li>
<?php
	}
}
elseif($dt_prs['ctg']>0 and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src) {
?>
	<li id="enter_ctg_prs" style="background-color: Chocolate;" onClick="maj('cat_prs','ctg','0',<?php echo $id ?>);"><?php echo $txt->nodef->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
foreach($ctg_prs[$id_lng] as $ctg_id => $nom) {
	if(substr(upnoac($nom),0,strlen($src))==$src) {
		if($cbl!='prs' and $id_ctg!=$ctg_id) {
?>		
	<li <?php if($flg_enter) {echo 'id="enter_ctg_prs" style="background-color: Chocolate;"';} ?> onClick="vue_elem('<?php echo $elem1; ?>','<?php echo $elem2.$ctg_id; ?>')"><?php echo $nom; ?></li>
<?php
			$flg_enter = false;
		}
		elseif($cbl=='prs' and $ctg_id != $dt_prs['ctg']) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_ctg_prs" style="background-color: Chocolate;"';} ?>  onClick="maj('cat_prs','ctg',<?php echo $ctg_id.','.$id ?>);"><?php echo $nom; ?></li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>