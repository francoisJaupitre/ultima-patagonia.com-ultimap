<?php
if(isset($_POST['id_dev_crc'])){
	$id_dev_crc = $_POST['id_dev_crc'];
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	$dt_crc = ftc_ass(select("dsc,info","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id_dev_crc));
	$dsc_crc = $dt_crc['dsc'];
	$inf_crc = $dt_crc['info'];
}
?>
<td class="lsb" style="text-align: center;">
	<div style="float: left; margin-top: 5px;">
		<strong><?php echo $txt->dsc->$id_lng.'<BR />'.$txt->crc->$id_lng; ?></strong>
	</div>
	<div style="margin-left: 105px; margin-right: 5px; position: relative;">
		<div id="ld_crc_dsc" class="loader"><img style="position:relative;top:50%;transform: translateY(-50%)" src="../prm/img/loader.gif"></div>
		<div id="crc_dsc" class="ust rich" <?php if(($aut['dev'] and $cnf<1) or ($aut['res'] and $cnf>0)){ ?> onclick="richTxtInit(this.id,'dev_crc','dsc',<?php echo $id_dev_crc ?>);this.onclick=null;" <?php } ?> ><?php echo nl2br(stripslashes($dsc_crc)) ?></div>
		<div id="tool_crc_dsc" class="tool"></div>
	</div>
</td>
<td class="dsg" style="text-align: center;">
	<div style="float: left; margin-top: 5px;">
		<strong><?php echo $txt->infos->$id_lng.'<BR />'.$txt->crc->$id_lng; ?></strong>
	</div>
	<div style="margin-left: 65px; margin-right: 5px;">
		<textarea <?php if(!$aut['dev'] and !$aut['res']){echo ' readonly';} ?> style="height: 40px;" onChange="maj('dev_crc','info',this.value,<?php echo $id_dev_crc ?>)"><?php echo stripslashes($inf_crc); ?></textarea>
	</div>
</td>
