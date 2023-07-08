<?php
//$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../prm/aut.php");
//include("../prm/lgg.php");
$li_sel = 'li_0';
$li_map = array();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="../prm/forme.css?version=<?php echo date('Y-m-d-H-i-s', filemtime('../prm/forme.css'))  ?>" />
		<link rel="stylesheet" type="text/css" href="forme.css?version=<?php echo date('Y-m-d-H-i-s', filemtime('forme.css'))  ?>" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script><?php include("../prm/script.js"); ?></script>
		<script><?php include("script.js");?></script>
	</head>
	<body class="usn">
		<div id="shadowing"></div>
		<div id="txtHint"><br/></div>
		<div id="container">
			<div id="vue_mel">
				<div id="drag" class="drag"></div>
				<div id="vue_lec" >
					<div id="drag2" class="drag"></div>
					<div class="t2m3bp"></div>
				</div>
				<div id="vue_box"></div>
			</div>
			<div id="vue_map" onclick="if(xhr_map != null){xhr_map.abort();}if(xhr_src != null){xhr_src.abort();}"><?php include("vue_map.php") ?></div>
		</div>
		<script src='../resources/js/script.js'></script>
		<script src='../resources/js/melLoad.js'></script>
	</body>
</html>
