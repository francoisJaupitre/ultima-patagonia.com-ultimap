<ul onclick="document.getElementById('sel_crr<?php if($cbl=='srv'){echo '_'.$cbl.$id_dev_srv;} elseif($cbl=='chm' or $cbl=='rgm'){echo '_'.$cbl.$id_dev_hbr;} elseif($cbl=='srv_pay'){echo '_'.$cbl.$id_srv_pay;} elseif($cbl=='hbr_pay'){echo '_'.$cbl.$id_hbr_pay;} ?>').style.display='none';">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
$uid = 'id="enter_';
if($cbl=='crc'){$uid .= 'crr';}
elseif($cbl=='srv'){$uid .= 'srv_crr'.$id_dev_srv;}
elseif($cbl=='chm' or $cbl=='rgm'){$uid .= $cbl.'_crr'.$id_dev_hbr;}
elseif($cbl=='srv_pay'){$uid .= 'srv_pay_crr'.$id_srv_pay;}
elseif($cbl=='hbr_pay'){$uid .= 'hbr_pay_crr'.$id_hbr_pay;}
$uid .= '"';
foreach($cfg_crr_nom as $crr_id => $nom){
	if($crr_id != $id_crr and substr(upnoac($nom),0,strlen($src))==$src){
		if($cbl=='crc'){$event = "maj('dev_crc','crr',".$crr_id.",".$id_dev_crc.")";}
		elseif($cbl=='srv'){$event = "maj('dev_srv','crr',".$crr_id.",".$id_dev_srv.")";}
		elseif($cbl=='chm' or $cbl=='rgm'){$event = "maj('dev_hbr','crr_".$cbl."',".$crr_id.",".$id_dev_hbr.")";}
		elseif($cbl=='srv_pay'){$event = "maj('dev_srv_pay','crr',".$crr_id.",".$id_srv_pay.")";}
		elseif($cbl=='hbr_pay'){$event = "maj('dev_hbr_pay','crr',".$crr_id.",".$id_hbr_pay.")";}
?>
	<li <?php if($flg_enter){echo $uid.' style="background-color: Chocolate;"';} ?> onClick="<?php echo $event; ?>"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
