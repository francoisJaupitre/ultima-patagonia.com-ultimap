<?php
if(isset($_GET['id']) and $_GET['id']>0 and isset($_GET['cbl']) and !empty($_GET['cbl']) and isset($_GET['id_lgg']) and $_GET['id_lgg']>=0){
	$cbl = $_GET['cbl'];
	$id = $_GET['id'];
	$lgg_id = $_GET['id_lgg'];
	$txt = simplexml_load_file('../resources/xml/mainTxt.xml');
	$txt_prg = simplexml_load_file('txt_prg.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	$wdt_img = 230;
	$hl = 12.4;
	include("prg.php");
	include("trf.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="forme.css?version=<?php echo date('Y-m-d-H-i-s', filemtime('forme.css')) ?>" />
		<link rel="stylesheet" type="text/css" href="../prm/forme.css?version=<?php echo date('Y-m-d-H-i-s', filemtime('../prm/forme.css')) ?>" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script><?php include("../prm/script.js"); ?></script>
		<script><?php include("script.js"); ?></script>
		<script>
			var ttr = "<?php echo $ttr ?>";
			$( window ).on( "load",function(){
				$('.majhtml').on('change', function(){
					var val = $(this).val();
					var id_ipt = $(this).attr("id");
					maj_html('<?php echo $cbl ?>',<?php echo $id ?>,<?php echo $lgg_id ?>,encodeURIComponent(val),id_ipt);
				});
			});
		</script>
	</head>
	<body onload="act_tab('prg',<?php echo $id ?>,'<?php echo $cbl ?>',<?php echo $lgg_id ?>);unload('FCT');">
		<div id="shadowing"></div>
		<div id="wrapper">
			<input type="button" value="<?php echo $txt->prg->act->$id_lng; ?>" onclick="vue_dt_prg('<?php echo $cbl ?>',<?php echo $id ?>,<?php echo $lgg_id ?>);" />
			<input type="button" value="<?php echo $txt->prg->pdf->$id_lng; ?>" onclick="pdf_prg('<?php echo $cbl ?>',<?php echo $id ?>,<?php echo $lgg_id ?>);" />
			<input type="button" value="<?php echo $txt->prg->docx->$id_lng; ?>" onclick="window.open('docx_prg.php?cbl=<?php echo $cbl ?>&id=<?php echo $id ?>&id_lgg=<?php echo $lgg_id ?>');" />
		</div>
		<br />
		<br />
		<div class="bck">
			<div class="set">
				<div class="fs_mdl3"><?php echo $txt_prg->vols_dom->$id_lng; ?><input id="vols_dom" type="checkbox" autocomplete="off" <?php if($vols_dom){echo('checked="checked"');} if($vue_vols){echo(' disabled');} ?> onclick="if(this.checked){maj('dev_crc','vols_dom','1',<?php echo $id ?>);$('#lst_vol').prop('disabled',true);}else{maj('dev_crc','vols_dom','0',<?php echo $id ?>);$('#lst_vol').prop('disabled',false);};" /></div>
				<div class="fs_mdl3"><?php echo $txt_prg->lst_vol->$id_lng; ?><input id="lst_vol" type="checkbox" autocomplete="off" <?php if($vue_vols){echo('checked="checked"');} if($vols_dom){echo(' disabled');} ?> onclick="if(this.checked){maj('dev_crc','vue_vols','1',<?php echo $id ?>);$('#vue_vols').show();$('#vols_dom').prop('disabled',true);}else{maj('dev_crc','vue_vols','0',<?php echo $id ?>);$('#vue_vols').hide();$('#vols_dom').prop('disabled',false);};" /></div>
				<div class="fs_mdl3"><?php echo $txt_prg->en_opt->$id_lng; ?><input type="checkbox" autocomplete="off" <?php if($vue_opt){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_crc','vue_opt','1',<?php echo $id ?>);}else{maj('dev_crc','vue_opt','0',<?php echo $id ?>);}" /></div>
				<div class="fs_mdl3"><?php echo $txt_prg->dt_trf->$id_lng; ?><input type="checkbox" autocomplete="off" <?php if($vue_dt_trf){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_crc','vue_dt_trf','1',<?php echo $id ?>)}else{maj('dev_crc','vue_dt_trf','0',<?php echo $id ?>)};" /></div>
				<div class="fs_mdl3"><?php echo $txt_prg->iti->$id_lng; ?><input type="checkbox" autocomplete="off" <?php if($vue_map){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_crc','vue_map','1',<?php echo $id ?>)}else{maj('dev_crc','vue_map','0',<?php echo $id ?>)};" /></div>
				<div class="fs_mdl3"><?php echo $txt_prg->vue_trf->$id_lng; ?><input type="checkbox" autocomplete="off" <?php if($vue_trf){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_crc','vue_trf','1',<?php echo $id ?>);}else{maj('dev_crc','vue_trf','0',<?php echo $id ?>);}" /></div>
<?php
	if($clt_tmpl[$id_clt]==1){
?>
				<div class="fs_mdl3">EUR/USD client<input type="text" autocomplete="off" style="width: 100px" value="<?php echo $dt_crc['tx_clt'] ?>"  onchange="maj('dev_crc','tx_clt',this.value,<?php echo $id ?>);" /></div>
<?php
	}
?>
				<hr />
				<span class="fs_mdl3"><?php echo $txt_prg->saut->$id_lng; ?></span>
				<div class="fs_mdl3"><?php echo $txt_prg->saut_avt->$id_lng; ?><input type="checkbox" autocomplete="off" <?php if($saut_avt){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_crc','saut_avt','1',<?php echo $id ?>);}else{maj('dev_crc','saut_avt','0',<?php echo $id ?>);}" /></div>
				<div class="fs_mdl3"><?php echo $txt_prg->saut_apr->$id_lng; ?><input type="checkbox" autocomplete="off" <?php if($saut_apr){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_crc','saut_apr','1',<?php echo $id ?>);}else{maj('dev_crc','saut_apr','0',<?php echo $id ?>);}" /></div>
				<div id="vue_vols" style="<?php if(!$vue_vols){echo 'display: none;';} ?>"><?php include("vue_vols.php") ?></div>
				<hr />
				<div class="fs_mdl3">
					TOTAL : <input type="text" autocomplete="off" style="width: 100px" value="<?php echo $dt_crc['total'] ?>" onchange="maj('dev_crc','total',this.value,<?php echo $id ?>);" />
					<span id="vue_crr"><?php include("vue_crr.php") ?></span>
				</div>
			</div>
			<div id="vue_dt_prg"><?php include("vue_dt_prg.php"); ?></div>
		</div>
		<script src='../resources/js/common.js'></script>
	</body>
</html>
<?php
}
?>
