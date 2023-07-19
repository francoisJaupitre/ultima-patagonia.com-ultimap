<?php
if(isset($_POST['cbl'])){
	$cbl = $_POST['cbl'];
	unset($_POST['cbl']);
	$id_grp = $_POST['id_grp'];
	$id_clt = $_POST['id_clt'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
}
else{$id_grp = $id_clt = 0;}
include("../cfg/clt.php");
$rang = 1
?>
<table class="tbl_acc">
	<tr>
		<td>
			<table id="tab_dev">
				<tr class="fwb">
					<td class='tbl'>
<?php
switch($cbl){
	case 'dev':
		if($id_clt==0 and $id_grp==0){$nb_dev = ftc_ass(sel_quo("COUNT(*) as total","dev_crc","cnf","NULL"));}
		elseif($id_clt==0){$nb_dev = ftc_ass(sel_quo("COUNT(*) as total","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("id_grp","cnf"),array($id_grp,"NULL")));}
		else{$nb_dev = ftc_ass(sel_quo("COUNT(*) as total","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("id_clt","cnf"),array($id_clt,"NULL")));}
		echo $nb_dev['total'].' '.$txt->dev->$id_lng.'&#xA;'.$txt->encours->$id_lng;
		$cnf = "Null";
		break;
	case 'arc':
		if($id_clt==0 and $id_grp==0){$nb_arc = ftc_ass(sel_quo("COUNT(*) as total","dev_crc","cnf","-1"));}
		elseif($id_clt==0){$nb_arc = ftc_ass(sel_quo("COUNT(*) as total","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("id_grp","cnf"),array($id_grp,"-1")));}
		else{$nb_arc = ftc_ass(sel_quo("COUNT(*) as total","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("id_clt","cnf"),array($id_clt,"-1")));}
		echo $nb_arc['total'].' '.$txt->dev->$id_lng.'&#xA;'.$txt->archives->$id_lng;
		$cnf = "-1";
		break;
	case 'cnf':
		if($id_clt==0 and $id_grp==0){$nb_cnf = ftc_ass(sel_quo("COUNT(*) as total","dev_crc","cnf","1"));}
		elseif($id_clt==0){$nb_cnf = ftc_ass(sel_quo("COUNT(*) as total","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("id_grp","cnf"),array($id_grp,"1")));}
		else{$nb_cnf = ftc_ass(sel_quo("COUNT(*) as total","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("id_clt","cnf"),array($id_clt,"1")));}
		echo $nb_cnf['total'].' '.$txt->cnf->$id_lng.'&#xA;'.$txt->encours->$id_lng;
		$cnf = "1";
		break;
	case 'fin':
		if($id_clt==0 and $id_grp==0){$nb_fin = ftc_ass(sel_quo("COUNT(*) as total","dev_crc","cnf","2"));}
		elseif($id_clt==0){$nb_fin = ftc_ass(sel_quo("COUNT(*) as total","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("id_grp","cnf"),array($id_grp,"2")));}
		else{$nb_fin = ftc_ass(sel_quo("COUNT(*) as total","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("id_clt","cnf"),array($id_clt,"2")));}
		echo $nb_fin['total'].' '.$txt->cnf->$id_lng.'&#xA;'.$txt->archives->$id_lng;
		$cnf = "2";
		break;
}
?>
					</td>
					<td class='tbl'><?php echo $txt->lst->cat->titre->$id_lng; ?></td>
					<td class='tbl'><?php echo $txt->lst->dev->duree->$id_lng; ?></td>
					<td class='tbl'>
						<div class="sel" onclick="vue_cmd('sel_grp')">
							<img src="../prm/img/sel.png" />
							<div>
								<input type="hidden" id="grp" value="<?php echo $id_grp ?>" />
<?php
		if($id_grp==0){echo $txt->grp->$id_lng;}
		else{
			$dt_grp = ftc_ass(sel_quo("nomgrp","grp_dev","id",$id_grp));
			echo $dt_grp['nomgrp'];
			}
?>
							</div>
						</div>
						<div id="sel_grp" class="cmd mw200">
							<input type="text" id="ipt_sel_grp" onkeyup="auto_lst('<?php echo $cbl ?>','grp',this.value,event);" />
							<div id="lst_grp"><?php include("vue_lst_grp.php") ?></div>
						</div>
					</td>
					<td class='tbl'>
<?php
if($cbl == 'cnf' or $cbl == 'fin'){echo $txt->lst->dev->dateconfirmation->$id_lng;}
else{echo $txt->lst->dev->datecreation->$id_lng;}
?>
					</td>
					<td class='tbl'><?php echo $txt->lst->dev->datearrivee->$id_lng; ?></td>
<?php
if($cbl == 'cnf' or $cbl == 'fin'){
?>
					<td class='tbl'><?php echo $txt->lst->dev->datedepart->$id_lng; ?></td>
<?php
}
?>
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
if($cbl=='dev'){
?>
					<td class="text-center" id="addDev">
						<img src="../prm/img/ajt.png" />
					</td>
<?php
}
?>
				</tr>
<?php
$flg_sup = $flg_arc = false;
include("vue_dt_dev.php");
?>
			</table>
		</td>
	</tr>
<?php
if($flg_sup){
?>
	<tr>
		<td class="text-right">
<?php
	echo $txt->cmd->elements->$id_lng;
?>
			<span class="dib" id="deleteElems"><img src="../prm/img/sup.png" /></span>
		</td>
	</tr>
<?php
}
elseif($flg_arc){
?>
	<tr>
		<td class="text-right">
<?php
	echo $txt->cmd->elements->$id_lng;
?>
			<span class="dib" id="archiveElems"><img src="../prm/img/arch.png" /></span>
		</td>
	</tr>
<?php
}
?>
</table>
<br/><br/><br/><br/><br/>
