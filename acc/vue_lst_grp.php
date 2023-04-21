<ul>
<?php
if(!isset($src)){$src='';}
if($id_grp!=0 and empty($src)){
	$event = "vue_dev('".$cbl."','grp','0');";
?>
	<li onClick="<?php echo $event ?>"><?php echo $txt->grp->$id_lng; ?></li>
<?php
}
$flg_enter = true;
$var = "grp_dev.id,nomgrp";
$tab = "grp_dev INNER JOIN dev_crc ON grp_dev.id = dev_crc.id_grp";
$col = "cnf";
if($cbl == 'dev'){
	//$val = "Null";
	$col = "";
	$val = "";
	}
elseif($cbl == 'arc'){$val = "-1";}
elseif($cbl == 'cnf'){$val = "1";}
elseif($cbl == 'fin'){$val = "2";}
$ord = "nomgrp";
$rq_grp = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
while($dt_grp = ftc_ass($rq_grp)){
	if($dt_grp['id']!=$id_grp and substr(upnoac($dt_grp['nomgrp']),0,strlen($src))==$src){
		$event = "vue_dev('".$cbl."','grp','".$dt_grp['id']."');";
?>		
	<li <?php if($flg_enter){echo 'id="enter_grp" style="background-color: Chocolate;"';} ?> onClick="<?php echo $event ?>"><?php echo $dt_grp['nomgrp'] ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>