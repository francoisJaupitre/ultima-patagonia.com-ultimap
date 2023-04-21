<?php
$rq_rmn_pax = select("*","dev_".$cbl."_rmn_pax","id_rmn=".$id_rmn." AND id_pax",$id_pax);
if(num_rows($rq_rmn_pax)>0){
	$dt_rmn_pax = ftc_ass($rq_rmn_pax);
?>
<span id="<?php echo $cbl; ?>_pax_room<?php echo $dt_rmn_pax['id']; ?>" class="wsn"><?php include("vue_pax_room.php"); ?></span>
<?php
}
elseif($aut['dev'] or $aut['res']){
?>
<input type="button" value="<?php echo $txt->ajt->$id_lng ?>" onclick="ajt_rmn_pax('<?php echo $cbl ?>',<?php echo $id_rmn.','.$id_pax ?>)" />
<?php
}
?>
