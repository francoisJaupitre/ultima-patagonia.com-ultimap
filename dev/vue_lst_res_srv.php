<ul onclick="document.getElementById('sel_res_<?php echo $cbl; if($cbl=='srv'){echo $id_dev_srv;} elseif($cbl=='hbr'){echo $id_dev_hbr;} ?>').style.display='none';">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
$uid = 'id="enter_'.$cbl.'_res';
if($cbl=='srv'){$uid .= $id_dev_srv;}
elseif($cbl=='hbr'){$uid .= $id_dev_hbr;}
$uid .= '"';
foreach($res_srv[$id_lng] as $res_id => $nom){
	if($res_id != $id_res and substr(upnoac($nom),0,strlen($src))==$src){
		if($cbl == 'srv')
		{
			if($src_frn_res_srv[$res_id])
			{
				$param = '{\x22res\x22:'.$res_id.'}';
				$event = "searchSrv(".$dt_srv['id_frn'].",'$param',".$id_dev_srv.")";
			}else{
				$event = "maj('dev_srv','res',".$res_id.",".$id_dev_srv.",".$id_dev_prs.");";
			}
		}
		elseif($cbl=='hbr'){
			$event = "maj('dev_hbr','res',".$res_id.",".$id_dev_hbr.",".$id_dev_prs.");";
			$event .= "searchHbr(".$id_cat_hbr.",".$id_cat_chm.",0,".$id_rgm.",".$id_dev_hbr.",0,".$res_id.");";
		}
?>
	<li <?php if($flg_enter){echo $uid.' style="background-color: Chocolate;"';} ?> onClick="<?php echo $event; ?>"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
