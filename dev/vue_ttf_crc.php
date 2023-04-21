<?php
if(isset($_POST['id_dev_crc'])){
	$id_dev_crc = $_POST['id_dev_crc'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	$dt_crc = ftc_ass(select("cnf,id_grp,duree,titre,id_clt,com,mrq_hbr,frs,ty_mrq,crr,lgg","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id_dev_crc));
	$cnf = $dt_crc['cnf'];
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/res_srv.php");
	include("../prm/ty_mrq.php");
	include("../cfg/clt.php");
	include("../cfg/crr.php");
	include("../cfg/hbr_def.php");
	$grp_crc = $dt_crc['id_grp'];
	$rq_grp = select("id","dev_crc","id_grp",$grp_crc);
	if(num_rows($rq_grp)>1){$flg_clt=false;}
	else{$flg_clt=true;}
	$flg_grp=true;
	$rq_grp_crc = select("dev_crc_pax.id","dev_crc_pax","id_crc",$id_dev_crc);
	if(num_rows($rq_grp_crc)>0){$flg_grp=false;}
	elseif($flg_grp){
		$rq_grp_mdl = select("dev_mdl_pax.id","dev_mdl_pax INNER JOIN dev_mdl ON dev_mdl_pax.id_mdl=dev_mdl.id","id_crc",$id_dev_crc);
		if(num_rows($rq_grp_mdl)>0){$flg_grp=false;}
		elseif($flg_grp){
			$rq_grp_srv = sel_whe("dev_srv.id","dev_mdl INNER JOIN (dev_jrn INNER JOIN (dev_prs INNER JOIN dev_srv ON dev_prs.id=dev_srv.id_prs) ON dev_jrn.id=dev_prs.id_jrn) ON dev_mdl.id=dev_jrn.id_mdl","dev_srv.res IN (".implode(',',$maj_grp_res_srv).") AND id_crc =".$id_dev_crc);
			if(num_rows($rq_grp_srv)>0){$flg_grp=false;}
			elseif($flg_grp){
				$rq_grp_hbr = sel_whe("dev_hbr.id","dev_mdl INNER JOIN (dev_jrn INNER JOIN (dev_prs INNER JOIN dev_hbr ON dev_prs.id=dev_hbr.id_prs) ON dev_jrn.id=dev_prs.id_jrn) ON dev_mdl.id=dev_jrn.id_mdl","dev_hbr.res IN (".implode(',',$maj_grp_res_srv).") AND id_crc =".$id_dev_crc);
				if(num_rows($rq_grp_hbr)>0){$flg_grp=false;}
			}
		}
	}
	$duree = $dt_crc['duree'];
	$ttr_crc = $dt_crc['titre'];
	$clt_crc = $dt_crc['id_clt'];
	$com_crc = $dt_crc['com'];
	$mrq_hbr_crc = $dt_crc['mrq_hbr'];
	$frs_crc = $dt_crc['frs'];
	$ty_mrq = $dt_crc['ty_mrq'];
	$id_crr_crc = $dt_crc['crr'];
	$lgg_crc = $dt_crc['lgg'];
}
?>
<td class="lsb">
	<div style="float: right; padding-left: 5px;">
		<span class="vdfp"><?php echo $duree.' '.$txt->jours->$id_lng; ?></span>
		<span id="crc_grp" class="grp vatdib"><?php include("vue_crc_grp.php"); ?></span>
		<span id="clt_crc" class="clt vatdib"><?php include("vue_crc_clt.php"); ?></span>
		<span id="crc_lgg" class="lgg dib"><?php include("vue_crc_lgg.php"); ?></span>
	</div>
	<div class="wsn" style="display: block; overflow: hidden;">
		<strong><?php echo $txt->titre->$id_lng; ?></strong>
		<input <?php if((!$aut['dev'] and $cnf<1) or (!$aut['res'] and $cnf>0)){echo ' disabled';} ?> id="crc_titre<?php echo $id_dev_crc ?>" type="text" class="w-100" value="<?php echo stripslashes(htmlspecialchars($ttr_crc)) ?>" onchange="maj('dev_crc','titre',this.value,<?php echo $id_dev_crc ?>)" />
	</div>
</td>
<td class="dsg">
	<div style="float: right; padding-right: 5px;">
		<span id="crc_hbr_def" style="display: inline-block"><?php include("vue_crc_hbr_def.php"); ?></span>
	</div>
	<div style="display: block; overflow: hidden;">
		<span id="crc_ty_mrq" style="display: inline-block; <?php if(!$aut['dev']){echo 'vertical-align: top;';} ?>"><?php include("vue_crc_ty_mrq.php"); ?></span>
		<span class="vatdib">
			<span id="crc_com"><?php include("vue_crc_com.php"); ?></span>
			<span id="crc_mrq_hbr"><?php include("vue_crc_mrq_hbr.php"); ?></span>
			<strong><?php echo '  |  '.$txt->frs->$id_lng.':'; ?></strong>
			<input <?php if(!$aut['dev']){echo ' disabled';} ?> id="crc_frs<?php echo $id_dev_crc ?>" type="text" style="width: 35px;" value="<?php echo $frs_crc*100 ?>" onChange="maj('dev_crc','frs',this.value.replace(',','.')/100,<?php echo $id_dev_crc ?>)"/>
			<strong><?php echo '%  |  '; ?></strong>
		</span>
		<span id="crc_crr" style="display: inline-block; <?php if(!$aut['dev'] or $cnf>0){echo 'vertical-align: top;';} ?>"><?php include("vue_crc_crr.php") ?></span>
	</div>
</td>
