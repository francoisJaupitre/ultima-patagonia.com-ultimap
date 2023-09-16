<?php
if(isset($_GET['id']) and $_GET['id']>0){
	$id_grp = $_GET['id'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/ncn.php");
	include("../prm/res_srv.php");
	include("../prm/stat_tsk.php");
	include("../cfg/clt.php");
	include("../cfg/frn.php");
	$rq_pic = sel_quo("pic","cat_pic");
	while($dt_pic = ftc_ass($rq_pic)){$bg[] = $dt_pic['pic'];}
	if(isset($bg)){
		$i = rand(0, count($bg)-1);
		$pic = "$bg[$i]";
	}
	$dt_grp = ftc_ass(sel_quo("*","grp_dev","id",$id_grp));
	$grp = $dt_grp['nomgrp'];
	$clt_grp = $dt_grp['id_clt'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="../prm/forme.css?version=<?php echo date('Y-m-d-H-i-s', filemtime('../prm/forme.css'))  ?>" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script><?php include("script.js");?></script>
		<script><?php include("../prm/script.js");?></script>
	</head>
	<body class="usn">
		<input type="hidden" id="id_grp" value="<?php echo $id_grp; ?>" />
		<input type="hidden" id="autDev" value="<?php echo $aut['dev']; ?>" />
		<input type="hidden" id="autRes" value="<?php echo $aut['res']; ?>" />
		<div id="shadowing"></div>
		<div id="alert"></div>
		<div id="txtHint"><br/></div>
		<div id="bck" style="background-image: url('../pic/<?php echo $dir.'/'.$pic; ?>');"></div>
			<div style="float:right; max-width: 80%;">
				<div class="tbl_prs">
					<div id="pax_grp"><?php include("vue_pax.php"); ?></div>
				</div>
			</div>
			<div class="div_cat2">
				<div class="tbl_crc">
					<table class="dsg" style="width:100%">
						<tr>
							<td>
								<table style="width:100%">
									<tr>
										<td class="fwb"><?php echo $txt->grp->$id_lng.':'; ?></td>
										<td class="w-100">
											<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="text" style="width: 150px; margin-right: 10px;" value="<?php echo stripslashes($grp) ?>" onChange="maj('grp_dev','nomgrp',this.value,<?php echo $id_grp ?>)" />
										</td>
									</tr>
									<tr>
										<td class="fwb"><?php echo $txt->clt->$id_lng.':'; ?></td>
										<td id="clt" class="grp_clt"><?php include("vue_clt.php"); ?></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<table style="width:100%">
									<tr>
										<td class="fwb"><?php echo $txt->notes->$id_lng; ?></td>
										<td style="width: 100%; overflow:hidden;">
											<textarea <?php if(!$aut['dev']){echo ' readonly';} ?> onChange="maj('grp_dev','notes',this.value,<?php echo $id_grp ?>)"><?php echo stripslashes($dt_grp['notes']) ?></textarea>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<table>
				<tr class="vat">
					<td>
						<div id="tsk_grp" class="tbl_prs tsk_grp vatdib"><?php include("vue_tsk.php"); ?></div>
						<div id="fac_grp" class="tbl_prs vatdib"><?php include("vue_fac.php"); ?></div>
					</td>
					<td>
						<div id="res_hbr" class="grp_crc hbr_ope vatdib"><?php include("vue_res_hbr.php"); ?></div>
					</td>
					<td>
						<div id="res_frn" class="grp_crc frn_ope vatdib"><?php include("vue_res_frn.php"); ?></div>
					</td>
					<td>
						<div id="crc" class="grp_crc tbl_prs vatdib"><?php include("vue_crc.php"); ?></div>
					</td>
				</tr>
			</table>
		<script src='../resources/js/common.js'></script>
		<script src='../resources/js/grpScript.js'></script>
	</body>
</html>
<?php
}
?>
