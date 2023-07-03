<?php
if(isset($_POST['id_dev_mdl'])){
	$id_dev_mdl = $_POST['id_dev_mdl'];
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/col.php");
	$dt_mdl = ftc_ass(select("col,dsc,info","dev_mdl","id",$id_dev_mdl));
	$id_col_mdl = $dt_mdl['col'];
	$dsc_mdl = $dt_mdl['dsc'];
	$inf_mdl = $dt_mdl['info'];
}
?>
<table class="w-100">
	<tr>
		<td class="lslm" style="text-align: center;" colspan="2">
			<div style="float: left; margin-top: 5px;">
				<strong><?php echo $txt->dsc->$id_lng.'<BR />'.$txt->mdl->$id_lng; ?></strong>
			</div>
			<div style="margin-left: 105px; margin-right: 5px; position: relative">
				<div id="ld_mdl_dsc<?php echo $id_dev_mdl ?>" class="loader"><img style="position:relative;top:50%;transform: translateY(-50%)" src="../prm/img/loader.gif"></div>
				<div id="mdl_dsc<?php echo $id_dev_mdl ?>" class="ust rich rich_dt_crc rich_dsc_mdl<?php echo $id_dev_mdl ?>" style="color: #<?php echo $col[$id_col_mdl]; ?>" <?php if(($aut['dev'] and $cnf<1) or ($aut['res'] and $cnf>0)){ ?> onclick="richTxtInit(this.id,'dev_mdl','dsc',<?php echo $id_dev_mdl ?>);this.onclick=null;" <?php } ?> ><?php echo nl2br(stripslashes($dsc_mdl)) ?></div>
				<div id="tool_mdl_dsc<?php echo $id_dev_mdl ?>" class="tool"></div>
				<img hidden src onerror="$('#mdl_dsc<?php echo $id_dev_mdl ?>').css('pointer-events','auto');" />
			</div>
		</td>
		<td class="dsg" style="text-align: center;width: 40%;">
			<div style="float: left; margin-top: 5px;">
				<strong><?php echo $txt->infos->$id_lng.'<BR />'.$txt->mdl->$id_lng; ?></strong>
			</div>
			<div style="margin-left: 65px; margin-right: 5px;">
				<textarea <?php if(!$aut['dev'] and !$aut['res']){echo ' readonly';} ?> style="height: 40px;" onChange="maj('dev_mdl','info',this.value,<?php echo $id_dev_mdl ?>)"><?php echo stripslashes($inf_mdl); ?></textarea>
			</div>
		</td>
	</tr>
</table>
