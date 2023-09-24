<?php
if(isset($_POST['id_dev_jrn'])){
	$id_dev_jrn = $_POST['id_dev_jrn'];
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/col.php");
	include("../cfg/rgn.php");
	$dt_jrn = ftc_ass(select("opt,dsc,id_mdl,id_pic,id_cat","dev_jrn","id",$id_dev_jrn));
	$opt_jrn = $dt_jrn['opt'];
	$dsc_jrn = $dt_jrn['dsc'];
	$id_pic_jrn = $dt_jrn['id_pic'];
	$id_dev_mdl = $dt_jrn['id_mdl'];
	$dt_mdl = ftc_ass(select("col","dev_mdl","id",$id_dev_mdl));
	$id_col_mdl = $dt_mdl['col'];
	$id_rgn = 0;
}
?>
<tr>
	<td class="<?php if($opt_jrn){echo 'lcrl';} else{echo 'tht';} ?>" style="text-align: center;">
		<strong><?php echo $txt->dsc->$id_lng.'<br />'.$txt->jrn->$id_lng; ?></strong>
	</td>
	<td class="<?php if($opt_jrn){echo 'lcrl';} else{echo 'tht';} ?>" style="width:100%; text-align: center;">
		<div style="margin-right: 5px; position: relative" onload="alt('load')">
			<div id="ld_jrn_dsc<?php echo $id_dev_jrn ?>" class="loader"><img style="position:relative;top:50%;transform: translateY(-50%)" src="../resources/gif/loader.gif"></div>
			<div id="jrn_dsc<?php echo $id_dev_jrn ?>" class="ust rich rich_dt_crc rich_dt_mdl<?php echo $id_dev_mdl ?> rich_dsc_jrn<?php echo $id_dev_jrn ?>" style="height: 80px; color: #<?php echo $col[$id_col_mdl]; ?>" <?php if(($aut['dev'] and $cnf<1) or ($aut['res'] and $cnf>0)){ ?> onclick="richTxtInit(this.id,'dev_jrn','dsc',<?php echo $id_dev_jrn ?>);this.onclick=null;" <?php } ?> ><?php echo nl2br(stripslashes($dsc_jrn)) ?></div>
			<div id="tool_jrn_dsc<?php echo $id_dev_jrn ?>" class="tool"></div>
			<img hidden src onerror="$('#jrn_dsc<?php echo $id_dev_jrn ?>').css('pointer-events','auto');" />
		</div>
	</td>
	<td class="<?php if($opt_jrn){echo 'lcrl';} else{echo 'tht';} ?>" style="text-align: center;">
		<span id="pic_rgn<?php echo $id_dev_jrn ?>" class="rgn"><?php include("vue_pic_rgn.php"); ?></span>
	</td>
</tr>
