<ul onclick="document.getElementById('sel_<?php echo $cbl.'_pax'; if($cbl=='mdl'){echo $id_dev_mdl;} ?>').style.display='none';">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
$rq_lst = sel_quo("*","grp_pax",array("id_grp","prt"),array($grp_crc,1),"ord");
while($dt_lst = ftc_ass($rq_lst)){
	$nom = $dt_lst['nom'].' '.$dt_lst['pre'];
	if((!isset($lst_pax) or !in_array($dt_lst['id'],$lst_pax)) and substr(upnoac($nom),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_'.$cbl.'_pax'; if($cbl=='mdl'){echo $id_dev_mdl;} echo '" style="background-color: Chocolate;"';} ?> onClick="ajt_pax('<?php echo $cbl; ?>',<?php echo $dt_lst['id']; if($cbl=='mdl'){echo ','.$id_dev_mdl;}; ?>)"><?php echo stripslashes($nom); ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
