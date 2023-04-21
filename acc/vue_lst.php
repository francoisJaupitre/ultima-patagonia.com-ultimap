<?php
if(!isset($_POST['cbl'])){return;}
$cbl = $_POST['cbl'];
unset($_POST['cbl']);
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../prm/aut.php");
include("../prm/lgg.php");
include("../prm/pays.php");
$id_grp = $id_clt = $id_rgn = $id_vll = $id_ctg = $id_pays = $web = 0;
switch($cbl){
	case 'acc':
?>
<div id="vue_acc" class="div_acc frn_dev frn_ope hbr_ope srv_pay srv_pay_pay hbr_pay hbr_pay_pay"><?php include("vue_acc.php"); ?></div>
<?php
		break;
	case 'dev':
	case 'arc':
	case 'cnf':
	case 'fin':
?>
<div id="vue_<?php echo $cbl; ?>" class="div_acc"><?php include("vue_dev.php"); ?></div>
<?php
		break;
	case 'gr0':
	case 'gr1':
?>
<div id="vue_<?php echo $cbl; ?>" class="div_acc"><?php include("vue_grp.php"); ?></div>
<?php
		break;
	case 'crc':
	case 'mdl':
	case 'jrn':
	case 'prs':
	case 'srv':
	case 'hbr':
	case 'clt':
	case 'frn':
	case 'pic':
	case 'rgn':
	case 'vll':
	case 'lieu':
	case 'bnq':
?>
<div id="vue_<?php echo $cbl; ?>" class="div_acc"><?php include("vue_cat.php"); ?></div>
<?php
		break;
	case 'pay':
?>
<span id="vue_pay" class="frn_dev frn_ope srv_pay srv_pay_pay hbr_pay hbr_pay_pay"><?php include("vue_pay.php"); ?></span>
<?php
		break;
	default:
?>
<span id="vue_<?php echo $cbl; ?>" class="<?php echo $cbl; ?>"><?php include("vue_".$cbl.".php"); ?></span>
<?php
}
?>
