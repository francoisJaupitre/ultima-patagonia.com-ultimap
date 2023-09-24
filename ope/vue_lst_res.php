<ul onclick="document.getElementById('sel_res_<?php echo $cbl; if($cbl == 'srv'){echo $dt_res['id_dev_srv'];} elseif($cbl == 'hbr'){echo $dt_res['id_dev_hbr'];} ?>').style.display='none';">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
$uid = 'id="enter_'.$cbl.'_res';
if($cbl == 'srv'){$uid .= $dt_res['id_dev_srv'];}
elseif($cbl == 'hbr'){$uid .= $dt_res['id_dev_hbr'];}
$uid .= '"';
foreach($res_srv[$id_lng] as $res_id => $nom){
	if($res_id != $dt_res['id_'.$cbl.'_res'] and substr(upnoac($nom),0,strlen($src)) == $src){
		if($cbl == 'srv')
		{
			if($src_frn_res_srv[$res_id])
			{
				$param = '{\x22res\x22:'.$res_id.'}';
				$event = "searchSrv(".$dt_res['id_frn'].",'$param',".$dt_res['id_dev_srv'].",".$dt_res['id_crc'].")";
			}else{
				$event = "updateData('dev_srv','res',".$res_id.",".$dt_res['id_dev_srv'].",".$dt_res['id_prs'].",".$dt_res['id_crc'].")";
			}
		}
		elseif($cbl == 'hbr'){$event = "updateData('dev_hbr','res',".$res_id.",".$dt_res['id_dev_hbr'].",".$dt_res['id_prs'].",".$dt_res['id_crc'].");searchHbr(".$dt_res['id_cat_hbr'].",".$dt_res['id_cat_chm'].",0,".$dt_res['id_rgm'].",".$dt_res['id_dev_hbr'].",0,".$res_id.','.$dt_res['id_crc'].");";}
?>
	<li <?php if($flg_enter){echo $uid.' style="background-color: Chocolate;"';} ?> onClick="<?php echo $event; ?>"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
