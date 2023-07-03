<?php
if(isset($_POST['id_dev_prs'])){
	$id_dev_prs = $_POST['id_dev_prs'];
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	$dt_prs = ftc_ass(select("dsc,notes,id_jrn,opt","dev_prs","id",$id_dev_prs));
	$opt_prs = $dt_prs['opt'];
	$dsc_prs = $dt_prs['dsc'];
	$not_prs = $dt_prs['notes'];
	$id_dev_jrn = $dt_prs['id_jrn'];
	$dt_jrn = ftc_ass(select("id_mdl","dev_jrn","id",$id_dev_jrn));
	$id_dev_mdl = $dt_jrn['id_mdl'];
}
?>
<td class="<?php if($opt_prs){echo 'lmcf';} else{echo 'tht';} ?>" style="text-align: center;">
	<div style="float: left; margin-top: 5px;">
		<strong><?php echo $txt->dsc->$id_lng.'<BR />'.$txt->prs->$id_lng; ?></strong>
	</div>
	<div style="margin-left: 105px; margin-right: 5px; position: relative;">
		<div id="ld_prs_dsc<?php echo $id_dev_prs ?>" class="loader"><img style="position:relative;top:50%;transform: translateY(-50%)" src="../prm/img/loader.gif"></div>
		<div id="prs_dsc<?php echo $id_dev_prs ?>" class="ust rich rich_dt_crc rich_dt_mdl<?php echo $id_dev_mdl ?> rich_dt_jrn<?php echo $id_dev_jrn ?> rich_dsc_prs<?php echo $id_dev_prs ?>" <?php if(($aut['dev'] and $cnf<1) or ($aut['res'] and $cnf>0)){ ?> onclick="richTxtInit(this.id,'dev_prs','dsc',<?php echo $id_dev_prs ?>);this.onclick=null;" <?php } ?> ><?php echo nl2br(stripslashes($dsc_prs)) ?></div>
		<div id="tool_prs_dsc<?php echo $id_dev_prs ?>" class="tool"></div>
		<img hidden src onerror="$('#prs_dsc<?php echo $id_dev_prs ?>').css('pointer-events','auto');" /><?php //no se encuentra en dsc_crc ?>
	</div>
</td>
<td class="dsg" style="text-align: center;">
	<div style="float: left; margin-top: 5px;">
		<strong><?php echo $txt->notes->$id_lng.'<BR />'.$txt->internes->$id_lng; ?></strong>
	</div>
	<div style="margin-left: 65px; margin-right: 5px;">
		<textarea <?php if(!$aut['dev'] and !$aut['res']){echo ' readonly';} ?> style="height: 40px;" onChange="maj('dev_prs','notes',this.value,<?php echo $id_dev_prs ?>)"><?php echo stripslashes($not_prs) ?></textarea>
	</div>
</td>
