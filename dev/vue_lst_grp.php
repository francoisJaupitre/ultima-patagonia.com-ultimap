<ul onclick="document.getElementById('sel_grp').style.display='none';">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
if(substr(upnoac($txt->opn->$id_lng),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_grp" style="background-color: Chocolate;"';} ?> onClick="window.parent.opn_frm('grp/ctr.php?id=<?php echo $grp_crc; ?>');"><?php echo $txt->opn->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if(substr(upnoac($txt->creer->$id_lng),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_grp" style="background-color: Chocolate;"';} ?> onClick="ajt_grp(<?php echo $clt_crc ?>)"><?php echo $txt->creer->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
$rq_sel_grp = select("id,nomgrp","grp_dev","","","id DESC");
while($dt_sel_grp = ftc_ass($rq_sel_grp)){
	if($dt_sel_grp['id'] != $grp_crc and substr(upnoac($dt_sel_grp['nomgrp']),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_grp" style="background-color: Chocolate;"';} ?> onClick="maj('dev_crc','id_grp',<?php echo $dt_sel_grp['id'].','.$id_dev_crc ?>)"><?php echo stripslashes($dt_sel_grp['nomgrp']); ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
