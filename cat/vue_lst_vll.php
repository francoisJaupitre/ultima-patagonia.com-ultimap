<ul onclick="document.getElementById('sel_vll').style.display='none';">
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
$elem2='';
if($cbl!='jrn' and $cbl!='srv' and $cbl!='hbr' and $cbl!='frn' and $cbl!='lieu') {
	$elem1 = $cbl.'_vll';
	if($cbl=='jrn_prs' or $cbl=='prs') {
		$elem1 .= '_ctg';
		if($id_ctg>0) {$elem2 = '_'.$id_ctg;}
		else{$elem2 = '_0';}
	}
	elseif($cbl=='mdl') {$elem2 = '_0';}
	elseif($cbl=='pic') {$elem1 .= $id;}
	if((!isset($id_vll) or $id_vll!=0) and empty($src)) {
?>
	<li onClick="vue_elem('<?php echo $elem1."','0".$elem2 ?>')"><?php if($cbl=='mdl') {echo $txt->villedep->$id_lng;}elseif($cbl=='jrn_prs') {echo $txt->vlldep->$id_lng;}else{echo $txt->vll->$id_lng;} ?></li>
<?php
	}
}
elseif(($cbl=='srv' or $cbl=='hbr' or $cbl=='lieu') and $id_vll and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src) {
?>
	<li id="enter_vll" style="background-color: Chocolate;" onClick="maj('cat_<?php echo $cbl ?>','id_vll','0',<?php echo $id ?>);"><?php echo $txt->nodef->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if(!isset($id_vll)) {$id_vll=0;}
foreach($vll as $vll_id => $nom) {
	if(substr(upnoac($nom),0,strlen($src))==$src) {
		if($vll_id!=$id_vll and $cbl!='srv' and $cbl!='hbr' and $cbl!='lieu') {
			if($cbl=='jrn' or $cbl=='frn') {$event = "ajt('".$cbl."_vll',".$vll_id.",'".$cbl."',".$id.")";}
			else{$event = "vue_elem('".$elem1."','".$vll_id.$elem2."')";}
			if($cbl!='jrn_prs') {$uid = 'enter_vll';}
			else{$uid = 'enter_vll_prs';}
			$flg_vll = true;
			if($cbl=='frn') {
				$rq_vll = select("id_vll","cat_frn_vll","id_frn",$id);
				while($dt_vll = ftc_ass($rq_vll)) {
					if($dt_vll['id_vll']==$vll_id) {$flg_vll=false;}
				}
			}
			if($flg_vll) {
?>
	<li <?php if($flg_enter) {echo 'id="'.$uid.'" style="background-color: Chocolate;"';} ?> onClick="<?php echo $event ?>"><?php echo $nom ?></li>
<?php
				$flg_enter = false;
			}
		}
		elseif(($cbl=='srv' or $cbl=='hbr' or $cbl=='lieu') and $vll_id != $id_vll) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_vll" style="background-color: Chocolate;"';} ?> onClick="maj('cat_<?php echo $cbl ?>','id_vll',<?php echo $vll_id.','.$id ?>);"><?php echo $nom; ?></li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
