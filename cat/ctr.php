<?php
if(isset($_GET['id']) and $_GET['id']>0 and isset($_GET['cbl']) and !empty($_GET['cbl'])) {
	$cbl_cat = $cbl = $_GET['cbl'];
	$id_cat = $id = $_GET['id'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	$rq_pic = select("pic","cat_pic");
	while($dt_pic = ftc_ass($rq_pic)) {$bg[] = $dt_pic['pic'];}
	if(isset($bg)) {
		$i = rand(0, count($bg)-1);
		$pic = "$bg[$i]";
	}
	$url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$host = explode('.',$_SERVER['HTTP_HOST']);
	if(isset($host[2])) {unset($host[0]);}
	$url .= 'www.'.implode('.',$host).'/';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="../prm/forme.css?version=<?php echo date('Y-m-d-H-i-s', filemtime('../prm/forme.css'))  ?>" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script><?php include("script_act.js");?></script>
		<script><?php include("script_ajt.js");?></script>
		<script><?php include("script_sup.js");?></script>
		<script><?php include("script_vue.js");?></script>
		<script><?php include("../prm/script.js"); ?></script>
	</head>
	<body class="usn" onload="init('<?php echo $id_lng ?>','<?php echo $cbl ?>',<?php echo $id.','.$aut['cat']; ?>);">
		<input type="hidden" id="host" value="<?php echo $url; ?>" >
		<div id="shadowing"></div>
		<div id="alert"></div>
		<div id="txtHint"><br/></div>
		<div id="bck" style="background-image: url('../pic/<?php echo $dir.'/'.$pic; ?>');"></div>
		<span id="vue"><?php include("vue.php"); ?></span>
		<script src='../vendor/tinymce/tinymce.min.js'></script>
		<script src='../resources/js/richTxt.js'></script>
	</body>
</html>
<?php
}
?>
