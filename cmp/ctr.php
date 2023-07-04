<?php
if(isset($_GET['cbl']) and !empty($_GET['cbl'])){
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../cfg/crr.php");
	include("../cfg/fin.php");
	include("../cfg/itm.php");
	$cbl = $_GET['cbl'];
	$rq_pic = sel_quo("pic","cat_pic");
	while($dt_pic = ftc_ass($rq_pic)){$bg[] = $dt_pic['pic'];}
	if(isset($bg)){
		$i = rand(0, count($bg)-1);
		$pic = "$bg[$i]";
	}
	$max = ftc_num(sel_quo("MAX(date)","cmp_fac"));
	$dat_max = $max[0];
	$id_itm = $id_grp = 0;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="../prm/forme.css?version=<?php echo date('Y-m-d-H-i-s', filemtime('../prm/forme.css'))  ?>" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script><?php include("../prm/script.js"); ?></script>
		<script><?php include("script.js");?></script>
	</head>
	<body onload="act_tab();init();">
		<div id="shadowing"></div>
		<div id="txtHint"><br/></div>
		<div id="bck" style="background-image: url('../pic/<?php echo $dir.'/'.$pic; ?>');"></div>
		<input type="hidden" id="cbl" value="<?php echo $cbl; ?>" />
		<input type="hidden" id="aut" value="<?php echo $aut['maj_'.$cbl]; ?>" />
		<span id="vue_<?php echo $cbl ?>"><?php if(empty($dat_min) or $dat_min=='0000-00-00'){echo 'CONFIGUREZ DATE INITIALE DE FINANCES!';} else{include("vue.php");} ?></span>
		<div id="cmp_<?php echo $cbl ?>"></div>
		<script src='../resources/js/script.js'></script>
	</body>
</html>
<?php
}
?>
