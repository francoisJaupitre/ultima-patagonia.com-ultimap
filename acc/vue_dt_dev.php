<?php
$limit = 50;
$i = 0;
if(isset($_POST['rang'])){
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../cfg/clt.php");
	$cbl = $_POST['cbl'];
	unset($_POST['cbl']);
	$id_grp = $_POST['id_grp'];
	$id_clt = $_POST['id_clt'];
	$rang = $_POST['rang'];
}
$var = "dev_crc.*,grp_dev.nomgrp,grp_dev.id_clt";
$tab = "grp_dev INNER JOIN (dev_crc LEFT JOIN (SELECT id_crc, min(date) AS dat, max(date) AS dat2 FROM dev_jrn LEFT JOIN dev_mdl ON dev_mdl.id = dev_jrn.id_mdl WHERE dev_jrn.id_cat>-1 GROUP BY id_crc) jrn ON dev_crc.id = jrn.id_crc) ON grp_dev.id = dev_crc.id_grp";
if($id_clt==0 and $id_grp==0){$col = "cnf";}
elseif($id_clt==0){$col = "id_grp=".$id_grp." AND cnf";}
else{$col = "id_clt=".$id_clt." AND cnf";}
if($cbl == 'dev'){$val = "Null";}
elseif($cbl == 'arc'){$val = "-1";}
elseif($cbl == 'cnf'){$val = "1";}
elseif($cbl == 'fin'){$val = "2";}
if($cbl == 'cnf'){$ord = "dat, groupe";}
elseif($cbl == 'fin'){$ord = "dat2 DESC, groupe";}
else{$ord = "dt_dev DESC, groupe, version DESC";}
$ord .= " LIMIT ";
if($rang==1){$ord .= $limit;}
else{$ord .= (($limit*($rang-1))).",".$limit;}
$rq_dev = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
if(num_rows($rq_dev)==0){return;}
while($dt_dev = ftc_ass($rq_dev)){
	$i++;
	$id_dev = $dt_dev['id'];
	if(!isset($_POST['rang'])){
?>
<tr id="dev<?php echo $id_dev ?>" class="tr">
<?php
	}
	else{echo "dev".$id_dev.'$$';}
?>
	<td class="tbl lnk<?php if($id_usr==$dt_dev['usr']){echo ' fwb';} ?>" onclick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $id_dev ?>');"><?php echo stripslashes($dt_dev['groupe']).' V'.$dt_dev['version'] ?></td>
	<td class='tbl'><?php echo mb_substr(stripslashes($dt_dev['titre']),0,30,'UTF-8'); if(mb_strlen($dt_dev['titre'],'UTF-8')>30){echo '...';} ?></td>
	<td class='tbl'><?php echo $dt_dev['duree'].$txt->lst->dev->jours->$id_lng; ?></td>
	<td class='tbl lnk' onclick="window.parent.opn_frm('grp/ctr.php?id=<?php echo $dt_dev['id_grp'] ?>');"><?php echo $dt_dev['nomgrp'] ?></td>
	<td class='tbl'>
<?php
	if($cbl == 'cnf' or $cbl == 'fin'){echo date("d/m/Y", strtotime($dt_dev['dt_cnf']));}
	else{echo date("d/m/Y", strtotime($dt_dev['dt_dev']));}
?>
	</td>
<?php
	$dt_jrn = ftc_ass(sel_whe("min(date) AS dat","dev_jrn LEFT JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id","dev_jrn.id_cat>-1 AND id_crc=".$id_dev));
?>
	<td class='tbl' style="<?php if($cbl!='fin' and $dt_jrn['dat']<date("Y-m-d")){echo 'color: red';} ?>"><?php if(!empty($dt_jrn['dat']) and $dt_jrn['dat']!='0000-00-00'){echo date("d/m/Y", strtotime($dt_jrn['dat']));} ?></td>
<?php
	if($cbl == 'cnf' or $cbl == 'fin'){
		$dt_jrn = ftc_ass(sel_whe("max(date) AS dat","dev_jrn LEFT JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id","dev_jrn.id_cat>-1 AND id_crc=".$id_dev));
?>
	<td class='tbl' style="<?php if($cbl!='fin' and $dt_jrn['dat']<date("Y-m-d")){echo 'color: red';} ?>"><?php echo date("d/m/Y", strtotime($dt_jrn['dat'])); ?></td>
<?php
	}
?>
	<td class='tbl lnk' onclick="window.parent.opn_frm('cat/ctr.php?cbl=clt&id=<?php echo $dt_dev['id_clt'] ?>');"><?php echo stripslashes($clt[$dt_dev['id_clt']]) ?></td>
	<td>
		<div class="div_cmd" onclick="vue_cmd('vue_cmd_dev<?php echo $id_dev ?>');">
<!--COMMANDES-->
			<img src="../prm/img/cmd.gif" />
			<div id="vue_cmd_dev<?php echo $id_dev ?>" class="cmd wsn">
				<strong><?php echo $txt->cmd->commandes->$id_lng; ?></strong>
				<ul id="<?php echo $id_dev ?>">
					<li onclick="window.parent.opn_frm('fct/vue_trf.php?id=<?php echo $id_dev; ?>');"><?php echo $txt->cmd->voirtarifs->$id_lng; ?></li>
					<li onclick="window.parent.opn_frm('fct/vue_prg.php?cbl=dev&id=<?php echo $id_dev; ?>&id_lgg=<?php echo $dt_dev['lgg']; ?>');"><?php echo $txt->cmd->voirprogramme->$id_lng; ?></li>
					<li class="new-vrs"><?php echo $txt->cmd->vrs->$id_lng; ?></li>
					<li onclick="cop('dev',<?php echo $id_dev ?>);"><?php echo $txt->cmd->copier->$id_lng; ?></li>
<?php
		if($cbl == 'cnf'){
?>
					<li onclick="window.open('../fct/docx_pax.php?id=<?php echo $id_dev ?>&cbl=crc');"><?php echo $txt->cmd->lst_pax->$id_lng; ?></li>
<?php
		}
		if(($cbl == 'dev' or $cbl == 'cnf') and ($aut['dev'] or $id_usr==$dt_dev['usr'])){
?>
					<li onclick="arch(<?php echo "'".$cbl."'" ?>,<?php echo $id_dev ?>);"><?php echo $txt->cmd->archiver->$id_lng; ?></li>
<?php
		}
		if($cbl == 'cnf' and ($aut['dev'] or $id_usr==$dt_dev['usr'])){
?>
					<li onclick="annul(<?php echo $id_dev ?>);"><?php echo $txt->cmd->annuler->$id_lng; ?></li>
<?php
		}
		elseif(($cbl == 'arc' or $cbl == 'fin') and ($aut['dev'] or $id_usr==$dt_dev['usr'])){
?>
					<li onclick="rest(<?php echo "'".$cbl."'" ?>,<?php echo $id_dev ?>);"><?php echo $txt->cmd->restaurer->$id_lng; ?></li>
					<li onclick="del(<?php echo "'".$cbl."'" ?>,<?php echo $id_dev ?>);"><?php echo $txt->cmd->supprimer->$id_lng; ?></li>
<?php
		}
?>
				</ul>
			</div>
		</div>
	</td>
<?php
	if($aut['dev'] or $id_usr==$dt_dev['usr']){
		if($cbl == 'arc'){$flg_sup = true;}
		elseif($cbl == 'dev' or $cbl == 'cnf'){$flg_arc = true;}
?>
	<td><input type="checkbox" class="chk" id="<?php echo $id_dev ?>" /></td>
<?php
	}
	if(!isset($_POST['rang'])){
?>
</tr>
<?php
	}
	elseif($i<$limit){echo '|';}
}
?>
