<h4><?php echo $txt->lst->acc->elemweb->$id_lng.' :' ?></h4>
<?php
if(isset($crc_web)){
?>
<h5><?php echo $txt->lst->acc->crcweb->$id_lng.' :' ?></h5>
<?php
	foreach($crc_web as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=crc&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($mdl_web)){
?>
<h5><?php echo $txt->lst->acc->mdlweb->$id_lng.' :' ?></h5>
<?php
	foreach($mdl_web as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=mdl&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
?>
