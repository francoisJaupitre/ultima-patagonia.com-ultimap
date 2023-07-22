<ul>
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
if($cbl!='srv' and $cbl!='frn') {
	$elem1 = $cbl;
	if($cbl=='prs') {
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
elseif($cbl!='frn' and $id_ctg>0 and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src) {
?>
	<li id="enter_ctg_srv" style="background-color: Chocolate;" onClick="updateData('cat_srv','ctg','0',<?php echo $id ?>);"><?php echo $txt->nodef->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
foreach($ctg_srv[$id_lng] as $ctg_id => $nom) {
	if(substr(upnoac($nom),0,strlen($src))==$src) {
		if($id_ctg!=$ctg_id and $cbl!='srv') {
			if($cbl=='frn') {$event = "ajt('frn_ctg_srv',".$ctg_id.",'frn',".$id.")";}
			else{$event = "vue_elem('".$elem1."','".$elem2.$ctg_id."')";}
			$flg_ctg = true;
			if($cbl=='frn') {
				$rq_ctg = select("ctg_srv","cat_frn_ctg_srv","id_frn",$id);
				while($dt_ctg = ftc_ass($rq_ctg)) {
					if($dt_ctg['ctg_srv']==$ctg_id) {$flg_ctg=false;}
				}
			}
			if($flg_ctg) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_ctg_srv" style="background-color: Chocolate;"';} ?> onClick="<?php echo $event; ?>"><?php echo $nom; ?></li>
<?php
				$flg_enter = false;
			}
		}
		elseif($cbl=='srv' and $ctg_id != $id_ctg['ctg'] and $ctg_id != 1) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_ctg_srv" style="background-color: Chocolate;"';} ?>  onClick="updateData('cat_srv','ctg',<?php echo $ctg_id.','.$id ?>);"><?php echo $nom; ?></li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
