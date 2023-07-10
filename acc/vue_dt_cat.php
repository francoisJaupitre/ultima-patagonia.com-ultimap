<?php
$url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = explode('.',$_SERVER['HTTP_HOST']);
if(isset($host[2])) {unset($host[0]);}
$limit = 50;
$i = 0;
if(isset($_POST['rang'])) {
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	$cbl = $_POST['cbl'];
	unset($_POST['cbl']);
	$rang = $_POST['rang'];
	$id_clt = $id_rgn = $id_vll = $id_ctg = $web = 0;
}
switch($cbl) {
	case 'crc':
		$url .= 'www.'.implode('.',$host).'/fr/circuit/';
		if(isset($_POST['id_clt'])) {$id_clt = $_POST['id_clt'];}
		if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
		if(isset($_POST['web'])) {$web = $_POST['web'];}
		$var = "cat_crc.id,nom,titre,dsc,info,web_uid";
		if($flt) {$whr = "(nom LIKE '%".$flt."%' OR titre LIKE '%".$flt."%' OR dsc LIKE '%".$flt."%' OR web_uid LIKE '%".$flt."%') AND ";}
		else{$whr = "";}
		if($web) {$whr .= "web_uid != '' AND ";}
		if(!$id_clt) {
			$tab = "cat_crc LEFT JOIN cat_crc_txt ON cat_crc.id = cat_crc_txt.id_crc AND lgg=".$id_lgg;
			$col = $whr."1";
			$val = "1";
		}
		else{
			$tab = "cat_crc_clt LEFT JOIN (cat_crc LEFT JOIN cat_crc_txt ON cat_crc.id = cat_crc_txt.id_crc AND lgg=".$id_lgg.") ON cat_crc_clt.id_crc = cat_crc.id";
			$col = $whr."id_clt";
			$val = $id_clt;
		}
		$ord = "nom,info,titre LIMIT ";
		if($rang==1) {$ord .= $limit;}
		else{$ord .= (($limit*($rang-1))).",".$limit;}
		$rq_crc = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
		if(num_rows($rq_crc)==0 and isset($_POST['rang'])) {echo '0';}
		while($dt_crc = ftc_ass($rq_crc)) {
			$i++;
			if(!isset($_POST['rang'])) {
?>
<tr id="crc<?php echo $dt_crc['id'] ?>" class="tr">
<?php
			}
			else{echo "crc".$dt_crc['id'].'$$';}
?>
	<td class="tbl lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=crc&id=<?php echo $dt_crc['id'] ?>')"><span id="nom_crc_<?php echo $dt_crc['id'] ?>"><?php echo stripslashes($dt_crc['nom']); ?></span><?php echo stripslashes(' ['.$dt_crc['info'].']'); ?></td>
	<td class='tbl'>
<?php
if(!empty($dt_crc['web_uid'])) {echo '<a href="'.$url.$dt_crc['web_uid'].'" target="_blank">';}
echo mb_substr(stripslashes($dt_crc['titre']),0,50,'UTF-8'); if(mb_strlen($dt_crc['titre'],'UTF-8')>50) {echo '...';}
if(!empty($dt_crc['web_uid'])) {echo '</a>';}
?>
	</td>
	<td class='tbl'>
<?php
			$rq_crc_clt = sel_quo("*","cat_crc_clt LEFT JOIN cat_clt ON cat_crc_clt.id_clt = cat_clt.id","id_crc",$dt_crc['id'],"nom");
			while($dt_crc_clt = ftc_ass($rq_crc_clt)) {echo $dt_crc_clt['nom'].'<br/>';}
?>
	</td>
	<td>
		<div class="div_cmd" onclick="vue_cmd('vue_cmd_crc<?php echo $dt_crc['id'] ?>');">
<!--COMMANDES-->
			<img src="../prm/img/cmd.gif" />
			<div id="vue_cmd_crc<?php echo $dt_crc['id'] ?>" class="cmd wsn">
				<strong><?php echo $txt->cmd->commandes->$id_lng; ?></strong>
				<ul class="ul-cmd" id="<?php echo $dt_crc['id'] ?>">
					<li class="add-dev"><?php echo $txt->cmd->creerdevis->$id_lng; ?></li>
					<li onclick="window.parent.opn_frm('fct/vue_prg.php?cbl=crc&id=<?php echo $dt_crc['id'] ?>&id_lgg=<?php echo $id_lgg ?>');"><?php echo $txt->cmd->apercu->$id_lng; ?></li>
					<li class="copy-elem"><?php echo $txt->cmd->copier->$id_lng; ?></li>
<?php
			if($aut['cat']) {
?>
					<li class="delete-elem"><?php echo $txt->cmd->supprimer->$id_lng; ?></li>
<?php
			}
?>
				</ul>
			</div>
		</div>
	</td>
<?php
			if(!isset($_POST['rang'])) {
?>
</tr>
<?php
			}
			elseif($i<$limit) {echo '|';}
		}
		break;
	case 'mdl':
		$url .= 'www.'.implode('.',$host).'/fr/module/';
		include("../cfg/rgn.php");
		if(isset($_POST['id_rgn'])) {$id_rgn = $_POST['id_rgn'];}
		if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
		if(isset($_POST['web'])) {$web = $_POST['web'];}
		$var = "cat_mdl.id,nom,titre,info,web_uid";
		if($flt) {$whr = "(nom LIKE '%".$flt."%' OR titre LIKE '%".$flt."%' OR dsc LIKE '%".$flt."%' OR web_uid LIKE '%".$flt."%') AND ";}
		else{$whr = "";}
		if($web) {$whr .= "web_uid != '' AND ";}
		if(!$id_rgn) {
			$tab = "cat_mdl LEFT JOIN cat_mdl_txt ON cat_mdl.id = cat_mdl_txt.id_mdl AND lgg=".$id_lgg;
			$col = $whr."1";
			$val = "1";
		}
		else{
			$tab = "cat_mdl_rgn LEFT JOIN (cat_mdl LEFT JOIN cat_mdl_txt ON cat_mdl.id = cat_mdl_txt.id_mdl AND lgg=".$id_lgg.") ON cat_mdl_rgn.id_mdl = cat_mdl.id";
			$col = $whr."id_rgn";
			$val = $id_rgn;
		}
		$ord = "nom,info,titre LIMIT ";
		if($rang==1) {$ord .= $limit;}
		else{$ord .= (($limit*($rang-1))).",".$limit;}
		$rq_mdl = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
		if(num_rows($rq_mdl)==0 and isset($_POST['rang'])) {echo '0';}
		while($dt_mdl = ftc_ass($rq_mdl)) {
			$i++;
			if(!isset($_POST['rang'])) {
?>
<tr id="mdl<?php echo $dt_mdl['id'] ?>" class="tr">
<?php
			}
			else{echo "mdl".$dt_mdl['id'].'$$';}
?>
	<td class="tbl lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=mdl&id=<?php echo $dt_mdl['id'] ?>')"><span id="nom_mdl_<?php echo $dt_mdl['id'] ?>"><?php echo stripslashes($dt_mdl['nom']); ?></span><?php echo stripslashes(' ['.$dt_mdl['info'].']'); ?></td>
	<td class='tbl'>
<?php
			if(!empty($dt_mdl['web_uid'])) {echo '<a href="'.$url.$dt_mdl['web_uid'].'" target="_blank">';}
			echo mb_substr(stripslashes($dt_mdl['titre']),0,50,'UTF-8');
			if(mb_strlen($dt_mdl['titre'],'UTF-8')>50) {echo '...';}
			if(!empty($dt_mdl['web_uid'])) {echo '</a>';}
?>
	</td>
	<td class='tbl'>
<?php
			$rq_mdl_rgn = sel_quo("*","cat_mdl_rgn","id_mdl",$dt_mdl['id']);
			while($dt_mdl_rgn = ftc_ass($rq_mdl_rgn)) {echo $rgn[$dt_mdl_rgn['id_rgn']].'<br/>';}
?>
	<td>
		<div class="div_cmd" onclick="vue_cmd('vue_cmd_mdl<?php echo $dt_mdl['id'] ?>');">
<!--COMMANDES-->
			<img src="../prm/img/cmd.gif" />
			<div id="vue_cmd_mdl<?php echo $dt_mdl['id'] ?>" class="cmd wsn">
				<strong><?php echo $txt->cmd->commandes->$id_lng; ?></strong>
				<ul class="ul-cmd" id="<?php echo $dt_mdl['id'] ?>">
					<li onclick="window.parent.opn_frm('fct/vue_prg.php?cbl=mdl&id=<?php echo $dt_mdl['id'] ?>&id_lgg=<?php echo $id_lgg ?>');"><?php echo $txt->cmd->apercu->$id_lng; ?></li>
					<li class="copy-elem"><?php echo $txt->cmd->copier->$id_lng; ?></li>
<?php
			if($aut['cat']) {
?>
					<li class="delete-elem"><?php echo $txt->cmd->supprimer->$id_lng; ?></li>
<?php
			}
?>
				</ul>
			</div>
		</div>
	</td>
<?php
			if(!isset($_POST['rang'])) {
?>
</tr>
<?php
			}
			elseif($i<$limit) {echo '|';}
		}
		break;
	case 'jrn':
		include("../cfg/vll.php");
		if(isset($_POST['id_vll'])) {$id_vll = $_POST['id_vll'];}
		if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
		$var = "cat_jrn.id,nom,titre,info";
		if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
		else{$whr = "";}
		if(!$id_vll) {
			$tab = "cat_jrn LEFT JOIN cat_jrn_txt ON cat_jrn.id = cat_jrn_txt.id_jrn AND lgg=".$id_lgg;
			$col = $whr."1";
			$val = "1";
		}
		else{
			$tab = "cat_jrn_vll LEFT JOIN (cat_jrn LEFT JOIN cat_jrn_txt ON cat_jrn.id = cat_jrn_txt.id_jrn AND lgg=".$id_lgg.") ON cat_jrn_vll.id_jrn = cat_jrn.id";
			$col = $whr."id_vll";
			$val = $id_vll;
		}
		$ord = "nom,info,titre LIMIT ";
		if($rang==1) {$ord .= $limit;}
		else{$ord .= (($limit*($rang-1))).",".$limit;}
		$rq_jrn = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
		if(num_rows($rq_jrn)==0 and isset($_POST['rang'])) {echo '0';}
		while($dt_jrn = ftc_ass($rq_jrn)) {
			$i++;
			if(!isset($_POST['rang'])) {
?>
<tr id="jrn<?php echo $dt_jrn['id'] ?>" class="tr">
<?php
			}
			else{echo "jrn".$dt_jrn['id'].'$$';}
?>
	<td class="tbl lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=jrn&id=<?php echo $dt_jrn['id'] ?>')"><span id="nom_jrn_<?php echo $dt_jrn['id'] ?>"><?php echo stripslashes($dt_jrn['nom']); ?></span><?php echo stripslashes(' ['.$dt_jrn['info'].']'); ?></td>
	<td class='tbl'><?php  echo mb_substr(stripslashes($dt_jrn['titre']),0,50,'UTF-8'); if(mb_strlen($dt_jrn['titre'],'UTF-8')>50) {echo '...';}  ?></td>
	<td class='tbl'>
<?php
				$rq_jrn_vll = sel_quo("*","cat_jrn_vll","id_jrn",$dt_jrn['id'],"ord");
				while($dt_jrn_vll = ftc_ass($rq_jrn_vll)) {echo $vll[$dt_jrn_vll['id_vll']].'<br/>';}
?>
	</td>
	<td>
		<div class="div_cmd" onclick="vue_cmd('vue_cmd_jrn<?php echo $dt_jrn['id'] ?>');">
<!--COMMANDES-->
			<img src="../prm/img/cmd.gif" />
			<div id="vue_cmd_jrn<?php echo $dt_jrn['id'] ?>" class="cmd wsn">
				<strong><?php echo $txt->cmd->commandes->$id_lng; ?></strong>
				<ul class="ul-cmd" id="<?php echo $dt_jrn['id'] ?>">
					<li class="copy-elem"><?php echo $txt->cmd->copier->$id_lng; ?></li>
<?php
				if($aut['cat']) {
?>
					<li class="delete-elem"><?php echo $txt->cmd->supprimer->$id_lng; ?></li>
<?php
				}
?>
				</ul>
			</div>
		</div>
	</td>
<?php
			if(!isset($_POST['rang'])) {
?>
</tr>
<?php
			}
			elseif($i<$limit) {echo '|';}
		}
		break;
	case 'prs':
		include("../prm/lgg.php");
		include("../prm/ctg_prs.php");
		include("../cfg/vll.php");
		if(isset($_POST['id_vll'])) {$id_vll = $_POST['id_vll'];}
		if(isset($_POST['id_ctg'])) {$id_ctg = $_POST['id_ctg'];}
		if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
		$var = "cat_prs.id,cat_prs.nom,ctg,cat_prs_txt.titre,info";
		if($flt) {$whr = "cat_prs.nom LIKE '%".$flt."%' AND ";}
		else{$whr = "";}
		if(!$id_vll) {
			$tab = "cat_prs LEFT JOIN cat_prs_txt ON cat_prs.id = cat_prs_txt.id_prs AND lgg=".$id_lgg;
			if($id_ctg!=0) {
				$col = $whr."ctg";
				$val = $id_ctg;
			}
			else{
				$col = $whr."1";
				$val = "1";
			}
		}
		else{
			if($id_ctg!=0) {$tab = "cat_prs_lieu LEFT JOIN (cat_prs LEFT JOIN cat_prs_txt ON cat_prs.id = cat_prs_txt.id_prs AND lgg=".$id_lgg.") ON cat_prs_lieu.id_prs = cat_prs.id LEFT JOIN cat_lieu ON cat_prs_lieu.id_lieu = cat_lieu.id";}
			else{$tab = "cat_prs_lieu LEFT JOIN (cat_prs LEFT JOIN cat_prs_txt ON cat_prs.id = cat_prs_txt.id_prs AND lgg=".$id_lgg.") ON cat_prs_lieu.id_prs = cat_prs.id LEFT JOIN cat_lieu ON cat_prs_lieu.id_lieu = cat_lieu.id";}
			if($id_ctg!=0) {
				$col = $whr."id_vll=".$id_vll." AND ctg";
				$val = $id_ctg;
			}
			else{
				$col = $whr."id_vll";
				$val = $id_vll;
			}
		}
		$ord = "nom,info,titre LIMIT ";
		if($rang==1) {$ord .= $limit;}
		else{$ord .= (($limit*($rang-1))).",".$limit;}
		$rq_prs = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
		if(num_rows($rq_prs)==0 and isset($_POST['rang'])) {echo '0';}
		while($dt_prs = ftc_ass($rq_prs)) {
			$i++;
			if(!isset($_POST['rang'])) {
?>
<tr id="prs<?php echo $dt_prs['id'] ?>" class="tr">
<?php
			}
			else{echo "prs".$dt_prs['id'].'$$';}
?>
	<td class="tbl lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $dt_prs['id'] ?>')"><span id="nom_prs_<?php echo $dt_prs['id'] ?>"><?php echo stripslashes($dt_prs['nom']); ?></span><?php echo stripslashes(' ['.$dt_prs['info'].']'); ?></td>
	<td class='tbl'><?php  echo mb_substr(stripslashes($dt_prs['titre']),0,50,'UTF-8'); if(mb_strlen($dt_prs['titre'],'UTF-8')>50) {echo '...';}  ?></td>
	<td class='tbl'>
<?php
			$rq_prs_vll = sel_quo("cat_lieu.id_vll","cat_prs_lieu LEFT JOIN cat_lieu ON cat_prs_lieu.id_lieu = cat_lieu.id","id_prs",$dt_prs['id'],"ord","DISTINCT");
			while($dt_prs_vll = ftc_ass($rq_prs_vll)) {
				if($dt_prs_vll['id_vll']!=0) {echo $vll[$dt_prs_vll['id_vll']].'<br/>';}
			}
?>
	</td>
	<td class='tbl'><?php echo $ctg_prs[$id_lng][$dt_prs['ctg']] ?></td>
	<td>
		<div class="div_cmd" onclick="vue_cmd('vue_cmd_prs<?php echo $dt_prs['id'] ?>');">
<!--COMMANDES-->
			<img src="../prm/img/cmd.gif" />
			<div id="vue_cmd_prs<?php echo $dt_prs['id'] ?>" class="cmd wsn">
				<strong><?php echo $txt->cmd->commandes->$id_lng; ?></strong>
				<ul class="ul-cmd" id="<?php echo $dt_prs['id'] ?>">
					<li class="copy-elem"><?php echo $txt->cmd->copier->$id_lng; ?></li>
<?php
			if($aut['cat']) {
?>
					<li class="delete-elem"><?php echo $txt->cmd->supprimer->$id_lng; ?></li>
<?php
			}
?>
				</ul>
			</div>
		</div>
	</td>
<?php
			if(!isset($_POST['rang'])) {
?>
</tr>
<?php
			}
			elseif($i<$limit) {echo '|';}
		}
		break;
	case 'srv':
		include("../prm/lgg.php");
		include("../prm/ctg_srv.php");
		include("../cfg/vll.php");
		if(isset($_POST['id_vll'])) {$id_vll = $_POST['id_vll'];}
		if(isset($_POST['id_ctg'])) {$id_ctg = $_POST['id_ctg'];}
		if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
		$var = "cat_srv.id,id_vll,ctg,nom,titre,info,t.dt_max,cat_srv.lgg";
		$tab = "cat_srv LEFT JOIN cat_srv_txt ON cat_srv.id = cat_srv_txt.id_srv AND cat_srv_txt.lgg=".$id_lgg." LEFT JOIN (SELECT cat_srv_trf.id_srv AS id_srv,MAX(dt_max) AS dt_max FROM cat_srv_trf_ssn LEFT JOIN cat_srv_trf ON cat_srv_trf_ssn.id_trf=cat_srv_trf.id GROUP BY cat_srv_trf.id_srv) t ON cat_srv.id = t.id_srv";
		if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
		else{$whr = "";}
		if(!$id_vll) {
			if($id_ctg!=0) {
				$col = $whr."ctg";
				$val = $id_ctg;
			}
			else{
				$col = $whr."1";
				$val = "1";
			}
		}
		else{
			if($id_ctg!=0) {
				$col = $whr."ctg = ".$id_ctg." AND id_vll";
				$val = $id_vll;
			}
			else{
				$col = $whr."id_vll";
				$val = $id_vll;
			}
		}
		$ord = "nom,info,titre LIMIT ";
		if($rang==1) {$ord .= $limit;}
		else{$ord .= (($limit*($rang-1))).",".$limit;}
		$rq_srv = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
		if(num_rows($rq_srv)==0 and isset($_POST['rang'])) {echo '0';}
		while($dt_srv = ftc_ass($rq_srv)) {
			$i++;
			if(!isset($_POST['rang'])) {
?>
<tr id="srv<?php echo $dt_srv['id'] ?>" class="tr">
<?php
			}
			else{echo "srv".$dt_srv['id'].'$$';}
?>
	<td class="tbl lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=srv&id=<?php echo $dt_srv['id'] ?>')">
		<span id="nom_srv_<?php echo $dt_srv['id'] ?>"><?php echo stripslashes($dt_srv['nom']); ?></span>
<?php
			if($dt_srv['lgg']>0) {echo '['.$nom_lgg_lgg[$id_lng][$dt_srv['lgg']].']';}
			if(!empty($dt_srv['info'])) {echo stripslashes(' ['.$dt_srv['info'].']');}
?>
	</td>
	<td class='tbl'><?php  echo mb_substr(stripslashes($dt_srv['titre']),0,50,'UTF-8'); if(mb_strlen($dt_srv['titre'],'UTF-8')>50) {echo '...';}  ?></td>
	<td class='tbl'><?php if($dt_srv['id_vll']>0) {echo $vll[$dt_srv['id_vll']];} ?></td>
	<td class='tbl'><?php if($dt_srv['ctg']>0) {echo $ctg_srv[$id_lng][$dt_srv['ctg']];} ?></td>
	<td class='tbl' style="<?php if($dt_srv['dt_max'] < date ('Y-m-d', strtotime ("+1 months"))) {echo 'color: red';} ?>"><?php if($dt_srv['dt_max']!='0000-00-00' and !empty($dt_srv['dt_max'])) {echo date("d/m/Y", strtotime($dt_srv['dt_max']));} ?></td>
	<td>
		<div class="div_cmd" onclick="vue_cmd('vue_cmd_srv<?php echo $dt_srv['id'] ?>');">
<!--COMMANDES-->
			<img src="../prm/img/cmd.gif" />
			<div id="vue_cmd_srv<?php echo $dt_srv['id'] ?>" class="cmd wsn">
				<strong><?php echo $txt->cmd->commandes->$id_lng; ?></strong>
				<ul class="ul-cmd" id="<?php echo $dt_srv['id'] ?>">
					<li class="copy-elem"><?php echo $txt->cmd->copier->$id_lng; ?></li>
<?php
			if($aut['cat']) {
?>
					<li class="delete-elem"><?php echo $txt->cmd->supprimer->$id_lng; ?></li>
<?php
			}
?>
				</ul>
			</div>
		</div>
	</td>
<?php
			if(!isset($_POST['rang'])) {
?>
</tr>
<?php
			}
			elseif($i<$limit) {echo '|';}
		}
		break;
	case 'hbr':
		include("../prm/lgg.php");
		include("../cfg/ctg_hbr.php");
		include("../cfg/vll.php");
		if(isset($_POST['id_vll'])) {$id_vll = $_POST['id_vll'];}
		if(isset($_POST['id_ctg'])) {$id_ctg = $_POST['id_ctg'];}
		if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
		$var = "cat_hbr.id,id_vll,ctg,nom,titre,nvtrf,lstrg,ferme,t.dt_max";
		$tab = "cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$id_lgg." LEFT JOIN (SELECT cat_hbr_chm.id_hbr AS id_hbr,MAX(dt_max) AS dt_max FROM cat_hbr_chm_trf_ssn LEFT JOIN (cat_hbr_chm_trf LEFT JOIN cat_hbr_chm ON cat_hbr_chm_trf.id_chm = cat_hbr_chm.id) ON cat_hbr_chm_trf_ssn.id_trf=cat_hbr_chm_trf.id GROUP BY cat_hbr_chm.id_hbr) t ON cat_hbr.id = t.id_hbr";
		if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
		else{$whr = "";}
		if(!$id_vll) {
			if($id_ctg!=0) {
				$col = $whr."ctg";
				$val = $id_ctg;
			}
			else{
				$col = $whr."1";
				$val = "1";
			}
		}
		else{
			if($id_ctg!=0) {
				$col = $whr."ctg = ".$id_ctg." AND id_vll";
				$val = $id_vll;
			}
			else{
				$col = $whr."id_vll";
				$val = $id_vll;
			}
		}
		$ord = "nom,titre LIMIT ";
		if($rang==1) {$ord .= $limit;}
		else{$ord .= (($limit*($rang-1))).",".$limit;}
		$rq_hbr = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
		if(num_rows($rq_hbr)==0 and isset($_POST['rang'])) {echo '0';}
		while($dt_hbr = ftc_ass($rq_hbr)) {
			$i++;
			if(!isset($_POST['rang'])) {
?>
<tr id="hbr<?php echo $dt_hbr['id'] ?>" class="tr" <?php if($dt_hbr['ferme']) {echo 'style="text-decoration: line-through;"';} elseif($dt_hbr['lstrg']) {echo 'style="color: red;"';} ?>>
<?php
			}
			else{echo "hbr".$dt_hbr['id'].'$$';}
?>
	<td class="tbl lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $dt_hbr['id'] ?>')"><?php echo stripslashes($dt_hbr['nom']) ?></td>
	<td class='tbl'><?php  echo mb_substr(stripslashes($dt_hbr['titre']),0,50,'UTF-8'); if(mb_strlen($dt_hbr['titre'],'UTF-8')>50) {echo '...';}  ?></td>
	<td class='tbl'><?php echo $vll[$dt_hbr['id_vll']] ?></td>
	<td class='tbl'><?php if(isset($ctg_hbr[$id_lng][$dt_hbr['ctg']])) {echo $ctg_hbr[$id_lng][$dt_hbr['ctg']];} ?></td>
	<td class='tbl' style="<?php if($dt_hbr['dt_max'] < date ('Y-m-d', strtotime ("+1 months"))) {echo 'color: red';} ?>"><?php if(!$dt_hbr['ferme']) {if($dt_hbr['dt_max']!='0000-00-00' and !empty($dt_hbr['dt_max'])) {echo date("d/m/Y", strtotime($dt_hbr['dt_max']));}} ?></td>
	<td class='tbl'>
		<input <?php if($dt_hbr['ferme'] or !$aut['cat']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if (!$dt_hbr['ferme'] and $dt_hbr['nvtrf']) {echo('checked="checked"');} ?> onclick="if(this.checked) {maj('cat_hbr','nvtrf','1',<?php echo $dt_hbr['id'] ?>)}else{maj('cat_hbr','nvtrf','0',<?php echo $dt_hbr['id'] ?>)};" />
</td>
<?php
			if($aut['cat']) {
?>
	<td class="delete-elem2" id="<?php echo $dt_hbr['id'] ?>"><img src="../prm/img/sup.png" /></td>
<?php
			}
			if(!isset($_POST['rang'])) {
?>
</tr>
<?php
			}
			elseif($i<$limit) {echo '|';}
		}
		break;
	case 'clt':
		include("../cfg/ctg_clt.php");
		if(isset($_POST['id_ctg'])) {$id_ctg = $_POST['id_ctg'];}
		if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
		$var = "id,id_ctg,nom";
		$tab = "cat_clt";
		if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
		else{$whr = "";}
		if(!$id_ctg) {
			$col = $whr."1";
			$val = "1";
		}
		else{
			$col = $whr."id_ctg";
			$val = $id_ctg;
		}
		$ord = "nom LIMIT ";
		if($rang==1) {$ord .= $limit;}
		else{$ord .= (($limit*($rang-1))).",".$limit;}
		$rq_clt = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
		if(num_rows($rq_clt)==0 and isset($_POST['rang'])) {echo '0';}
		while($dt_clt = ftc_ass($rq_clt)) {
			$i++;
			if(!isset($_POST['rang'])) {
?>
<tr id="clt<?php echo $dt_clt['id'] ?>" class="tr">
<?php
			}
			else{echo "clt".$dt_clt['id'].'$$';}
?>
	<td class="tbl lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=clt&id=<?php echo $dt_clt['id'] ?>')"><?php echo stripslashes($dt_clt['nom']) ?></td>
	<td class='tbl'><?php echo $nom_ctg_clt[$dt_clt['id_ctg']] ?></td>
<?php
			if($aut['cat']) {
?>
<td class="delete-elem2" id="<?php echo $dt_clt['id'] ?>"><img src="../prm/img/sup.png" /></td>
<?php
			}
			if(!isset($_POST['rang'])) {
?>
</tr>
<?php
			}
			elseif($i<$limit) {echo '|';}
		}
		break;
	case 'frn':
		include("../prm/lgg.php");
		include("../prm/ctg_srv.php");
		include("../cfg/vll.php");
		if(isset($_POST['id_vll'])) {$id_vll = $_POST['id_vll'];}
		if(isset($_POST['id_ctg'])) {$id_ctg = $_POST['id_ctg'];}
		if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
		$var = "cat_frn.id,nom,nvtrf,lstrg,ferme";
		if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
		else{$whr = "";}
		if(!$id_vll) {
			if($id_ctg!=0) {
				$tab = "cat_frn_ctg_srv LEFT JOIN cat_frn ON cat_frn_ctg_srv.id_frn = cat_frn.id";
				$col = $whr."ctg_srv";
				$val = $id_ctg;
			}
			else{
				$tab = "cat_frn";
				$col = $whr."1";
				$val = "1";
			}
		}
		else{
			if($id_ctg!=0) {
				$tab  = "cat_frn_vll LEFT JOIN (cat_frn LEFT JOIN cat_frn_ctg_srv ON cat_frn_ctg_srv.id_frn = cat_frn.id)	ON cat_frn_vll.id_frn = cat_frn.id";
				$col = $whr."ctg_srv = ".$id_ctg." AND id_vll";
				$val = $id_vll;
			}
			else{
				$tab = "cat_frn_vll LEFT JOIN cat_frn ON cat_frn_vll.id_frn = cat_frn.id";
				$col = $whr."id_vll";
				$val = $id_vll;
			}
		}
		$ord = "nom,titre LIMIT ";
		if($rang==1) {$ord .= $limit;}
		else{$ord .= (($limit*($rang-1))).",".$limit;}
		$rq_frn = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
		if(num_rows($rq_frn)==0 and isset($_POST['rang'])) {echo '0';}
		while($dt_frn = ftc_ass($rq_frn)) {
			$i++;
			if(!isset($_POST['rang'])) {
?>
<tr id="frn<?php echo $dt_frn['id'] ?>" class="tr" <?php if($dt_frn['ferme']) {echo 'style="text-decoration: line-through;"';} elseif($dt_frn['lstrg']) {echo 'style="color: red;"';} ?>>
<?php
			}
			else{echo "frn".$dt_frn['id'].'$$';}
?>
	<td class='tbl lnk' onclick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $dt_frn['id'] ?>')"><?php echo stripslashes($dt_frn['nom']) ?></td>
	<td class='tbl'>
<?php
			$rq_frn_vll = sel_quo("*","cat_frn_vll","id_frn",$dt_frn['id']);
			while($dt_frn_vll = ftc_ass($rq_frn_vll)) {
				if(isset($vll[$dt_frn_vll['id_vll']])) {echo $vll[$dt_frn_vll['id_vll']].'<br/>';}
			}
?>
	</td>
	<td class='tbl'>
<?php
			$rq_frn_ctg = sel_quo("*","cat_frn_ctg_srv","id_frn",$dt_frn['id']);
			while($dt_frn_ctg = ftc_ass($rq_frn_ctg)) {echo $ctg_srv[$id_lng][$dt_frn_ctg['ctg_srv']].'<br/>';}
?>
	</td>
	<td class='tbl'>
		<input <?php if($dt_frn['ferme'] or !$aut['cat']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if (!$dt_frn['ferme'] and $dt_frn['nvtrf']) {echo('checked="checked"');} ?> onclick="if(this.checked) {maj('cat_frn','nvtrf','1',<?php echo $dt_frn['id'] ?>)}else{maj('cat_frn','nvtrf','0',<?php echo $dt_frn['id'] ?>)};" />
	</tbl>
<?php
			if($aut['cat']) {
?>
	<td class="delete-elem2" id="<?php echo $dt_frn['id'] ?>"><img src="../prm/img/sup.png" /></td>
<?php
			}
			if(!isset($_POST['rang'])) {
?>
</tr>
<?php
			}
			elseif($i<$limit) {echo '|';}
		}
		break;
	case 'pic':
		include("../cfg/rgn.php");
		if(isset($_POST['id_rgn'])) {$id_rgn = $_POST['id_rgn'];}
		$var = "id,id_rgn,pic";
		$tab = "cat_pic";
		if($id_rgn==0) {
			$col = "";
			$val = "";
		}
		else{
			$col = "id_rgn";
			$val = $id_rgn;
		}
		$ord = "pic LIMIT ";
		if($rang==1) {$ord .= $limit;}
		else{$ord .= (($limit*($rang-1))).",".$limit;}
		$rq_pic = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
		if(num_rows($rq_pic)==0 and isset($_POST['rang'])) {echo '0';}
		while($dt_pic = ftc_ass($rq_pic)) {
			$i++;
			if(!isset($_POST['rang'])) {
?>
<tr id="pic<?php echo $dt_pic['id'] ?>" class="tr">
<?php
			}
			else{echo "pic".$dt_pic['id'].'$$';}
?>
	<td class="tbl lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=pic&id=<?php echo $dt_pic['id'] ?>')"><img src="../pic/<?php echo $dir.'/'.$dt_pic['pic']; ?>" style="width:100%;" /></td>
	<td class='tbl'><?php echo $rgn[$dt_pic['id_rgn']] ?></td>
<?php
			if($aut['cat']) {
?>
	<td class="delete-elem2" id="<?php echo $dt_pic['id'] ?>"><img src="../prm/img/sup.png" /></td>
<?php
			}
			if(!isset($_POST['rang'])) {
?>
</tr>
<?php
			}
			elseif($i<$limit) {echo '|';}
		}
		break;
	case 'rgn':
		if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
		$var = "id,nom";
		$tab = "cat_rgn";
		if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
		else{$whr = "";}
		$col = $whr."1";
		$val = "1";
		$ord = "nom LIMIT ";
		if($rang==1) {$ord .= $limit;}
		else{$ord .= (($limit*($rang-1))).",".$limit;}
		$rq_rgn = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
		if(num_rows($rq_rgn)==0 and isset($_POST['rang'])) {echo '0';}
		while($dt_rgn = ftc_ass($rq_rgn)) {
			$i++;
			if(!isset($_POST['rang'])) {
?>
<tr id="rgn<?php echo $dt_rgn['id'] ?>" class="tr">
<?php
			}
			else{echo "rgn".$dt_rgn['id'].'$$';}
?>
	<td class="tbl lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=rgn&id=<?php echo $dt_rgn['id'] ?>')"><?php echo stripslashes($dt_rgn['nom']) ?></td>
<?php
			if($aut['cat']) {
?>
	<td class="delete-elem2" id="<?php echo $dt_rgn['id'] ?>"><img src="../prm/img/sup.png" /></td>
<?php
			}
			if(!isset($_POST['rang'])) {
?>
</tr>
<?php
			}
			elseif($i<$limit) {echo '|';}
		}
		break;
	case 'vll':
		include("../cfg/rgn.php");
		if(isset($_POST['id_rgn'])) {$id_rgn = $_POST['id_rgn'];}
		if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
		$var = "id,id_rgn,nom";
		$tab = "cat_vll";
		if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
		else{$whr = "";}
		if(!$id_rgn) {
			$col = $whr."1";
			$val = "1";
		}
		else{
			$col = $whr."id_rgn";
			$val = $id_rgn;
		}
		$ord = "nom LIMIT ";
		if($rang==1) {$ord .= $limit;}
		else{$ord .= (($limit*($rang-1))).",".$limit;}
		$rq_vll = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
		if(num_rows($rq_vll)==0 and isset($_POST['rang'])) {echo '0';}
		while($dt_vll = ftc_ass($rq_vll)) {
			$i++;
			if(!isset($_POST['rang'])) {
?>
<tr id="vll<?php echo $dt_vll['id'] ?>" class="tr">
<?php
			}
			else{echo "vll".$dt_vll['id'].'$$';}
?>
	<td class="tbl lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=vll&id=<?php echo $dt_vll['id'] ?>')"><?php echo stripslashes($dt_vll['nom']) ?></td>
	<td class='tbl'><?php echo $rgn[$dt_vll['id_rgn']] ?></td>
<?php
			if($aut['cat']) {
?>
	<td class="delete-elem2" id="<?php echo $dt_vll['id'] ?>"><img src="../prm/img/sup.png" /></td>
<?php
			}
			if(!isset($_POST['rang'])) {
?>
</tr>
<?php
			}
			elseif($i<$limit) {echo '|';}
		}
		break;
	case 'lieu':
		include("../cfg/vll.php");
		if(isset($_POST['id_vll'])) {$id_vll = $_POST['id_vll'];}
		if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
		$var = "cat_lieu.id,nom,titre,id_vll";
		$tab = "cat_lieu LEFT JOIN cat_lieu_txt ON cat_lieu.id = cat_lieu_txt.id_lieu AND lgg=".$id_lgg;
		if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
		else{$whr = "";}
		if(!$id_vll) {
			$col = $whr."1";
			$val = "1";
		}
		else{
			$col = $whr."id_vll";
			$val = $id_vll;
		}
		$ord = "nom,titre LIMIT ";
		if($rang==1) {$ord .= $limit;}
		else{$ord .= (($limit*($rang-1))).",".$limit;}
		$rq_lieu = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
		if(num_rows($rq_lieu)==0 and isset($_POST['rang'])) {echo '0';}
		while($dt_lieu = ftc_ass($rq_lieu)) {
			$i++;
			if(!isset($_POST['rang'])) {
?>
<tr id="lieu<?php echo $dt_lieu['id'] ?>" class="tr">
<?php
			}
			else{echo "lieu".$dt_lieu['id'].'$$';}
?>
	<td class="tbl lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=lieu&id=<?php echo $dt_lieu['id'] ?>')"><?php echo mb_substr(stripslashes($dt_lieu['nom']),0,50,'UTF-8'); if(mb_strlen($dt_lieu['nom'],'UTF-8')>50) {echo '...';} ?></td>
	<td class='tbl'><?php  echo mb_substr(stripslashes($dt_lieu['titre']),0,50,'UTF-8'); if(mb_strlen($dt_lieu['titre'],'UTF-8')>50) {echo '...';}  ?></td>
	<td class='tbl'><?php if(isset($vll[$dt_lieu['id_vll']])) {echo $vll[$dt_lieu['id_vll']];} ?></td>
<?php
			if($aut['cat']) {
?>
	<td class="delete-elem2" id="<?php echo $dt_lieu['id'] ?>"><img src="../prm/img/sup.png" /></td>
<?php
			}
			if(!isset($_POST['rang'])) {
?>
</tr>
<?php
			}
			elseif($i<$limit) {echo '|';}
		}
		break;
	case 'bnq':
		include("../prm/pays.php");
		if(isset($_POST['id_pays'])) {$id_pays = $_POST['id_pays'];}
		if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
		$var = "id,nom,id_pays";
		$tab = "cat_bnq";
		if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
		else{$whr = "";}
		if(!$id_pays) {
			$col = $whr."1";
			$val = "1";
		}
		else{
			$col = $whr."id_pays";
			$val = $id_pays;
		}
		$ord = "nom LIMIT ";
		if($rang==1) {$ord .= $limit;}
		else{$ord .= (($limit*($rang-1))).",".$limit;}
		$rq_bnq = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
		if(num_rows($rq_bnq)==0 and isset($_POST['rang'])) {echo '0';}
		while($dt_bnq = ftc_ass($rq_bnq)) {
			$i++;
			if(!isset($_POST['rang'])) {
?>
<tr id="bnq<?php echo $dt_bnq['id'] ?>" class="tr">
<?php
			}
			else{echo "bnq".$dt_bnq['id'].'$$';}
?>
	<td class="tbl lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=bnq&id=<?php echo $dt_bnq['id'] ?>')"><?php echo stripslashes($dt_bnq['nom']) ?></td>
	<td class='tbl'><?php if(isset($pays[$id_lng][$dt_bnq['id_pays']])) {echo $pays[$id_lng][$dt_bnq['id_pays']];} ?></td>
	<?php
			if($aut['cat']) {
?>
	<td class="delete-elem2" id="<?php echo $dt_bnq['id'] ?>"><img src="../prm/img/sup.png" /></td>
<?php
			}
			if(!isset($_POST['rang'])) {
?>
</tr>
<?php
			}
			elseif($i<$limit) {echo '|';}
		}
		break;
}
?>
