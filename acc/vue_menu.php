<?php
if(isset($_POST['cbl'])){
	$cbl = $_POST['cbl'];
	unset($_POST['cbl']);
	if(isset($_POST['sub'])){$sub = $_POST['sub'];}
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
}
?>
<input type="hidden" id="cbl" value="<?php echo $cbl ?>" />
<input type="hidden" id="sub" value="<?php echo $sub ?>" />
<ul>
	<li><a class="fwb" style="<?php if($cbl=='acc'){echo 'color: #e10000';}?>" onclick="vue_menu('acc');vue_lst('acc');"><?php echo $txt->acc->$id_lng; ?></a></li>
	<hr />
	<li><a id="main_cat" class="fwb"><?php echo $txt->cat->$id_lng; ?></a></li>
	<ul id="sub_cat" class="sub">
<?php
$cat = array('crc','mdl','jrn','prs','srv','hbr','clt','frn','pic','rgn','vll','lieu','bnq');
foreach($cat as $nom){
?>
		<li><a style="<?php if($cbl==$nom){echo 'color: #e10000';}?>" onclick="vue_menu('<?php echo $nom; ?>','cat');vue_lst('<?php echo $nom; ?>');"><?php echo $txt->$nom->$id_lng; ?></a></li>
<?php
}
?>
	</ul>
	<hr />
	<li><a id="main_dev" class="fwb"><?php echo $txt->dev->$id_lng; ?></a></li>
	<ul id="sub_dev" class="sub">
		<li><a style="<?php if($cbl=='dev'){echo 'color: #e10000';}?>" onclick="vue_menu('dev','dev');vue_lst('dev');"><?php echo $txt->now->$id_lng; ?></a></li>
		<li><a style="<?php if($cbl=='arc'){echo 'color: #e10000';}?>" onclick="vue_menu('arc','dev');vue_lst('arc');"><?php echo $txt->arc->$id_lng; ?></a></li>
	</ul>
	<hr />
	<li><a id="main_cnf" class="fwb"><?php echo $txt->cnf->$id_lng; ?></a></li>
	<ul id="sub_cnf" class="sub">
		<li><a style="<?php if($cbl=='cnf'){echo 'color: #e10000';}?>" onclick="vue_menu('cnf','cnf');vue_lst('cnf');"><?php echo $txt->now->$id_lng; ?></a></li>
		<li><a style="<?php if($cbl=='fin'){echo 'color: #e10000';}?>" onclick="vue_menu('fin','cnf');vue_lst('fin');"><?php echo $txt->arc->$id_lng; ?></a></li>
	</ul>
	<hr />
	<li><a id="main_grp" class="fwb"><?php echo $txt->grp->$id_lng; ?></a></li>
	<ul id="sub_grp" class="sub">
		<li><a style="<?php if($cbl=='gr0'){echo 'color: #e10000';}?>" onclick="vue_menu('gr0','grp');vue_lst('gr0');"><?php echo $txt->now->$id_lng; ?></a></li>
		<li><a style="<?php if($cbl=='gr1'){echo 'color: #e10000';}?>" onclick="vue_menu('gr1','grp');vue_lst('gr1');"><?php echo $txt->cfm->$id_lng; ?></a></li>
	</ul>
	<hr />
	<li><a id="main_ope" class="fwb"><?php echo $txt->ope->$id_lng; ?></a></li>
	<ul id="sub_ope" class="sub">
		<li><a onclick="window.parent.opn_frm('ope/ctr.php?cnf=1')"><?php echo $txt->now->$id_lng; ?></a></li>
		<li><a onclick="window.parent.opn_frm('ope/ctr.php?cnf=2')"><?php echo $txt->arc->$id_lng; ?></a></li>
	</ul>
	<hr />
	<li><a id="main_cmp" class="fwb"><?php echo $txt->cmp->$id_lng; ?></a></li>
	<ul id="sub_cmp" class="sub">
		<li><a onclick="window.parent.opn_frm('cmp/ctr.php?cbl=fac')"><?php echo $txt->fac->$id_lng; ?></a></li>
		<li><a onclick="window.parent.opn_frm('cmp/ctr.php?cbl=clc')"><?php echo $txt->clc->$id_lng; ?></a></li>
		<li><a onclick="window.parent.opn_frm('cmp/ctr.php?cbl=rsm')"><?php echo $txt->rsm->$id_lng; ?></a></li>
	</ul>
<?php
if($aut['fin']){
?>
	<hr />
	<li><a id="main_fin" class="fwb"><?php echo $txt->fin->$id_lng; ?></a></li>
	<ul id="sub_fin" class="sub">
<?php
	$fin = array('ecr','trs','rsl','bln','grp');
	foreach($fin as $nom){
?>
		<li><a onclick="window.parent.opn_frm('fin/ctr.php?cbl=<?php echo $nom ?>')"><?php echo $txt->$nom->$id_lng; ?></a></li>
<?php
	}
?>
	</ul>
<?php
}
?>
</ul>
