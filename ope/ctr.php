<?php
if(isset($_GET['cnf']) and !empty($_GET['cnf'])){
	$txt = simplexml_load_file('txt.xml');
	$cnf = $_GET['cnf'];
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/ctg_srv.php");
	include("../prm/ctg_prs.php");
	include("../prm/res_prs.php");
	include("../prm/res_srv.php");
	include("../cfg/crr.php");
	include("../cfg/frn.php");
	include("../cfg/vll.php");
	$rq_pic = sel_quo("pic","cat_pic");
	while($dt_pic = ftc_ass($rq_pic)){$bg[] = $dt_pic['pic'];}
	if(isset($bg)){
		$i = rand(0, count($bg)-1);
		$pic = "$bg[$i]";
	}
	$id_ctg = 0;
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
	<body class="usn">
		<div id="shadowing"></div>
		<div id="alert"></div>
		<div id="txtHint"><br/></div>
		<div id="bck" style="background-image: url('../pic/<?php echo $dir.'/'.$pic; ?>');"></div>
		<span id="vue"><?php include("vue.php"); ?></span>
		<script src='../vendor/tinymce/tinymce.min.js'></script>
		<script src='../resources/js/script.js'></script>
		<script src='../resources/js/richTxt.js'></script>
		<script src='../resources/js/opeMail.js'></script>
		<script src='../resources/js/opeCmd.js'></script>
		<script src='../resources/js/opeLoad.js'></script>
	</body>
</html>
<?php
}
?>
