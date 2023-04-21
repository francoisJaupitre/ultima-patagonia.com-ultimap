<?php
if(isset($_POST['cbl'])){
	$cbl = $_POST['cbl'];
	unset($_POST['cbl']);
	$id_clt = $_POST['id_clt'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
}
else{$id_clt = 0;}
include("../cfg/clt.php");
$rang = 1
?>
<table class="tbl_acc">
	<tr>
		<td>
			<table id="tab_grp">
				<tr class="fwb">
					<td class='tbl'>
<?php
switch($cbl){
	case 'gr0':
		if($id_clt==0){$nb_grp = ftc_ass(sel_whe("COUNT(DISTINCT id) as total","grp_dev LEFT JOIN (SELECT DISTINCT(id_grp) FROM dev_crc WHERE cnf>0) t ON grp_dev.id=t.id_grp LEFT JOIN (SELECT DISTINCT(id_grp) FROM fin_bdg) t2 ON grp_dev.id=t2.id_grp","t.id_grp IS NULL AND t2.id_grp IS NULL"));}
		else{$nb_grp = ftc_ass(sel_whe("COUNT(DISTINCT id) as total","grp_dev LEFT JOIN (SELECT DISTINCT(id_grp) FROM dev_crc WHERE cnf>0) t ON grp_dev.id=t.id_grp LEFT JOIN (SELECT DISTINCT(id_grp) FROM fin_bdg) t2 ON grp_dev.id=t2.id_grp","(t.id_grp IS NULL AND t2.id_grp IS NULL) AND id_clt=".$id_clt));}
		echo $nb_grp['total'].' '.$txt->grp->$id_lng;
		break;
	case 'gr1':
		if($id_clt==0){$nb_grp = ftc_ass(sel_whe("COUNT(DISTINCT id) as total","grp_dev LEFT JOIN (SELECT DISTINCT(id_grp) FROM dev_crc WHERE cnf>0) t ON grp_dev.id=t.id_grp LEFT JOIN (SELECT DISTINCT(id_grp) FROM fin_bdg) t2 ON grp_dev.id=t2.id_grp","t.id_grp IS NOT NULL OR t2.id_grp IS NOT NULL"));}
		else{$nb_grp = ftc_ass(sel_whe("COUNT(DISTINCT id) as total","grp_dev LEFT JOIN (SELECT DISTINCT(id_grp) FROM dev_crc WHERE cnf>0) t ON grp_dev.id=t.id_grp LEFT JOIN (SELECT DISTINCT(id_grp) FROM fin_bdg) t2 ON grp_dev.id=t2.id_grp","(t.id_grp IS NOT NULL OR t2.id_grp IS NOT NULL) AND id_clt=".$id_clt));}
		echo $nb_grp['total'].' '.$txt->grp->$id_lng;
		break;
}
?>
					</td>
					<td class='tbl'><?php echo $txt->crc->$id_lng; ?></td>
					<td class='tbl'>
						<div class="sel" onclick="vue_cmd('sel_clt')">
							<img src="../prm/img/sel.png" />
							<div>
								<input type="hidden" id="clt" value="<?php echo $id_clt ?>" />
<?php
		if($id_clt==0){echo $txt->clt->$id_lng;}
		else{echo $clt[$id_clt];}
?>
							</div>
						</div>
						<div id="sel_clt" class="cmd mw200">
							<input type="text" id="ipt_sel_clt" onkeyup="auto_lst('<?php echo $cbl ?>','clt',this.value,event);" />
							<div id="lst_clt"><?php include("vue_lst_clt.php") ?></div>
						</div>
					</td>
<?php
if($cbl=='gr0'){
?>
					<td class="text-center" onclick="ajt('grp',0);">
						<img src="../prm/img/ajt.png" />
					</td>
<?php
}
?>
				</tr>
<?php
include("vue_dt_grp.php");
?>
			</table>
		</td>
	</tr>
<?php
if($cbl == 'gr0'){
?>
	<tr>
		<td class="text-right">
<?php
	echo $txt->cmd->elements->$id_lng;
?>
			<span class="dib" onClick="del_pls('grp');"><img src="../prm/img/sup.png" /></span>
		</td>
	</tr>
<?php
}
?>
</table>
<br/><br/><br/><br/><br/>
