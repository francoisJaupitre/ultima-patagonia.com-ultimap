<?php
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../prm/aut.php");
$rq_pic = sel_whe("pic","cat_pic");
while($dt_pic = ftc_ass($rq_pic)){$bg[] = $dt_pic['pic'];}
if(isset($bg)){
	$i = rand(0, count($bg)-1);
	$pic = "$bg[$i]";
}
insert("cfg_usr_cnx",array("id_usr","cnx","ip"),array($id_usr,date('Y-m-d H:i:s'),$_SERVER['REMOTE_ADDR']));
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="../prm/forme.css?version=<?php echo date('Y-m-d-H-i-s', filemtime('../prm/forme.css'))  ?>" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script><?php include("../prm/script.js"); ?></script>
		<script><?php include("script_act.js"); ?></script>
		<script><?php include("script_vue.js"); ?></script>
	</head>
	<body class="usn">
		<div id="shadowing"></div>
		<div id="alert"></div>
		<div id="txtHint"><br/></div>
		<div id="bck" style="background-image: url('../pic/<?php echo $dir.'/'.$pic; ?>');"></div>
		<div class="menu" id="vue_menu"><?php include("vue_menu.php"); ?></div>
		<div class="lst" id="vue_lst"><?php include("vue_lst.php"); ?></div>
		<script src='../resources/js/common.js'></script>
		<script src='../resources/js/accScript.js'></script>
	</body>
</html>
